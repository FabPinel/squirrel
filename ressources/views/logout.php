<?php

session_start(); //on récupère la session à détruire

$_SESSION = array(); //on récupère les informations contenues dans session 
session_destroy(); //Destruit la session en cours (on détruit le tableau $_SESSION)
header('Location:/index.php '); // on redirige l'utilisateur vers la page index sans informations de connection de session
die();
