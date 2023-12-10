<?php
require_once __DIR__ . '../../class/Comment.php';
require_once __DIR__ . '../../class/Post.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
session_start();
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
$id_post = $_GET['post'];

$posts = Post::getPostByPostId($id_post);
$comments = Comment::getCommentsByPostId($id_post);
$sessionUser = false;

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
    <title>Squirrel</title>
    <meta name="description" content="Explorer les posts">
</head>

<body>
    <?php include './navbar.php' ?>
    <div class="container">
        <div class='panel'>
            <div class="topPost">
                <span class="material-symbols-outlined arrowBack" onclick="goBack()">
                    arrow_back
                </span>
                <h2>Poster</h2>
            </div>
            <?php foreach ($posts as $post) : ?>
                <div class="unitPanelPost">
                    <div class="userPost">
                        <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="linkAvatarUser">
                            <img src="<?= $post->getUser()->getPicture(); ?>" alt="Profil utilisateur" class="avatarUserPost">
                        </a>
                        <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="userName"><?= $post->getUser()->getNickname(); ?></a>
                        <?php if (User::getCertif($post->getUser()->getId())) { ?>
                            <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                        <?php } ?>
                        <p class="postTimePost"><?= Post::getTimeElapsedString($post->getCreatedDate()); ?></p>
                        <?php
                        if (isset($_SESSION['user'])) {
                            if ($sessionUser->getRole() == 'Admin' || $post->getUser()->getId() == $sessionUser->getId()) { ?>
                                <form action="../controller/postController.php" method="post">
                                    <input type="hidden" name="idPost" value="<?php echo $post->getId(); ?>">
                                    <button class="deleteComment" name="deletePost">
                                        <span class="material-symbols-outlined">
                                            cancel
                                        </span>
                                    </button>
                                </form>
                        <?php }
                        } ?>
                    </div>
                    <div class="postContent">
                        <p class="textPost"><?= $post->getTexte(); ?></a>
                            <span class="without-caption image-link">
                                <img src="<?= $post->getMedia(); ?>" alt="" class="imgPost">
                            </span>
                    </div>
                    <div class="likecomment">
                        <?php if (isset($_SESSION['user'])) { ?>
                            <div class="likePost <?php echo (Post::isLiked($post->getId(), $sessionUser->getId())) ? 'like-active' : ''; ?>" data-post-id="<?= $post->getId(); ?>" data-user-id="<?= $sessionUser->getId(); ?>">
                                <span class="material-icons-outlined like-button" style="font-size: 22px;">
                                    favorite
                                </span>
                                <p class="numberLike like-count" data-post-id="<?= $post->getId(); ?>">
                                    <?= Post::countLikeByPostId($post->getId()); ?>
                                </p>
                            </div>
                        <?php } else { ?>
                            <div class="likePost">
                                <span class="material-icons-outlined" style="font-size: 22px;">
                                    favorite
                                </span>
                                <p class="numberLike like-count" data-post-id="<?= $post->getId(); ?>">
                                    <?= Post::countLikeByPostId($post->getId()); ?>
                                </p>
                            </div>
                        <?php } ?>
                        <div class="commentPost">
                            <span class="material-icons-outlined" style="font-size: 22px;">
                                chat_bubble
                            </span>
                            <p class="numberLike like-count" data-post-id="<?= $post->getId(); ?>">
                                <?= Post::countCommentByPostId($post->getId()); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (isset($_SESSION['user'])) { ?>
                <form action="../controller/postController.php" method="post" id="commentForm">
                    <input type="hidden" name="sessionUser" value="<?php echo $sessionUser->getId(); ?>">
                    <input type="hidden" name="idPost" value="<?php echo $id_post; ?>">
                    <div class="unitPanelPost">
                        <div class="userPost">
                            <a href="profil.php?user=<?= $sessionUser->getId(); ?>" class="linkAvatarUser">
                                <img src="<?= $sessionUser->getPicture(); ?>" alt="Profil utilisateur" class="avatarUserPost">
                            </a>
                            <textarea class="reponse" name="reponse" id="commentText" oninput="checkCommentText()" placeholder="Postez votre réponse"></textarea>
                            <button type="submit" name="newComment" class="newComment" id="submitButton" disabled>Répondre</button>
                        </div>
                    </div>
                </form>
            <?php } ?>
            <?php foreach ($comments as $comment) : ?>
                <div class="unitPanelPost">
                    <div class="userPost">
                        <a href="profil.php?user=<?= $comment->getUser()->getId(); ?>" class="linkAvatarUser">
                            <img src="<?= $comment->getUser()->getPicture(); ?>" alt="Profil utilisateur" class="avatarUserPost">
                        </a>
                        <a href="profil.php?user=<?= $comment->getUser()->getId(); ?>" class="userName"><?= $comment->getUser()->getNickname(); ?></a>
                        <?php if (User::getCertif($comment->getUser()->getId())) { ?>
                            <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                        <?php } ?>
                        <p class="postTimePost"><?= Post::getTimeElapsedString($comment->getCreatedDate()); ?></p>
                        <?php if (isset($_SESSION['user'])) {
                            if ($sessionUser->getRole() == 'Admin' || $comment->getUser()->getId() == $sessionUser->getId()) { ?>
                                <form action="../controller/postController.php" method="post">
                                    <input type="hidden" name="idComment" value="<?php echo $comment->getId(); ?>">
                                    <button class="deleteComment" name="deleteComment">
                                        <span class="material-symbols-outlined">
                                            cancel
                                        </span>
                                    </button>
                                </form>
                        <?php }
                        } ?>
                    </div>
                    <div class="postContent">
                        <p class="textPost"><?= $comment->getContent(); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>