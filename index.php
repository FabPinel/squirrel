<?php
require __DIR__ . '/ressources/class/Post.php';
session_start();
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
$posts = Post::getAllPosts();
if (isset($_SESSION['user'])) {
    $sessionUser = User::getSessionUser($bdd);
    $postsFollow = Post::getAllPostsFollowByUserId($sessionUser->getId());
    $suggestUsers = User::getSuggestUsers($sessionUser->getId());
}
$users = User::getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./ressources/css/style.css">
    <link rel="stylesheet" href="./ressources/css/navbar.css">
    <link rel="stylesheet" href="./ressources/css/profil.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/ressources/js/profil.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" type="image/x-icon" href="https://image.noelshack.com/fichiers/2023/39/1/1695652660-favicon-squirrel.png" />
    <title>Squirrel</title>
</head>

<body>
    <?php include './ressources/views/navbar.php' ?>

    <div class="flux-suggestion">

        <div class="container">
            <?php include './ressources/views/modal-post.php' ?>

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
                        <div class="overlay hidden"></div>
                        <?php foreach ($posts as $post) : ?>
                            <div class="unitPanelPost">
                                <div class="userPost">
                                    <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="linkAvatarUser">
                                        <img src="<?= $post->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                                    </a>
                                    <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="userName"><strong><?= $post->getUser()->getNickname(); ?></a></strong>
                                    <?php if (User::getCertif($post->getUser()->getId())) { ?>
                                        <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                                    <?php } ?>
                                    <p class="postTime"><?= Post::getTimeElapsedString($post->getCreatedDate()); ?></p>
                                    <?php if (isset($_SESSION['user'])) {
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
                        <?php if (!isset($_SESSION['user'])) { ?>
                            <div class="aboIndex">
                                <p>Vous devez être connecté.</p>
                                <a href="/ressources/views/login.php" class="login-button">Se connecter</a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <?php foreach ($postsFollow as $post) : ?>
                                <div class="unitPanelPost">
                                    <div class="userPost">
                                        <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="linkAvatarUser">
                                            <img src="<?= $post->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                                        </a>
                                        <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="userName"><strong><?= $post->getUser()->getNickname(); ?></a></strong>
                                        <?php if (User::getCertif($post->getUser()->getId())) { ?>
                                            <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                                        <?php } ?>
                                        <p class="postTime"><?= Post::getTimeElapsedString($post->getCreatedDate()); ?></p>
                                        <?php if (isset($_SESSION['user'])) {
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
                        <?php
                        }
                        ?>
                    </div>

                </div>
            </div>
            </script>


        </div>
        <?php if (isset($_SESSION['user'])) { ?>
            <div class="suggestions">
                <h2>Suggestions</h2>
                <?php foreach ($suggestUsers as $user) : ?>
                    <div class="suggestions-unitPanelPost">
                        <div class="suggestions-userPost">
                            <a href="profil.php?user=<?= $user->getId(); ?>" class="linkAvatarUser">
                                <img src="<?= $user->getPicture(); ?>" alt="" class="avatarUserPost">
                            </a>
                            <a href="profil.php?user=<?= $user->getId(); ?>" class="userName"><?= $user->getNickname(); ?></a>
                            <?php if (User::getCertif($user->getId())) { ?>
                                <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
                            <?php } ?>
                            <form action="../controller/profilController.php" method="post" class="suggestion-form">
                                <input type="hidden" name="sessionUser" value="">
                                <input type="hidden" name="userProfil" value="">
                                <button class="follow-suggestion" name="follow">Suivre</button>
                            </form>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php } ?>
    </div>
    <script src="/ressources/js/index.js"></script>

</body>

</html>