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
  <meta name="description" content="Lettres Au Mot, site d'aide à la résolution de jeux de lettres. Quels sont les outils présents sur ce site ? Quelles sont les options, avec ou sans accents ? Présentation de l'intégration du dictionnaire libre Wiktionnaire.">
  <meta name="author" content="Frédéric Gainza">

  <!-- FAVICONS -->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon-letters/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-letters/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-letters/favicon-16x16.png">
  <link rel="manifest" href="assets/img/favicon-letters/site.webmanifest">
  <link rel="mask-icon" href="assets/img/favicon-letters/safari-pinned-tab.svg" color="#5bbad5">


  <title>Lettres Au Mot - Informations</title>

  <link rel="canonical" href="https://lettres-au-mot.fr/explications-outils.php">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,900;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- CSS Perso -->
  <link rel="stylesheet" href="assets/css/style.css">

  <style>
    a:not([href]),
    a:not([href]):hover {
      color: inherit !important;
      text-decoration: none !important;
    }
  </style>
</head>

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
        <li class="nav-item dropdown mresp bg-li-list">
          <a class="nav-link nav-active icon dropdown-toggle rad-haut" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Les outils
          </a>
          <div class="dropdown-menu ml-3 ml-lg-1 mb-3" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="index.php">Anagrammeur</a>
            <a class="dropdown-item" href="maxpossibilator.php">MaxPossibilator</a>
            <div class="dropdown-divider-perso"></div>
            <a class="dropdown-item active" href="explications-outils.php">Explications</a>
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


    <!-- ############################################################### -->
    <!-- START - SECTION PRESENTATION GENERALE -->
    <!-- ############################################################### -->
    <section class="explications-generales">
      <div class="container pb-2">

        <div class="row mt-3">
          <div class="col-lg-8 offset-lg-2">

            <!-- START ACCORDION 1 - PRESENTATION GENERALE-->
            <div class="accordion mb-3" id="explicationsGenerales">

              <!-- START ACCORDION 1 HEADER -->
              <div class="accordion-header">
                <h1 class="icon explications my-0">Présentation générale</h1>
              </div>
              <!-- END ACCORDION 1 HEADER -->

              <!-- START CARD 1 - Présentation du site -->
              <div class="card">
                <div class="card-header" id="generalOne">
                  <h2 class="clearfix mb-0">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseGeneralOne" aria-expanded="false" aria-controls="collapseGeneralOne">Présentation du site<i class="material-icons">add</i></a>
                  </h2>
                </div>

                <div id="collapseGeneralOne" class="collapse" aria-labelledby="generalOne" data-parent="#explicationsGenerales">

                  <!-- Les outils de Lettres-au-Mot -->
                  <div class="card-body">
                    <span>"Lettres au Mot" vous propose différents outils pour vos jeux littéraires. L'accès au site est gratuit et aucune inscription n'est nécessaire.</span><br>
                    <span class="d-block mt-2">Ces outils sont accessibles au travers de deux dispositifs :</span>
                    </span>

                    <ul class="expli mt-2">

                      <!-- Outil l'Anagramot -->
                      <li class="ml-1 ml-lg-3">
                        <h5 class="principe-max-100">L'Anagrammeur</h5>
                        <span class="d-block ml-4"> Grâce à cette barre de recherche, vous avez accès à 3 outils différents : </span>
                        <span class="d-block ml-5 fz95"><i class="fas fa-sm mr-2 fa-long-arrow-alt-right"></i>ANAGRAMIA, AJOUGRAMME et MOTROU </span>
                      </li>

                      <!-- Outil le MaxPossibilitator -->
                      <li class="ml-1 ml-lg-3 mt-1">
                        <h5 class="principe-max-100">Le MaxPossibilator</h5>
                        <span class="d-block ml-4">Cet outil vous permet de trouver tous les mots contenant certaines lettres</span>
                      </li>
                    </ul>
                    <span>De nouveaux outils sont en développement, suivez notre page pour en savoir plus !!</span>
                  </div>
                </div>
              </div>
              <!-- END CARD 1 - Présentation du site -->

              <!-- START CARD 2 - Gestion des cookies -->
              <div class="card">
                <div class="card-header" id="generalTwo">
                  <h2 class="mb-0">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseGeneralTwo" aria-expanded="false" aria-controls="collapseGeneralTwo">Gestion des cookies<i class="material-icons">add</i></a>
                  </h2>
                </div>
                <div id="collapseGeneralTwo" class="collapse" aria-labelledby="generalTwo" data-parent="#explicationsGenerales">
                  <div class="card-body">
                    <span><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>"Lettres au Mot" utilise seulement Google Analytics comme cookie externe (cela permet d'améliorer l'ergonomie du site grâce à l'analyse de l'utilisation des visiteurs).</span>
                    <span class="d-block mt-1">Des cookies propres à "Lettres au Mot" sont proposés et ont pour unique but de garder en mémoire vos préférences, à savoir :</span>
                    <ul class="expli">
                      <li class="ml-1 ml-lg-3 mt-1 mb-0 puce-li">affichage ou non de la fenêtre de présentation sur la page d'accueil ; </li>
                      <li class="ml-1 ml-lg-3 puce-li mb-0">gestion des caractères accentués ou non</li>
                      <li class="ml-1 ml-lg-3 puce-li mb-0">le dictionnaire de référence : simplifié ou complet</li>
                    </ul>
                    <span><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Si vous ne souhaitez pas que ces cookies soient déposés sur votre navigateur, vous devez le préciser dans les paramètres de votre navigateur.</span>
                    <span class="d-block mt-1">La méthode est différente selon le navigateur que vous utilisez, reportez vous aux <a href="mentions-legales.php">"mentions légales"</a> pour savoir comment procéder.</span>
                  </div>
                </div>
              </div>
              <!-- END CARD 2 - Gestion des cookies -->

              <!-- START CARD 3 - Options disponibles -->
              <div class="card">
                <div class="card-header" id="generalThree">
                  <h2 class="mb-0">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseGeneralThree" aria-expanded="false" aria-controls="collapseGeneralThree">Options disponibles<i class="material-icons">add</i></a>
                  </h2>
                </div>
                <div id="collapseGeneralThree" class="collapse" aria-labelledby="generalThree" data-parent="#explicationsGenerales">
                  <div class="card-body">
                    <ul class="expli">
                      <li class="ml-1 ml-lg-3">
                        <h5 class="principe-max-100">Choix de la langue</h5>
                        <span class="d-block ml-3"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Vous avez la possibilité de choisir une des quatre langues suivantes : français, espagnol, anglais et allemand.</span>
                        <span class="d-block ml-3 mt-1"> A noter que les résultats sont plus exhaustifs avec le français car la base lexicales est plus large</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt2">
                        <h5 class="principe-max-100">La base lexicale de référence</h5>
                        <span class="d-block ml-3"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Pour le français, vous avez le choix entre deux bases de référence&nbsp;: une simplifiée comprenant environ 22&nbsp;000 mots, et une plus importante avec environ 350&nbsp;000 entrées (base de mots et de verbes conjugués).</span>
                        <span class="d-block ml-3 mt-1"> Pour les autres langues, une seule base est proposée : 40&nbsp;000 mots pour l'anglais, 30&nbsp;000 pour l'allemand et 16&nbsp;000 pour l'espagnol.</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <h5 class="principe-max-100">La gestions des accents</h5>
                        <span class="d-block ml-3"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>"Lettres au Mot" vous permet de gérer facilement la prise en compte des accents. Il vous suffit de cliquer choisir entre "Avec Accents" et "Sans Accents"</span>
                        <span class="d-block ml-3 mt-1"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Ce choix s'applique tant au niveau de la recherche qu'aux résultats obtenus. Ainsi, si vous choisissez l'option avec accents, une recherche avec lettres "<span class="UpperCase">ést</span>" ne sera pas traitée de la même façon qu'une recherche avec "EST"</span>
                        <span class="d-block ml-3 mt-1"><i class="fas fa-caret-right mr-2 fa-sm text-blue2">Cette fonctionnalité n'est présente que pour le français.</i></span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- END CARD 3 - Options disponibles -->

              <!-- START CARD 4 - Intégration dictionnaire Wiktionnaire -->
              <div class="card">
                <div class="card-header" id="generalFour">
                  <h2 class="mb-0">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseGeneralFour" aria-expanded="false" aria-controls="collapseGeneralFour">Dictionnaire Wiktionnaire<i class="material-icons">add</i></a>
                  </h2>
                </div>
                <div id="collapseGeneralFour" class="collapse" aria-labelledby="generalFour" data-parent="#explicationsGenerales">
                  <div class="card-body">
                    <ul class="expli">
                      <li class="ml-1 ml-lg-3">
                        <h5 class="principe-max-100">Un dictionnaire libre et gratuit</h5>
                        <span class="d-block ml-3"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Vous avez la possibilité, pour chaque résultat de vos recherches, de consulter sa définition directement sur le site, juste en cliquant dessus.</span>
                        <span class="d-block ml-3 mt-1">Toutes les définitions sont issues du <a class="text-primary" href="https://fr.wiktionary.org/ target=" _blank">Wiktionnaire</a>, un projet open source auquel tout le monde peut participer pour l'enrichir et l'améliorer.</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <h5 class="principe-max-100">Outil perfectible</h5>
                        <span class="d-block ml-3"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>L'outil présent sur Lettres-au-mot est un outil maison et il est fort probable qu'il connaisse certaines défaillances.</span>
                        <span class="d-block ml-3 mt-1"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Nous vous remercions par avance de nous faire remonter ces dysfonctionnements en nous laissant un message via notre <a class="text-primary" href="contact.php">formulaire de contact</a> en nous indiquant le problème rencontré et le mot concerné.</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- END CARD 4 - Intégration dictionnaire Wiktionnaire -->

            </div>
            <!-- END ACCORDION 1 - PRESENTATION GENERALE-->

          </div>
        </div>
      </div>

    </section>
    <!-- ############################################################### -->
    <!-- END - SECTION PRESENTATION GENERALE -->
    <!-- ############################################################### -->


    <!-- ############################################################### -->
    <!-- START - SECTION PRESENTATION DES OUTILS -->
    <!-- ############################################################### -->
    <section class="explications-jeux">
      <div class="container pt-2 pb-2">

        <div class="row">
          <div class="col-lg-8 offset-lg-2 mb-4">

            <!-- START ACCORDION 2 - PRESENTATION DES OUTILS -->
            <div class="accordion" id="explicationsJeux">

              <!-- START ACCORDION 2 HEADER -->
              <div class="accordion-header">
                <h1 class="icon explications my-0">Présentation des outils</h1>
              </div>
              <!-- END ACCORDION 2 HEADER -->

              <!-- START CARD 1 - Anagramia -->
              <div class="card">
                <div class="card-header" id="jeuxOne">
                  <h2 class="clearfix mb-0">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseJeuxOne" aria-expanded="false" aria-controls="collapseJeuxOne">ANAGRAMIA<i class="material-icons">add</i></a>
                  </h2>
                </div>
                <div id="collapseJeuxOne" class="collapse" aria-labelledby="jeuxOne" data-parent="#explicationsJeux">
                  <div class="card-body">
                    <ul class="expli">
                      <li class="ml-1 ml-lg-3">
                        <span class="text-titre-explications puce-li principe-max-100">Principe</span>
                        <span class="d-block ml-4">Cet outil vous permet d'obtenir tous les annagrammes d'un mot (ou d'une série de lettres) que vous avez saisi.</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <span class="text-titre-explications puce-li principe-max-100">Utilisation</span>
                        <span class="d-block ml-4">Vous entrez un mot (ou des lettres, peu importe l'ordre) dans notre barre de recherche, puis vous cliquez sur le bouton "envoyer".</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2 mb-0">
                        <span class="text-titre-explications puce-li principe-max-100">Paramètres</span>
                        <ul class="ml-4">
                          <li><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>La recherche doit contenir entre 3 et 20 caractères</li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- END CARD 1 - Anagramia -->

              <!-- START CARD 2 - Ajougramme -->
              <div class="card">
                <div class="card-header" id="jeuxTwo">
                  <h2 class="mb-0">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseJeuxTwo" aria-expanded="false" aria-controls="collapseJeuxTwo">AJOUGRAMME<i class="material-icons">add</i></a>
                  </h2>
                </div>
                <div id="collapseJeuxTwo" class="collapse" aria-labelledby="jeuxTwo" data-parent="#explicationsJeux">
                  <div class="card-body">
                    <ul class="expli">
                      <li class="ml-1 ml-lg-3">
                        <span class="text-titre-explications puce-li principe-max-100">Principe</span>
                        <span class="d-block ml-4"> Même principe que pour l'ANAGRAMIA, avec en plus l'utilisation d'un joker de valeur qui représente n'importe quelle lettre de l'alphabet.</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <span class="text-titre-explications puce-li principe-max-100">Utilisation</span>
                        <span class="d-block ml-4"> Vous entrez un mot (ou des lettres, peu importe l'ordre) dans notre barre de recherche, ainsi qu'un point d'interrogation "?" pour le joker de valeur, puis vous cliquez sur le bouton "envoyer".</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <span class="text-titre-explications puce-li principe-max-100">Paramètres</span>
                        <ul class="ml-4">
                          <li class="ml-1 ml-lg-3 mb-0"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>La recherche doit contenir entre 3 et 20 caractères</li>
                          <li class="ml-1 ml-lg-3 mb-0"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Un seul joker de valeur "?" par recherche (si vous souhaitez plusieurs jokers de valeur, utilser le <a class="text-primary" href="https://lettres-au-mot.fr/maxpossibilator.php">MaxPossibilitator</a>)</li>
                          <li class="ml-1 ml-lg-3 mb-0"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Il n'est pas possible d'utiliser un joker de valeur "?" et un joker de position "_" dans une même recherche</li>
                        </ul>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2 mb-0">
                        <span class="text-titre-explications puce-li principe-max-100">Exemple</span>
                        <span class="d-block ml-4"> Si vous entrez les caractères "CARR?", vous obtiendrez comme résultat : <span class="text-maj">carra, carre, earré, racer</span> et <span class="text-maj">carry</span>.</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- END CARD 2 - Ajougramme -->

              <!-- START CARD 3 - MotTrou -->
              <div class="card">
                <div class="card-header" id="jeuxThree">
                  <h2 class="mb-0">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseJeuxThree" aria-expanded="false" aria-controls="collapseJeuxThree">MOTROU<i class="material-icons">add</i></a>
                  </h2>
                </div>
                <div id="collapseJeuxThree" class="collapse" aria-labelledby="jeuxThree" data-parent="#explicationsJeux">
                  <div class="card-body">
                    <ul class="expli">
                      <li class="ml-1 ml-lg-3">
                        <span class="text-titre-explications puce-li principe-max-100">Principe</span>
                        <span class="d-block ml-4"> Utiliser des jokers de position pour retouver les lettres manquantes (principe des mots à trous). Cela permet de trouver des mots à patrtir de quelques lettres.</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <span class="text-titre-explications puce-li principe-max-100">Utilisation</span>
                        <span class="d-block ml-4"> Vous saisissez les lettres dont vous connaissez la position dans le mot recherché, et vous utiliser un joker de position représenté par le caractère underscore "_" pour les lettres inconnues.</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <span class="text-titre-explications puce-li principe-max-100">Paramètres</span>
                        <ul class="ml-4">
                          <li class="ml-1 ml-lg-3 mb-0"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>La recherche doit contenir entre 3 et 20caractères</li>
                          <li class="ml-1 ml-lg-3 mb-0"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>8 jokers de position "_" au maximum par recherche</li>
                          <li class="ml-1 ml-lg-3 mb-0"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Il n'est pas possible d'utiliser un joker de valeur "?" et un joker de position "_" dans une même recherche</li>
                        </ul>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2 mb-0">
                        <span class="text-titre-explications puce-li principe-max-100">Exemple</span>
                        <span class="d-block ml-4"> Si vous entrez les caractères "SE_T", vous obtiendrez comme résultat : <span class="text-maj">sent, sept</span> et <span class="text-maj">sert</span>.</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- END CARD 3 - MotTrou -->


              <!-- START CARD 4 - MaxPossibilitator -->
              <div class="card">
                <div class="card-header" id="jeuxFour">
                  <h2 class="mb-0">
                    <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseJeuxFour" aria-expanded="false" aria-controls="collapseJeuxFour">MAXPOSSIBILATOR<i class="material-icons">add</i></a>
                  </h2>
                </div>
                <div id="collapseJeuxFour" class="collapse" aria-labelledby="jeuxFour" data-parent="#explicationsJeux">
                  <div class="card-body">
                    <ul class="expli">
                      <li class="ml-1 ml-lg-3">
                        <span class="text-titre-explications puce-li principe-max-100">Principe</span>
                        <span class="d-block ml-4"> Cet outil vous permet de trouver tous les mots contenant certaines lettres.</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <span class="text-titre-explications puce-li principe-max-100">Utilisation</span>
                        <span class="d-block ml-4"> Vous saisissez les lettres souhaitées (vous pouvez choisir plusieurs fois la même lettre), et vous indiquez le nombre de lettres du mot final.</span>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2">
                        <span class="text-titre-explications puce-li principe-max-100">Paramètres</span>
                        <ul class="ml-4">
                          <li class="ml-1 ml-lg-3 mb-0"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>La recherche doit contenir entre 3 et 20 caractères</li>
                          <li class="ml-1 ml-lg-3 mb-0"><i class="fas fa-caret-right mr-2 fa-sm text-blue2"></i>Il faut choisir entre 1 et 15 lettres</li>
                        </ul>
                      </li>
                      <li class="ml-1 ml-lg-3 mt-2 mb-0">
                        <span class="text-titre-explications puce-li principe-max-100">Exemple</span>
                        <span class="d-block ml-4"> Si vous entrez les lettres B, C et E, vous obtiendrez comme résultat tous les mots de 7 lettres qui contiennent les lettres B, C et E, soit 317 mots différents.</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- END CARD 4 - MaxPossibilitator -->

            </div>
            <!-- END ACCORDION 2 - PRESENTATION DES OUTILS -->

          </div>
        </div>
      </div>

    </section>
    <!-- ############################################################### -->
    <!-- END - SECTION PRESENTATION GENERALE -->
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
          <br class="d-md-none">
          <span class="mx-1 mx-sm-2 mx-md-5">|</span>
          <span class="d-none d-md-inline mx-2 mx-md-5">|</span>
          <span class="text-nowrap text-footer"><a class="fz-norm-resp" href="https://fgainza.fr" target="_blank">Réalisation du site</a></span>
        </div>
      </div>
    </div>
  </footer>
  <!-- ############################################################### -->
  <!-- START - FOOTER -->
  <!-- ############################################################### -->

</div>
<!-- END - Layout Global -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="assets/js/app.js"></script>

</body>

</html>