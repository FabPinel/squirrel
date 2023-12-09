<?php

session_start(); // Démarre la session
//connection à la bdd
require_once('../../configbdd.php');
require_once('../Class/UserBanned.php'); ?>
<link rel="stylesheet" href="../css/login.css">
<?php

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
                // Vérification si l'utilisateur est banni
                $bannedUsers = UserBanned::getAllUsersBanned($bdd);

                foreach ($bannedUsers as $bannedUser) {
                    if ($bannedUser->getUser()->getId() == $verif_user['id']) { ?>
                        <div class="center">
                            <h2>Le marteau du bannissement a frappé</h2>
                            <div class="banni">Impossible de vous connecter, vous êtes banni</div>
                            <a href="/index.php">
                                <button class="BtnRetour"> Retourner à la page d'accueil</button>
                            </a>
                        </div>
<?php
                        die();
                    }
                }
                $_SESSION['user'] = $verif_user['id'];
                header('Location: ' . $_SESSION['current_page']);
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
