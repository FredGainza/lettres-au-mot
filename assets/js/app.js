// Récupérer les cookies
function getCookie(nomCookie) {
  deb = document.cookie.indexOf(nomCookie + "=");
  if (deb >= 0) {
    deb += nomCookie.length + 1;
    fin = document.cookie.indexOf(";", deb);
    if (fin < 0) {
      fin = document.cookie.length;
    }
    return unescape(document.cookie.substring(deb, fin));
  } else return "";
}

// Cookie Bar
CookieBoxConfig = {
  language: "fr",
  backgroundColor: "#57a4b75c",
  url: "/mentions-legales.php#cookiesInfo",
};

//Jquery
jQuery(document).ready(function ($) {

  // Reset formulaire page index au load de la page
  if (
    window.location.href == "https://lettres-au-mot.fr/" ||
    window.location.href == "https://lettres-au-mot.fr/index.php" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#resultats" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#resGeneral" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#listesMotsPossibles"
  ) {

    window.onload = function () {
      formSaisie = document.getElementById("formSaisie");
      formSaisie.motInput.value = '';
    };

  }

  // Reset formulaire page maxpossibilator au load de la page
  if (
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php" ||
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php#" ||
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php#resultatMax"
  ) {
    window.onload = function () {
      formSaisie = document.getElementById("formSaisie");
      formSaisie.nbCarMotFinal.value = '';
      $('#nbCarMotFinal').text('');
      formSaisie.motInput.value = '';
      
    };
  }

  // Reset formulaire page Contact au load de la page
  if (
    window.location.href == "https://lettres-au-mot.fr/contact.php"
  ) {
    window.onload = function () {
      formContact = document.getElementById("formContact");
      formContact.name.value = "";
    };
  }

  // Régler le problème du page précédente sous firefox
  window.addEventListener("pageshow", function (event) {
    let historyTraversal = event.persisted ||
      (typeof window.performance != "undefined" && performance.getEntriesByType === "back_forward") ||
      (typeof window.performance != "undefined" && window.performance.navigation.type === 2);
    if (historyTraversal) {
      window.location.reload();
    }
  });


  // Attribuer le focus
  function attribuerFocus() {
    document.getElementById("motInput").focus();
  }

  // Définir des Id dynamiques
  function f(id) {
    return $("#" + id);
  }

  // Tester si écran tactile ou non
  let is_touch_device = function () {
    try {
      document.createEvent("TouchEvent");
      return true;
    } catch (e) {
      return false;
    }
  };

  // Désactiver les infos bulle si écran tactile
  if (!is_touch_device()) {
    $('[data-toggle="tooltip"]').tooltip();
  }

  // Récupérer dimensions écran visiteur
  $width = $(window).width();
  $("#width-js").val($width);
  $height = $(window).height();
  $("#height-js").val($height);

  // Désactiver autocomplete au formulaire    
  $('#formSaisie').attr('autocomplete', 'off');

  // Bouton haut de page et gestion du scroll
  $(window).scroll(function () {
    if ($(window).scrollTop() < 800) {
      $("#scrolltotop").fadeOut();
    } else {
      $("#scrolltotop").fadeIn();
    }
  });

  // ################### COOKIES

  let dateCook = new Date(Date.now() + 2592000000); //86400000ms = 1 jour
  dateCook = dateCook.toUTCString();

  function options() {
    // Gestion des accents
    let issetCookAccents = document.cookie.indexOf("preferenceAccents=");

    if (issetCookAccents > 0) {
      if (getCookie("preferenceAccents") === "sansAccents") {
        $("#sAccents").addClass("selectRadio");
        $("input[name='accents'][value='sansAccents']").attr("checked", true);
      }
      if (getCookie("preferenceAccents") === "avecAccents") {
        $("#aAccents").addClass("selectRadio");
        $("input[name='accents'][value='avecAccents']").attr("checked", true);
      }
    } else {
      $("#sAccents").addClass("selectRadio");
      $("input[name='accents'][value='sansAccents']").attr("checked", true);
      document.cookie =
        "preferenceAccents=sansAccents; path=/; expires=" + dateCook;
    }

    $("input[type=radio][name=accents]").change(function () {
      if ($(this).val() == "sansAccents") {
        $("#sAccents").removeClass("unselectRadio");
        $("#sAccents").addClass("selectRadio");
        $("#aAccents").removeClass("selectRadio");
        document.cookie =
          "preferenceAccents=sansAccents; path=/; expires=" + dateCook;
      } else if ($(this).val() == "avecAccents") {
        $("#aAccents").removeClass("unselectRadio");
        $("#aAccents").addClass("selectRadio");
        $("#sAccents").removeClass("selectRadio");
        document.cookie =
          "preferenceAccents=avecAccents; path=/; expires=" + dateCook;
      }
    });

    // Gestion du dictionnaire
    let issetCookDico = document.cookie.indexOf("preferenceDico=");

    if (issetCookDico > 0) {
      if (getCookie("preferenceDico") === "lightDico") {
        $("#dicoL").addClass("selectRadio");
        $("input[name='dico'][value='dicoLight']").attr("checked", true);
      }
      if (getCookie("preferenceDico") === "fullDico") {
        $("#dicoF").addClass("selectRadio");
        $("input[name='dico'][value='dicoFull']").attr("checked", true);
      }
    } else {
      $("#dicoF").addClass("selectRadio");
      $("input[name='dico'][value='dicoFull']").attr("checked", true);
      document.cookie = "preferenceDico=fullDico; path=/; expires=" + dateCook;
    }

    $("input[type=radio][name=dico]").change(function () {
      if ($(this).val() == "dicoLight") {
        $("#dicoL").removeClass("unselectRadio");
        $("#dicoL").addClass("selectRadio");
        $("#dicoF").removeClass("selectRadio");
        document.cookie =
          "preferenceDico=lightDico; path=/; expires=" + dateCook;
      } else if ($(this).val() == "dicoFull") {
        $("#dicoF").removeClass("unselectRadio");
        $("#dicoF").addClass("selectRadio");
        $("#dicoL").removeClass("selectRadio");
        document.cookie =
          "preferenceDico=fullDico; path=/; expires=" + dateCook;
      }
    });
  }

  //Gestion de la langue
  let isseCookLangage = document.cookie.indexOf("langueChoisie=");
  if (isseCookLangage > 0) {
    if (getCookie("langueChoisie") === "fr") {
      $('#choixLangue option[value="fr"]').prop('selected', true);
      $('#options').removeClass('displayMsg');
    }
    if (getCookie("langueChoisie") === "en") {
      $('#choixLangue option[value="en"]').prop('selected', true);
      $('#options').addClass('displayMsg');
    }
    if (getCookie("langueChoisie") === "es") {
      $('#choixLangue option[value="es"]').prop('selected', true);
      $('#options').addClass('displayMsg');
    }
    if (getCookie("langueChoisie") === "de") {
      $('#choixLangue option[value="de"]').prop('selected', true);
      $('#options').addClass('displayMsg');
    }
  } else {
    $('#choixLangue option[value="fr"]').prop('selected', true);
    document.cookie = "langueChoisie=fr; path=/; expires=" + dateCook;
  }

  if (getCookie("langueChoisie") === "fr") {
    options();
  }
  // Selection de la langue
  $("select")
    .change(function () {
      var str = "";
      $("select option:selected").each(function () {
        str += $(this).text() + " ";
      });
      sigle = $('#choixLangue').val();
      $("#langueChoisie").html("<span class=\"text-info fz95resp fz-bolder\">Langue choisie :</span>&nbsp;&nbsp;<img src=\"https://lettres-au-mot.fr/assets/img/flag-" + sigle + ".png\" class=\"pb-1\" width=\"" + ($width < 769 ? "18" : "20") + "\"><strong class=\"fz90-100-rem\">&nbsp;&nbsp;" + str + "</strong>");
      document.cookie = "langueChoisie=" + sigle + ";  path=/; expires=" + dateCook;

      if (getCookie("langueChoisie") === "fr") {
        $('#options').fadeIn();
        options();
      }
      if (getCookie("langueChoisie") != "fr") {
        $('#options').fadeOut();
        // options();
      }
    })
    .trigger("change");


  // ########################   START - INDEX  ###########################################  
  if (
    window.location.href == "https://lettres-au-mot.fr/" ||
    window.location.href == "https://lettres-au-mot.fr/index.php" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#resultats" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#resGeneral" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#listesMotsPossibles"
  ) {
    // Gestion de la fenêtre de présentation
    let issetCookAffIndex = document.cookie.indexOf(
      "preferenceAffichageIndex="
    );
    let close = document.getElementById("closePres");
    let pres = document.getElementById("pres");
    let iconClose = document.getElementById("iconClose");
    let iconEye = document.getElementById("iconEye");

    if (issetCookAffIndex > 0) {
      if (getCookie("preferenceAffichageIndex") === "visible") {
        $("#pres").removeClass("displayDiv");
        pres.style.display = "block";
        iconClose.style.display = "flex";
        $("#iconClose").removeClass("displayIconClose");
        iconEye.style.display = "none";
      }
      if (getCookie("preferenceAffichageIndex") === "nonVisible") {
        $("#iconEye").removeClass("displayIconEye");
        pres.style.display = "none";
        iconClose.style.display = "none";
        iconEye.style.display = "flex";
      }
    } else {
      iconEye.style.display = "none";
      iconClose.style.display = "flex";
      pres.style.display = "block";
      document.cookie =
        "preferenceAffichageIndex=visible; path=/; expires=" + dateCook;
    }

    $("#closePres").click(() => {
      if ($("#pres").css("display") != "none") {
        $("#iconClose").fadeOut(1000, () => {
          $("#iconClose").css({
            display: "none",
          });
          $("#iconEye").css({
            display: "flex",
          });
        });
        $("#pres").slideFadeToggle(1000, () => {
          $("#pres").css({
            display: "none",
          });
        });
        document.cookie =
          "preferenceAffichageIndex=nonVisible; path=/; expires=" + dateCook;
      } else {
        $("#pres").slideFadeToggle(1000, () => {
          $("#pres").css({
            display: "block",
          });
        });
        $("#iconEye").fadeOut(1000, () => {
          $("#iconEye").css({
            display: "none",
          });
          $("#iconClose").css({
            display: "flex",
          });
        });
        document.cookie =
          "preferenceAffichageIndex=visible; path=/; expires=" + dateCook;
      }
    });
  }
  // ########################   END - INDEX  ###########################################


  // ########################   START - MAXPOSSIBILATOR  ###########################################
  if (
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php" ||
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php#" ||
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php#resultatMax"
  ) {
    // Gestion de la fenêtre de présentation
    let closeMax = document.getElementById("closePresMax");
    let presMax = document.getElementById("presMax");
    let iconCloseMax = document.getElementById("iconCloseMax");
    let iconEyeMax = document.getElementById("iconEyeMax");
    let issetCookAffMax = document.cookie.indexOf("preferenceAffichageMax=");
    $("#nbLettres").html("<span class=\"text-info fz95resp fz-bolder\">Nombre de lettres du mot recherché :");

    if (issetCookAffMax > 0) {
      if (getCookie("preferenceAffichageMax") === "visible") {
        $("#presMax").removeClass("displayDiv");
        presMax.style.display = "block";
        iconCloseMax.style.display = "flex";
        $("#iconCloseMax").removeClass("displayIconClose");
        iconEyeMax.style.display = "none";
      }
      if (getCookie("preferenceAffichageMax") === "nonVisible") {
        $("#iconEyeMax").removeClass("displayIconEye");
        presMax.style.display = "none";
        iconCloseMax.style.display = "none";
        iconEyeMax.style.display = "flex";
      }
    } else {
      iconEyeMax.style.display = "none";
      iconCloseMax.style.display = "flex";
      presMax.style.display = "block";
      document.cookie =
        "preferenceAffichageMax=visible; path=/; expires=" + dateCook;
    }

    $.fn.slideFadeToggle = function (speed, easing, callback) {
      return this.animate(
        {
          opacity: "toggle",
          height: "toggle",
        },
        speed,
        easing,
        callback
      );
    };

    $("#closePresMax").click(() => {
      if ($("#presMax").css("display") != "none") {
        $("#iconCloseMax").fadeOut(1000, () => {
          $("#iconCloseMax").css({
            display: "none",
          });
          $("#iconEyeMax").css({
            display: "flex",
          });
        });
        $("#presMax").slideFadeToggle(1000, () => {
          $("#presMax").css({
            display: "none",
          });
        });
        document.cookie =
          "preferenceAffichageMax=nonVisible; path=/; expires=" + dateCook;
      } else {
        $("#presMax").slideFadeToggle(1000, () => {
          $("#presMax").css({
            display: "block",
          });
        });
        $("#iconEyeMax").fadeOut(1000, () => {
          $("#iconEyeMax").css({
            display: "none",
          });
          $("#iconCloseMax").css({
            display: "flex",
          });
        });
        document.cookie =
          "preferenceAffichageMax=visible; path=/; expires=" + dateCook;
      }
    });
  }
  // ########################   END - MAXPOSSIBILATOR  ###########################################


  /*
   #############################################
   ###     START Ajax API Perso Wiki
   #############################################
   */

  // Définitions des ID dynamiques des termes à définir

  // MaxPossibilator
  $nbMax = $("#resMax li").length;
  for (let i = 0; i < $nbMax; i++) {
    $(f("max_" + i)).click((e) => { });
  }

  // Anagrammes
  $nbAnna = $("#liste-anagrammes li").length;
  for (let i = 0; i < $nbAnna; i++) {
    $(f("anna_" + i)).click((e) => { });
  }

  // Mots possibles de 3 à n-1 lettres
  $nbMotsPossibles = $("#listesMotsPossibles ul li").length;
  for (let i = 0; i < $nbMotsPossibles; i++) {
    $(f("motPossible_" + i)).click((e) => { });
  }

  // Ajougramme
  $nbAjoutgrams = $("#listeAjoutgrams ul li").length;
  for (let i = 0; i < $nbAjoutgrams; i++) {
    $(f("ajoutgram_" + i)).click((e) => { });
  }

  // Motrou
  $nbAtrous = $("#listeAtrous li").length;
  for (let i = 0; i < $nbAtrous; i++) {
    $(f("atrou_" + i)).click((e) => { });
  }

  $(".click-def").click((e) => {
    e.preventDefault();

    //Récupération ID du terme à rechercher
    $id = e.currentTarget.id;

    //Récupération du terme à rechercher
    if($id=="definitionLight") {
      $motWiki = $("#motDef").text();
    }else if($id=="definitionBefore") {
      $motWiki = $("#definitionBefore").text();
    }else if($id=="definitionAfter") {
      $motWiki = $("#definitionAfter").text();
    }else{
      $motWiki = $("#" + $id).text();
    }
    $mot = $motWiki.toLowerCase();
    $lang = $('#choixLangue').val();

    // Envoi AJAX à  API perso
    $.ajax({
      url: "app/api_wiki.php",
      type: "POST",
      data: { motWiki: $mot, langue: $lang },
      dataType: "json",
      beforeSend: function () {
        $("#loader").addClass("loader-wait");
      },
      success: function (data) {
        let $resultat = data;
        console.log($resultat);
        $txtTitre = "";
        if ($lang == 'fr') {
          $txtTerme = 'définition';
          $txtTitre = 'Définition de ';
        } else {
          $txtTerme = 'traduction';
          $txtTitre = 'Traduction de ';
        }
        $("#motWikiAff").html(
          '<i class="fas ml-3 mr-3 text-info fa-lg fa-edit"></i><span class="font-weight-bold fz115-130">' + $txtTitre + '<span class="d-inline font-weight-bold fz130-145 text-ocre">&nbsp;&nbsp;' +
          $resultat.motWiki.toUpperCase() +
          "</span></span>"
        );
        $("#closeWikiBtn").delay(300).fadeIn(500);
        $("#closeWikiArrow").delay(600).fadeIn(500);

        if ($resultat.url_img != "" && $resultat.legende_img == "") {
          $("#imgWikiAff").html(
            '<div class="text-center col-12 col-md-10 offset-md-1"><img src="' +
            $resultat.url_img +
            '" class="img-fluid max-img-height" alt="Illustration du terme ' +
            $resultat.motWiki +
            ' Responsive Image">' +
            '<span class="d-block fz80-90 text-right pr-0 mb-1">Crédits : <a class="fz80-90i" href="' +
            $resultat.url_credits +
            '" target="_blank">Commons Wikimedia</a></span></div>'
          );
          $("#line-separator").html('<hr class="my-0">');
        }

        if ($resultat.url_img != "" && $resultat.legende_img != "") {
          $("#imgWikiAff").html(
            '<div class="text-center col-12 col-md-10 offset-md-1"><figure class="imgbox">' +
            '<a href="' +
            $resultat.url_img +
            '" target="_blank"><img src="' +
            $resultat.url_img +
            '" class="img-fluid max-img-height" alt="Illustration du terme ' +
            $resultat.motWiki +
            ' Responsive Image"></a>' +
            "<figcaption><p>" +
            $resultat.legende_img +
            " </p></figcaption></figure>" +
            ' <span class="d-block small text-right fz80-90i mb-3 pr-0"><em>Crédits</em> : <a class="fz80-90i small" href="' +
            $resultat.url_credits +
            '" target="_blank">Commons Wikimedia</a></span></div>'
          );
          $("#line-separator").html('<hr class="my-0">');
        }

        $nbElements = Object.keys($resultat).length;
        $nbNatures = 0;
        $nbNatures = $resultat.natureDef.length;

        $defs = "";
        if (null != $nbNatures && $nbNatures != 0) {
          for (let i in $resultat.nature) {
            let nature = "";
            if ($lang == "fr") {
              nature =
                $resultat.genre[i][0] != $resultat.nature[i] ? $resultat.nature[i] : $resultat.nature[i] +
                  ' <span class="small text-dark">(' +
                  $resultat.genre[i][1] +
                  ")</span>";
            } else {
              nature = $resultat.nature[i];
            }
            $nbNatures = $resultat.natureDef[0].length;
            $defs +=
              '<span class="d-block fz1rem text-titre-def-popup text-left mt-4 mb-2">' +
              nature +
              "</span>";

            $nbNaturesDef = Object.keys($resultat.natureDef[i][0]).length;
            $defs += '<ul class="fa-ul">';

            for (let k in $resultat.natureDef[i][0]) {
              if (typeof $resultat.natureDef[i][0][k] === "string") {
                $defs +=
                  '<li class="mb-1 ml-1 lh-12">' +
                  '<span class="fa-li"><i class="fas fa-xs mr-1 fa-caret-right"></i></span>' +
                  $resultat.natureDef[i][0][k] +
                  "</li>";
              }

              if (typeof $resultat.natureDef[i][0][k] !== "string") {
                $nbElListe = $resultat.natureDef[i][0][k].length;
                $defs += '<ul class="definition mb-2">';
                for (let z in $resultat.natureDef[i][0][k][0]) {
                  $defs +=
                    '<li class="mb-1 ml-3 lh-12"><span class="puce3">' +
                    $resultat.natureDef[i][0][k][0][z] +
                    "</span></li>";
                }
                $defs += "</ul>";
              }
            }

            $defs += "</ul>";
          }

        } else {
          $defs +=
            '<span class="text-danger"> Impossible d\'afficher la ' + $txtTerme + '</span><br>' +
            '<span class="text-dark">' + $resultat.error + '</span>';
        }

        $("#defsWikiAff").html($defs);

        // Affichage du lien vers la page du Wiktionnaire du terme défini
        if ($resultat.direct_link != '') {
          $('#linkPageWiki').html('<div class="text-right"><em><a class="fz80-90i small text-right" href="' +
            $resultat.direct_link +
            '" target="_blank">Page Wiktionnaire</a></em></div>');
        }

        // Complement formes verbales
        for (let i = 0; i < $nbNatures; i++) {
          $nbCompVerbe = $resultat.nature[i] == "Forme de verbe" ? $resultat.natureDef[i][0].length : 0;
        }

        // Définitions des ID dynamiques des termes à définir
        for (let i = 0; i < $nbMax; i++) {
          $(f("complement_verbe_" + i)).click((e) => { });
        }

        /*#############################################
        ###         Ajax Mot Compléméent            ###
        #############################################*/

        $(".click-def-complement").click((e) => {
          e.preventDefault();

          //Récupération ID du terme à rechercher
          $id = e.currentTarget.id;
          $motWikiCompId = $("#" + $id);

          //Récupération du terme à rechercher
          $motWikiCompTxt = $("#" + $id).text();

          $complement = $motWikiCompTxt.toLowerCase();
          $.ajax({
            url: "app/api_wiki_complement.php",
            type: "POST",
            data: { motWikiComplement: $complement, langue: $lang },
            dataType: "json",
            success: function (dataComp) {
              let $resComp = dataComp;
              console.log($resComp);

              $("#cadreComplement").fadeIn(1000, () => {
                $("#closeComp").fadeIn(300);
              });
              $motWikiCompId.attr("href", "#cadreComplement");
              $("#complementAff").html(
                '<span class="font-weight-bold fz110-120">' + $txtTitre + '<span class="d-inline font-weight-bold fz115-130 text-blue2">' +
                $resComp.motWikiComplement.toUpperCase() +
                "</span></span>"
              );
              $("#line-separatorComp").html('<hr class="my-0">');

              $nbElementsComp = Object.keys($resComp).length;
              $nbNaturesComp = $resComp.natureDefComp.length;
              $defsComp = "";

              if ($nbNaturesComp != 0) {
                for (let i = 0; i < $nbNaturesComp; i++) {
                  let natureComp = "";
                  if ($lang == "fr") {
                    natureComp =
                      $resComp.genreComp[i][0] != $resComp.natureComp[i] ? $resComp.natureComp[i] : $resComp.natureComp[i] +
                        ' <span class="small text-dark">(' +
                        $resComp.genreComp[i][1] +
                        ")</span>";
                  } else {
                    natureComp = $resComp.natureComp[i];
                  }
                  nbNaturesComp = $resComp.natureDefComp[0].length;
                  $defsComp +=
                    '<span class="d-block fz1rem text-titre-def-popup text-left mt-4 mb-2">' +
                    natureComp +
                    "</span>";

                  $nbNaturesCompDef = Object.keys($resComp.natureDefComp[i][0]).length;
                  $defsComp += '<ul class="fa-ul">';
                  for (let k in $resComp.natureDefComp[i][0]) {
                    if (typeof $resComp.natureDefComp[i][0][k] === "string") {
                      $defsComp +=
                        '<li class="mb-1 ml-1 lh-12">' +
                        '<span class="fa-li"><i class="fas fa-xs mr-1 fa-caret-right"></i></span>' +
                        $resComp.natureDefComp[i][0][k] +
                        "</li>";
                    }
                    if (typeof $resComp.natureDefComp[i][0][k] !== "string") {
                      $nbElListe = $resComp.natureDefComp[i][0][k].length;
                      $defsComp += '<ul class="definition mb-2">';
                      for (let z in $resComp.natureDefComp[i][0][k][0]) {
                        $defsComp +=
                          '<li class="mb-1 ml-3 lh-12"><span class="puce3">' +
                          $resComp.natureDefComp[i][0][k][0][z] +
                          "</span></li>";
                      }
                      $defsComp += "</ul>";
                    }
                  }
                  $defsComp += "</ul>";
                }

              } else {
                $defsComp +=
                  '<span class="text-danger"> Impossible d\'afficher la ' + $txtTerme + '</span><br>' +
                  '<span class="text-dark">' + $resComp.errorComp + '</span>';
              }

              $("#defsCompAff").html($defsComp);
            },
            error: function (resComp, statut, erreur) {
              console.log(resComp);
            },
          });
        });
      },
      complete: function () {
        $("#loader").removeClass("loader-wait");
      },
      error: function (resultat, statut, erreur) {
        console.log(resultat);
      },
    });
  });

  /*
    #############################################
    ###     END Ajax API Perso Wiki
    #############################################
    */

  // Ouverture Fenêtre Modale des définitions
  $(".popupOpen").on("click", function (e) {
    var targeted_popup_class = jQuery(this).attr("pd-popup-open");
    $('[pd-popup="' + targeted_popup_class + '"]').fadeIn(300, () => {
      $("#closeWiki").delay(1500).fadeIn(1000);
      $("#CreditWiki").delay(1500).fadeIn(1000);
    });
    e.preventDefault();
  });

  // Fermeture div Complément
  $("#closeComp").click(() => {
    $("#cadreComplement").fadeOut(1000, () => {
      $("#complementAff").empty();
      $("#defsCompAff").empty();
      $("#cadreComplement").addClass("display-cadre-complement");
    });
  });

  $(".popupCloseWiki").on("click", function (e) {
    var targeted_popup_class = jQuery(this).attr("pd-popup-close");
    $('[pd-popup="' + targeted_popup_class + '"]').fadeOut(600, () => {
      $("#motWikiAff").empty();
      $("#imgWikiAff").empty();
      $("#line-separator").empty();
      $("#defsWikiAff").empty();
      $('#linkPageWiki').empty();
      $("#complementAff").empty();
      $("#motWikiAff").empty();
      $("#line-separatorComp").empty();
      $("#defsCompAff").empty();
      $("#cadreComplement").hide();
      $("#closeComp").hide();
      $("#closeWikiBtn").hide();
    });
    e.preventDefault();
  });

  // toogle mise en avant culeur pour l'outil MaxPossibilité
  $.fn.slideFadeToggle = function (speed, easing, callback) {
    return this.animate(
      {
        opacity: "toggle",
        height: "toggle",
      },
      speed,
      easing,
      callback
    );
  };




  if (
    window.location.href == "https://lettres-au-mot.fr/" ||
    window.location.href == "https://lettres-au-mot.fr/index.php" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#resultats" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#resGeneral" ||
    window.location.href == "https://lettres-au-mot.fr/index.php#listesMotsPossibles"
  ) {

    $("#scrolltotop").click(function () {
      if ($("#resGeneral")) {
        $position = $("#resGeneral").offset().top;
        $("html,body").animate(
          { scrollTop: $position },
          "slow"
        );
      } else {
        $("html,body").animate({ scrollTop: 0 }, "slow");
      }
    });

    
    $("#motInput").keyup(function (e) {
      let validForm = document.getElementById("validForm");

      // Messages d'erreur
      let carInterdit =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous ne pouvez utiliser que les caractères suivants : les lettres, accentuées ou non, et les 2 caractères "?" et "_"</div>';
      let jokValeur =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous ne pouvez utiliser qu\'un seul jocker de valeur "?"</div>';
      let jokPosition =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous ne pouvez utiliser que huit jockers de position "_" au maximum</div>';
      let tropCar =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous ne pouvez pas dépasser 20 caractères</div>';
      let manqCar =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous devez saisir 3 caractères au minimum</div>';
      let doubleJoker =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous ne pouvez pas utiliser les deux types de jockers dans une même recherche</div>';


      // Gestion de l'input
      let motInput = document.getElementById("motInput");
      let nbCaracteres = $(this).val().length;
      let msg = " " + nbCaracteres;
      $("#compteur").text(msg);
      let erreur = false;
      let motInterdit = false;

      let pat = /[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ?_]/;
      for (let i = 0; i < nbCaracteres; i++) {
        let x = motInput.value[i];
        if (!pat.test(x)) {
          motInterdit = true;
        }
      }

      // Gestion des jokers
      let doubleJok = false;
      let jokPos = false;
      let jokVal = false;
      for (let i = 0; i < nbCaracteres; i++) {
        if (motInput.value[i] == "?") {
          jokVal = true;
        }
        if (motInput.value[i] == "_") {
          jokPos = true;
        }
      }
      if (jokVal === true && jokPos === true) {
        doubleJok = true;
      }

      let nbJokValeur = 0;
      for (let i = 0; i < nbCaracteres; i++) {
        if (motInput.value[i] == "?") {
          nbJokValeur++;
        }
      }

      let msgValeur = " " + nbJokValeur;
      $("#compteurJokValeur").text(msgValeur);

      let nbJokPosition = 0;
      for (let i = 0; i < nbCaracteres; i++) {
        if (motInput.value[i] == "_") {
          nbJokPosition++;
        }
      }

      let msgPosition = " " + nbJokPosition;
      $("#compteurJokPosition").text(msgPosition);

      $msg = "";
      if (
        nbCaracteres > 20 ||
        nbJokValeur > 1 ||
        nbJokPosition > 8 ||
        motInterdit == true ||
        doubleJok == true
      ) {
        erreur = true;
        $("#validForm").removeClass("displayMsg");
        $("#validForm").addClass("msg-error my-2 my-lg-3");
        $("#cardSearch").removeClass("card");
        $("#cardSearch").addClass("bordCard");
        $("#loaderRes").removeClass("loader");
        $("#bgLoader").removeClass("transparent-background");
      } else {
        erreur = false;
        $("#validForm").text("");
        $("#validForm").addClass("displayMsg");
        $("#cardSearch").addClass("card");
        $("#validForm").removeClass("msg-error my-2 my-lg-3");
        $("#cardSearch").removeClass("bordCard");
      }

      if (motInterdit == true) {
        $msg += carInterdit;
        $("#validForm").html($msg);
      }

      if (doubleJok == true) {
        $msg += doubleJoker;
        $("#validForm").html($msg);
      }

      if (nbCaracteres > 20) {
        $msg += tropCar + "<br>";
        $("#compteur").addClass("cligno1");
        $("#validForm").html($msg);
      } else {
        $("#compteur").removeClass("cligno1");
      }

      if (nbJokValeur > 1) {
        $msg += jokValeur;
        $("#compteurJokValeur").addClass("cligno2");
        $("#validForm").html($msg);
      } else {
        $("#compteurJokValeur").removeClass("cligno2");
      }

      if (nbJokPosition > 8) {
        $("#compteurJokPosition").addClass("cligno3");
        $msg += jokPosition;
        $("#validForm").html($msg);
      } else {
        $("#compteurJokPosition").removeClass("cligno3");
      }

      /***** Page Index *****/
      function validSaisieForm() {
        if (
          nbCaracteres > 20 ||
          nbJokValeur > 1 ||
          nbJokPosition > 8 ||
          motInterdit == true ||
          doubleJok == true
        ) {
          e.preventDefault();
          $("#loaderRes").removeClass("loader");
          $("#bgLoader").removeClass("transparent-background");
        } else if (nbCaracteres < 3) {
          e.preventDefault();
          $("#loaderRes").removeClass("loader");
          $("#bgLoader").removeClass("transparent-background");

          $("#validForm").removeClass("displayMsg");
          $("#validForm").addClass("msg-error my-2 my-lg-3");
          $("#cardSearch").removeClass("card");
          $("#cardSearch").addClass("bordCard");

          $msg = manqCar + "<br>";
          $("#compteur").addClass("cligno1");
          $("#validForm").html($msg);
        } else {
          $("#formSaisie").submit();
          $("#bgLoader").addClass("transparent-background");
          $("#loaderRes").addClass("loader");

          $("#validForm").text("");
          $("#validForm").addClass("displayMsg");
          $("#validForm").removeClass("msg-error my-2 my-lg-3");
          $("#cardSearch").addClass("card");
          $("#cardSearch").removeClass("bordCard");

          $("#compteur").removeClass("cligno1");
        }
      }

      $btn = ["#btnEnvoiForm", "#btnEnvoiForm-lg"];
      for (let i = 0; i < 2; i++) {
        $($btn[i]).click(validSaisieForm);
      }

      // Gestion de touche "enter" pour l'input
      $("#formSaisie").keypress(function (e) {
        if ((e.keyCode == 13) && (e.target.type != "textarea")) {
          e.preventDefault();
          $(this).submit(validSaisieForm(e));
        }
      });
    });
    if (
      $("#resultats") ||
      $("#resGeneral") ||
      $("#listeAjoutgrams") ||
      $("#listeTrous")
    ) {
      $("#loaderRes").removeClass("loader");
      $("#bgLoader").removeClass("transparent-background");
    }


  }

  if (
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php" ||
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php#" ||
    window.location.href == "https://lettres-au-mot.fr/maxpossibilator.php#resultatMax"
  ) {
 
    $("#nbCarMotFinal").change(() => {

      lettreMotFinal = $("#nbCarMotFinal").val();
      $("#nbCarMotFinal").removeClass('noValidEffect');
      if (lettreMotFinal < 3 || lettreMotFinal > 20) {
        $("#nbLettres").html("<span class=\"font-weight-bold fz95resp text-info\">Nombre de lettres du mot recherché :</span>&nbsp;<div id=\"compteurMax\" class=\"d-inline font-weight-bold text-danger\">&nbsp;" + lettreMotFinal + "</div>");
        $("#compteurMax").addClass("cligno4");
        $('#nbCarMotFinal').addClass('bordCard-letter');
        if (!$('#msg-error-letter').length) {
          $('#nbCarMotFinal').after('<div id="msg-error-letter" class="text-danger w-100">entre 3 et 20 lettres</div>');
        }

      } else {
        $("#nbLettres").html("<span class=\"font-weight-bold fz95resp text-info\">Nombre de lettres du mot recherché :</span>&nbsp;<div id=\"compteurMax\" class=\"d-inline font-weight-bold text-success\">&nbsp;" + lettreMotFinal + "</div>");
        $("#compteurMax").removeClass("cligno4");
        $('#nbCarMotFinal').removeClass('bordCard-letter');
        $('#msg-error-letter').remove();
      }
    });

    $("#scrolltotop").click(function () {
      if ($("#resultatMax")) {
        $position = $("#resultatMax").offset().top;
        $("html,body").animate(
          { scrollTop: $position },
          "slow"
        );
      } else {
        $("html,body").animate({ scrollTop: 0 }, "slow");
      }
    });

    $("#motInput").keyup(function (e) {
      let validForm = document.getElementById("validForm");

      // Messages d'erreur
      let carMotRecherche =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Le mot recherché doit être composé de 3 à 20 lettres</div>';
      let manqCarMax =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous devez saisir au moins une lettre</div>';
      let carInterditMax =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous ne pouvez saisir que des lettres, accentuées ou non</div>';
      let msgLettreInput =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Vous devez choisir entre 1 et 15 lettres</div>';
      let msgImpossible =
        '<div class="w-100 text-center my-1"><i class="fas text-danger mr-2 fa-sm fa-exclamation-triangle"></i> Le mot final ne peut pas comporter moins de lettres que vous n\'en avez choisi !!</div>';

      // Gestion de l'input
      let motInput = document.getElementById("motInput");
      let nbCaracteres = $(this).val().length;
      let msg = " " + nbCaracteres;
      let lettreMotFinal = $("#nbCarMotFinal").val();
      console.log(lettreMotFinal);
      $("#compteur").text(msg);
      let erreur = false;
      let motInterdit = false;


      let pat = /[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]/;
      for (let i = 0; i < nbCaracteres; i++) {
        let x = motInput.value[i];
        if (!pat.test(x)) {
          motInterdit = true;
        }
      }

      $msg = "";
      if (
        nbCaracteres > 15 ||
        motInterdit == true
      ) {
        erreur = true;
        $("#validForm").removeClass("displayMsg");
        $("#validForm").addClass("msg-error my-2 my-lg-3");
        $("#cardSearch").removeClass("card");
        $("#cardSearch").addClass("bordCard");
        $("#loaderRes").removeClass("loader");
        $("#bgLoader").removeClass("transparent-background");
      } else {
        erreur = false;
        $("#validForm").text("");
        $("#validForm").addClass("displayMsg");
        $("#cardSearch").addClass("card");
        $("#validForm").removeClass("msg-error my-2 my-lg-3");
        $("#cardSearch").removeClass("bordCard");
      }

      if (motInterdit == true) {
        $msg += carInterditMax;
        $("#validForm").html($msg);
      }

      if (nbCaracteres > 15) {
        $msg += msgLettreInput + "<br>";
        $("#compteur").addClass("cligno1");
        $("#validForm").html($msg);
      } else {
        $("#compteur").removeClass("cligno1");
      }


      /***** MaxPossibilitator *****/
      function validSaisieFormMax() {
        $msg="";
        lettreMotFinal = $("#nbCarMotFinal").val();
        nbCaracteres = $('#motInput').val().length;
        let pat = /[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ]/;
        for (let i = 0; i < nbCaracteres; i++) {
          let x = motInput.value[i];
          if (!pat.test(x)) {
            motInterdit = true;
          }
        }

        if (
          nbCaracteres > 15 ||
          lettreMotFinal < 3 ||
          lettreMotFinal > 20 ||
          lettreMotFinal < nbCaracteres ||
          motInterdit == true
        ) {
          e.preventDefault();
          
          $("#loaderRes").removeClass("loader");
          $("#bgLoader").removeClass("transparent-background");
          $("#validForm").removeClass("displayMsg");
          $("#validForm").addClass("msg-error my-2 my-lg-3");
    
          if (motInterdit == true) {
            $msg += carInterditMax;
            $("#validForm").html($msg);
          }
    
          if (nbCaracteres > 15) {
            $msg += msgLettreInput + "<br>";
            $("#compteur").addClass("cligno1");
            $("#validForm").html($msg);
          } else {
            $("#compteur").removeClass("cligno1");
          }


          if (lettreMotFinal < 3 || lettreMotFinal > 20) {
            $msg += carMotRecherche + "<br>";
            $("#validForm").html($msg);
          }

          if (lettreMotFinal != 0 && lettreMotFinal < nbCaracteres) {
            $msg += msgImpossible + "<br>";
            $("#validForm").html($msg);
          }

        } else if (nbCaracteres < 1) {
          e.preventDefault();
          $("#loaderRes").removeClass("loader");
          $("#bgLoader").removeClass("transparent-background");

          $("#validForm").removeClass("displayMsg");
          $("#validForm").addClass("msg-error my-2 my-lg-3");
          $("#cardSearch").removeClass("card");
          $("#cardSearch").addClass("bordCard");

          $msg = manqCarMax + "<br>";
          $("#compteur").addClass("cligno1");
          $("#validForm").html($msg);
        } else {
          $("#validForm").text("");
          $("#formSaisie").submit();
          $("#bgLoader").addClass("transparent-background");
          $("#loaderRes").addClass("loader");

          $("#validForm").addClass("displayMsg");
          $("#validForm").removeClass("msg-error my-2 my-lg-3");
          $("#cardSearch").addClass("card");
          $("#cardSearch").removeClass("bordCard");

          $("#compteur").removeClass("cligno1");
        }
      }


      $btn = ["#btnEnvoiForm", "#btnEnvoiForm-lg"];
      for (let i = 0; i < 2; i++) {
        $($btn[i]).click((e) => {
          e.preventDefault();
          validSaisieFormMax(e);
        })

      }

        // Gestion de touche "enter" pour l'input
        if ((e.keyCode == 13) && (e.target.type != "textarea")) {
          e.preventDefault();
          validSaisieFormMax(e);
        }

    });


    if (
      $("#resultats") ||
      $("#resGeneral") ||
      $("#resultatMax")
    ) {
      $("#loaderRes").removeClass("loader");
      $("#bgLoader").removeClass("transparent-background");
    }

    // Toggle affichage des lettres recherchées en couleur
    let alpha = [
      "a",
      "b",
      "c",
      "d",
      "e",
      "f",
      "g",
      "h",
      "i",
      "j",
      "k",
      "l",
      "m",
      "n",
      "o",
      "p",
      "q",
      "r",
      "s",
      "t",
      "u",
      "v",
      "w",
      "x",
      "y",
      "z",
    ];
    for (let i = 0; i < 26; i++) {
      $(f("btn" + alpha[i])).bootstrapToggle();
      $(f("btn-" + alpha[i])).change(() => {
        $(f("color-" + alpha[i])).toggle();
        $(f("black-" + alpha[i])).toggle();
      });
    }
  }

  /*
      #############################################
      ###     FIN Validation Formulaire index.php
      #############################################
      */

  //----- OPEN POPUP DICOLINK
  $(".popupOpen").on("click", function (e) {
    var targeted_popup_class = jQuery(this).attr("pd-popup-open");
    $('[pd-popup="' + targeted_popup_class + '"]').fadeIn(100);
    e.preventDefault();
  });
  //----- CLOSE POPUP DICOLINK
  $(".popupClose").on("click", function (e) {
    var targeted_popup_class = jQuery(this).attr("pd-popup-close");
    $('[pd-popup="' + targeted_popup_class + '"]').fadeOut(200);
    e.preventDefault();
  });


  if (
    window.location.href == "https://lettres-au-mot.fr/contact.php" ||
    window.location.href == "https://lettres-au-mot.com/contact.php"

  ) {
    // Effet scale des labels du formulaire
    (function () {
      "use strict";
      // Detect when form-control inputs are not empty
      $(".cool-b4-form .form-control").on("input", function () {
        if ($(this).val()) {
          $(this).addClass("hasValue");
        } else {
          $(this).removeClass("hasValue");
        }
      });
    })();
  }

  if (
    window.location.href == "https://lettres-au-mot.fr/explications-outils.php" ||
    window.location.href == "https://lettres-au-mot.com/explications-outils.php"

  ) {
    /*
        #############################
            ACCORDION
        #############################
        */
    // Add minus icon for collapse element which is open by default
    $(".collapse.show").each(function () {
      $(this).siblings(".card-header").find(".btn i").html("remove");
      $(this).prev(".card-header").addClass("highlight");
    });

    // Toggle plus minus icon on show hide of collapse element
    $(".collapse")
      .on("show.bs.collapse", function () {
        $(this).parent().find(".card-header .btn i").html("remove");
      })
      .on("hide.bs.collapse", function () {
        $(this).parent().find(".card-header .btn i").html("add");
      });

    // Highlight open collapsed element
    $(".card-header .btn").click(function () {
      $(".card-header").not($(this).parents()).removeClass("highlight");
      $(this).parents(".card-header").toggleClass("highlight");
    });
  }
});