<?php
require_once __DIR__ . '../../class/Post.php';
require_once __DIR__ . '../../class/Follow.php';
require_once __DIR__ . '../../class/User.php';
require($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
session_start();
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
$id_user = $_GET['user'];
$user = User::getUserById($id_user);
$follows = Follow::getAllFollows($id_user);
$followers = Follow::getAllFollowers($id_user);


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/profil.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="/ressources/js/profil.js"></script>
    <link rel="icon" type="image/x-icon" href="https://image.noelshack.com/fichiers/2023/39/1/1695652660-favicon-squirrel.png" />
    <title>Squirrel - Follow</title>
</head>

<body>
    <?php include './navbar.php' ?>
    <div class="container">
        <div class="profilTop"> <span class="material-symbols-outlined arrowBackProfil" onclick="goBack()">
                arrow_back
            </span>
            <h1 class="profil hide"><?php echo $user->getNickname(); ?></h1>
        </div>
        <div class='toggle'>
            <div class='tabs'>
                <div class='tab active'>Abonnés</div>
                <div class='tab'>Abonnements</div>
            </div>
            <div class='panels'>
                <div class='panel'>
                    <?php foreach ($followers as $follower) : ?>
                        <div class="unitPanelPost">
                            <div class="userPost">
                                <a href="profil.php?user=<?= $follower->getUser()->getId(); ?>" class="linkAvatarUser">
                                    <img src="<?= $follower->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                                </a>
                                <a href="profil.php?user=<?= $follower->getUser()->getId(); ?>" class="userName"><?= $follower->getUser()->getNickname(); ?></a>
                                <?php if (User::getCertif($follower->getUser()->getId())) { ?>
                                    <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                                <?php } ?>
                            </div>
                            <div class="postContent">
                                <p class="textPost"><?= $follower->getUser()->getBio(); ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class='panel'>
                    <?php foreach ($follows as $follow) : ?>
                        <div class="unitPanelPost">
                            <div class="userPost">
                                <a href="profil.php?user=<?= $follow->getUser()->getId(); ?>" class="linkAvatarUser">
                                    <img src="<?= $follow->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                                </a>
                                <a href="profil.php?user=<?= $follow->getUser()->getId(); ?>" class="userName"><?= $follow->getUser()->getNickname(); ?></a>
                                <?php if (User::getCertif($follow->getUser()->getId())) { ?>
                                    <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                                <?php } ?>
                            </div>
                            <div class="postContent">
                                <p class="textPost"><?= $follow->getUser()->getBio(); ?></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>