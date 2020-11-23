<?php

$host = 'localhost';
$dbname = 'anagrammes;charset=UTF8';
$user = 'root';
$pass = '';


try {
    $dbh = new PDO('mysql:host='.$host.';dbname=' .$dbname, $user, $pass);
} catch (PDOException $e) {
    print "Erreur ! " . $e-> getMessage() . "<br>";
    die();
}