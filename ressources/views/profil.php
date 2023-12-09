<?php
require __DIR__ . '../../class/Post.php';
require($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
session_start();
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
$id_user = $_GET['user'];
$isUserSession = false;
$isFollow = false;
$isCertified = false;
$isBanned = false;

$posts = Post::getAllPostsByUserId($id_user);
$postsComments = Post::getAllPostsCommentByUserId($id_user);
$postsLikes = Post::getAllPostsLikeByUserId($id_user);
$user = User::getUserById($id_user);
$totalPost = Post::countPostByUserId($id_user);
$followOfUser = User::countFollowByUserId($id_user);
$followersOfUser = User::countFollowersByUserId($id_user);

if (isset($_SESSION['user'])) {
    $sessionUser = User::getSessionUser($bdd);
    if ($id_user == $sessionUser->getId()) {
        $isUserSession = true;
    }
    $isFollow = User::getFollow($sessionUser->getId(), $id_user);
    $isCertified = User::getCertif($id_user);
    $isBanned = User::getBan($id_user);
    $isFollower = User::isFollower($sessionUser->getId(), $id_user);
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
    <title>Squirrel - <?php echo $user->getNickname() ?></title>
</head>

<body>
    <?php include './navbar.php' ?>
    <div class="container">
        <div class="profilTop"> <span class="material-symbols-outlined arrowBackProfil" onclick="goBack()">
                arrow_back
            </span>
            <h1 class="profil hide"><?php echo $user->getNickname(); ?></h1>
        </div>
        <a class="post hide"><?php echo $totalPost; ?> posts</a>
        <img src="<?php echo $user->getBanner(); ?>" alt="" class="banner">
        <img src="<?php echo $user->getPicture(); ?>" alt="" class="profilPic">
        <?php if (isset($_SESSION['user'])) {
            if ($isUserSession) { ?>
                <button class="profilEdit">Editer le profil</button>
                <?php } else {
                if ($isFollow) { ?>
                    <form action="../controller/profilController.php" method="post">
                        <input type="hidden" name="sessionUser" value="<?php echo $sessionUser->getId(); ?>">
                        <input type="hidden" name="userProfil" value="<?php echo $id_user; ?>">
                        <button class="isFollow" name="follow">Suivi ✔</button>
                    </form>
                <?php } else if ($isFollower) { ?>
                    <form action="../controller/profilController.php" method="post">
                        <input type="hidden" name="sessionUser" value="<?php echo $sessionUser->getId(); ?>">
                        <input type="hidden" name="userProfil" value="<?php echo $id_user; ?>">
                        <button class="follow" name="follow">Suivre en retour</button>
                    </form>
                <?php
                } else { ?>
                    <form action="../controller/profilController.php" method="post">
                        <input type="hidden" name="sessionUser" value="<?php echo $sessionUser->getId(); ?>">
                        <input type="hidden" name="userProfil" value="<?php echo $id_user; ?>">
                        <button class="follow" name="follow">Suivre</button>
                    </form>
        <?php }
            }
        }
        ?>
        <div class="bio">
            <div class="profilNickname">
                <h2 class="profil"><?php echo $user->getNickname(); ?></h2>
                <?php if ($user->isVerified()) { ?>
                    <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verifiedNickname">
                <?php } ?>
            </div>
            <p><?php echo $user->getBio(); ?></p>
            <div class="profilDate">
                <span class="material-symbols-outlined" style="font-size: 22px; margin-top: 1vw; margin-right: 0.5vw;">
                    cake
                </span>
                <p class="profilNaissance">Naissance le <?php echo $user->formatBirthday($user->getBirthday()); ?></p>
                <span class="material-symbols-outlined" style="font-size: 22px; margin-top: 1vw; margin-left: 0.5vw;  margin-right: 0.3vw;">
                    calendar_month
                </span>
                <p class="profilCreatedDate">A rejoint Squirrel en <?php echo $user->formatCreatedDate($user->getCreatedDate()); ?></p>
            </div>
            <a href="follow.php?user=<?= $user->getId(); ?>" class="followProfil">
                <strong><?php echo $followOfUser; ?></strong> abonnements
                <strong><?php echo $followersOfUser; ?></strong> abonnés
            </a>
            <?php if (isset($_SESSION['user']) && $sessionUser->getRole() == 'Admin' && !$isUserSession) { ?>
                <div class="profilAdmin">
                    <?php if ($isCertified) { ?>
                        <form action="../controller/profilController.php" method="post">
                            <input type="hidden" name="userProfil" value="<?php echo $id_user; ?>">
                            <button class="isCertif" name="certif">Certifier ✔</button>
                        </form>
                    <?php } else { ?>
                        <form action="../controller/profilController.php" method="post">
                            <input type="hidden" name="userProfil" value="<?php echo $id_user; ?>">
                            <button class="certif" name="certif">Certifier</button>
                        </form>
                    <?php }
                    if ($isBanned) { ?>
                        <form action="../controller/profilController.php" method="post">
                            <input type="hidden" name="userProfil" value="<?php echo $id_user; ?>">
                            <input type="hidden" name="sessionUser" value="<?php echo $sessionUser->getId(); ?>">
                            <button class="isBanned" name="ban">Bannir ✔</button>
                        </form>
                    <?php } else { ?>
                        <form action="../controller/profilController.php" method="post">
                            <input type="hidden" name="userProfil" value="<?php echo $id_user; ?>">
                            <input type="hidden" name="sessionUser" value="<?php echo $sessionUser->getId(); ?>">
                            <button class="ban" name="ban">Bannir</button>
                        </form>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <div id="overlay"></div>

        <!-- Formulaire de modification de profil (initiallement caché) -->
        <div id="editProfilePopup" class="popup">
            <div class="popupTitle">
                <button class="closeButton" onclick="hideEditProfilePopup()">X</button>
                <h2 class="title">Éditer le profil</h2>
            </div>
            <form action="../controller/profilController.php" method="post">
                <input type="hidden" name="idUser" value="<?php echo $id_user; ?>">
                <img src="<?php echo $user->getBanner(); ?>" alt="" class="bannerEdit">
                <img src="<?php echo $user->getPicture(); ?>" alt="" class="profilPicEdit">
                <label for="bannerEdit">Bannière:</label>
                <input type="text" id="bannerEdit" name="bannerEdit" value="<?php echo $user->getBanner(); ?>">

                <label for="pictureEdit">Photo de profil:</label>
                <input type="text" id="pictureEdit" name="pictureEdit" value="<?php echo $user->getPicture(); ?>">

                <label for="nickname">Pseudo:</label>
                <input type="text" id="nickname" name="nickname" value="<?php echo $user->getNickname(); ?>">

                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio"><?php echo $user->getBio(); ?></textarea>

                <label for="birthday">Date de naissance:</label>
                <input type="date" id="birthday" name="birthday" value="<?php echo $user->getBirthday(); ?>">

                <button type="submit" name="editUser" class="editUser">Enregistrer</button>
            </form>
        </div>

        <div class='toggle'>
            <div class='tabs'>
                <div class='tab active'>Posts</div>
                <div class='tab'>Réponses</div>
                <div class='tab'>J'aime</div>
            </div>
            <div class='panels'>
                <div class='panel'>
                    <?php if (empty($posts)) {
                        if ($isUserSession) { ?>
                            <h2 class="emptyPost">Vous n'avez aucune publication</h2>
                        <?php } else { ?>
                            <h2 class="emptyPost"><?php echo $user->getNickname(); ?> n'a aucune publication</h2>
                        <?php }
                    } else { ?>
                        <?php foreach ($posts as $post) : ?>
                            <div class="unitPanelPost clickable-post" data-post-id="<?= $post->getId(); ?>">
                                <div class="userPost">
                                    <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="linkAvatarUser">
                                        <img src="<?= $post->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                                    </a>
                                    <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="userName"><?= $post->getUser()->getNickname(); ?></a>
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
                                    <a href="post.php?post=<?= $post->getId(); ?>" class="post-link">
                                        <p class="textPost"><?= $post->getTexte(); ?></p>
                                        <?php if ($post->getMedia()) : ?>
                                            <img src="<?= $post->getMedia(); ?>" alt="" class="imgPost">
                                        <?php endif; ?>
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
                    <?php endforeach;
                    } ?>
                </div>

                <div class='panel'>
                    <?php if (empty($postsComments)) {
                        if ($isUserSession) { ?>
                            <h2 class="emptyPost">Vous n'avez commenté aucune publication</h2>
                        <?php } else { ?>
                            <h2 class="emptyPost"><?php echo $user->getNickname(); ?> n'a commenté aucune publication</h2>
                        <?php }
                    } else { ?>
                        <?php foreach ($postsComments as $post) : ?>
                            <div class="unitPanelPost clickable-post" data-post-id="<?= $post->getId(); ?>">
                                <div class="userPost">
                                    <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="linkAvatarUser">
                                        <img src="<?= $post->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                                    </a>
                                    <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="userName"><?= $post->getUser()->getNickname(); ?></a>
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
                                    <a href="post.php?post=<?= $post->getId(); ?>" class="post-link">
                                        <p class="textPost"><?= $post->getTexte(); ?></p>
                                        <?php if ($post->getMedia()) : ?>
                                            <img src="<?= $post->getMedia(); ?>" alt="" class="imgPost">
                                        <?php endif; ?>
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
                    <?php endforeach;
                    } ?>
                </div>

                <div class='panel'>
                    <?php if (empty($postsLikes)) {
                        if ($isUserSession) { ?>
                            <h2 class="emptyPost">Vous n'avez aimé aucune publication</h2>
                        <?php } else { ?>
                            <h2 class="emptyPost"><?php echo $user->getNickname(); ?> n'a aimé aucune publication</h2>
                        <?php }
                    } else { ?>
                        <?php foreach ($postsLikes as $post) : ?>
                            <div class="unitPanelPost clickable-post" data-post-id="<?= $post->getId(); ?>">
                                <div class="userPost">
                                    <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="linkAvatarUser">
                                        <img src="<?= $post->getUser()->getPicture(); ?>" alt="" class="avatarUserPost">
                                    </a>
                                    <a href="profil.php?user=<?= $post->getUser()->getId(); ?>" class="userName"><?= $post->getUser()->getNickname(); ?></a>
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
                                    <a href="post.php?post=<?= $post->getId(); ?>" class="post-link">
                                        <p class="textPost"><?= $post->getTexte(); ?></p>
                                        <?php if ($post->getMedia()) : ?>
                                            <img src="<?= $post->getMedia(); ?>" alt="" class="imgPost">
                                        <?php endif; ?>
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
                    <?php endforeach;
                    } ?>
                </div>

            </div>
        </div>
    </div>
</body>

</html>