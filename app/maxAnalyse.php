<?php
session_start();
require "toolbox.php";
require "../app/bdd.php";

// On passe les dimensions de l'écran du visiteur en session
$_SESSION['width-user'] = $_POST['width-js'];
$_SESSION['height-user'] = $_POST['height-js'];

// On vide les variables de session
$_SESSION['errors'] = '';
$_SESSION['lettresInputTab'] = [];
$_SESSION['nbLettresInput'] = 0;
$_SESSION['nbLettresOutput'] = 0;
$_SESSION['resultatMax'] = [''];
$_SESSION['outilMax'] = false;
$_SESSION['langue'] = '';
$_SESSION['lettresInputBruts'] = [];

// printPre($_POST);exit;
// On vérifie les données
if (isset($_POST['motInput']) && !empty($_POST['motInput']) && isset($_POST['nbCarMotFinal']) && !empty($_POST['nbCarMotFinal'])) {
    $lettresInputTemp = $_POST['motInput'];
    $lettresInput = valid_donnees($lettresInputTemp);
    if(isset($_POST['langue']) && $_POST['langue'] == "fr"){
        $accents = $_POST['accents'];
    }

    $inputLower = mb_strtolower($lettresInputTemp);
    $nb_car_final = $_POST['nbCarMotFinal'];

    // Enregistrement de l'user en Bdd
    include_once('user-bdd.php');

    // Enregistrer la recherche en BDD
    $recSearch = $dbh->prepare('INSERT INTO recherche (maxpo, nb_car_final, ip, session_id, visiteur_id) VALUES (:maxpo, :nb_car_final, :ip, :session_id, :visiteur_id)');
    $recSearch->bindValue(':visiteur_id', $userId, PDO::PARAM_INT);
    $recSearch->bindValue(':maxpo', $lettresInput, PDO::PARAM_STR);
    $recSearch->bindValue(':nb_car_final', $nb_car_final, PDO::PARAM_INT);
    $recSearch->bindValue(':ip', $ipAPI, PDO::PARAM_STR);
    $recSearch->bindValue(':session_id', $sessionId, PDO::PARAM_STR);
    $recSearch->execute();

    // On vérifie les caractères entrés ar l'utilisateur
    $pattern = '/^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]{1,15}$/';
    if (preg_match($pattern, $lettresInput)) {
        $nb_car_temp  = $_POST['nbCarMotFinal'];
        $nb_car = valid_donnees($nb_car_temp);
        if ($nb_car > 2 && $nb_car < 21) {

            $lettresInputBrutTab = mb_str_split($lettresInput);
            $_SESSION['lettresInputBruts'] = $lettresInputBrutTab;
            $lettresInputTab = mb_str_split($lettresInput);
            sort($lettresInputTab);
            $lettresInputAlphaTab = $lettresInputTab;

            $caractAccents = ["À", "Â", "Ç", "Ë", "É", "È", "Ê", "Ï", "Î", "Ô", "Ü", "Ù", "Û"];

            /*
                Utilisation d'un pattern avec LIKE de SQL
                Détermination du nombre d'occurences de chaque lettre rentrée par l'utilsateur
                pour obetenir les différents patterns :
                    -> on va chercher ces paterns dans les champs "alpha" de la bdd (pratique pour
                    les cas où la même lettre est entrée plusieurs fois)
            */

            $_SESSION['outilMax'] = true;
            // 
            $refTabCount = array_count_values($lettresInputAlphaTab);
            $newRefTab = [];
            foreach ($refTabCount as $k => $v) {
                if ($v === 1) {
                    $newRefTab[] =  $k;
                } else {
                    $x = '';
                    for ($i = 0; $i < $v; $i++) {
                        $x .= $k;
                    }
                    $newRefTab[] = $x;
                }
            }

            if(isset($_POST['langue']) && $_POST['langue'] == "fr"){
                if (isset($_POST['dico']) && $_POST['dico'] == 'dicoLight') {
                    $req = 'SELECT * FROM dico_simple WHERE nb_car = :nb_car';
                }
                if (isset($_POST['dico']) && $_POST['dico'] == 'dicoFull') {
                    $req = 'SELECT * FROM dico_complet WHERE nb_car = :nb_car';
                }
    
                if ($accents == 'sansAccents') {
                    foreach ($newRefTab as $v) {
                        $req .= ' AND LOWER(slug_alpha) LIKE "%' . $v . '%"';
                    }
                }
                if ($accents == 'avecAccents') {
                    foreach ($newRefTab as $v) {
                        $req .= ' AND LOWER(mot_alpha) LIKE "%' . $v . '%"';
                    }
                }
            }

            if(isset($_POST['langue']) && $_POST['langue'] == "en"){
                $req = 'SELECT * FROM dico_english WHERE nb_car = :nb_car';
                foreach ($newRefTab as $v) {
                    $req .= ' AND LOWER(mot_alpha) LIKE "%' . $v . '%"';
                }
            }

            if(isset($_POST['langue']) && $_POST['langue'] == "es"){
                $req = 'SELECT * FROM dico_spain WHERE nb_car = :nb_car';
                foreach ($newRefTab as $v) {
                    $req .= ' AND LOWER(mot_alpha) LIKE "%' . $v . '%"';
                }
            }

            if(isset($_POST['langue']) && $_POST['langue'] == "de"){
                $req = 'SELECT * FROM dico_deutch WHERE nb_car = :nb_car';
                foreach ($newRefTab as $v) {
                    $req .= ' AND LOWER(mot_alpha) LIKE "%' . $v . '%"';
                }
            }

            $select = $dbh->prepare($req);
            $select->bindValue(':nb_car', $nb_car, PDO::PARAM_INT);
            $select->execute();
            $resMax = $select->fetchAll(PDO::FETCH_OBJ);

            // Si option avec accents : on filtre les résultats
            if ($_POST['langue'] == "fr" && $accents == 'avecAccents') {
                $resultatOk = [];
                $inputLowerTab = mb_str_split($inputLower);
                foreach ($resMax as $v) {
                    $motOk = true;
                    $motTemp = $v->mot;
                    foreach ($inputLowerTab as $lettre) {
                        $position = strpos($motTemp, $lettre);
                        if ($position == false) {
                            $motOk = false;
                        }
                    }
                    if ($motOk == true) {
                        $resultatOk[] = $v;
                    }
                }
            }

            $_SESSION['lettresInputTab'] = $lettresInputAlphaTab;
            $_SESSION['nbLettresInput'] = count($lettresInputAlphaTab);
            $_SESSION['nbLettresOutput'] = $nb_car;
            $_SESSION['resultatMaxSansAccents'] = $resMax;
            $_SESSION['resultatMaxAvecAccents'] = $resultatOk;
            $_SESSION['accents'] = $accents;
            $_SESSION['langue'] = $_POST['langue'];


            header('Location: ../maxpossibilator.php#resultatMax');
            exit;
        } else {
            $_SESSION['errors'] = "Le mot final doit comporter entre 3 et 20 lettres.";
        }
    } else {
        $_SESSION['errors'] = "Vous devez choisir entre 1 et 15 lettres. Seuls les caractères proposés sont autorisés.";
    }
} else {
    $_SESSION['errors'] = "Un évènement inattendu s'est produit. Veuillez recommencer.";
}

header('Location: ../maxpossibilator.php');
exit;