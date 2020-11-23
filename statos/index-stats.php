<?php
session_start();
require '../app/toolbox.php';
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex" />

  <!-- FAVICONS -->
  <link rel="icon" type="image/png" sizes="32x32" href="https://lettres-au-mot.fr/statos/assets-stats/img/favicon-letters/favicon-32x32.png">

  <title>Lettres Au Mot - Statistiques</title>

  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,900;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <!-- CSS Perso -->
  <link rel="stylesheet" href="https://lettres-au-mot.fr/statos/assets-stats/css-stats/function-table-bootstrap.css">
  <link rel="stylesheet" href="https://lettres-au-mot.fr/statos/assets-stats/css-stats/style-stats.css">

  <style>
    .width-large {
      width: auto;
    }

    .w-90 {
      width: 90%;
    }

    .bg-stats {
      background-color: #fcfcfa;
      border-top: #fcfcfa !important;
    }

    .border-bott {
      border-bottom: 1px solid #dee2e6;
    }

    #recapStats tr td {
      text-align: center;
    }

    #recapStats {
      display: none;
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
  <div id="layoutDefault" class="width-large">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light nav-bg">
      <a class="navbar-brand titre-logo" href="https://lettres-au-mot.fr/index.php">Lettres au Mot</a>
      <button class="navbar-toggler my-2 mr-5" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse fg-0 navbar-collapse ml-auto mr-0" id="navbarNav">
        <ul class="navbar-nav w-50-resp2 mr-auto bg-menu">
          <li class="nav-item dropdown mresp bg-li-list">
            <a class="nav-link dropdown-toggle rad-haut" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Les outils
            </a>
            <div class="dropdown-menu ml-3 ml-lg-1 mb-3" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="https://lettres-au-mot.fr/index.php">Anagrammeur</a>
              <a class="dropdown-item" href="https://lettres-au-mot.fr/maxpossibilator.php">MaxPossibilator</a>
              <div class="dropdown-divider-perso"></div>
              <a class="dropdown-item" href="https://lettres-au-mot.fr/explications-outils.php">Explications</a>
            </div>
          </li>
          <li class="nav-item mx-0 mx-lg-5 dropdown">
            <a class="nav-link rad-bas" href="https://lettres-au-mot.fr/contact.php">Contact</a>
          </li>
        </ul>
        <ul class="list-group list-group-horizontal-lg w-100 d-lg-none">
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php">
            <li id="indexStatMini" class="list-group-item fz-table link-li-tables ml-5">Index Stats</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=visiteur">
            <li id="visiteurMini" class="list-group-item fz-table link-li-tables ml-5">Table User</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=recherche">
            <li id="rechercheMini" class="list-group-item fz-table link-li-tables ml-5">Table Recherche</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=recherche_wiki">
            <li id="recherche_wikiMini" class="list-group-item fz-table link-li-tables ml-5">Table Recherche Wiki</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=message">
            <li id="messageMini" class="list-group-item fz-table link-li-tables ml-5">Table Message</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=erreur">
            <li id="erreurMini" class="list-group-item fz-table link-li-tables ml-5">Table Erreur</li>
          </a>
        </ul>
      </div>
    </nav>

    <!-- START - Layout Contenu -->
    <div id="layoutDefault_content" role="main">

      <!-- ############################################################### -->
      <!-- START - SECTION SELECTION TABLE -->
      <!-- ############################################################### -->

      <!-- Navbar de sélection des tables -->
      <section class="menu-tables container-fluid mx-0 px-0 mt-0 mb-3 row">
        <ul class="list-group list-group-horizontal-lg w-100 d-none d-lg-flex">
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php">
            <li id="indexStat" class="list-group-item fz-table link-li-tables ml-5">Index Stats</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=visiteur">
            <li id="visiteur" class="list-group-item fz-table link-li-tables ml-5">Table User</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=recherche">
            <li id="recherche" class="list-group-item fz-table link-li-tables ml-5">Table Recherche</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=recherche_wiki">
            <li id="recherche_wiki" class="list-group-item fz-table link-li-tables ml-5">Table Recherche Wiki</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=message">
            <li id="message" class="list-group-item fz-table link-li-tables ml-5">Table Message</li>
          </a>
          <a class="link-tables" href="https://lettres-au-mot.fr/statos/index-stats.php?table=erreur">
            <li id="erreur" class="list-group-item fz-table link-li-tables ml-5">Table Erreur</li>
          </a>
        </ul>

        <?php
        $page = ['visiteur', 'recherche', 'recherche_wiki', 'message', 'erreur'];
        foreach ($page as $i => $p) {
          if (isset($_GET['table']) && $_GET['table'] == $p) {
            require $p . '-table-stats.php';
          }
        }
        ?>
      </section>
      <!-- ############################################################### -->
      <!-- END - SECTION SELECTIONTABLE -->
      <!-- ############################################################### -->



      <!-- ############################################################### -->
      <!-- START - NOTIFICATIONS DES ERREURS -->
      <!-- ############################################################### -->

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
      <!-- END - NOTIFICATIONS DES ERREURS -->
      <!-- ############################################################### -->



      <!-- ############################################################### -->
      <!-- START - STATISTIQUES -->
      <!-- ############################################################### -->
      <div id="recapStats">
        <?php

        require '../app/bdd.php';

        $page = ['visiteur', 'recherche', 'recherche_wiki', 'message', 'erreur'];
        $req = ['date_connexion', 'date_realisation', 'created_at', 'date_envoi', 'created_at'];

        $interval_txt = [
          'Statistiques des dernières 24 heures',
          'Statistiques des 7 derniers jours',
          'Statistiques du dernier mois',
          'Statistiques des 3 derniers mois'
        ];
        $interval = [
          'DATE_SUB(NOW(), INTERVAL 24 HOUR)',
          'DATE_SUB(NOW(), INTERVAL 1 WEEK)',
          'DATE_SUB(NOW(), INTERVAL 1 MONTH)',
          'DATE_SUB(NOW(), INTERVAL 3 MONTH)'
        ];

        foreach ($interval as $i => $int) {
          foreach ($page as $ip => $p) {
            $stat = $dbh->prepare('SELECT * FROM ' . $p . ' WHERE ' . $req[$ip] . ' >= ' . $int . ' ORDER BY ' . $req[$ip] . ' DESC');
            $stat->execute();
            $res = $stat->fetchAll(PDO::FETCH_OBJ);

            if ($p == 'visiteur') {
              $visite = count($res);
              foreach ($res as $i => $v) {
                $ip = $v->ip;
                $localisationTab[] = $v->pays . ' (' . $v->ville . ')';
                $ipTab[] = $ip;
              }
              $ipTabUnique = array_unique($ipTab);
            }

            if ($p == 'recherche') {
              $nbAnna = 0;
              $nbMax = 0;
              foreach ($res as $i => $v) {
                if ($v->mot != '') {
                  $nbAnna++;
                  $annaTab[] = $v->mot;
                }
                if ($v->maxpo != '') {
                  $nbMax++;
                  $maxTab[] = $v->maxpo;
                }
                $v->mot != '' ? $nbAnna++ : ($v->maxpo != '' ? $nbMax++ : $error++);
              }
            }

            if ($p == "recherche_wiki") {
              $nbWiki = count($res);
              foreach ($res as $i => $v) {
                $wikiTab[] = $v->mot_wiki;
              }
            }

            if ($p == "message") {
              $nbMessage = count($res);
            }


            if ($p == "erreur") {
              $nbErreur = count($res);
              foreach ($res as $i => $v) {
                $erreurTab[] = $v->code_erreur;
              }
            }
          }
          $visiteTotal[] = $visite;
          $visite = 0;
          $ipTabTotal[] = $ipTab;
          $ipTab = [];
          $ipTabUniqueTotal[] = $ipTabUnique;
          $ipTabUnique = [];

          $localisationTabTotal[] = $localisationTab;
          $localisationTab = [];

          $nbMaxTotal[] = $nbMax;
          $nbMax = 0;
          $maxTabTotal[] = $maxTab;
          $maxTab = [];

          $nbAnnaTotal[] = $nbAnna;
          $nbAnna = 0;
          $annaTabTotal[] = $annaTab;
          $annaTab = [];

          $nbWikiTotal[] = $nbWiki;
          $nbWiki = 0;
          $wikiTabTotal[] = $wikiTab;
          $wikiTab = [];

          $nbMessageTotal[] = $nbMessage;
          $nbMessage = 0;

          $nbErreurTotal[] = $nbErreur;
          $nbErreur = 0;
          $erreurTabTotal[] = $erreurTab;
          $erreurTab = [];
        }
        ?>

        <section class="container stats">
          <h3 class="text-center titre-table text-danger mt-4 mb-4">Statistiques</h3>
          <!-- <?php printPre($annaTabTotal) ?>; -->
          <table class="table w-auto">

            <tr>
              <td class="bg-stats"></td>
              <th scope="col">Depuis 1 jour</th>
              <th scope="col">Depuis 1 semaine</th>
              <th scope="col">Depuis 1 mois</th>
              <th scope="col">Depuis 3 mois</th>
            </tr>

            <tr>
              <th scope="row" class="w-auto">Nombre de visites</th>
              <td><?= $visiteTotal[0]; ?></td>
              <td><?= $visiteTotal[1]; ?></td>
              <td><?= $visiteTotal[2]; ?></td>
              <td><?= $visiteTotal[3]; ?></td>
            </tr>

            <tr>
              <th scope="row" class="w-auto">Nombre de visites uniques</th>
              <td><?= isset($ipTabUniqueTotal[0]) ? count($ipTabUniqueTotal[0]) : 0; ?></td>
              <td><?= isset($ipTabUniqueTotal[1]) ? count($ipTabUniqueTotal[1]) : 0; ?></td>
              <td><?= isset($ipTabUniqueTotal[2]) ? count($ipTabUniqueTotal[2]) : 0; ?></td>
              <td><?= isset($ipTabUniqueTotal[3]) ? count($ipTabUniqueTotal[3]) : 0; ?></td>
            </tr>

            <tr>
              <th scope="row" class="w-auto">Nombre de recherches "annagrammeur"</th>
              <td><?= isset($annaTabTotal[0]) ? count($annaTabTotal[0]) : 0; ?></td>
              <td><?= isset($annaTabTotal[1]) ? count($annaTabTotal[1]) : 0; ?></td>
              <td><?= isset($annaTabTotal[2]) ? count($annaTabTotal[2]) : 0; ?></td>
              <td><?= isset($annaTabTotal[3]) ? count($annaTabTotal[3]) : 0; ?></td>
            </tr>

            <tr>
              <th scope="row" class="w-auto">Nombre de recherches "maxPoss"</th>
              <td><?= isset($maxTabTotal[0]) ? count($maxTabTotal[0]) : 0; ?></td>
              <td><?= isset($maxTabTotal[1]) ? count($maxTabTotal[1]) : 0; ?></td>
              <td><?= isset($maxTabTotal[2]) ? count($maxTabTotal[2]) : 0; ?></td>
              <td><?= isset($maxTabTotal[3]) ? count($maxTabTotal[3]) : 0; ?></td>
            </tr>

            <tr>
              <th scope="row" class="w-auto">Nombre de recherches "Wiki"</th>
              <td><?= isset($wikiTabTotal[0]) ? count($wikiTabTotal[0]) : 0; ?></td>
              <td><?= isset($wikiTabTotal[1]) ? count($wikiTabTotal[1]) : 0; ?></td>
              <td><?= isset($wikiTabTotal[2]) ? count($wikiTabTotal[2]) : 0; ?></td>
              <td><?= isset($wikiTabTotal[3]) ? count($wikiTabTotal[3]) : 0; ?></td>
            </tr>

            <tr>
              <th scope="row" class="w-auto">Nombre de messages</th>
              <td><?= $nbMessageTotal[0]; ?></td>
              <td><?= $nbMessageTotal[1]; ?></td>
              <td><?= $nbMessageTotal[2]; ?></td>
              <td><?= $nbMessageTotal[3]; ?></td>
            </tr>

            <tr>
              <th scope="row" class="w-auto border-bott">Nombre d'erreurs</th>
              <td class="border-bott"><?= $nbErreurTotal[0]; ?></td>
              <td class="border-bott"><?= $nbErreurTotal[1]; ?></td>
              <td class="border-bott"><?= $nbErreurTotal[2]; ?></td>
              <td class="border-bott"><?= $nbErreurTotal[3]; ?></td>
            </tr>

          </table>

        </section>

      </div>


      <!-- ############################################################### -->
      <!-- END - STATISTIQUES -->
      <!-- ############################################################### -->

    </div>
    <!-- END - Layout Contenu -->


  </div>
  <!-- END - Layout Global -->

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script>
  $(function () {
    $ref = window.location.search;
    console.log($ref);
    if ($ref == "") {
        $('#recapStats').show();
        $('.link-li-tables').each(function () {
            $(this).removeClass('active');
        })
        $('#indexStat').addClass('active');
        $('#indexStatMini').addClass('active');
    } else {
        $('#recapStats').hide();
        $page = ['visiteur', 'recherche', 'recherche_wiki', 'message', 'erreur'];
        for (let i = 0; i < 5; i++) {
            $currentPage = $page[i];
            $curPage = "?table=" + $currentPage;
            if ($ref.includes($curPage)) {
                $('.link-li-tables').each(function () {
                    $(this).removeClass('active');
                })
                $('#' + $currentPage).siblings('li').removeClass('active');
                $('#' + $currentPage).addClass('active');
                $('#' + $currentPage + 'Mini').addClass('active');
            }
        }
    }
  });
  </script>
</body>

</html>