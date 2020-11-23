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
  <meta name="description" content="Lettres Au Mot, site d'aide à la résolution de jeux de lettres (scrabble, mots croisés, mots à trous...). Consultez sur cette page les diverses mentions légales relatives à l'utilisation de ce site internet.">
  <meta name="author" content="Frédéric Gainza">
  <meta name="theme-color" content="#ffffff">

  <!-- FAVICONS -->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon-letters/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-letters/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-letters/favicon-16x16.png">
  <link rel="manifest" href="assets/img/favicon-letters/site.webmanifest">
  <link rel="mask-icon" href="assets/img/favicon-letters/safari-pinned-tab.svg" color="#5bbad5">

  <title>Lettres Au Mot - Mentions légales</title>

  <link rel="canonical" href="https://lettres-au-mot.fr/mentions-legales.php">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,900;1,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- CSS Perso -->
  <link rel="stylesheet" href="assets/css/style.css">

  <style>
    * {
      font-family: Metropolis, sans-serif !important;
      font-size: .95rem;
      margin: 0px;
      padding: 0px;
      box-sizing: border-box;
    }

    h3 {
      font-size: 1.2rem;
      color: #710a0a;
      font-weight: 600;
    }

    .proprio {
      font-weight: 600;
    }

    @media (min-width: 990px) {
      * {
        font-size: 1rem;
      }

      h3 {
        font-size: 1.4rem;
      }
    }
  </style>
  
</head>

<body>
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
            <a class="nav-link dropdown-toggle rad-haut" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Les outils
            </a>
            <div class="dropdown-menu ml-3 ml-lg-1 mb-3" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="index.php">Anagrammeur</a>
              <a class="dropdown-item" href="maxpossibilator.php">MaxPossibilator</a>
              <div class="dropdown-divider-perso"></div>
              <div class="dropdown-divider pb-3"></div>
              <a class="dropdown-item" href="explications-outils.php">Explications</a>
            </div>
          </li>
          <li class="nav-item mx-0 mx-lg-5 dropdown">
            <a class="nav-link rad-bas" href="contact.php">Contact</a>
          </li>
        </ul>
        <div class="d-lg-none">
          <a class="nav-link-foot fz95 active" href="mentions-legales.php">Mentions Légales</a>
          <a class="nav-link-foot fz95" href="https://fgainza.fr" target="_blank">Réalisation du site</a>
          <span class="nav-link-foot mb-3 fz95">2020 &copy; Lettres-Au-Mot</span>
        </div>
      </div>
    </nav>

    <!-- START - Layout Contenu -->
    <div id="layoutDefault_content" role="main">

      <!-- ############################################################### -->
      <!-- START - SECTION MENTIONS LEGALES -->
      <!-- ############################################################### -->
      <section class="mentions-legales">

        <div class="container mt-4 pt-2 pb-2">
          <div id="mLegales">

            <div class="col12 col-lg-10 row mx-auto align-items-center justify-content-center fade show" id="validForm"></div>
            <fieldset class="form-border">
              <legend class="form-border">
                <h1 class="mentions-legales">Mentions légales</h1>
              </legend>
              <div class="mb-4">
                <br>

                <!-- 1. Présentation du site -->
                <h3>1. Présentation du site</h3>
                <p>En vertu de l'article 6 de la loi n° 2004-575 du 21 juin 2004 pour la confiance dans l'économie numérique, il est précisé aux utilisateurs du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> l'identité des différents intervenants dans le cadre de sa réalisation et de son suivi :</p>
                <p><strong>Propriétaire</strong> : Frédéric Gainza – – 15 rue Montesquieu 33400 Talence<br />
                  <strong>Créateur</strong> : <a href="https://www.fgainza.fr">Frédéric Gainza</a><br />
                  <strong>Responsable publication</strong> : Frédéric Gainza – mot-anagramme@fgainza.fr, dénommé ci-après KoPaTik Agency<br />
                  Le responsable publication est une personne physique ou une personne morale.<br />
                  <strong>Webmaster</strong> : Frédéric Gainza – mot-anagramme@fgainza.fr<br />
                  <strong>Hébergeur</strong> : Infomaniak – 25 Eugène-Marziano 1227 Les Acacias (Suisse)<br />
                </p>
                <br>

                <!-- 2. Conditions générales d’utilisation du site et des services proposés -->
                <h3>2. Conditions générales d’utilisation du site et des services proposés</h3>
                <p>L’utilisation du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> implique l’acceptation pleine et entière des conditions générales d’utilisation ci-après décrites. Ces conditions d’utilisation sont susceptibles d’être modifiées ou complétées à tout moment, les utilisateurs du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> sont donc invités à les consulter de manière régulière.</p>
                <p>Ce site est normalement accessible à tout moment aux utilisateurs. Une interruption pour raison de maintenance technique peut être toutefois décidée par <span class="proprio">KoPaTik Agency</span>, qui s’efforcera alors de communiquer préalablement aux utilisateurs les dates et heures de l’intervention.</p>
                <p>Le site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> est mis à jour régulièrement par <span class="proprio">KoPaTik Agency</span>. De la même façon, les mentions légales peuvent être modifiées à tout moment : elles s’imposent néanmoins à l’utilisateur qui est invité à s’y référer le plus souvent possible afin d’en prendre connaissance.</p>
                <br>

                <!-- 3. Description des services fournis -->
                <h3>3. Description des services fournis</h3>
                <p>Le site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> a pour objet de fournir une information concernant l’ensemble des activités de la société.</p>
                <p><span class="proprio">KoPaTik Agency</span> s’efforce de fournir sur le site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> des informations aussi précises que possible. Toutefois, il ne pourra être tenue responsable des omissions, des inexactitudes et des carences dans la mise à jour, qu’elles soient de son fait ou du fait des tiers partenaires qui lui fournissent ces informations.</p>
                <p>Tous les informations indiquées sur le site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> sont données à titre indicatif, et sont susceptibles d’évoluer. Par ailleurs, les renseignements figurant sur le site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> ne sont pas exhaustifs. Ils sont donnés sous réserve de modifications ayant été apportées depuis leur mise en ligne.</p>
                <br>

                <!-- 4. Limitations contractuelles sur les données techniques -->
                <h3>4. Limitations contractuelles sur les données techniques</h3>
                <p>Le site utilise la technologie JavaScript.</p>
                <p>Le site Internet ne pourra être tenu responsable de dommages matériels liés à l’utilisation du site. De plus, l’utilisateur du site s’engage à accéder au site en utilisant un matériel récent, ne contenant pas de virus et avec un navigateur de dernière génération mis-à-jour</p>
                <br>

                <!-- 5. Propriété intellectuelle et contrefaçons -->
                <h3>5. Propriété intellectuelle et contrefaçons</h3>
                <p><span class="proprio">KoPaTik Agency</span> est propriétaire des droits de propriété intellectuelle ou détient les droits d’usage sur tous les éléments accessibles sur le site, notamment les textes, images, graphismes, logo, icônes, sons, logiciels.</p>
                <p>Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de : <span class="proprio">KoPaTik Agency</span>.</p>
                <p>Toute exploitation non autorisée du site ou de l’un quelconque des éléments qu’il contient sera considérée comme constitutive d’une contrefaçon et poursuivie conformément aux dispositions des articles L.335-2 et suivants du Code de Propriété Intellectuelle.</p>
                <br>

                <!-- 6. Limitations de responsabilité -->
                <h3>6. Limitations de responsabilité</h3>
                <p><span class="proprio">KoPaTik Agency</span> ne pourra être tenue responsable des dommages directs et indirects causés au matériel de l’utilisateur, lors de l’accès au site www.mot-anagramme.fr, et résultant soit de l’utilisation d’un matériel ne répondant pas aux spécifications indiquées au point 4, soit de l’apparition d’un bug ou d’une incompatibilité.</p>
                <p><span class="proprio">KoPaTik Agency</span> ne pourra également être tenue responsable des dommages indirects (tels par exemple qu’une perte de marché ou perte d’une chance) consécutifs à l’utilisation du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a>.</p>
                <p>Des espaces interactifs (possibilité de poser des questions dans l’espace contact) sont à la disposition des utilisateurs. <span class="proprio">KoPaTik Agency</span> se réserve le droit de supprimer, sans mise en demeure préalable, tout contenu déposé dans cet espace qui contreviendrait à la législation applicable en France, en particulier aux dispositions relatives à la protection des données. Le cas échéant, <span class="proprio">KoPaTik Agency</span> se réserve également la possibilité de mettre en cause la responsabilité civile et/ou pénale de l’utilisateur, notamment en cas de message à caractère raciste, injurieux, diffamant, ou pornographique, quel que soit le support utilisé (texte, photographie…).</p>
                <br>

                <!-- 7. Gestion des données personnelles -->
                <h3>7. Gestion des données personnelles</h3>
                <p>En France, les données personnelles sont notamment protégées par la loi n° 78-87 du 6 janvier 1978, la loi n° 2004-801 du 6 août 2004, l'article L. 226-13 du Code pénal et la Directive Européenne du 24 octobre 1995.</p>
                <p>A l'occasion de l'utilisation du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a>, peuvent êtres recueillies : l'URL des liens par l'intermédiaire desquels l'utilisateur a accédé au site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a>, le fournisseur d'accès de l'utilisateur, l'adresse de protocole Internet (IP) de l'utilisateur.</p>
                <p> En tout état de cause <span class="proprio">KoPaTik Agency</span> ne collecte des informations personnelles relatives à l'utilisateur que pour le besoin de certains services proposés par le site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a>. L'utilisateur fournit ces informations en toute connaissance de cause, notamment lorsqu'il procède par lui-même à leur saisie. Il est alors précisé à l'utilisateur du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> l’obligation ou non de fournir ces informations.</p>
                <p>Conformément aux dispositions des articles 38 et suivants de la loi 78-17 du 6 janvier 1978 relative à l’informatique, aux fichiers et aux libertés, tout utilisateur dispose d’un droit d’accès, de rectification et d’opposition aux données personnelles le concernant, en effectuant sa demande écrite et signée, accompagnée d’une copie du titre d’identité avec signature du titulaire de la pièce, en précisant l’adresse à laquelle la réponse doit être envoyée.</p>
                <p>Aucune information personnelle de l'utilisateur du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> n'est publiée à l'insu de l'utilisateur, échangée, transférée, cédée ou vendue sur un support quelconque à des tiers. Seule l'hypothèse du rachat de <span class="proprio">KoPaTik Agency</span> et de ses droits permettrait la transmission des dites informations à l'éventuel acquéreur qui serait à son tour tenu de la même obligation de conservation et de modification des données vis à vis de l'utilisateur du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a>.</p>
                <p>Les bases de données sont protégées par les dispositions de la loi du 1er juillet 1998 transposant la directive 96/9 du 11 mars 1996 relative à la protection juridique des bases de données.</p>
                <br>

                <!-- 8. Liens hypertextes et cookies -->
                <h3 id="cookiesInfo">8. Liens hypertextes et cookies</h3>
                <p>Le site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> contient un certain nombre de liens hypertextes vers d’autres sites, mis en place avec l’autorisation de <span class="proprio">KoPaTik Agency</span>. Cependant, <span class="proprio">KoPaTik Agency</span> n’a pas la possibilité de vérifier le contenu des sites ainsi visités, et n’assumera en conséquence aucune responsabilité de ce fait.</p>
                <p>La navigation sur le site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> est susceptible de provoquer l’installation de cookie(s) sur l’ordinateur de l’utilisateur. Un cookie est un fichier de petite taille, qui ne permet pas l’identification de l’utilisateur, mais qui enregistre des informations relatives à la navigation d’un ordinateur sur un site. Les données ainsi obtenues visent à faciliter la navigation ultérieure sur le site, et ont également vocation à permettre diverses mesures de fréquentation.</p>
                <p>Le refus d’installation d’un cookie peut entraîner l’impossibilité d’accéder à certains services. L’utilisateur peut toutefois configurer son ordinateur de la manière suivante, pour refuser l’installation des cookies :</p>
                <p>Sous Internet Explorer : onglet outil (pictogramme en forme de rouage en haut a droite) / options internet. Cliquez sur Confidentialité et choisissez Bloquer tous les cookies. Validez sur Ok.</p>
                <p>Sous Firefox : en haut de la fenêtre du navigateur, cliquez sur le bouton Firefox, puis aller dans l'onglet Options. Cliquer sur l'onglet Vie privée.
                  Paramétrez les Règles de conservation sur : utiliser les paramètres personnalisés pour l'historique. Enfin décochez-la pour désactiver les cookies.</p>
                <p>Sous Safari : Cliquez en haut à droite du navigateur sur le pictogramme de menu (symbolisé par un rouage). Sélectionnez Paramètres. Cliquez sur Afficher les paramètres avancés. Dans la section "Confidentialité", cliquez sur Paramètres de contenu. Dans la section "Cookies", vous pouvez bloquer les cookies.</p>
                <p>Sous Chrome : Cliquez en haut à droite du navigateur sur le pictogramme de menu (symbolisé par trois lignes horizontales). Sélectionnez Paramètres. Cliquez sur Afficher les paramètres avancés. Dans la section "Confidentialité", cliquez sur préférences. Dans l'onglet "Confidentialité", vous pouvez bloquer les cookies.</p>
                <br>

                <!-- 9. Droit applicable et attribution de juridiction -->
                <h3>9. Droit applicable et attribution de juridiction</h3>
                <p>Tout litige en relation avec l’utilisation du site <a href="https://lettres-au-mot.fr/">lettres-au-mot.fr</a> est soumis au droit français. Il est fait attribution exclusive de juridiction aux tribunaux compétents de Paris.</p>
                <br>

                <!-- 10. Les principales lois concernées -->
                <h3>10. Les principales lois concernées</h3>
                <p>Loi n° 78-17 du 6 janvier 1978, notamment modifiée par la loi n° 2004-801 du 6 août 2004 relative à l'informatique, aux fichiers et aux libertés.</p>
                <p> Loi n° 2004-575 du 21 juin 2004 pour la confiance dans l'économie numérique.</p>
                <br>

                <!-- 11. Lexique -->
                <h3>11. Lexique</h3>
                <p>Utilisateur : Internaute se connectant, utilisant le site susnommé.</p>
                <p>Informations personnelles : « les informations qui permettent, sous quelque forme que ce soit, directement ou non, l'identification des personnes physiques auxquelles elles s'appliquent » (article 4 de la loi n° 78-17 du 6 janvier 1978).</p>
                <br>
                <p class="font-italic"><strong>Crédits</strong> : Le modèle de mentions légales est offert par <strong>Subdelirium.com</strong> <a target="_blank" href="https://www.subdelirium.com/generateur-de-mentions-legales/">Mentions légales</a></p>
              </div>

            </fieldset>
          </div>
        </div>

      </section>
      <!-- ############################################################### -->
      <!-- START - SECTION MENTIONS LEGALES -->
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
  <script>
    $(function() {
      // Bouton haut de page et gestion du scroll
      $(window).scroll(function() {
        if ($(window).scrollTop() < 800) {
          $('#scrolltotop').fadeOut();
        } else {
          $('#scrolltotop').fadeIn();
        }
      });

      $('#scrolltotop').click(function() {
        if ($('#resultats')) {
          $('html,body').animate({
            scrollTop: $('#mLegales').position().top
          }, 'slow');
        } else {
          $('html,body').animate({
            scrollTop: 0
          }, 'slow');
        }
      });
    });
  </script>

</body>

</html>