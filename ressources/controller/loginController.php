<?php

session_start(); // Démarre la session
//connection à la bdd
require_once('../../configbdd.php');

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = strtolower($email);

    // vérification si l'utilisateur existe déjà pour éviter les doublons
    $check = $bdd->prepare('SELECT * FROM users WHERE email=?');
    $check->execute(array($email));
    $verif_user = $check->fetch();
    $row =  $check->rowCount();

    if ($row > 0) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {  //on vérifie que l'email ait la bonne forme
            if (password_verify($password, $verif_user['password'])) {
                $_SESSION['user'] = $verif_user['id'];
                //header('Location: ' . $_SESSION['current_page']);
                die();
            } else {
                echo 'Votre mot de passe ne correspond pas';
            }
        } else {
            echo "Votre email n'est pas valide";
        }
    } else {
        echo "Cet utilisateur n'existe pas";
    }
} else {
    echo "Vous n'êtes pas connecté";
}
