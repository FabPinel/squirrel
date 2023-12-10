<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profil.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <script src="/ressources/js/profil.js"></script>
    <link rel="icon" type="image/x-icon" href="https://image.noelshack.com/fichiers/2023/39/1/1695652660-favicon-squirrel.png">
    <title>Squirrel - Expoler</title>
    <meta name="description" content="Liste des utilisateurs">
</head>

<?php
require_once __DIR__ . '../../class/Post.php';
require_once __DIR__ . '../../class/Follow.php';
require_once __DIR__ . '../../class/User.php';
require($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
session_start();
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
$users = User::getAllUsers();
?>

<body>
    <?php include './navbar.php' ?>
    <div class="container">
        <div class="profilTop"> <span class="material-symbols-outlined arrowBackProfil" onclick="goBack()">
                arrow_back
            </span>
            <h1 class="profil hide">Explorer les utilisateurs</h1>
        </div>
        <?php foreach ($users as $user) : ?>
            <div class="unitPanelPost">
                <div class="userPost">
                    <a href="profil.php?user=<?= $user->getId(); ?>" class="linkAvatarUser">
                        <img src="<?= $user->getPicture(); ?>" alt="Profil utilisateur" class="avatarUserPost">
                    </a>
                    <a href="profil.php?user=<?= $user->getId(); ?>" class="userName"><?= $user->getNickname(); ?></a>
                    <?php if (User::getCertif($user->getId())) { ?>
                        <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                    <?php } ?>
                </div>
                <div class="postContent">
                    <p class="textPost"><?= $user->getBio(); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>