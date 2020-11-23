<?php
session_start();
require "app/toolbox.php";
require "app/bdd.php";

$message = '';
if ($errorMsg = "401") {
  $message = 'Erreur Code 401 : Accès non autorisé';
}
if ($errorMsg = "403") {
  $message = 'Erreur Code 403 : Accès interdit au répertoire demandé';
}
if ($errorMsg = "404") {
  $message = 'Erreur Code 404 : Le document demandé est introuvable';
}
if ($errorMsg = "501") {
  $message = 'Erreur Code 501 : Erreur interne du serveur';
}
if ($errorMsg = "502") {
  $message = 'Erreur Code 502 : Mauvaise passerelle';
}
if ($errorMsg = "503") {
  $message = 'Erreur Code 503 : Service indisponible';
}
if ($errorMsg = "504") {
  $message = 'Erreur Code 504 : Temps d\'attente expiré';
}
?>

<!doctype html>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Lettres Au Mot, site d'aide à la résolution de jeux de lettres. Oups... On quelque chose s'est mal passé... Mais rien de grave, cliquez ci-dessous pour revenir à la page d'accueil.">
  <meta name="author" content="Frédéric Gainza">

  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon-letters/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-letters/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-letters/favicon-16x16.png">
  <link rel="manifest" href="assets/img/favicon-letters/site.webmanifest">
  <link rel="mask-icon" href="assets/img/favicon-letters/safari-pinned-tab.svg" color="#5bbad5">

  <title>Lettres Au Mot - Page 404 et autres problèmes</title>

  <link rel="canonical" href="https://lettres-au-mot.fr/page-error.php">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,900;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="assets/css/style.css">

  <style>
    body {
      background-color: #e5e5e5 !important;
      background-image: url('assets/img/bg-error/error_404_300.jpg');
      background-size: 40%;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: bottom;
    }

    @media (min-width: 576px) {
      body {
        background-image: url('assets/img/bg-error/error_404_400.jpg');
      }
    }

    @media (min-width: 768px) {
      body {
        background-image: url('assets/img/bg-error/error_404_500.jpg');
      }
    }

    @media (min-width: 990px) {
      body {
        background-image: url('assets/img/bg-error/error_404_700.jpg');
      }
    }

    @media (min-width: 1200px) {
      body {
        background-image: url('assets/img/bg-error/error_404_1000.jpg');
      }
    }

    @media (orientation: portrait) {
      body {
        background-position: center;
      }
    }
  </style>
</head>
<body>
  <div id="layoutDefault">
    <nav class="navbar navbar-expand-lg navbar-light nav-bg">
      <a class="navbar-brand titre-logo" href="index.php">Lettres au Mot</a>
      <button class="navbar-toggler my-2 mr-2" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse ml-auto mr-0" id="navbarNav">
        <ul class="navbar-nav w-50-resp2 mr-auto mt-2 mt-lg-0 bg-menu">
          <li class="nav-item dropdown mresp bg-li-list">
            <a class="nav-link dropdown-toggle rad-haut" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Les outils
            </a>
            <div class="dropdown-menu ml-3 ml-lg-1 mb-3" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="index.php">Anagrammeur</a>
              <a class="dropdown-item" href="maxpossibilator.php">MaxPossibilator</a>
              <div class="dropdown-divider-perso"></div>
              <a class="dropdown-item" href="explications-outils.php">Explications</a>
            </div>
          </li>
          <li class="nav-item mx-0 mx-lg-5 dropdown">
            <a class="nav-link rad-bas" href="contact.php">Contact</a>
          </li>
        </ul>
        <div class="d-lg-none">
          <a class="nav-link-foot fz95" href="mentions-legales.php">Mentions Légales</a>
          <a class="nav-link-foot fz95" href="https://fgainza.fr" target="_blank">Réalisation du site</a>
          <span class="nav-link-foot mb-3 fz95">2020 &copy; Lettres-Au-Mot</span>
        </div>
      </div>
    </nav>

    <div id="layoutDefault_content" role="main">
      <?php $errorMsg = $_GET['error']; ?>
      <div class="container mx-auto mt-3 mt-lg-5">
        <?php if ($errorMsg == "404") : ?>
          <div id="alert" class="alert col-md-12 py-3 w-80-alert-error mb-3 alert-dismissible alert-danger-perso fade show" role="alert">
            <span class="text-danger d-block text-center mt-4">
              "OUPS"... Un problème est survenu...<br>
              Le code ci-dessous vous indique d'où vient le problème<br>
            </span>
            <span class="text-dark d-block text-center fz1rem my-4">
              <?= $message; ?>
            </span>
          </div>
        <?php endif ?>
      </div>

      <div class="mt-3 text-center"><a href="index.php">Retour à l'accueil</a></div>

    </div>
    <footer id="layoutDefault_footer" class="footer d-none d-lg-block py-1 footer-align bg-darkos footer-dark">
      <div class="container">
        <div class="d-flex flex-row justify-content-center align-items-center">
          <div class="text-center py-0 py-md-1">
            <span class="text-nowrap text-footer">2020 &copy; Lettres-Au-Mot</span>
            <span class="mx-1 mx-sm-2 mx-md-5">|</span>
            <span class="text-nowrap text-footer"><a class="fz-norm-resp" href="mentions-legales.php">Mentions Légales</a></span>
            <span class="mx-1 mx-sm-2 mx-md-5">|</span>
            <span class="text-nowrap text-footer"><a class="fz-norm-resp" href="https://fgainza.fr" target="_blank">Réalisation du site</a></span>
          </div>
        </div>
      </div>
    </footer>
    <?php
    if ($errorMsg != "") { // si il y a une erreur (variable erreur non vide)
      $referer = getenv('HTTP_REFERER'); // on récupère l'URL de la page d'origine
      $uri = $_SERVER['REQUEST_URI']; // on récupère l'URL de la page cause de l'erreur
      // $ipVisiteur = (null != $_SESSION['ip_visiteur']) ? $_SESSION['ip_visiteur'] : $_SERVER['REMOTE_ADDR']; // on récupère l'IP du visiteur (pour stats - facultatif)

      // Enregistrement de l'user en Bdd
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
      $access_key = '*****************************************';

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

        $userId = 0;
        if ($ipAPI != "**********************") {
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
      if ($ipAPI != "******************************") {
        $insertError = $dbh->prepare('INSERT INTO erreur (referer, uri, code_erreur, visiteur_id, session_id, ip) VALUES (:referer, :uri, :code_erreur, :visiteur_id, :session_id, :ip)');
        $insertError->bindValue(':referer', $referer, PDO::PARAM_STR);
        $insertError->bindValue(':uri', $uri, PDO::PARAM_STR);
        $insertError->bindValue(':code_erreur', $errorMsg, PDO::PARAM_INT);
        $insertError->bindValue(':visiteur_id', $userId, PDO::PARAM_INT);
        $insertError->bindValue(':session_id', $sessionId, PDO::PARAM_STR);
        $insertError->bindValue(':ip', $ipAPI, PDO::PARAM_STR);

        $insertError->execute();
      }

      // Je supprime toute les sessions errors et success
      unset($errorMsg);
      $message = '';
    }
    ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>