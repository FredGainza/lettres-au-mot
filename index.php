<?php
session_start();
require 'app/toolbox.php';
// printPre($_SESSION);
?>
<!doctype html>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Lettres Au Mot, site d'aide à la résolution de jeux de lettres. Utilisez l'outil Anagrammeur pour trouver tous les anagrammes de ce mot.">
  <meta name="keywords" content="anagrammes, jeux de lettres, scrabble, mots fléchés, mots à trous, anagrammeur, solutions">
  <meta name="author" content="Frédéric Gainza">
  <meta name="theme-color" content="#ffffff">

  <!-- FAVICONS -->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon-letters/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-letters/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-letters/favicon-16x16.png">
  <link rel="manifest" href="assets/img/favicon-letters/site.webmanifest">
  <link rel="mask-icon" href="assets/img/favicon-letters/safari-pinned-tab.svg" color="#5bbad5">


  <title>Lettres Au Mot - Outil Anagrammeur</title>

  <link rel="canonical" href="https://lettres-au-mot.fr/">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,900;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <!-- Cookie bar concentement -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cookie-consent-box@2.4.0/dist/cookie-consent-box.min.css" />
  <!-- CSS Perso -->
  <link rel="stylesheet" href="assets/css/style.css">

<style>
  .w-pers-langue{
    width: 100%
  }

  @media (min-width: 576px){
    .w-pers-langue{
      width: 30%;
    }
  }
</style>
</head>

<body>

  <!-- Loader -->
  <div id="bgLoader">
    <div class="loader-center">
      <div id="loaderRes"></div>
    </div>
  </div>

  <!-- START - Layout Global -->
  <div id="layoutDefault">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light nav-bg">
      <a class="navbar-brand titre-logo" href="index.php">Lettres au Mot</a>
      <button class="navbar-toggler my-2 mr-2" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse ml-auto mr-0" id="navbarNav">
        <ul class="navbar-nav w-50-resp2 mr-auto mt-2 mt-lg-0 bg-menu">
          <li class="nav-item dropdown  fz-110 mresp bg-li-list">
            <a class="nav-link nav-active icon dropdown-toggle rad-haut fz-110" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Les outils
            </a>
            <div class="dropdown-menu ml-3 ml-lg-1 mb-3" aria-labelledby="navbarDropdown">
              <a class="dropdown-item active" href="index.php">Anagrammeur</a>
              <a class="dropdown-item" href="maxpossibilator.php">MaxPossibilator</a>
              <div class="dropdown-divider-perso"></div>
              <a class="dropdown-item" href="explications-outils.php">Explications</a>
            </div>
          </li>
          <li class="nav-item mx-0 mx-lg-5 dropdown">
            <a class="nav-link rad-bas fz-110" href="contact.php">Contact</a>
          </li>
        </ul>
        <div class="d-lg-none">
          <a class="nav-link-foot fz95" href="mentions-legales.php">Mentions Légales</a>
          <a class="nav-link-foot fz95" href="https://fgainza.fr" target="_blank">Réalisation du site</a>
          <span class="nav-link-foot mb-3 fz95">2020 &copy; Lettres-Au-Mot</span>
        </div>
      </div>
    </nav>

    <!-- START - Layout Contenu -->
    <div id="layoutDefault_content" role="main">

      <!-- Notification des erreurs -->
      <div class="container w-50-90-resp mx-auto mt-1">
        <?php if (!empty($_SESSION['errors'])  || !empty($_SESSION['success'])) : ?>
          <?php $notification = isset($_SESSION['errors']) ? $_SESSION['errors'] : (isset($_SESSION['success']) ? $_SESSION['success'] : ''); ?>
          <?php $color = isset($_SESSION['errors']) ? 'danger-perso' : (isset($_SESSION['success']) ? 'success' : ''); ?>
          <div id="alert" class="alert col-md-12 py-3 w-80 mx-10p mt-3 mb-30 alert-dismissible alert-<?= $color; ?> fade show" role="alert">
            <button type="button" class="close" id="close" data-dismiss="alert" aria-label="Close"><span class="fz-iconeClose" aria-hidden="true">&times;</span></button>
            <?= $notification; ?>
          </div>
        <?php endif ?>
      </div>
      <?php
      // Je supprime toute les sessions errors et success
      unset($_SESSION['errors']);
      unset($_SESSION['success']);
      ?>

      <!-- ############################################################### -->
      <!-- START - SECTION PRESENTATION -->
      <!-- ############################################################### -->
      <section class="presentation">

        <div class="container">
          <div class="row flex-row justify-content-between align-items-center mb-3">

            <!-- Link vers MaxPossibilator -->
            <div class="col-4 col-lg-2 align-self-start">
              <a class="btn btn-info anagrammeurLink" href="maxpossibilator.php">MaxPossibilator</a>
            </div>

            <!-- Gestion affichage fenêtre modale de présentation -->
            <div class="col-8 col-lg-10 mx-auto">
              <div id="closePres" class="d-flex pt-2 mr-0 mr-lg-2 text-right link-fake align-self-end justify-content-end">
                <button id="iconClose" class="btn btn-sm-pers displayIconClose btn-danger align-items-center" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Fermer la fenêtre">
                  Fermer la fenêtre&nbsp;&nbsp;<i class="far fa-times-circle lh-15 fa-sm text-white-red "></i>
                </button>
                <button id="iconEye" class="btn btn-sm-pers btn-info-pers displayIconEye" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Afficher les infos">
                  <i class="fas fa-question"></i>
                </button>
              </div>
            </div>

            <!-- Contenu présentation modale -->
            <div id="pres" class="displayDiv mx-3 mx-lg-4 presentation-style align-self-center">
              <ul class="pres">
                <li class="pres-li"><span class="jeux">ANAGRAMIA</span> : Saisissez de 3 à 20 lettres, accentuées ou non, et retrouvez tous ses anagrammes</li>
                <li class="pres-li"><span class="jeux">AJOUGRAMME</span> : Utilisez la lettre "?" comme jocker de valeur (ex : CAREE?). Le "?" est l'équivalent de la case blanche au scrabble <br> (un seul jocker par mot - si vous en voulez plusieurs, utilisez notre autre outil, le <a href="maxpossibilator.php"><span class="jeux">MAXPOSSIBILATOR</span></a>)</li>
                <li class="pres-li"><span class="jeux">MOTROU</span> : Utilisez la lettre "_" comme jocker de position (ex : TR_R_ER) pour retouver les lettres manquantes</li>
                <li class="pres-li mt-2""><i>Remarque</i> : Il n'est pas possible d'utiliser ces deux types de jocker pour une même recherche</li>
                <li class=" pres-li">Possibilité de prendre en compte les accents ou de les ignorer</li>
                <li class="pres-li">Choix entre un dictionnaire épuré (22&nbsp;000 entrées) et un complet (350&nbsp;000 références)</li>
                <li class="pres-li">Définition disponible par simple clic pour chaque résultat (source des définitions : le <a class="fz-norm-resp link-div" href="">Wiktionnaire</a>)</li>
                <li class="sans-puce fz90resp mt-2 ml-1 ml-md-3 lh-13">
                  <i class="fas fa-caret-right mr-2 text-info"></i>Retrouvez plus d'explications et d'exemples dans la section "<a class="fz-norm-resp link-div" href="explications-outils.php">Les outils</a>".<br>
                  <i class="fas fa-caret-right mr-2 text-info mb-t mt-3"></i>Vous y trouverez également un autre outil : le <a href="maxpossibilator.php"><span class="jeux">MAXPOSSIBILATOR</span></a> qui permet de trouver tous les mots de n lettres contenant certaines lettres (trouvez par exemple tous les mots de 5 lettres contenant un A et un E).
                </li>
              </ul>
            </div>

          </div>
        </div>
      </section>
      <!-- ############################################################### -->
      <!-- END - SECTION PRESENTATION -->
      <!-- ############################################################### -->



      <!-- ############################################################### -->
      <!-- START - SECTION FORMULAIRE -->
      <!-- ############################################################### -->
      <section class="formulaire">
        <div class="container mt-2 mt-lg-4 pb-2">

          <!-- Titre principal -->
          <h1 class="title-main mr-3 ml-auto mr-lg-0 ml-lg-5">Anagrammeur</h1>

          <!-- Texte explicatif de l'outil -->
          <div id="presResume" class="pres-resume rounded px-2 px-lg-3 mb-3">
            <ul class="pres w-90 mx-auto">
              <li class="pres-li">Trouvez tous les anagrammes d'un mot et tous les mots possibles avec les lettres le composant</li>
              <li class="pres-li">Utilisez un joker "?" pour remplacer n'importe quelle lettre de l'alphabet</li>
              <li class="pres-li">Utilisez de un à huit jokers "_" pour positionner une lettre manquante</li>
              <span class="d-block small-pers ml-n2">(plus de détails dans la rubrique <a class="pol100p" href="explications-outils.php">explications</a> ou en cliquant sur l'icone <i class="fas pol80p fa-xs text-info fa-question"></i> en haut de cette page)</span>
            </ul>
          </div>

          <!-- START - Formulaire -->
          <form action="app/motAnalyse.php" method="POST" id="formSaisie">
            <fieldset class="form-border">
              <div class="row mx-auto align-items-center justify-content-around" id="validForm"></div>

              <div class="form-group form-inline w-100 mx-0 row my-3 my-md-2 ">
                <div id="langueChoisie" class="col-12 col-md-6 col-lg-8 ml-0 mr-md-auto fz90-100-rem"></div>

                  <label class="col-auto col-form-label col-forml-label-sm ml-sm-auto mr-0 pr-0"for="choixLangue">Modifier :</label>
                  <div class="col">
                  <select id="choixLangue" name="langue" class="custom-select custom-select-sm form-control py-0 form-control-md w-100">
                    <option value="fr">Français</option>
                    <option value="en">Anglais</option>
                    <option value="es">Espagnol</option>
                    <option value="de">Allemand</option>
                  </select>
                  
                  </div>

              </div>

              <!-- Validation en direct du formulaire -->
              <div class="row mx-0 mx-md-3 mt-1 mt-md-3 mb-3 mb-md-0 lh-12 infoSaisie">
                <div class="col-12 col-md-4 align-left-resp text-nowrap">
                  <span class="compt">Nombre de caractères :&nbsp;&nbsp;<div class="d-inline fz95 font-weight-bold" id="compteur">0</div><span>
                </div>
                <div class="col-12 col-md-4 align-center-resp text-nowrap">
                  <span class="compt">Nombre jocker "?" :&nbsp;&nbsp;<div class="d-inline fz95 font-weight-bold" id="compteurJokValeur">0</div><span>
                </div>
                <div class="col-12 col-md-4 align-right-resp text-nowrap">
                  <span class="compt">Nombre de jocker "_" :&nbsp;&nbsp;<div class="d-inline fz95 font-weight-bold" id="compteurJokPosition">0</div><span>
                </div>
              </div>

              <!-- Options + Search Bar-->
              <div class="row">

                <!-- Options -->
                <div id="options" class="col-12 order-2">
                  <div class="row w-resp justify-content-center">

                    <!-- Choix Accents -->
                    <div class="form-group w-50-resp justify-resp pl-md-2 mb-0">
                      <div class="form-check form-check-inline mr-4 mr-md-2">
                        <label class="form-check-label" for="sansAccents">
                          <input class="form-check-input" type="radio" name="accents" id="sansAccents" value="sansAccents">
                          <span id="sAccents" class="label-text">Sans accents</span>
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label" for="avecAccents">
                          <input class="form-check-input" type="radio" name="accents" id="avecAccents" value="avecAccents">
                          <span id="aAccents" class="label-text">Avec accents</span>
                        </label>
                      </div>
                    </div>

                    <hr class="separe-resp w-100">

                    <!-- Choix de la base lexicale -->
                    <div class="form-group w-50-resp align-right-resp justify-resp pl-md-5 mb-0">
                      <div class="form-check form-check-inline">
                        <label class="form-check-label" for="dicoLight">
                          <input class="form-check-input" type="radio" name="dico" id="dicoLight" value="dicoLight">
                          <span id="dicoL" class="label-text">Dictionnaire allégé</span>
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <label class="form-check-label" for="dicoFull">
                          <input class="form-check-input" type="radio" name="dico" id="dicoFull" value="dicoFull">
                          <span id="dicoF" class="label-text">Dictionnaire complet</span>
                        </label>
                      </div>
                    </div>

                  </div>
                </div>

                <!-- Search Bar -->
                <div class="col-12 order-1">

                  <div class="form-group row w-resp mx-auto mt-1">
                    <div id="cardSearch" class="card card-sm w-100 mb-2 mb-md-4">
                      <div class="card-body lh-125 search row no-gutters align-items-center">

                        <!-- Icone loupe -->
                        <div class="col-auto loupe-search btn-bg-bord no-bord-rad">
                          <button class="btn btn-bg-bord bord-btn pad-btn" disabled>
                            <i class="fas fa-search size-search color-search p5 mx-0 mb-0"></i>
                          </button>
                        </div>

                        <!-- Zone Input -->
                        <div class="col">
                          <input class="form-control form-control-borderless input-search" name="motInput" minlength="3" id="motInput" type="text" placeholder="Par ici la saisie !" pattern="^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ?_]{3,20}$" required autofocus>
                          <input type="hidden" id="width-js" name="width-js" value="">
                          <input type="hidden" id="height-js" name="height-js" value="">                 
                        </div>

                        <!-- Bouton validation grand ecran -->
                        <div class="col-auto d-none bg-btn d-md-flex pad-pers align-items-center">
                          <button class="btn btn-info btn-resp" id="btnEnvoiForm-lg" type="submit">Envoyer</button>
                        </div>
                        <!--end of col-->
                      </div>
                    </div>

                    <!-- Bouton validation petit ecran -->
                    <div class="d-md-none w-100">
                      <button class="btn btn-info mx-auto mt-1 mb-4 btn-resp btn-block" id="btnEnvoiForm" type="submit">Envoyer</button>
                    </div>
                  </div>
                </div>
              </div>

            </fieldset>

          </form>
          <!-- END - Formulaire -->

        </div>

      </section>
      <!-- ############################################################### -->
      <!-- END - SECTION FORMULAIRE -->
      <!-- ############################################################### -->




      <!-- ############################################################### -->
      <!-- START - SECTION RESULTATS ANAGRAMMES -->
      <!-- ############################################################### -->
      <div id="resGeneral">
        <section class="resultatsAnagramme container">

          <?php
          if (isset($_SESSION['motDico']) && !empty($_SESSION['motDico'])) {
            $motDico = $_SESSION['motDico'];
            $motAvant = $_SESSION['motAvant'];
            $motApres = $_SESSION['motApres'];
            $motSlug = $_SESSION['motSlug'];
            $anagrammes = $_SESSION['anagrammes'];
            $motsPossibles = $_SESSION['motsPossibles'];
            $motDicoId = $_SESSION['motDicoId'];
            $def = $_SESSION['def'];
            $source = $_SESSION['source'];
            $ensDef = $_SESSION['dicolink'];
            $nbElements = $_SESSION['nb_elements'];
            $langue = $_SESSION['langue'];
            $motScrabble = $_SESSION['motScrabble'];

            if ($_SESSION['motDico'] !== '-') {
              echo "<div id=\"resultats\" class=\"row\">";
              echo "<div class=\"col-12 col-md-10 mx-auto pt-0 pt-md-3\">";
              echo "<div class=\"card px-3 px-lg-1 bg-pers align-items-center justify-content-betweeen\">";
              echo "<ul class=\"mx-3 my-2\">";
              echo "<li class=\"py-1 fz95-103-rem\"><i class=\"fas fa-share text-orange fa-sm mr-2\"></i>Le mot " . "<span id=\"motDef\" class=\"text-success font-weight-bold fz95-103-rem\">" . mb_strtoupper($motDico) . "</span>" . " est présent dans le dictionnaire" . "</li>";
              if($langue == 'fr'){
                echo "<li class=\"py-1 fz95-103-rem\"><i class=\"fas fa-share text-orange fa-sm mr-2\"></i>" . ($motScrabble == true ? "Mot valide au Scrabble." : "Mot non valide au Scrabble.") . "</li>";
              }
              echo "<li class=\"pt-1 pb-0 mb-2 mb-md-0 fz95-103-rem\"><i class=\"fas fa-share text-orange fa-sm mr-2\"></i><strong><span class=\"text-danger fz95-103-rem\">".($langue == "fr" ? "Définition " : "Traduction ")."</span>&nbsp;:&nbsp;</strong>\"" . $def . "\"<br></li>";
              echo "<span class=\"d-block text-right line-height-1 text-right small pt-0 mt-0 mx-1 mb-2 mb-lg-1\"><a id=\"definitionLight\" class=\"click-def link-no-effect pol100p\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\">Voir ".($langue == "fr" ? "définition " : "traduction ")." du Wiktionnaire</a></span>";
              echo "<li class=\"pt-1 fz95-103-rem\"><i class=\"fas fa-share text-orange fa-sm mr-2\"></i>Le mot précédent est : <a id =\"definitionBefore\" class=\"click-def text-info font-weight-bold fz95-103-rem\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\">" . mb_strtoupper($motAvant) . "</a></li>";
              echo "<li class=\"pb-1 fz95-103-rem\"><i class=\"fas fa-share text-orange fa-sm mr-2\"></i>Le mot suivant est : <a id =\"definitionAfter\" class=\"click-def text-info font-weight-bold fz95-103-rem\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\">" . mb_strtoupper($motApres) . "</a></li>";


              echo "</ul>";
              echo "</div>";
              echo "<br></div></div><hr class=\"mt-2\">";
            } else {
              echo "<div id=\"resultats\" class=\"row\">";
              echo "<div class=\"col-12 col-md-10 mx-auto\">";
              if (isset($_SESSION['motInput']) && !empty($_SESSION['motInput'])) {
                $motInput = $_SESSION['motInput'];
                echo "<div class=\"card bg-pers align-items-center mot-absent justify-content-betweeen\">";
                echo "<div class=\"mx-auto text-center mx-3 my-3 px-3\">";
                echo "<span class=\"font-weight-bold fz110p word-spac-10\"><i class=\"fas fa-exclamation-triangle fz110p lh-15 fa-sm text-danger mr-2\"></i>Le mot " . "<span class=\"text-blue2 font-weight-bold fz110p\">" . mb_strtoupper($motInput) . "</span>" . " n'est pas présent dans le dictionnaire.</span><br>";
                if($langue == 'fr'){
                  echo "<span class=\"font-weight-bold fz95-103-rem word-spac-10\">" . ($motScrabble == true ? "<span class=\"text-success\">Mot valide au Scrabble</span>" : "(Mot non valide au Scrabble)") . "</span>";
                }
                echo "</div></div></div></div><br><hr class=\"mt-pers-175r\"><br>";
              }
            }

            echo "<div class=\"row\">";
            echo "<div class=\"col-12 col-md-10 mx-auto text-center\">";
            if (empty($anagrammes)) {
              echo "<span class=\"font-weight-bold fz110p word-spac-10\"><i class=\"fas fa-exclamation-triangle fz110p lh-15 fa-sm text-danger mr-2\"></i>Il n'existe pas d'anagramme du mot <span class=\"text-blue2 fz110p\">" . ($_SESSION['motDico'] !== '-' ? mb_strtoupper($motDico) : mb_strtoupper($motInput)) . "</span></span><br>";
              echo "<hr class=\"my-4\">";
            } else {
              $nb_ana = count($anagrammes);
              echo "<span class=\"font-weight-bold fz110p word-spac-10\"><i class=\"fas fa-check fa-sm text-info mr-2\"></i>Il existe <span class=\"text-success fz110p\">" . $nb_ana . " anagramme" . ($nb_ana > 1 ? 's' : '') . "</span> du mot " . "<span class=\"text-info fz110p\">" . ($_SESSION['motDico'] !== '-' ? mb_strtoupper($motDico) : mb_strtoupper($motInput)) . "</span>&nbsp;:</span><br>";
              echo "<ul id=\"liste-anagrammes\" class=\"" . ($nb_ana < 6 ? "list-group mx-5 mx-md-0" : "list-group2") . " resultat my-3 justify-content-center\">";
              foreach ($anagrammes as $k => $v) {
                echo "<a id=\"anna_" . $k . "\" class=\"click-def link-no-effect\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\"><li class=\"" . ($nb_ana < 6 ? "list-group-item mb-0 mb-md-2 mx-0 mx-md-1" : "list-group-item2 mb-2 mx-1") . " list-group-item-secondary fz90-100-rem-li resultat\"><b>$v</b></li></a>";
              }
              echo "</ul>";
              echo "<hr class=\"my-4\">";
            }
            echo "</div>";
            echo "</div>";

            if (!empty($motsPossibles)) {

              echo "<div class=\"row\">";
              echo "<div class=\"col-11 col-lg-10 mx-auto titreResTemp d-flex align-items-center justify-content-between flex-row flex-nowarp w-100 pl-2 pl-md-3 pl-lg-4 pr-2 mb-2\">";
              echo "<span class=\"font-weight-bold letter-spaces fz110p\"><i class=\"fas fa-caret-right mr-2 text-dark\"></i>Mots existants avec les lettres du mot " . ($_SESSION['motDico'] !== '-' ? mb_strtoupper($motDico) : mb_strtoupper($motInput)) . "</span>";
              echo "<span><i class=\"fas fa-level-down-alt fa-lg text-success mr-2 mr-lg-5 ml-1 ml-md-3\"></i></span>";
              echo "</div>";
              echo "<div id=\"listesMotsPossibles\" class=\"col-12 col-md-10 mx-auto text-center bord-index-resultats mb-5\">";
              for ($i = 0; $i < count($motsPossibles); $i++) {
                if ($i != count($motsPossibles) - 1) {
                  echo $motsPossibles[$i];
                  echo "<hr class=\"my-1\">";
                } else {
                  echo $motsPossibles[$i];
                  echo "<div class=\"mb-1\"></div>";
                }
              }
              echo "</div>";
              echo "</div>";
            }
            echo "</div>";
            echo "</div>";
          }

          ?>
          <div class="popup" pd-popup="popupNew">
            <div id="dicolink" class="popup-inner">
              <span class="d-block font-weight-bold fz110-120">Définition de <span class="d-inline font-weight-bold fz115-130 text-blue2"><?= mb_strtoupper($motDico); ?></span></span>
              <?php
              echo "<ul class=\"definition\">";
              for ($i = 0; $i < $nbElements; $i++) {
                if ($i == 0) {
                  echo "<span class=\"d-block fz1rem text-titre-def-popup text-left mt-4 mb-2\">Source : " . $ensDef[$i]['source'] . "</span>";
                } else {
                  if ($ensDef[$i]['source']  != $ensDef[$i - 1]['source'] ) {
                    echo "<hr class=\"my-3\">";
                    echo "<span class=\"d-block fz1rem text-titre-def-popup text-left mb-2\">Source : " . $ensDef[$i]['source']  . "</span>";
                  }
                }
                echo "<li class=\"mb-2\">";
                echo "<span class=\"puce d-block fz90-100-rem\">".($ensDef[$i]['nature'] != "" ? "(<em>".$ensDef[$i]['nature']."</em>) " : ""). $ensDef[$i]['definition'] . "</span>";
                echo "</li>";
              }
              echo "</ul>";
              ?>
              <div id="closeDicolink">
                <p class="text-right"><a pd-popup-close="popupNew" href="#" class="btn btn-sm btn-danger popupClose">Fermer</a></p>
                <a class="popup-close popupClose" pd-popup-close="popupNew" href="#"> </a>
              </div>
            </div>
          </div>

          <?php


          $_SESSION['motDico'] = '';
          $_SESSION['motAvant'] = '';
          $_SESSION['motApres'] = '';
          $_SESSION['motInput'] = '';
          $_SESSION['motSlug'] = '';
          $_SESSION['anagrammes'] = [];
          $_SESSION['motsPossibles'] = [];
          $_SESSION['motDicoId'] = 0;
          $_SESSION['dicolink'] = [];
          $_SESSION['motScrabble'] = '';
          $_SESSION['langue'] = '';
          ?>

        </section>
        <!-- ############################################################### -->
        <!-- END - SECTION RESULTATS ANAGRAMMES -->
        <!-- ############################################################### -->



        <!-- ############################################################### -->
        <!-- START - SECTION RESULTATS AJOUGRAMME -->
        <!-- ############################################################### -->
        <section class="resultatsAjougramme container">
          <?php
          if (isset($_SESSION['possibiliteTab']) && $_SESSION['ajout'] == true) {
            echo "<div class=\"col-12 col-md-10 mx-auto pt-0 pt-md-3 text-center pb-5\">";
            $nb_total = $_SESSION['nbjockersAna'];
            $resultat = $_SESSION['possibiliteTab'];
            $nb_car = $_SESSION['motJokTabNb'];
            $nb_jok = $_SESSION['motJokTabNbJok'];
            $lettresInput = $_SESSION['motJokLet'];
            $tabRef = $_SESSION['motsjockersAna'];

            if ($nb_total == 0) {
              echo "<span class=\"d-block text-center font-weight-bold fz110p titreRes mb-3\"><i class=\"fa fa-exclamation-triangle fz110p lh-15 fa-sm text-danger mr-3\"></i>Il n'existe pas de mot de " . $nb_car . " lettres avec les lettres  <span class=\"text-success fz110p\">\"" . $lettresInput . "\"</span> et <span class=\"text-success fz110p\">" . $nb_jok . " jocker" . ($nb_jok > 1 ? 's' : '') . "</span></span><br><br>";
            } else {
              echo "<span class=\"d-block text-center font-weight-bold fz110p titreRes mb-3\">Avec les lettres <span class=\"text-success fz115p-100\">\"" . $lettresInput . "\"</span> et&nbsp; <span class=\"text-success fz115p-100\">" . $nb_jok . "&nbsp;jocker" . ($nb_jok > 1 ? 's' : '') . "</span>&nbsp;:&nbsp; <span class=\"text-info fz115p-100\">" . $nb_total . "&nbsp;combinaison" . ($nb_total > 1 ? 's' : '') . " de " . $nb_car . " lettres</span>&nbsp;</span><br>";
              echo "<div id=\"listeAjoutgrams\" class=\"col-12 col-md-10 mx-auto text-center mt-2\">";
              // echo "<div id=\"loaderAjougramme\" class=\"loader-results\"></div>";

              $nbAjgr = 0;
              foreach ($resultat as $k => $v) {
                if (count($resultat[$k]) > 0) {
                  echo "<span class=\"font-weight-bold fz110p mr-2\">
                    <i class=\"fas fa-check fa-sm text-info mr-2\"></i>
                    Avec la lettre jocker&nbsp;
                    <span class=\"text-danger fz110p\">" . mb_strtoupper($k) . "</span>&nbsp;&nbsp;:&nbsp;&nbsp; 
                    <span class=\"text-success fz110p\">" . count($v) . " mot" . (count($v) > 1 ? 's' : '')  . "</span>
                  </span><br>";
                  echo "<ul class=\"list-group resultat my-3 justify-content-center\">";
                  foreach ($resultat[$k] as $c) {
                    echo "<a id=\"ajoutgram_" . $nbAjgr . "\" class=\"click-def link-no-effect\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\"><li class=\"list-group-item list-group-item-secondary mb-0 mb-md-2 mx-0 mx-md-1 resultat\"><b>" . $c . "</b></li></a>";
                    $nbAjgr++;
                  }
                  echo "</ul><hr>";
                }
              }
              echo "</div>";
            }
            echo "</div>";
          }
          $_SESSION['nbjockersAna'] = 0;
          $_SESSION['possibiliteTab'] = [];
          $_SESSION['motJokTabNb'] = [];
          $_SESSION['motJokTabNbJok'] = 0;
          $_SESSION['motJokLet'] = '';
          $_SESSION['motsjockersAna'] = '';
          $_SESSION['ajout'] = false;
          $_SESSION['def'] = '';
          $_SESSION['source'] = '';
          $_SESSION['nb_elements'] = 0;
          ?>

        </section>
        <!-- ############################################################### -->
        <!-- END - SECTION RESULTATS AJOUGRAMME -->
        <!-- ############################################################### -->


        <!-- ############################################################### -->
        <!-- START - SECTION RESULTATS MOTROU -->
        <!-- ############################################################### -->
        <section class="resultatsTrou container">
          <?php
          if (isset($_SESSION['resTrou']) && $_SESSION['trou'] == true) {
            echo "<div class=\"col-12 col-md-10 mx-auto pt-0 pt-md-3 text-center\">";
            $_SESSION['resTrou'];
            $nb_resultat = count($_SESSION['resTrou']);
            $pattern = $_SESSION['pattern'];
            if ($nb_resultat != 0) {
              $resTrou = $_SESSION['resTrou'];
              $lettersInput = $_SESSION['lettresInput'];
              $nb_lettres = $_SESSION['nbLettres'];
              $nb_jok = $_SESSION['nbJok'];
              $trouOk = $_SESSION['trou'];
              echo "<span class=\"d-block text-center font-weight-bold fz110p titreRes mb-3 word-spac-10\"><span class=\"text-info fz110p\">$nb_resultat possibilité" . ($nb_resultat > 1 ? 's' : '') . "</span> avec le modèle <span class=\"text-success fz110p\">\"$pattern\"</span>&nbsp;:&nbsp;</span>";
              echo "<div id=\"listeTrous\" class=\"col-12 col-md-10 mx-auto text-center\">";
              echo "<ul id=\"listeAtrous\" class=\"list-group resultat my-3 justify-content-center\">";
              $nbatr = 0;
              foreach ($resTrou as $v) {
                $v = htmlspecialchars_decode($v);
                echo "<a id=\"atrou_" . $nbatr . "\" class=\"click-def link-no-effect\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\"><li class=\"list-group-item list-group-item-secondary mb-0 mb-md-2 mx-0 mx-md-1 resultat\"><b>" . $v . "</b></li></a>";
                $nbatr++;
              }
              echo "</ul><br>";
              echo "</div>";
            } else {
              echo "<span class=\"d-block text-center font-weight-bold fz110p titreRes mb-3\"><i class=\"fas fa-exclamation-triangle fz110p lh-15 fa-sm text-danger mr-3\"></i><span class=\"text-info fz110p\">Aucune possibilité</span> avec le modèle <span class=\"text-success fz110p text-nowrap\">\"$pattern\"</span>.</span><br>";
            }
            echo "</div>";
          }
          $_SESSION['resTrou'] = [];
          $_SESSION['lettresInput'] = 0;
          $_SESSION['nbLettres'] = 0;
          $_SESSION['nbJok'] = 0;
          $_SESSION['pattern'] = '';
          $_SESSION['trou'] = false;
          ?>

        </section>
        <!-- Fin de resGeneral -->

      </div>
      <!-- ############################################################### -->
      <!-- FIN - SECTION RESULTATS MOTROU -->
      <!-- ############################################################### -->



      <!-- ############################################################### -->
      <!-- START - SECTION MODAL DEFINITION WIKI -->
      <!-- ############################################################### -->
      <div class="modal fade" id="apiWiki" tabindex="-1" pd-popup="popupWiki" aria-labelledby="apiWikiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-title" id="apiWikilLabel">
                <div id="motWikiAff" class="d-flex align-items-center"></div>
              </div>
              <button class="border-0">
                <a class="popup-close popupCloseWiki" id="closeWikiArrow" pd-popup-close="popupWiki" data-dismiss="modal" aria-label="Close" href="#"> </a>
              </button>
            </div>
            <div id="wikiBody" class="modal-body">
              <div id="loader"></div>
              <div id="imgWikiAff"></div>
              <div id="line-separator"></div>
              <div id="defsWikiAff"></div>
              <div id="cadreComplement" class="display-cadre-complement cadre-complement my-3">
                <div id="closeComp" class="close-container">
                  <div class="leftright"></div>
                  <div class="rightleft"></div>
                </div>
                <div id="complementAff"></div>
                <div id="line-separatorComp"></div>
                <div id="defsCompAff"></div>
              </div>
              <div class="d-flex align-items-end justify-content-between pb-3">
                <div id="linkPageWiki"></div>
                <p class="mb-0"><a id="closeWikiBtn" pd-popup-close="popupWiki" data-dismiss="modal" href="#" class="btn btn-sm btn-danger popupCloseWiki">Fermer</a></p>
              </div>
            </div>
            <div class="modal-footer">
              <div id="CreditWiki" class="d-flex justify-content-around align-items-center credit-wiki py-1 w-90 mx-auto">
                <div class="text-center w-85 fz80-90">Définition issue du <a href="https://fr.wiktionary.org/" class="fz80-90" alt="Site du Wiktionnaire, dictionnaire francophone libre et gratuit" target="_blank">Wiktionnaire</a>,
                  dictionnaire francophone libre et gratuit.</div>
                <div class="w-20 text-center my-auto">
                  <a href="https://creativecommons.org/licenses/by-sa/3.0/fr/" class="fz80-90" target="_blank"><img class="w-logo-cc" src="assets/img/CC-BY-SA-logo.png" alt="Logo Creative Commons CC-BY-SA-" /></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ############################################################### -->
      <!-- FIN - SECTION MODAL DEFINITION WIKI -->
      <!-- ############################################################### -->


    </div>
    <!-- END - Layout Contenu -->


    <!-- ############################################################### -->
    <!-- START - FOOTER -->
    <!-- ############################################################### -->
    <footer id="layoutDefault_footer" class="footer">

      <div class="container-fluid d-none d-lg-block py-1 footer-align bg-darkos footer-dark">
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
    <!-- ############################################################### -->
    <!-- END - FOOTER -->
    <!-- ############################################################### -->
    <div id="scrolltotop">
      <div></div>
    </div>


  </div>
  <!-- END - Layout Global -->

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="assets/js/app.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/cookie-consent-box@2.4.0/dist/cookie-consent-box.min.js"></script>

</body>

</html>