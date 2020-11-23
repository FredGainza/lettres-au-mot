<?php
session_start();
require "../app/toolbox.php";
require "../app/bdd.php";
require "../app/simple_html_dom.php";

if(isset($_POST['langue']) && $_POST['langue'] != 'fr'){
    $_POST['accents'] = 'sansAccents';
    $_POST['dico'] = '';
}

// On passe les dimensions de l'écran du visiteur en session
$_SESSION['width-user'] = $_POST['width-js'];
$_SESSION['height-user'] = $_POST['height-js'];

function parse($url){

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_REFERER, "https://whatismyip.com");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');
    $str = curl_exec($curl);
    curl_close($curl);

    return str_get_html($str); 
}

function afficheTraductionIndex($url){
    $_SESSION['def'] = '';
    $_SESSION['source'] = '';
    $traduction='';
    $gram='';
    $htmlDef = new simple_html_dom();
    $htmlDef->load_file($url);
    if(null != $htmlDef->find('span.tag_trans a', 0)){
        $traduction=$htmlDef->find('span.tag_trans a', 0);
    }
    if(null != $htmlDef->find('div[id=dictionary]', 0)){
        if(null != $htmlDef->find('div[id=dictionary]', 0)->find('span.tag_wordtype', 0)){
            $gram=$htmlDef->find('div[id=dictionary]', 0)->find('span.tag_wordtype', 0)->plaintext;
        }
    }
    $def='<b>'.ucfirst($traduction). '</b> '. ($gram != '' ? ' <small>('.$gram.')</small>' : '');
    if($traduction != ''){
        $_SESSION['def'] = $def. "&nbsp;<small>(source : <a class=\"link-blue pol100p\" href=\".$url.\" target=\"_blank\">Dictionnaire Linguee</a>)</small>";
    }else{
        $_SESSION['def'] = "Oups... pas de traduction trouvée...";
    }
}

function onlineCheck($domain){
    $timeout = 10;
    $curlInit = curl_init($domain);
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,$timeout);
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
    $reponse = curl_exec($curlInit);
    curl_close($curlInit);
    if ($reponse) return true;
    return false;
}

// On vide les variables de session
$_SESSION['motDico'] = '';
$_SESSION['motAvant'] = '';
$_SESSION['motApres'] = '';
$_SESSION['motInput'] = '';
$_SESSION['motSlug'] = '';
$_SESSION['errors'] = '';
$_SESSION['success'] = '';
$_SESSION['anagrammes'] = [];
$_SESSION['motsPossibles'] = [];
$_SESSION['motsjockers'] = '';
$_SESSION['nbjockersPossibles'] = [];
$_SESSION['motsjockers'] = [];
$_SESSION['nbjockersAna'] = 0;
$_SESSION['motsjockersAna'] = [];
$_SESSION['motJokTabNb'] = 0;
$_SESSION['motJokTabNbJok'] = 0;
$_SESSION['motJokLet'] = '';
$_SESSION['def'] = '';
$_SESSION['source'] = '';
$_SESSION['motPasDico'] = '';
$_SESSION['nb_elements'] = 0;
$_SESSION['langue'] = '';


// On vérifie les données
if (isset($_POST['motInput']) && !empty($_POST['motInput'])) {

    // Vérification des données passées en POST
    $motInput = $_POST['motInput'];
    $validInput = valid_donnees($motInput);

    $_SESSION['langue'] = $_POST['langue'];
    
    // Enregistrement de l'user en Bdd
    include_once('user-bdd.php');

    // Enregistrement de la recherche en BDD
    $recSearch = $dbh->prepare('INSERT INTO recherche (mot, ip, session_id, visiteur_id) VALUES (:mot, :ip, :session_id, :visiteur_id)');
    $recSearch->bindValue(':visiteur_id', $userId, PDO::PARAM_INT);
    $recSearch->bindValue(':mot', $validInput, PDO::PARAM_STR);
    $recSearch->bindValue(':ip', $ipAPI, PDO::PARAM_STR);
    $recSearch->bindValue(':session_id', $sessionId, PDO::PARAM_STR);
    $recSearch->execute();

    // On vérifie la  présence ou non de caractères spéciaux (cf. jockers)
    $pattern = '/^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ?_]{3,20}$/';
    $subject = $validInput;
    if (preg_match($pattern, $subject)) {
        if (count(mb_str_split($validInput))) {
            $motTemp = valid_donnees($motInput);
            $motTempTab = mb_str_split($motTemp);
            $ajouGram = false;
            $moTrou = false;
            foreach ($motTempTab as $v) {
                if ($v === "?") {
                    $ajouGram = true;
                }
                if ($v === "_") {
                    $moTrou = true;
                }
            }

            // Si présence de lettres, d'un "?" et de un plusieurs "_"
            if ($moTrou == true && $ajouGram == true) {
                $_SESSION['errors'] = "Vous ne pouvez pas utiliser les deux types de jockers \"?\" et \"_\" dans une même recherche.";
            } else {

                // Si c'est un mot entier (pas de "?" ni de "_")
                if (!$ajouGram && !$moTrou) {
                    $mot = mb_strtolower($motTemp);
                    // On prend en compte le dico demandé
                    if(isset($_POST['langue']) && $_POST['langue'] == 'fr'){
                        if (isset($_POST['dico']) && $_POST['dico'] == 'dicoLight') {
                            $selectMotDico = $dbh->prepare('SELECT * FROM dico_simple WHERE mot = :mot');
                        }
                        if (isset($_POST['dico']) && $_POST['dico'] == 'dicoFull') {
                            $selectMotDico = $dbh->prepare('SELECT * FROM dico_complet WHERE mot = :mot');
                        }
                    }
                    if(isset($_POST['langue']) && $_POST['langue'] == 'en') {
                        $selectMotDico = $dbh->prepare('SELECT * FROM dico_english WHERE mot = :mot');
                    }
                    if(isset($_POST['langue']) && $_POST['langue'] == 'es') {
                        $selectMotDico = $dbh->prepare('SELECT * FROM dico_spain WHERE mot = :mot');
                    }
                    if(isset($_POST['langue']) && $_POST['langue'] == 'de') {
                        $selectMotDico = $dbh->prepare('SELECT * FROM dico_deutch WHERE mot = :mot');
                    }
                    $selectMotDico->bindValue(':mot', $mot, PDO::PARAM_STR);
                    $selectMotDico->execute();

                    $resMotDicoTemp = $selectMotDico->fetchAll(PDO::FETCH_OBJ);

                    // !!! PB DE CARACTERES ACCENTUES !!!
                    /*
                        Il arrive qu'une requête renvoie 2 résultats, la version accentuée et non accentuée
                        EX : si on demande le mot "cerne", on va obtenir 2 réultats : "cerne" et "cerné" (également
                        le cas si la requête est "cerné").
                        Solution trouvée : si le nombre de résultat est supérieur à 1, on compare lettre par lettre l'input entré
                        avec les outputs possible à l'aide d'un compteur 
                    */

                    // Recherche du mot input dans le dico Scrabble
                    if(isset($_POST['langue']) && $_POST['langue'] == 'fr') {
                        $motScrabble = strtoupper(enleveaccents($mot));

                        $selectMotScrabble = $dbh->prepare('SELECT * FROM dico_scrabble_cap WHERE mot = :mot');
                        $selectMotScrabble->bindValue(':mot', $motScrabble, PDO::PARAM_STR);
                        $selectMotScrabble->execute();

                        $resMotScrabble = $selectMotScrabble->fetch(PDO::FETCH_OBJ);

                        $motExisteScrabble = !null == $resMotScrabble ? true : false;

                        $_SESSION['motScrabble'] = $motExisteScrabble;
                    }

                    // Recherche du mot input dans le dictionnaire  
                    if (count($resMotDicoTemp) == 1) {
                        if($_POST['langue'] == 'fr'){
                            if ($_POST['accents'] == 'sansAccents') {
                                $resMotDico = $resMotDicoTemp[0];
                            }
                            if ($_POST['accents'] == 'avecAccents') {
                                $res = [];
                                $valid = true;
                                $motR = $resMotDicoTemp[0]->mot;
                                $resMotTab = mb_str_split($motR);
                                $x = 0;
                                for ($i = 0; $i < count($resMotTab); $i++) {
                                    if (mb_strtolower($resMotTab[$i]) == mb_strtolower($motTempTab[$i])) {
                                        $x++;
                                    }
                                }
                                if ($x == count($resMotTab)) {
                                    $resMotDico = $resMotDicoTemp[0];
                                } else {
                                    $resMotDico = [];
                                }
                            }
                        }
                        if($_POST['langue'] != 'fr'){
                            $resMotDico = $resMotDicoTemp[0];
                        }
                    } else {
                        foreach ($resMotDicoTemp as $k => $v) {
                            $res = [];
                            $valid = true;
                            $motR = $v->mot;
                            $resMotTab = mb_str_split($motR);
                            $x = 0;
                            for ($i = 0; $i < count($resMotTab); $i++) {
                                if (mb_strtolower($resMotTab[$i]) == mb_strtolower($motTempTab[$i])) {
                                    $x++;
                                }
                            }
                            if ($x == count($resMotTab)) {
                                $resMotDico = $v;
                            }
                        }
                    }

                    // Si le mot saisi est présent dans le dico
                    if (!empty($resMotDico->mot)) {
                        $_SESSION['motDico'] = $resMotDico->mot;
                        $_SESSION['motSlug'] = enleveaccents($_SESSION['motDico']);

                        $idAvant = $resMotDico->id - 1;
                        $idApres = $resMotDico->id + 1;

                        if(isset($_POST['langue']) && $_POST['langue'] == 'fr'){
                            // Recherche Définition
                            $def = "";
                            $source="";
                            $motDico = $resMotDico->mot;

                            if (IFilesExists("https://www.larousse.fr/dictionnaires/francais/".$motDico)){
                                $url="https://www.larousse.fr/dictionnaires/francais/".$motDico;
                                $defTemp='';
                                $def='';
                                $marque='';
                                $gram='';

                                $htmlDef = new simple_html_dom();
                                $htmlDef->load_file($url);
                                if(null != $htmlDef->find('div[id=header-article]',0)){
                                    if(null != $htmlDef->find('div.header-article',0)->find('p.CatgramDefinition',0)){
                                        $gram=$htmlDef->find('div.header-article',0)->find('p.CatgramDefinition',0)->plaintext;
                                    }
                                }
                                if(null != $htmlDef->find('div[id=definition]',0)){
                                    if(null != $htmlDef->find('div[id=definition]',0)->find('ul.Definitions',0)){
                                        if(null != $htmlDef->find('div[id=definition]',0)->find('ul.Definitions',0)->find('li.DivisionDefinition',0)){
                                            if(null != $htmlDef->find('div[id=definition]',0)->find('ul.Definitions',0)->find('li.DivisionDefinition',0)->find('span.indicateurDefinition',0)){
                                                $marque=$htmlDef->find('div[id=definition]',0)->find('ul.Definitions',0)->find('li.DivisionDefinition',0)->find('span',0);
                                                $marque->class='indicateurDefinition text-info';
                                            }
                                            $defTemp=$htmlDef->find('div[id=definition]',0)->find('ul.Definitions',0)->find('li.DivisionDefinition',0)->innertext;
                                        }
                                    }
                                }
                                $def=($gram != '' ? '<small>('.$gram.')&nbsp;</small>' : '').$defTemp;
                                if($def != ''){
                                    $_SESSION['def'] = $def. "&nbsp;<span class=\"small\">(source : <a class=\"link-blue pol100p\" href=\"https://www.larousse.fr/dictionnaires/francais/".$motDico."\" target=\"_blank\">Le Larousse</a>)</span>";
                                }else{
                                    $_SESSION['def'] = "Oups... pas de traduction trouvée...";
                                }

                            }else{
                                $_SESSION['def'] = "Oups... pas de traduction trouvée...";
                            }                          
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] != 'fr'){
                            if($_POST['langue'] == 'en'){
                                //recherche de traduction
                                $motDico = $resMotDico->mot;
                                if (IFilesExists("https://www.linguee.fr/francais-anglais/search?source=anglais&query=".urlencode($motDico))) {
                                    $url="https://www.linguee.fr/francais-anglais/search?source=anglais&query=".urlencode($motDico);
                                    afficheTraductionIndex($url);
                                }
                            }
                            if($_POST['langue'] == 'es'){
                                //recherche de traduction
                                $motDico = $resMotDico->mot;
                                if (IFilesExists("https://www.linguee.fr/francais-espagnol/search?source=espagnol&query=".urlencode($motDico))) {
                                    $url="https://www.linguee.fr/francais-espagnol/search?source=espagnol&query=".urlencode($motDico);
                                    afficheTraductionIndex($url);
                                }
                            }
                            if($_POST['langue'] == 'de'){
                                //recherche de traduction
                                $motDico = $resMotDico->mot;
                                if (IFilesExists("https://www.linguee.fr/francais-allemand/search?source=allemand&query=".urlencode($motDico))) {
                                    $url="https://www.linguee.fr/francais-allemand/search?source=allemand&query=".urlencode($motDico);
                                    afficheTraductionIndex($url);
                                }
                            }
                        }

                        // Recherche du mot précédent
                        if(isset($_POST['langue']) && $_POST['langue'] == 'fr'){
                            if (isset($_POST['dico']) && $_POST['dico'] == 'dicoLight') {
                                $selectMotAvant = $dbh->prepare('SELECT * FROM dico_simple WHERE id = :id');
                            }
                            if (isset($_POST['dico']) && $_POST['dico'] == 'dicoFull') {
                                $selectMotAvant = $dbh->prepare('SELECT * FROM dico_complet WHERE id = :id');
                            }
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'en') {
                            $selectMotAvant = $dbh->prepare('SELECT * FROM dico_english WHERE id = :id');
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'es') {
                            $selectMotAvant = $dbh->prepare('SELECT * FROM dico_spain WHERE id = :id');
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'de') {
                            $selectMotAvant = $dbh->prepare('SELECT * FROM dico_deutch WHERE id = :id');
                        }
                        $selectMotAvant->bindValue(':id', $idAvant, PDO::PARAM_INT);
                        $selectMotAvant->execute();

                        $resMotAvant = $selectMotAvant->fetch(PDO::FETCH_OBJ);
                        $_SESSION['motAvant'] = $resMotAvant->mot;

                        // Recherche du mot suivant
                        if(isset($_POST['langue']) && $_POST['langue'] == 'fr'){
                            if (isset($_POST['dico']) && $_POST['dico'] == 'dicoLight') {
                                $selectMotApres = $dbh->prepare('SELECT * FROM dico_simple WHERE id = :id');
                            }
                            if (isset($_POST['dico']) && $_POST['dico'] == 'dicoFull') {
                                $selectMotApres = $dbh->prepare('SELECT * FROM dico_complet WHERE id = :id');
                            }
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'en') {
                            $selectMotApres = $dbh->prepare('SELECT * FROM dico_english WHERE id = :id');
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'es') {
                            $selectMotApres = $dbh->prepare('SELECT * FROM dico_spain WHERE id = :id');
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'de') {
                            $selectMotApres = $dbh->prepare('SELECT * FROM dico_deutch WHERE id = :id');
                        }
                        $selectMotApres->bindValue(':id', $idApres, PDO::PARAM_INT);
                        $selectMotApres->execute();

                        $resMotApres = $selectMotApres->fetch(PDO::FETCH_OBJ);
                        $_SESSION['motApres'] = $resMotApres->mot;


                        // Si le mot saisi n'est pas présent dans le dico
                    } else {

                        // Définition des variables nécessaires à la recherche des anagrammes
                        $motLettres = $mot;
                        $_SESSION['motDico'] = "-";
                        $_SESSION['motInput'] = $mot;
                        $motLettresTab = str_split_unicode($motLettres);
                        sort($motLettresTab);
                        $motLettresAlpha = join($motLettresTab);
                        $motLettresAlpha = enlevetiresp($motLettresAlpha);
                        $motLettresAlpha = mb_strtolower($motLettresAlpha);

                        $slugLettres = mb_strtolower(enleveaccents($motLettres));
                        $slugLettresTab = str_split_unicode($slugLettres);
                        sort($slugLettresTab);
                        $nb_car_lettres = count($slugLettresTab);
                        $slugLettresAlpha = join($slugLettresTab);
                        $slugLettresAlpha = enlevetiresp($slugLettresAlpha);
                        $slugLettresAlpha = mb_strtolower($slugLettresAlpha);
                    }

                    // Recherche d'anagrammes
                    $anagrammes = [];

                    /*
                        Le principe : on classe chaque mot de n caractères par ordre alphabétique (il y un champ alpha dans la base)
                        On compare chaque résultat avec la valeur de l'input initial : s'il sont égaux, c'est un anagramme
                    */


                    // On récupère les valeurs des options renseignées
                    if(isset($_POST['langue']) && $_POST['langue'] == 'fr'){
                        if ($_POST['accents'] == 'sansAccents') {
                            !empty($resMotDico->mot) ? $slugAlphaInput = $resMotDico->slug_alpha : $slugAlphaInput = $slugLettresAlpha;
                        }
                        if ($_POST['accents'] == 'avecAccents') {
                            !empty($resMotDico->mot) ? $slugAlphaInput = $resMotDico->mot_alpha : $slugAlphaInput = $motLettresAlpha;
                        }
                        !empty($resMotDico->mot) ? $nb_car = $resMotDico->nb_car : $nb_car = $nb_car_lettres;

                        if (isset($_POST['dico']) && $_POST['dico'] == 'dicoLight') {
                            $selectAna = $dbh->prepare('SELECT * FROM dico_simple WHERE nb_car = :nb_car');
                        }
                        if (isset($_POST['dico']) && $_POST['dico'] == 'dicoFull') {
                            $selectAna = $dbh->prepare('SELECT * FROM dico_complet WHERE nb_car = :nb_car');
                        }
                    }
                    if(isset($_POST['langue']) && $_POST['langue'] != 'fr'){
                        !empty($resMotDico->mot) ? $slugAlphaInput = $resMotDico->slug_alpha : $slugAlphaInput = $slugLettresAlpha;
                        !empty($resMotDico->mot) ? $nb_car = $resMotDico->nb_car : $nb_car = $nb_car_lettres;
                        if($_POST['langue'] == 'en'){
                            $selectAna = $dbh->prepare('SELECT * FROM dico_english WHERE nb_car = :nb_car');
                        }
                        if($_POST['langue'] == 'es'){
                            $selectAna = $dbh->prepare('SELECT * FROM dico_spain WHERE nb_car = :nb_car');
                        }
                        if($_POST['langue'] == 'de'){
                            $selectAna = $dbh->prepare('SELECT * FROM dico_deutch WHERE nb_car = :nb_car');
                        }
                    }
                    $selectAna->bindValue(':nb_car', $nb_car, PDO::PARAM_INT);
                    $selectAna->execute();

                    // On récupère tous les mots qui ont le même nombre de lettres que celui en input
                    $resAna = $selectAna->fetchAll(PDO::FETCH_OBJ);

                    if(isset($_POST['langue']) && $_POST['langue'] == 'fr'){
                        if ($_POST['accents'] == 'sansAccents') {
                            foreach ($resAna as $a) {
                                if ($a->slug_alpha === $slugAlphaInput && ($a->mot !== (!empty($resMotDico->mot) ? $resMotDico->mot : $slugLettres))) {
                                    $anagrammes[] = $a->mot;
                                }
                                $_SESSION['anagrammes'] = $anagrammes;
                            }
                        }
                        if ($_POST['accents'] == 'avecAccents') {
                            foreach ($resAna as $a) {
                                if ($a->mot_alpha === $slugAlphaInput && ($a->mot !== (!empty($resMotDico->mot) ? $resMotDico->mot : mb_strtolower($motLettres)))) {
                                    $anagrammes[] = $a->mot;
                                }
                                $_SESSION['anagrammes'] = $anagrammes;
                            }
                        }
                    }
                    if(isset($_POST['langue']) && $_POST['langue'] != 'fr'){
                        foreach ($resAna as $a) {
                            if ($a->slug_alpha === $slugAlphaInput && ($a->mot !== (!empty($resMotDico->mot) ? $resMotDico->mot : $slugLettres))) {
                                $anagrammes[] = $a->mot;
                            }
                            $_SESSION['anagrammes'] = $anagrammes;
                        }
                    }

                    // Recherche de combinaisons possibles avec (n-1) lettres du mot saisi (de n-1 à 3)
                    $nb = 0;
                    for ($i = $nb_car - 2; $i > 1; $i--) {

                        /*
                            Même principe que pour les anagrammes.
                            Par exemple, si count(Input) = n, on extrait d'abord de la base tous les mots de n-1 lettres.
                            Puis on compare avec l'Input : array_intersect permet d'obtenir les éléments communs à 2 tableaux.
                            Puis on les boucles pour éviter les doublons
                        */

                        $refSlugAlphaTab = mb_str_split($slugAlphaInput);
                        $motsPossible = [];

                        if(isset($_POST['langue']) && $_POST['langue'] == 'fr'){
                            if (isset($_POST['dico']) && $_POST['dico'] == 'dicoLight') {
                                $selectPoss = $dbh->prepare('SELECT * FROM dico_simple WHERE nb_car = :nb_car');
                            }
                            if (isset($_POST['dico']) && $_POST['dico'] == 'dicoFull') {
                                $selectPoss = $dbh->prepare('SELECT * FROM dico_complet WHERE nb_car = :nb_car');
                            }
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'en') {
                            $selectPoss = $dbh->prepare('SELECT * FROM dico_english WHERE nb_car = :nb_car');
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'es') {
                            $selectPoss = $dbh->prepare('SELECT * FROM dico_spain WHERE nb_car = :nb_car');
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'de') {
                            $selectPoss = $dbh->prepare('SELECT * FROM dico_deutch WHERE nb_car = :nb_car');
                        }
                        $selectPoss->bindValue(':nb_car', $i + 1, PDO::PARAM_INT);
                        $selectPoss->execute();
                        $resPoss = $selectPoss->fetchAll(PDO::FETCH_OBJ);

                        $refTabCount = array_count_values($refSlugAlphaTab);
                        foreach ($resPoss as $v) {
                            if (($_POST['langue'] == 'fr' && $_POST['accents'] == 'sansAccents') || $_POST['langue'] != 'fr') {
                                $possSlugAlphaTab = mb_str_split($v->slug_alpha);
                            }
                            if ($_POST['langue'] == 'fr' && $_POST['accents'] == 'avecAccents') {
                                $possSlugAlphaTab = mb_str_split($v->mot_alpha);
                            }


                            $result = array_intersect($possSlugAlphaTab, $refSlugAlphaTab);

                            $test = true;
                            if (arrays_equal($result, $possSlugAlphaTab)) {
                                $possTabCount = array_count_values($possSlugAlphaTab);
                                foreach ($possTabCount as $c => $val) {
                                    foreach ($refTabCount as $k => $w) {
                                        if ($c == $k && $test == true) {
                                            if ($val > $w) {
                                                $test = false;
                                            }
                                        }
                                    }
                                }

                                if ($test == true) {
                                    $motsPossible[] = $v->mot;
                                }
                            }
                        }
                        $nb_motsPossible = count($motsPossible);
                        if ($nb_motsPossible == 0) {
                            $_SESSION['motsPossibles'][] = "<span class=\"font-weight-bold fz110p word-spac-10\"><i class=\"far fa-times-circle fa-sm text-danger mr-2\"></i><span class=\"text-info fz110p \">Pas de mot de " . ($i + 1) . " lettres</span><br>";
                        } else {
                            $totalMots = '<ul class="' . ($nb_motsPossible < 2 ? "list-group mx-5 mx-md-0" : "list-group2") . ' resultat  mt-2 mt-md-3 mb-3 mb-md-4 justify-content-center">';
                            foreach ($motsPossible as $k => $v) {
                                $totalMots .= "<a id=\"motPossible_" . $nb . "\" class=\"click-def link-no-effect\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\"><li class=\"" . ($nb_motsPossible < 2 ? "list-group-item mb-0 mb-md-2 mx-0 mx-md-1" : "list-group-item2 mb-2 mx-1") . " list-group-item-secondary fz90p-li resultat\"><b>" . strtoupper($v) . "</b></li></a>";
                                $nb++;
                            }
                            $totalMots .= "</ul>";

                            $_SESSION['motsPossibles'][] = "<span class=\"d-block font-weight-bold text-blue2 fz110p word-spac-10 mt-3\">" . count($motsPossible) . " mot" . (count($motsPossible) > 1 ? 's' : '') .
                                " de " . ($i + 1) . " lettres</span>" . $totalMots;
                        }
                    }
                    header('Location: ../index.php#resGeneral');
                    exit;


                    // Si c'est un "ajouGramme" -> s'il y a un "?"
                } elseif (!$moTrou && $ajouGram) {
                    $ajout = true;
                    $_SESSION['ajout'] = true;
                    $motJok = $motTemp;
                    $motJokTemp = mb_strtolower($motTemp);


                    if ($_POST['accents'] == 'sansAccents' || $_Post['langue'] != 'fr') {
                        $motJok = enleveaccents($motJokTemp);
                    }
                    if ($_POST['accents'] == 'avecAccents') {
                        $motJok = $motJokTemp;
                    }

                    $motJokTab = mb_str_split($motJok);
                    $motJokTabLet = [];
                    $motJokTabJok = [];

                    foreach ($motJokTab as $v) {
                        $v === "?" ? $motJokTabJok[] = $v : $motJokTabLet[] = $v;
                    }

                    $motJokTabNb = count($motJokTab);
                    $motJokTabNbLet = count($motJokTabLet);
                    $motJokTabNbJok = count($motJokTabJok);

                    $_SESSION['motJokTabNb'] = $motJokTabNb;
                    $_SESSION['motJokTabNbJok'] = $motJokTabNbJok;
                    $_SESSION['motJokLet'] = mb_strtoupper(join(" ", $motJokTabLet));

                    // Recherche des combinaisons possibles de n caractères (n = nombre de caractères saisis)
                    if ($motJokTabNbJok == 1) {

                        if($_POST['langue'] == 'fr'){
                            ($_POST['accents'] == 'sansAccents') ? $test = 'slug_alpha' : $test = 'mot_alpha';
                        }
                        if($_POST['langue'] != 'fr'){
                            $test = 'slug_alpha';
                        }

                        if(isset($_POST['langue']) && $_POST['langue'] == 'fr'){
                            if (isset($_POST['dico']) && $_POST['dico'] == 'dicoLight') {
                                $selectGlobal = $dbh->prepare('SELECT * FROM dico_simple WHERE nb_car = :nb_car');
                            }
                            if (isset($_POST['dico']) && $_POST['dico'] == 'dicoFull') {
                                $selectGlobal = $dbh->prepare('SELECT * FROM dico_complet WHERE nb_car = :nb_car');
                            }
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'en') {
                            $selectGlobal = $dbh->prepare('SELECT * FROM dico_english WHERE nb_car = :nb_car');
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'es') {
                            $selectGlobal = $dbh->prepare('SELECT * FROM dico_spain WHERE nb_car = :nb_car');
                        }
                        if(isset($_POST['langue']) && $_POST['langue'] == 'de') {
                            $selectGlobal = $dbh->prepare('SELECT * FROM dico_deutch WHERE nb_car = :nb_car');
                        }

                        $selectGlobal->bindValue(':nb_car', $motJokTabNb, PDO::PARAM_INT);
                        $selectGlobal->execute();
                        $resGlobal = $selectGlobal->fetchAll(PDO::FETCH_OBJ);

                        $possibiliteTab = [];
                        foreach (range('a', 'z') as $l) {
                            $motsPossiblesTab = [];
                            $motInputComplet = [];
                            $motInputComplet = $motJokTabLet;
                            $motInputComplet[$motJokTabNbLet] = $l;
                            sort($motInputComplet);
                            $motInputCompletAlpha = join($motInputComplet);

                            foreach ($resGlobal as $v) {
                                if($_POST['langue'] == 'fr'){
                                    ($_POST['accents'] == 'sansAccents') ? $motAlpha = 'slug_alpha' : $motAlpha = 'mot_alpha';
                                }
                                if($_POST['langue'] != 'fr'){
                                    $motAlpha = 'slug_alpha';
                                }
                                $motRef = $v->$motAlpha;
                                if ($motInputCompletAlpha == $motRef) {
                                    $motPos = $v->mot;
                                    $motPosTab = mb_str_split($motPos);
                                    $key = array_search($l, $motPosTab);
                                    $motPosTab[$key] = '<span class="text-color">' . $l . '</span>';
                                    $motOK = join($motPosTab);
                                    $motsPossiblesTab[] = $motOK;
                                }
                            }
                            $possibiliteTab[$l] = $motsPossiblesTab;
                        }
                        $nb = [];
                        $nb_total = 0;
                        foreach ($possibiliteTab as $k => $v) {
                            $nb[] = count($possibiliteTab[$k]);
                            $nb_total += count($possibiliteTab[$k]);
                        }

                        $_SESSION['nbjockersAna'] = $nb_total;
                        $_SESSION['possibiliteTab'] = $possibiliteTab;
                    } else {
                        $_SESSION['errors'] = "<i class=\"fas fa-exclamation-triangle fz110p fa-sm text-danger mr-3\"></i>La saisie est incorrecte. Vous ne pouvez pas utiliser plus de un jocker (cf. \"?\") par mot saisi.";
                        header('Location: ../index.php#alert');
                        exit;
                    }
                } elseif ($moTrou && !$ajouGram) {
                    $x = "";
                    $trou = true;

                    // Si c'est un "motTrou" -> s'il y a un ou plusieurs "_"
                    $motTrou = mb_strtolower($motTemp);
                    $motTrouTab = mb_str_split($motTrou);
                    $nb_car = count($motTempTab);
                    $pat = $motTrou;
                    if ($_POST['accents'] == "avecAccents" && $_POST['dico'] == 'dicoLight') {
                        $selectTrou = $dbh->prepare('SELECT * FROM dico_simple WHERE nb_car = :nb_car AND LOWER(mot) LIKE :pat');
                    }
                    if ($_POST['accents'] == "avecAccents" && $_POST['dico'] == 'dicoFull') {
                        $selectTrou = $dbh->prepare('SELECT * FROM dico_complet WHERE nb_car = :nb_car AND LOWER(mot) LIKE :pat');
                    }
                    if ($_POST['accents'] == "sansAccents" && $_POST['dico'] == 'dicoLight') {
                        $selectTrou = $dbh->prepare('SELECT * FROM dico_simple WHERE nb_car = :nb_car AND LOWER(slug) LIKE :pat');
                    }
                    if ($_POST['accents'] == "sansAccents" && $_POST['dico'] == 'dicoFull') {
                        $selectTrou = $dbh->prepare('SELECT * FROM dico_complet WHERE nb_car = :nb_car AND LOWER(slug) LIKE :pat');
                    }
                    if($_POST['langue'] == 'en'){
                        $selectTrou = $dbh->prepare('SELECT * FROM dico_english WHERE nb_car = :nb_car AND LOWER(slug) LIKE :pat');
                    }
                    if($_POST['langue'] == 'es'){
                        $selectTrou = $dbh->prepare('SELECT * FROM dico_spain WHERE nb_car = :nb_car AND LOWER(slug) LIKE :pat');
                    }
                    if($_POST['langue'] == 'de'){
                        $selectTrou = $dbh->prepare('SELECT * FROM dico_deutch WHERE nb_car = :nb_car AND LOWER(slug) LIKE :pat');
                    }
                    $selectTrou->bindValue(':nb_car', $nb_car, PDO::PARAM_INT);
                    $selectTrou->bindValue(':pat', $pat, PDO::PARAM_STR);
                    $selectTrou->execute();

                    $resTrou = $selectTrou->fetchAll(PDO::FETCH_OBJ);

                    $motTrouTab = mb_str_split($motTrou);
                    $motTrouLettres = [];
                    $motTrouJok = [];

                    foreach ($motTrouTab as $k => $v) {
                        ($v === '_') ? $motTrouJok[$k][] = $v : $motTrouLettres[$k][] = $v;
                    }
                    $nb_lettres = count($motTrouLettres);
                    $nb_jok = count($motTrouJok);

                    foreach ($motTrouJok as $pos => $v) {
                        $posJok[] = $pos;
                    }
                    foreach ($motTrouLettres as $pos => $v) {
                        $posLettres[] = $pos;
                    }

                    $resultatTrou = [];
                    foreach ($resTrou as $res) {
                        $resMot = [];
                        $resMotTab = (mb_str_split(mb_strtoupper($res->mot)));
                        for ($j = 0; $j < $nb_jok; $j++) {
                            $resMotTab[$posJok[$j]] = htmlspecialchars('<span class="text-color">') . $resMotTab[$posJok[$j]] . htmlspecialchars('</span>');
                        }
                        $resultatTrou[] = join($resMotTab);
                    }
                    $_SESSION['resTrou'] = $resultatTrou;
                    $_SESSION['lettresInput'] = join($motTrouLettres);
                    $_SESSION['nbLettres'] = $nb_lettres;
                    $_SESSION['nbJok'] = $nb_jok;
                    $_SESSION['pattern'] = mb_strtoupper(join(" ", $motTrouTab));
                    $_SESSION['trou'] = $trou;

                    header('Location: ../index.php#resGeneral');
                    exit;
                } else {
                    $_SESSION['errors'] = "<i class=\"fas fa-exclamation-triangle fz110p fa-sm text-danger mr-3\"></i>La saisie est incorrecte. Veuillez recommencer.";
                    header('Location: ../index.php#alert');
                    exit;
                }
            }
        } else {
            $_SESSION['errors'] = "<i class=\"fas fa-exclamation-triangle fz110p fa-sm text-danger mr-3\"></i>Vous devez saisir entre 3 et 20 caractères (avec ou sans jockers, représentés par les caractères \"?\" et \"_\".)";
            header('Location: ../index.php#alert');
            exit;
        }
    } else {
        $_SESSION['errors'] = "<i class=\"fas fa-exclamation-triangle fz110p fa-sm text-danger mr-3\"></i>La saisie est incorrecte.<br>
                                <i class=\"fas fa-exclamation-triangle fz110p fa-sm text-danger mr-3\"></i>Vous devez saisir entre 3 et 20 caractères.<br>
                                <i class=\"fas fa-exclamation-triangle fz110p fa-sm text-danger mr-3\"></i>Ne sont autorisés que les lettres et les caractères jockers \"?\" et \"_\".";
        header('Location: ../index.php#alert');
        exit;
    }
} else {
    $_SESSION['errors'] = "<i class=\"fas fa-exclamation-triangle fz110p fa-sm text-danger mr-3\"></i>Saisie incorrecte. Veuillez recommencer.";
    header('Location: ../index.php#alert');
    exit;
}

header('Location: ../index.php');
exit;