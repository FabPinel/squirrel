<?php

session_start();

//connection à la bdd
require_once('../../configbdd.php');

$affich_users = $bdd->prepare('SELECT * FROM users');
$affich_users->execute(array());
$affichage = $affich_users->fetch();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/ressources/img/logo.png" />
    <link rel="stylesheet" href="../css/login.css">
    <meta name="description" content="Se connecter">
</head>

<body>
    <div class="center">
        <h1>Se connecter</h1>
        <form action="../controller/loginController.php" method="post">
            <div class="txt_field">
                <input type="text" name="email" required>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" required>
                <span></span>
                <label>Mot de passe</label>
            </div>
            <a href="../views/register.php" class="newRegister">
                Pas encore de compte ? S'enregistrer
            </a>
            <input type="submit" value="Connexion">
        </form>
        <a href="/index.php">
            <button class="BtnRetour"> Retourner à la page d'accueil</button>
        </a>
    </div>
</body>

</html>