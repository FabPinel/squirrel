<?php
require_once __DIR__ . '../../class/Comment.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
session_start();
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
$id_comment = $_GET['comment'];

$comments = Comment::getCommentById($id_comment);

if (isset($_SESSION['user'])) {
    $sessionUser = User::getSessionUser($bdd);
}

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
    <title>Squirrel - Votre commentaire</title>
</head>

<body>
    <?php include './navbar.php' ?>
    <div class="container">
        <div class='panel'>
            <div class="topPost">
                <span class="material-symbols-outlined arrowBack" onclick="goBack()">
                    arrow_back
                </span>
            </div>
            <?php foreach ($comments as $comment) : ?>
                <div class="unitPanelPost">
                    <div class="userPost">
                        <a href="profil.php?user=<?= $comment->getUser()->getId(); ?>" class="linkAvatarUser">
                            <img src="<?= $comment->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                        </a>
                        <a href="profil.php?user=<?= $comment->getUser()->getId(); ?>" class="userName"><?= $comment->getUser()->getNickname(); ?></a>
                        <?php if (User::getCertif($comment->getUser()->getId())) { ?>
                            <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                        <?php } ?>
                        <p class="postTimePost"><?= Post::getTimeElapsedString($comment->getCreatedDate()); ?></p>
                        <span class="material-symbols-outlined edit commentEdit" data-comment-id="<?= $comment->getId(); ?>">
                            cancel
                        </span>
                    </div>
                    <div class="postContent">
                        <p class="textPost"><?= $comment->getContent(); ?></a>
                            <textarea class="reponse" name="reponse" id="commentText"><?= $comment->getContent(); ?></textarea>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>