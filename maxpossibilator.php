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
    <meta name="description" content="Lettres Au Mot, site d'aide à la résolution de jeux de lettres. Utilisez l'outil MaxPossibilator pour trouver tous les mots possibles contenant les lettres que vous souhaitez. Outil qui peut vous aider dans vos mots croisés ou dans divers jeux littéraires.">

    <meta name="author" content="Frédéric Gainza">
    <meta name="theme-color" content="#ffffff">

    <!-- FAVICONS -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon-letters/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-letters/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-letters/favicon-16x16.png">
    <link rel="manifest" href="assets/img/favicon-letters/site.webmanifest">
    <link rel="mask-icon" href="assets/img/favicon-letters/safari-pinned-tab.svg" color="#5bbad5">

    <title>Lettres Au Mot - Outil MaxPossibilator</title>

    <link rel="canonical" href="https://lettres-au-mot.fr/maxpossibilator.php">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"">
  <!-- Cookie bar concentement -->
  <link rel=" stylesheet" href="https://cdn.jsdelivr.net/npm/cookie-consent-box@2.4.0/dist/cookie-consent-box.min.css" />
    <!-- CSS Perso -->
    <link rel="stylesheet" href="assets/css/style.css">
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
                <ul class="navbar-nav w-50-resp2 mt-2 mt-lg-0 mr-auto bg-menu">
                    <li class="nav-item dropdown mresp bg-li-list">
                        <a class="nav-link nav-active icon dropdown-toggle rad-haut" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Les outils
                        </a>
                        <div class="dropdown-menu ml-3 ml-lg-1 mb-3" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="index.php">Anagrammeur</a>
                            <a class="dropdown-item active" href="maxpossibilator.php">MaxPossibilator</a>
                            <div class="dropdown-divider-perso"></div>
                            <!-- <div class="dropdown-divider pb-3"></div> -->
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

        <!-- START - Layout Contenu -->
        <div id="layoutDefault_content" role="main">

            <!-- Notification des erreurs -->
            <div class="container w-50-90-resp mx-auto mt-1">
                <?php if (!empty($_SESSION['errors'])  || !empty($_SESSION['success'])) : ?>
                    <?php $notification = isset($_SESSION['errors']) ? $_SESSION['errors'] : (isset($_SESSION['success']) ? $_SESSION['success'] : ''); ?>
                    <?php $color = isset($_SESSION['errors']) ? 'danger-perso' : (isset($_SESSION['success']) ? 'success' : ''); ?>
                    <div id="alert" class="alert col-md-12 py-3 w-80 mx-10p mb-30 alert-dismissible alert-<?= $color; ?> fade show" role="alert">
                        <button type="button" class="close" id="close" data-dismiss="alert" aria-label="Close"><span class="fz-iconeClose" aria-hidden="true">&times;</span></button>
                        <?= '<i class=\"fas fa-exclamation-triangle fz110p lh-15 fa-sm text-danger mr-2\"></i>' . $notification; ?>
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

                        <!-- Link vers Anagrammeur -->
                        <div class="col-4 col-lg-2 align-self-start">
                            <a class="btn btn-info anagrammeurLink" href="index.php">Anagrammeur</a>
                        </div>

                        <!-- Gestion affichage fenêtre modale de présentation -->
                        <div class="col-8 col-lg-10 mt-1 mx-auto">
                            <div id="closePresMax" class="d-flex pt-2 mr-0 mr-lg-2 text-right link-fake align-self-end justify-content-end">
                                <button id="iconCloseMax" class="btn btn-sm-pers displayIconClose btn-danger align-items-center" data-toggle="tooltip" data-placement="top" data-trigger="hover" title="Fermer la fenêtre">
                                    Fermer la fenêtre&nbsp;&nbsp;<i class="far fa-times-circle text-white-red "></i>
                                </button>
                                <button id="iconEyeMax" class="btn btn-sm-pers btn-info-pers mr-0 mr-lg-5displayIconEye" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Afficher les infos">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Contenu présentation modale -->
                        <div id="presMax" class="displayDiv mx-3 mx-lg-4 presentation-style w-100 align-self-center">
                            <ul class="presMax">
                                <li class="mb-2 principe-max">
                                    Cet outil vous permet de trouver tous les mots contenant certaines lettres.
                                </li>
                                <li class="puce fz90resp pres-li ml-2 ml-lg-3">
                                    <u><em>Utilisation</em></u> : Vous indiquez le nombre de lettres du mot final et vous saisissez les lettres qu'il doit contenir.
                                </li>
                                <li class="puce fz90resp pres-li ml-2 ml-3">
                                    <u><em>Exemple</em></u> : Vous choisissez 7 pour le nombre de lettres du mot recherché, et vous saisissez les lettres B, C et E.<br>
                                    Vous obtiendrez alors tous les mots de 7 lettres qui contiennent les lettres B, C et E.
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
                    <h1 class="title-main mr-3 ml-auto mr-lg-0 ml-lg-5">MaxPossibilitator</h1>

                    <!-- Texte explicatif de l'outil -->
                    <div id="presResume" class="pres-resume rounded px-2 px-lg-3 mb-3">
                        <ul class="pres w-90 mx-auto">
                            <li class="pres-li">Trouver tous les mots possibles contenant les lettres que vous souhaitez.</li>
                            <span class="d-block small-pers ml-n2">(plus de détails dans la rubrique <a class="pol100p" href="explications-outils.php">explications</a> ou en cliquant sur l'icone <i class="fas pol80p fa-xs text-info fa-question"></i> en haut de cette page)</span>
                        </ul>
                    </div>

                    <!-- START - Formulaire -->
                    <form action="app/maxAnalyse.php" method="POST" id="formSaisie" class="formOutilMax was-validated">
                        <fieldset class="form-border">
                            <div class="row mx-auto align-items-center justify-content-around" id="validForm"></div>

                            <!-- Choix de la langue -->
                            <div class="form-group form-inline w-100 mx-0 row my-3 my-md-2">
                                <div id="langueChoisie" class="col-12 col-md-6 col-lg-8 ml-0 mr-md-auto"></div>
                                <label class="col-auto col-form-label col-forml-label-sm ml-sm-auto mr-0 pr-0" for="choixLangue">Modifier :</label>
                                <div class="col">
                                    <select id="choixLangue" name="langue" class="custom-select custom-select-sm py-0 form-control form-control-md w-100">
                                        <option value="fr">Français</option>
                                        <option value="en">Anglais</option>
                                        <option value="es">Espagnol</option>
                                        <option value="de">Allemand</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Ligne de séparation -->
                            <hr class="my-2">

                            <!-- Choix de la taille du mot cherché -->
                            <div class="form-group form-inline w-100 mx-0 row my-3 my-md-2">
                                <div id="nbLettres" class="col-12 col-md-6 col-lg-8 ml-0 mr-md-auto"></div>
                                <label class="col-auto col-form-label col-forml-label-sm ml-sm-auto mr-0 pr-0" for="nbCarMotFinal">Modifier : </label>
                                <div class="col">
                                    <div class="input-group input-group-sm is-invalid">
                                        <input type="number" class="form-control py-0 mx-auto w-input-letters input-letters noValidEffect" name="nbCarMotFinal" id="nbCarMotFinal" placeholder="Nombre de lettres" aria-describedby="msg-error-letter" aria-label="Mot Final" min="3" max="20" value="">
                                    </div>
                                </div>
                            </div>


                            <!-- Ligne de séparation -->
                            <hr class="my-2">


                            <div class="ml-3 mr-auto my-3 mt-3">
                                        <span class="text-info fz95resp fz-bolder">Saisir les lettres à inclure dans la recherche</span>
                                    </div>

                            <!-- Validation en direct du formulaire -->
                            <div class="row mx-0 mx-md-3 mt-1 mt-md-3 mb-0 infoSaisie">
                                <div class="col-12 col-md-4 align-left-resp text-nowrap">
                                    <span class="compt">Nombre de caractères saisis&nbsp;:&nbsp;&nbsp;<div class="d-inline fz95 font-weight-bold" id="compteur">&nbsp;0</div><span>
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
                                                    <input class="form-control form-control-borderless input-search" name="motInput" minlength="1" maxlenght="15" id="motInput" type="text" placeholder="Par ici la saisie !" required autofocus>
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
        <!-- START - SECTION RESULTATS MAXPOSSIBILITATOR -->
        <!-- ############################################################### -->
        <?php
        if (isset($_SESSION['resultatMax']) && $_SESSION['outilMax'] == true) {

            echo "<section class=\"resultatMax container mb-3\">";
            echo "<div id=\"resultatMax\">";
            $lettresInputAlphaTab = $_SESSION['lettresInputTab'];
            $nbLettresInput = $_SESSION['nbLettresInput'];
            $nbLettresOutput = $_SESSION['nbLettresOutput'];
            $resultatMaxSansAccents = $_SESSION['resultatMaxSansAccents'];
            $resultatMaxAvecAccents = $_SESSION['resultatMaxAvecAccents'];
            $accents = $_SESSION['accents'];
            $langue = $_SESSION['langue'];
            $lettresInputBrutTab = $_SESSION['lettresInputBruts'];

            if ($langue == "fr") {
                $accents == 'sansAccents' ? $resultatMax = $resultatMaxSansAccents : $resultatMax = $resultatMaxAvecAccents;
            } else {
                $resultatMax = $resultatMaxSansAccents;
            }
            $nbResultat = count($resultatMax);
            $pattern = '';
            foreach ($lettresInputBrutTab as $k => $v) {
                $k === 0 ?  $pattern .= strtoupper($v) : $pattern .= ' ' . strtoupper($v);
            }



            if ($nbResultat === 0) {
                echo "<div class=\"col-12 col-md-10 mx-auto pt-0 pt-md-1\">";
                echo "<span class=\"d-block text-center font-weight-bold fz110p titreRes mb-3\"><i class=\"fas far-times-circle fa-sm text-danger mr-2\"></i><span class=\"text-info fz110p\">Aucun mot de $nbLettresOutput lettres</span> ne contient" . ($nbLettresInput < 2 ? ' la lettre ' : ' les lettres ') . "<span class=\"fz110p text-nowrap\">\"$pattern\"</span></span><br>";
            } else {

                echo "<div class=\"back-explication mx-0\">";
                echo "<span class=\"d-block text-center text-darky-pers mb-2 mb-md-1 font-weight-bold fz110p\"><i class=\"fas fa-share mr-2 fa-xs text-success\"></i>
              Accès, par simple click, à la définition de chaque mot.<i class=\"fas fa-reply ml-2 fa-xs text-success\"></i><br></span>";
                echo "<span class=\"d-inline text-center text-darky-pers font-weight-bold fz110p\"><i class=\"fas fa-share mr-2 fa-xs text-success\"></i>
              Mise en évidence des lettres choisies dans les résultats en cliquant sur l'élément " .
                    "<input id=\"test-text\" type=\"checkbox\" data-toggle=\"toggle\" data-style=\"slooow\" data-offstyle=\"success-pers\" data-off=\"<i class='fas fa-sm text-white fa-tint'></i>\" data-onstyle=\"danger-pers\" data-on=\"<i class='fa fa-sm text-dark my-auto fa-tint-slash'></i>\" data-size=\"xs\" checked>" .
                    "<i class=\"fas fa-reply ml-2 fa-xs text-success\"></i></span></div><br>";
                echo "<div class=\"col-12 col-md-10 mx-auto pt-0 pt-md-1\">";
                echo "<span class=\"d-block titre-resultat my-4\">Résultats de la recherche</span>";
                echo "<span class=\"d-block text-center font-weight-bold fz110p titreRes mb-3\"><span class=\"text-info fz110p\">$nbResultat mot" . ($nbResultat > 1 ? 's' : '') . " de $nbLettresOutput lettres</span> contenant" . ($nbLettresInput < 2 ? ' la lettre ' : ' les lettres ') . "<span class=\"text-success fz110p text-nowrap\">\"$pattern\"</span></span><br>";

                $resTotal = [];
                $resLettre = [];
                $lettres = [];
                $strFirst = $resultatMax[0]->mot;
                $slugFirst = $resultatMax[0]->slug;
                $lettres[] = $slugFirst[0];
                $resLettre[] = $strFirst;

                foreach ($resultatMax as $k => $v) {
                    $mot = $v->mot;
                    $slug = $v->slug;
                    if ($k > 0) {
                        $slugAvant = $resultatMax[$k - 1]->slug;
                        $strAvant = $resultatMax[$k - 1]->mot;
                        $slug = $resultatMax[$k]->slug;
                        $str = $resultatMax[$k]->mot;
                        if ($slug[0] == $slugAvant[0]) {
                            $resLettre[] = $str;
                        } else {
                            $lettres[] = $slug[0];
                            $resTotal[] = $resLettre;
                            $resLettre = [];
                            $resLettre[] = $str;
                        }
                    }
                }
                if (!empty($resLettre)) {
                    $resTotal[] = $resLettre;
                    $resLettre = [];
                }

                $resFF = [];
                foreach ($lettresInputAlphaTab as $v) {
                    $r = mb_strtolower($v);
                    $newtab[] = $r;
                }
                $inputTabCount = array_count_values($newtab);

                echo "<div class=\"col-12 mx-auto\">";
                echo "<div id=\"lettresAlpha\" class=\"lettres-alpha d-flex justify-content-center align-items-center flex-wrap\">";
                foreach ($lettres as $k => $v) {
                    echo "<div class=\"pagination\"><a class=\"mx-auto\" href=\"#lettre_" . $v . "\">" . mb_strtoupper($v) . "</a></div>";
                }
                echo "</div>";
                echo "</div>";

                echo "<div id=\"resMax\" class=\"col-12 col-md-10 mx-auto px-0 pt-0 pt-md-1\">";
                $nb = 0;
                foreach ($resTotal as $k => $v) {
                    echo "<div class=\"mx-auto mt-3\">";
                    echo "<div id=\"lettre_" . $lettres[$k] . "\" class=\"card card-results-max\">";
                    echo "<div class=\"card-header card-header-max d-flex justify-content-between align-items-center\">";
                    echo "<span class=\"d-block font-weight-bold color-header text-left fz95-105resp text-blue2 ml-0 ml-sm-1 ml-md-2 ml-lg-3\"><i class=\"fas fa-caret-right fa-sm text-dark mr-2\"></i>" . count($v) . " mot" . (count($v) > 1 ? 's' : '') . "&nbsp; commençant par un&nbsp;&nbsp;" . mb_strtoupper($lettres[$k]) . "</span>";
                    echo "<input id=\"btn-" . mb_strtolower($lettres[$k]) . "\" type=\"checkbox\" data-toggle=\"toggle\" data-style=\"slooow\" data-offstyle=\"success-pers\" data-off=\"<i class='fas fa-sm text-white fa-tint'></i>\" data-onstyle=\"danger-pers\" data-on=\"<i class='fa fa-sm text-dark my-auto fa-tint-slash'></i>\" data-size=\"xs\" checked>";
                    echo "</div>";

                    // ######################################################################
                    // OPTION PAR DEFAUT - AFFICHAGE RESULTATS D'UNE SEULE COULEUR
                    // ######################################################################
                    echo "<div id=\"black-" . mb_strtolower($lettres[$k]) . "\" class=\"card-body-max\">";
                    echo "<ul class=\"list-group2 list-group3 resultat my-1 justify-content-center\">";
                    foreach ($v as $r) {
                        $resCol = [];
                        $rSlug = enleveaccents($r);
                        $motTab = mb_str_split($r);
                        $motTabSlug = mb_str_split($rSlug);
                        $outputTabCount = array_count_values($motTab);

                        foreach ($inputTabCount as $lettre => $occ) {
                            if ($occ != 0) {
                                if ($langue == "fr") {
                                    $accents == 'sansAccents' ? $key = array_search($lettre, $motTabSlug) : $key = array_search($lettre, $motTab);
                                } else {
                                    $key = array_search($lettre, $motTabSlug);
                                }
                                $letInp = $motTab[$key];
                                $motTab[$key] = '<span class="text-info">' . $letInp . '</span>';
                                $occ--;
                            }
                        }

                        $motCol = join($motTab);
                        echo "<li class=\"list-group-item-200 list-group-item-secondary mb-2 mx-1 fz90p-li resultat\"><b><a id=\"max_" . $nb . "\" class=\"click-def\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\">" . $r . "</a></b></li>";
                        $nb++;
                    }
                    echo "</ul>";
                    echo "</div>";

                    // ######################################################################
                    // OPTION COLOR - AFFICHAGE DES LETTRES CHOISIS AVEC COULEUR SPECIFIQUE
                    // ######################################################################
                    echo "<div id=\"color-" . mb_strtolower($lettres[$k]) . "\" class=\"card-body-max\" style=\"display:none\">";
                    echo "<ul class=\"list-group2 list-group3 resultat my-1 justify-content-center\">";
                    foreach ($v as $r) {
                        $resCol = [];
                        $rSlug = enleveaccents($r);
                        $motTab = mb_str_split($r);
                        $motTabSlug = mb_str_split($rSlug);
                        $outputTabCount = array_count_values($motTab);

                        foreach ($inputTabCount as $lettre => $occ) {
                            if ($occ != 0) {
                                if ($langue == "fr") {
                                    $accents == 'sansAccents' ? $key = array_search($lettre, $motTabSlug) : $key = array_search($lettre, $motTab);
                                } else {
                                    $key = array_search($lettre, $motTabSlug);
                                }
                                $letInp = $motTab[$key];
                                $motTab[$key] = '<span class="text-info">' . $letInp . '</span>';
                                $occ--;
                            }
                        }

                        $motCol = join($motTab);
                        echo "<li class=\"list-group-item-200 list-group-item-secondary mb-2 mx-1 fz90p-li resultat\"><b><a id=\"max_" . $nb . "\" class=\"click-def\" data-toggle=\"modal\" data-target=\"#apiWiki\" href=\"#\">" . $motCol . "</a></b></li>";
                        $nb++;
                    }
                    echo "</ul>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<br>";
                }
            }
            echo "</div>";
            echo "</div>";
        }

        $_SESSION['errors'] = '';
        $_SESSION['lettresInputTab'] = [];
        $_SESSION['nbLettresInput'] = 0;
        $_SESSION['nbLettresOutput'] = 0;
        $_SESSION['resultatMax'] = [''];
        $_SESSION['outilMax'] = false;

        $_SESSION['resultatMaxSansAccents'] = [];
        $_SESSION['resultatMaxAvecAccents'] = [];
        $_SESSION['accents'] = '';
        $_SESSION['langue'] = '';
        ?>
        </section>
        <!-- ############################################################### -->
        <!-- END - SECTION RESULTATS MAXPOSSIBILITATOR -->
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
    <div id="scrolltotop">
        <div></div>
    </div>

    </div>
    <!-- END - Layout Global -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="assets/js/app.js"></script>

</body>

</html>