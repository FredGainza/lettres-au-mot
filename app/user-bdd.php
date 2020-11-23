<?php
require 'bdd.php';

// On vérifie su user déjà dans la bdd

$ip = get_ip();
$sessionId = '';
isset($_COOKIE['PHPSESSID']) ? $sessionId = $_COOKIE['PHPSESSID'] : $sessionId = 'indefine';


// Enregistrement d'élément du USER en BDD

/*
#############################################
###     Utilisation de l'API IPSTACK
#############################################
*/

// set IP address and API access key 
$access_key = '8ba544cd18b6656e1b5048b37b31af5b';

// Initialize CURL:
$ch = curl_init('http://api.ipstack.com/' . $ip . '?access_key=' . $access_key . '');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$api_result = json_decode($json, true);


// Output the data
if (isset($api_result) && !empty($api_result)) {

    $ipAPI = $api_result['ip'];
    $continent = $api_result['continent_name'];
    $pays = $api_result['country_name'];
    $region = $api_result['region_name'];
    $ville = $api_result['city'];
    $codePostal = $api_result['zip'];
    $latitude = strval($api_result['latitude']);
    $longitude = strval($api_result['longitude']);

    isset($api_result['location']) && !empty($api_result['location']['languages']) ? $langue =  $api_result['location']['languages'][0]['name'] : $langue = '-';

    isset($api_result['success']) && $api_result['success'] == false ? $error_code = $api_result['error']['code'] : $error_code = 0;
    isset($api_result['success']) && $api_result['success'] == false ? $error_type = $api_result['error']['type'] : $error_type = '-';
    isset($api_result['success']) && $api_result['success'] == false ? $error_info = $api_result['error']['info'] : $error_info = '-';
} else {
    $ipAPI = $ip;
    $continent = 'NO API';
    $pays = 'NO API';
    $region = 'NO API';
    $ville = 'NO API';
    $codePostal = 'NO API';
    $latitude = 'NO API';
    $longitude = 'NO API';
    $langue = 'NO API';
    $error_code = 0;
    $error_type = 'NO API';
    $error_info = 'NO API';
}
$width = !empty($_POST['width-js']) ? $_POST['width-js'] : 0;
$height = !empty($_POST['height-js']) ? $_POST['height-js'] : 0;

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != 0) {
    $userId = $_SESSION['user_id'];
} else {
    if ($ipAPI != "128.65.195.219") {
        $recUser = $dbh->prepare('INSERT INTO visiteur (ip, session_id, continent, pays, region, ville, code_postal, latitude, longitude, language, width, height, error_code, error_type, error_info) 
                        VALUES (:ip, :session_id, :continent, :pays, :region, :ville, :code_postal, :latitude, :longitude, :language, :width, :height, :error_code, :error_type, :error_info)');
        $recUser->bindValue(':ip', $ipAPI, PDO::PARAM_STR);
        $recUser->bindValue(':session_id', $sessionId, PDO::PARAM_STR);
        $recUser->bindValue(':continent', $continent, PDO::PARAM_STR);
        $recUser->bindValue(':pays', $pays, PDO::PARAM_STR);
        $recUser->bindValue(':region', $region, PDO::PARAM_STR);
        $recUser->bindValue(':ville', $ville, PDO::PARAM_STR);
        $recUser->bindValue(':code_postal', $codePostal, PDO::PARAM_STR);
        $recUser->bindValue(':latitude', $latitude, PDO::PARAM_STR);
        $recUser->bindValue(':longitude', $longitude, PDO::PARAM_STR);
        $recUser->bindValue(':language', $langue, PDO::PARAM_STR);
        $recUser->bindValue(':width', $width, PDO::PARAM_INT);
        $recUser->bindValue(':height', $height, PDO::PARAM_INT);
        $recUser->bindValue(':error_code', $error_code, PDO::PARAM_INT);
        $recUser->bindValue(':error_type', $error_type, PDO::PARAM_STR);
        $recUser->bindValue(':error_info', $error_info, PDO::PARAM_STR);

        $recUser->execute();

        $lastId = $dbh->lastInsertId();
        $userId = $lastId;
        $_SESSION['user_id'] = $lastId;
    }
}