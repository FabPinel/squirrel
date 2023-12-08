<?php
require __DIR__ . '/ressources/class/Post.php';
session_start();
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
$posts = Post::getAllPosts($bdd);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./ressources/css/style.css">
    <link rel="stylesheet" href="./ressources/css/navbar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" type="image/x-icon" href="https://image.noelshack.com/fichiers/2023/39/1/1695652660-favicon-squirrel.png" />
    <title>Squirrel</title>
</head>

<body>
    <?php include './ressources/views/navbar.php' ?>

    <div class="container">

        <h1 class="accueil">Accueil</h1>
        <div class='toggle'>
            <div class='tabs'>
                <div class='tab active'>
                    Pour vous
                </div>
                <div class='tab'>
                    Abonnements
                </div>

            </div>

            <div class='panels'>

                <div class='panel'>
                    <button class="show-modal">SHOW MODAL 1</button>

                    <div class="modal hidden">
                        <button class="close-modal">&times;</button>
                        <form action="" method="post" class="form-add-post">
                            <div class="modal-post">
                                <img src="https://cdn.discordapp.com/attachments/893102098953166949/893102250690494545/IMG_20210930_134435.jpg" alt="">
                                <input type="text" name="" id="" placeholder="J'adore quand...">
                            </div>
                            <input type="file" name="">
                            <div class="divide-form"></div>
                            <button class="submit-modal-post">poster</button>
                        </form>
                    </div>
                    <div class="overlay hidden"></div>
                    <?php foreach ($posts as $post) : ?>
                        <div class="unitPanelPost">
                            <div class="userPost">
                                <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="linkAvatarUser">
                                    <img src="<?= $post->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                                </a>
                                <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="userName"><?= $post->getUser()->getNickname(); ?></a>
                                <?php if (User::getCertif($post->getUser()->getId())) { ?>
                                    <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                                <?php } ?>
                                <p class="postTime"><?= Post::getTimeElapsedString($post->getCreatedDate()); ?></p>
                            </div>
                            <div class="postContent">
                                <p class="textPost"><?= $post->getTexte(); ?></a>
                                    <a href="<?= $post->getMedia(); ?>" class="without-caption image-link">
                                        <img src="<?= $post->getMedia(); ?>" alt="" class="imgPost">
                                    </a>
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

                </div>




                <div class='panel'>
                    Panel 2
                </div>

            </div>
        </div>

        <script src="/ressources/js/index.js">

        </script>


    </div>

</body>

</html>