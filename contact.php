<?php
session_start();
require 'app/toolbox.php';
$_SESSION['nbRecapLettres'] = 0;

?>

<!doctype html>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Lettres Au Mot, site d'aide à la résolution de jeux de lettres. Utilisez ce formulaire de contact pour nous envoyer un message : problèmes rencontrés, suggestions d'amélioration... ou pour tout autre chose !">
  <meta name="author" content="Frédéric Gainza">

  <!-- FAVICONS -->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon-letters/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-letters/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-letters/favicon-16x16.png">
  <link rel="manifest" href="assets/img/favicon-letters/site.webmanifest">
  <link rel="mask-icon" href="assets/img/favicon-letters/safari-pinned-tab.svg" color="#5bbad5">

  <title>Lettres Au Mot - Formulaire de contact</title>

  <link rel="canonical" href="https://lettres-au-mot.fr/contact.php">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,900;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- CSS Perso -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>

  <!-- START - Layout Global -->
  <div id="layoutDefault2">

    <!-- Navbar -->
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
            <a class="nav-link nav-active icon rad-bas" href="contact.php">Contact</a>
          </li>
        </ul>
        <div class="d-lg-none">
          <a class="nav-link-foot fz95" href="mentions-legales.php">Mentions Légales</a>
          <a class="nav-link-foot fz95" href="https://fgainza.fr" target="_blank">Réalisation du site</a>
          <span class="nav-link-foot mb-3 fz95">2020 &copy; Lettres-Au-Mot</span>
        </div>
      </div>
    </nav>

    <!-- Plugin Facebook - Affichage -->
    <div class="container  mx-auto w-50 my-3">
      <div class="d-flex align-items-center justify-content-center flex-resp mx-3 ">
        <div class="fb-page d-none d-md-block" data-href="https://www.facebook.com/Lettres-Au-Mot-101268365119634" data-width="450" data-height="" data-hide-cover="false" data-hide-cta="true" data-show-facepile="false"></div>
        <div class="fb-page d-md-none" data-href="https://www.facebook.com/Lettres-Au-Mot-101268365119634" data-width="300" data-height="" data-hide-cover="false" data-hide-cta="true" data-show-facepile="false"></div>
      </div>
    </div>


    <!-- START - Layout Contenu -->
    <div id="layoutDefault_content" role="main">

      <!-- Notification des erreurs -->
      <div class="container w-notif mx-auto mt-1">
        <?php if (!empty($_SESSION['errors'])  || !empty($_SESSION['success'])) : ?>
          <?php
          $notification = '';
          if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
            $notification = $_SESSION['errors'];
            $color = 'danger';
          } else {
            if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
              $notification = $_SESSION['success'];
              $color = 'success';
            }
          }
          ?>
          <div id="alert" class="alert font-weight-bold col-md-12 py-3 mb-30 alert-dismissible color-perso-<?= $color; ?> alert-<?= $color; ?> fade show showIn" role="alert">
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
      <!-- START - SECTION FORMULAIRE -->
      <!-- ############################################################### -->
      <section class="formulaire">
        <div class="container pt-2 mb-2">
          <div class="row bg-text-form mx-2">
            <h1 class="d-block contact text-left ml-3 ml-lg-5 py-2">Merci d'utiliser le formulaire suivant pour nous contacter.</h1>
          </div>
          <form action="app/traitement-form.php" method="POST" id="formContact" class="mt-4 pb-4 cool-b4-form needs-validation" novalidate>
            <fieldset class="form-border">
              <legend class="form-border">Contact</legend>
              <div class="row mx-auto align-items-center justify-content-center fade show" id="validForm"></div>
              <div class="wrap">
                <div class="form-row">
                  <div class="col-12">

                    <!-- Nom -->
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" id="name" required>
                      <label for="name">Nom</label>
                      <span class="input-highlight"></span>
                      <div class="valid-feedback">Saisie correcte</div>
                      <div class="invalid-feedback">Saisie incorrecte de votre nom</div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                      <input type="email" class="form-control" name="email" id="email" required>
                      <label for="email">Email</label>
                      <span class="input-highlight"></span>
                      <div class="valid-feedback">Saisie correcte</div>
                      <div class="invalid-feedback">Saisie incorrecte de votre adresse mail</div>
                    </div>

                    <!-- Sujet -->
                    <div class="form-group">
                      <input type="text" class="form-control" name="subject" id="subject" required>
                      <label for="subject">Sujet</label>
                      <span class="input-highlight"></span>
                      <div class="valid-feedback">Saisie correcte</div>
                      <div class="invalid-feedback">Saisie incorrecte de votre message</div>
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                      <textarea name="message" id="message" class="form-control" rows="6" required></textarea>
                      <label for="message">Message</label>
                      <span class="input-highlight"></span>
                    </div>
                  </div>
                </div>

                <!-- ReCaptcha -->
                <div class="form-row justify-content-center justify-content-lg-end">
                  <div class="g-recaptcha pt-3" data-sitekey="6LeXgtYZAAAAAIvcF44o2eR2q2a_YTJcOcDQ4JzH"></div>
                </div>
                <div class="form-row">
                  <div class="col-12 mx-auto mt-2">

                    <!-- Bouton Submit -->
                    <div class="form-group">
                      <button type="submit" class="btn btn-lg btn-blue-submit btn-block">Envoyer</button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
        </fieldset>
        </form>
    </div>
    </section>
    <!-- ############################################################### -->
    <!-- END - SECTION FORMULAIRE -->
    <!-- ############################################################### -->

  </div>
  <!-- END - Layout Contenu -->


  <!-- ############################################################### -->
  <!-- START - FOOTER -->
  <!-- ############################################################### -->
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
  <!-- ############################################################### -->
  <!-- END - FOOTER -->
  <!-- ############################################################### -->

  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="assets/js/app.js"></script>

</body>

</html>