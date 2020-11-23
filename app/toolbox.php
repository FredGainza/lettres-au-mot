<?php

// Fonction de mise en forme de var_dump
function dumpPre($x)
{
    echo '<pre>';
    var_dump($x);
    echo '</pre>';
}

// Fonction de mise en forme de print_r
function printPre($x)
{
    echo '<pre>';
    print_r($x);
    echo '</pre>';
}

// Fonction de verif et de validation des inputs entrés par l'utilisateur
function valid_donnees($donnees)
{
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}


/* Générateur de Slug (Friendly Url) : convertit un titre en une URL conviviale.*/
function slugify($string, $delimiter = '-')
{
    $oldLocale = setlocale(LC_ALL, '0');
    setlocale(LC_ALL, 'en_US.UTF-8');
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = trim($clean, $delimiter);
    setlocale(LC_ALL, $oldLocale);
    return $clean;
}

// Fonction qui tronque un texte
function tronquer_texte($texte, $nbchar)
{
    return (strlen($texte) > $nbchar ? substr(
        substr($texte, 0, $nbchar),
        0,
        strrpos(substr($texte, 0, $nbchar), " ")
    ) . " (...)" : $texte);
}

// Fonction qui vérifie l'égalité de 2 tableaux
function arrays_equal($array1, $array2)
{
    array_multisort($array1);
    array_multisort($array2);
    return (serialize($array1) === serialize($array2));
}

// Fonction qui enlève tirets, espaces et ligatures
function enlevetiresp($chaine)
{
    $search  = array('-', '–', ' ', 'œ', '.');
    $replace = array('', '', '', 'oe', '');

    $chaine = str_replace($search, $replace, $chaine);
    return $chaine; //On retourne le résultat
}

// Fonction quio enlève les accents
function enleveaccents($chaine)
{
    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö',  'œ', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', '-', ' ', '.');
    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'oe', 'u', 'u', 'u', 'u', 'y', 'y', '', '', '');

    $chaine = str_replace($search, $replace, $chaine);
    return $chaine; //On retourne le résultat
}

// Fonction pour split string en array (unicode)
function str_split_unicode($str, $l = 0)
{
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

// Fonction qui récupère IP de l'utilisateur
function get_ip()
{
    // IP si internet partagé
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    // IP derrière un proxy
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Sinon : IP normale
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Fonction qui vérifie l'existence d'une page web
function IFilesExists($url)
{
    $headers = @get_headers($url, 1);
    if ($headers[0] == '') return false;
    return !((preg_match('/404/', $headers[0])) == 1);
}
function checkWebSite($url)
{
    // Vérifiez si l'URL fournie est valide
    if(!filter_var($url, FILTER_VALIDATE_URL)){
      return false;
    }
    // Initialiser cURL
    $ch = curl_init($url);
    
    // Définir les options
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($ch,CURLOPT_HEADER,true);
    curl_setopt($ch,CURLOPT_NOBODY,true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    // Récupérer la réponse
    $response = curl_exec($ch);
    
    // Fermer la session cURL
    curl_close($ch);
    return $response ? true : false;
}

// Fonction qui extrait le contenu entre 2 balises html
function recupValeurEntreBalise($text, $baliseDebut, $baliseFin)
{
    $i = 0;
    $ii = 0;
    $textModif = "";
    $textFinal = array();
    while ($i < strlen($text)) {
        if ($text[$i] == $baliseDebut) {
            while ($ii < strlen($text)) {
                $textModif = $textModif . $text[$ii];
                if ($text[$i] == $baliseFin) {
                    $textModif = str_replace(array($baliseDebut, $baliseFin), "", $textModif);
                    array_push($textFinal, $textModif);
                    $textModif = "";
                    break;
                }
                $i++;
                $ii++;
            }
        }
        $i++;
        $ii++;
    }
    return $textFinal;
}

function remplacerStringEntreDeuxBalises($texte_initial, $borne_debut, $borne_finale, $text_remplacement){
    $position_debut = strrpos($texte_initial, $borne_debut);
    $position_fin = strrpos($texte_initial, $borne_finale);
    $tagLength = $position_fin - $position_debut + 1;

    return substr_replace($texte_initial, $text_remplacement, $position_debut, $tagLength);
}

function remplacerSautDeLigne($chaine){
    return preg_replace("# {2,}#"," ",preg_replace("#(\r\n|\n\r|\n|\r)#"," ",$chaine));
}

$min=["à", "á", "â", "ã", "ä", "å", "æ", "ç", "ð", "è", "é", "ê", "ë", "ì", "í", "î", "ï", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "œ", "ß", "š", "þ", "ù", "ú", "û", "ü", "ý", "ÿ", "ž"];
$minIso=["&#224;", "&#225;", "&#226;", "&#227;", "&#228;", "&#229;", "&#230;", "&#231;", "&#240;", "&#232;", "&#233;", "&#234;", "&#235;", "&#236;", "&#237;", "&#238;", "&#239;", "&#241;", "&#242;", "&#243;", "&#244;", "&#245;", "&#246;", "&#248;", "&#156;", "&#223;", "&#154;", "&#254;", "&#249;", "&#250;", "&#251;", "&#252;", "&#253;", "&#255;", "&#158;"];
$minNom=["&agrave;", "&aacute;", "&acirc;", "&atilde;", "&auml;", "&aring;", "&aelig;", "&ccedil;", "&eth;", "&egrave;", "&eacute;", "&ecirc;", "&euml;", "&igrave;", "&iacute;", "&icirc;", "&iuml;", "&ntilde;", "&ograve;", "&oacute;", "&ocirc;", "&otilde;", "&ouml;", "&oslash;", "&oelig;", "&szlig;", "&scaron;", "&thorn;", "&ugrave;", "&uacute;", "&ucirc;", "&uuml;", "&yacute;", "&yuml;", "&zcaron;"];

$maj=["À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "Ð", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Œ", "Š", "Þ", "Ù", "Ú", "Û", "Ü", "Ý", "Ÿ", "Ž"];
$majIso=["&#192;", "&#193;", "&#194;", "&#195;", "&#196;", "&#197;", "&#198;", "&#199;", "&#208;", "&#200;", "&#201;", "&#202;", "&#203;", "&#204;", "&#205;", "&#206;", "&#207;", "&#209;", "&#210;", "&#211;", "&#212;", "&#213;", "&#214;", "&#216;", "&#140;", "&#138;", "&#222;", "&#217;", "&#218;", "&#219;", "&#220;", "&#221;", "&#376;", "&#142;"];
$majNom=["&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Auml;", "&Aring;", "&AElig;", "&Ccedil;", "&ETH;", "&Egrave;", "&Eacute;", "&Ecirc;", "&Euml;", "&Igrave;", "&Iacute;", "&Icirc;", "&Iuml;", "&Ntilde;", "&Ograve;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Ouml;", "&Oslash;", "&OElig;", "&Scaron;", "&THORN;", "&Ugrave;", "&Uacute;", "&Ucirc;", "&Uuml;", "&Yacute;", "&Yuml;", "&Zcaron;"];

$speciaux=["!", '"', "#", "$", "%", "&", "'", "(", ")", "*", "+", ",", "-", ".", "/", ":", ";", "<", "=", ">", "?", "@", "[", "\"", "]", "^", "_", "`", "{", "|", "}", "~", "¡", "¦", "§", "¨", "©", "ª", "«", "®", "¯", "°", "±", "²", "³", "´", "µ", "·", "¹", "º", "»", "¼", "½", "¾", "¿", "×", "÷", "∞", "‰", "™"];
$speciauxIso=["&#33;", "&#34;", "&#35;", "&#36;", "&#37;", "&#38;", "&#39;", "&#40;", "&#41;", "&#42;", "&#43;", "&#44;", "&#45;", "&#46;", "&#47;", "&#58;", "&#59;", "&#60;", "&#61;", "&#62;", "&#63;", "&#64;", "&#91;", "&#92;", "&#93;", "&#94;", "&#95;", "&#96;", "&#123;", "&#124;", "&#125;", "&#126;", "&#161;", "&#166;", "&#167;", "&#168;", "&#169;", "&#170;", "&#171;", "&#174;", "&#175;", "&#176;", "&#177;", "&#178;", "&#179;", "&#180;", "&#181;", "&#183;", "&#185;", "&#186;", "&#187;", "&#188;", "&#189;", "&#190;", "&#191", "&#215", "&#247", "&#8734;", "&#8240;", "&#8482;"];
$speciauxNom=["aucun", "&quot;", "aucun", "&dollar;", "aucun", "&amp;", "&apos;", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "&lt;", "aucun", "&gt;", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "&iexcl;", "&brvbar;", "&sect;", "&uml;", "&copy;", "&ordf;", "&laquo;", "&reg;", "&macr;", "&deg;", "&plusmn;", "&sup2;", "&sup3;", "&aigu;", "&micro;", "&middot;", "&sup1;", "&ordm;", "&raquo;", "&frac14;", "&frac12;", "&frac34;", "&iquest;", "&times;", "&divide;", "&infin;", "&permil;", "&trade;"];

$monnaie=["$", "€", "£", "¥", "¢", "¤", "₹", "₽", "元", "₢", "₦", "₨", "₩", "₪", "₫", "₭", "₮", "₱", "₲", "₴", "₵", "₸", "₺", "₼", "฿", "៛", "﷼"];
$monnaieIso=["&#36;", "&#8364;", "&#163;", "&#165;", "&#162;", "&#164;", "&#8377;", "&#8381;", "&#20803;", "&#8354;", "&#8358;", "&#8360;", "&#8361;", "&#8362;", "&#8363;", "&#8365;", "&#8366;", "&#8369;", "&#8370;", "&#8372;", "&#8373;", "&#8376;", "&#8378;", "&#8380;", "&#3647;", "&#6107;", "&#65020;"];
$monnaieNom=["&dollar;", "&euro;", "&pound;", "&yen;", "&cent;", "&curren;", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun", "aucun"];

$letGrec=["α", "β", "γ", "δ", "ε", "ζ", "η", "θ", "ι", "κ", "λ", "μ", "ν", "ξ", "ο", "π", "ρ", "σ", "τ", "υ", "φ", "χ", "ψ", "ω", "Α", "Β", "Γ", "Δ", "Ε", "Ζ", "Η", "Θ", "Ι", "Κ", "Λ", "Μ", "Ν", "Ξ", "Ο", "Π", "Ρ", "Σ", "Τ", "Υ", "Φ", "Χ", "Ψ", "Ω"];
$letGrecIso=["&#945;", "&#946;", "&#947;", "&#948;", "&#949;", "&#950;", "&#951;", "&#952;", "&#953;", "&#954;", "&#955;", "&#956;", "&#957;", "&#958;", "&#959;", "&#960;", "&#961;", "&#963;", "&#964;", "&#965;", "&#966;", "&#967;", "&#968;", "&#969;", "&#913;", "&#914;", "&#915;", "&#916;", "&#917;", "&#918;", "&#919;", "&#920;", "&#921;", "&#922;", "&#923;", "&#924;", "&#925;", "&#926;", "&#927;", "&#928;", "&#929;", "&#931;", "&#932;", "&#933;", "&#934;", "&#935;", "&#936;", "&#937;"];
$letGrecNom=["&alpha;", "&beta;", "&gamma;", "&delta;", "&epsilon;", "&zeta;", "&eta;", "&theta;", "&iota;", "&kappa;", "&lambda;", "&mu;", "&nu;", "&xi;", "&omicron;", "&pi;", "&rho;", "&sigma;", "&tau;", "&upsilon;", "&phi;", "&chi;", "&psi;", "&omega;", "&Alpha;", "&Beta;", "&Gamma;", "&Delta;", "&Epsilon;", "&Zeta;", "&Eta;", "&Theta;", "&Iota;", "&Kappa;", "&Lambda;", "&Mu;", "&Nu;", "&Xi;", "&Omicron;", "&Pi;", "&Rho;", "&Sigma;", "&Tau;", "&Upsilon;", "&Phi;", "&Chi;", "&Psi;", "&Omega;"];
