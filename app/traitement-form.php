<?php
session_start();
require "../app/toolbox.php";
require "../app/bdd.php";

$nameBool = true;
$emailBool = true;
$subjectBool = true;
$messageBool = true;

$_SESSION['errors'] = '';
$_SESSION['success'] = '';
$errors = [];
$success = [];


function verif_alpha($str)
{

    // On cherche tt les caractères autre que [A-z]
    preg_match("/([^A-Za-z\s])/", $str, $result);

    // si on trouve des caractère autre que A-z
    if (!empty($result)) {
        return false;
    }
    return true;
}

// ####################################### 
// ########### CAPTCHA START #############

// Ma clé privée
$secret = "************************************************************";
// Paramètre renvoyé par le recaptcha
$response = $_POST['g-recaptcha-response'];
// On récupère l'IP de l'utilisateur
$remoteip = $_SERVER['REMOTE_ADDR'];

$api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
    . $secret
    . "&response=" . $response
    . "&remoteip=" . $remoteip;

$decode = json_decode(file_get_contents($api_url), true);

// ############ CAPTCHA END ##############
// ####################################### 


if ($decode['success'] == true) {

    if (isset($_POST) && !empty($_POST)) {
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $nameTemp = $_POST['name'];
            $nameValid = valid_donnees($nameTemp);

            if (strlen($nameValid) <= 20) {
                $nom = $nameValid;
            } else {
                $nameBool = false;
                $errors[] = "Saisie incorrecte de votre nom";
            }
        } else {
            $nameBool = false;
            $errors[] = "Saisie incorrecte de votre nom";
        }

        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $emailTemp = $_POST['email'];
            $emailValid = valid_donnees($emailTemp);

            if (filter_var($emailValid, FILTER_VALIDATE_EMAIL)) {
                $email = $emailValid;
            } else {
                $emailBool = false;
                $errors[] = "Saisie incorrecte de votradresse email";
            }
        } else {
            $emailBool = false;
            $errors[] = "Saisie incorrecte de votradresse email";
        }

        if (isset($_POST['subject']) && !empty($_POST['subject'])) {
            $subjectTemp = $_POST['subject'];
            $subjectValid = valid_donnees($subjectTemp);

            if (strlen($subjectValid) <= 30) {
                $sujet = $subjectValid;
            } else {
                $subjectBool = false;
                $errors[] = "Saisie incorrecte du sujet du message";
            }
        } else {
            $subjectBool = false;
            $errors[] = "Saisie incorrecte du sujet du message";
        }

        if (isset($_POST['message']) && !empty($_POST['message'])) {
            $messageTemp = $_POST['message'];
            $messageValid = valid_donnees($messageTemp);

            if (strlen($messageValid) <= 2000) {
                $msg = $messageValid;
            } else {
                $messageBool = false;
                $errors[] = "Saisie incorrecte du message";
            }
        } else {
            $messageBool = false;
            $errors[] = "Saisie incorrecte du message";
        }

        if (!$nameBool || !$emailBool || !$subjectBool || !$messageBool) {
            printPre($errors);
            foreach ($errors as $msg) {
                $_SESSION['errors'] .= "<i class=\"far fa-times-circle fa-sm text-danger mr-2\"></i>" . $msg . "<br>";
            }
        } else {

            // Enregistrement de l'user en Bdd
            include_once('user-bdd.php');
            $ip = get_ip();
            $sessionId = '';
            isset($_COOKIE['PHPSESSID']) ? $sessionId = $_COOKIE['PHPSESSID'] : $sessionId = 'indefine';

            $msgBdd = $dbh->prepare('INSERT INTO message (nom, email, sujet, msg, visiteur_id, ip, session_id) VALUES (:nom, :email, :sujet, :msg, :visiteur_id, :ip, :session_id)');
            $msgBdd->bindValue(':nom', $nom, PDO::PARAM_STR);
            $msgBdd->bindValue(':email', $email, PDO::PARAM_STR);
            $msgBdd->bindValue(':sujet', $sujet, PDO::PARAM_STR);
            $msgBdd->bindValue(':msg', $msg, PDO::PARAM_STR);
            $msgBdd->bindValue(':visiteur_id', $userId, PDO::PARAM_INT);
            $msgBdd->bindValue(':ip', $ip, PDO::PARAM_STR);
            $msgBdd->bindValue(':session_id', $sessionId, PDO::PARAM_STR);

            $msgBdd->execute();

            $_SESSION['success'] = '<i class="fas fa-check text-success fa-lg mr-2"></i><span class="ml-3">Votre message a bien été enregistré</span>.<br><span class="ml-5">Nous vous répondons très prochainement.</span><br><span class="ml-5">Merci pour l\'intérêt que vous portez à notre site.</span>';
        }
    }
} else {
    $_SESSION['errors'] = "<i class=\"far fa-times-circle fa-sm text-danger mr-2\"></i>Captcha Invalid... Si vous êtes un humain, merci de réessayer !<br>";
}
header('Location: ../contact.php');
exit;