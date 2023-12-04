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
    <title>Squirrel</title>
    <script src="/ressources/js/profil.js"></script>
</head>

<body>
    <?php include './navbar.php' ?>
    <div class="container">
        <a href="/ressources/views/login.php">LOGIN</a>
        <a href="/ressources/views/logout.php">DECO</a>
        <a href="../../index.php">ACCUEIL</a>
        <h1 class="profil"><?php echo $user->getNickname(); ?></h1>
        <a class="post"><?php echo $totalPost; ?> posts</a>
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
                <?php } else { ?>
                    <form action="../controller/profilController.php" method="post">
                        <input type="hidden" name="sessionUser" value="<?php echo $sessionUser->getId(); ?>">
                        <input type="hidden" name="userProfil" value="<?php echo $id_user; ?>">
                        <button class="follow" name="follow">Suivre</button>
                    </form>
        <?php
                }
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
                <p class="profilNaissance">Naissance le <?php echo $user->formatBirthday($user->getBirthday()); ?></p>
                <p class="profilCreatedDate">A rejoint Squirrel en <?php echo $user->formatCreatedDate($user->getCreatedDate()); ?></p>
            </div>
            <a><strong><?php echo $followOfUser; ?></strong> abonnements</a>
            <a><strong><?php echo $followersOfUser; ?></strong> abonnés</a>
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
                        <?php endforeach; ?>
                        </div>

                        <div class='panel'>
                            <div class="unitPanel">
                                <div class="userPost">
                                    <a href="#" class="linkAvatarUser">
                                        <img src="https://cdn.discordapp.com/attachments/893102098953166949/893102250690494545/IMG_20210930_134435.jpg" alt="" class="avatarUserPost">
                                    </a>
                                    <a href="#" class="userName">Pierre (la ruche)</a>
                                    <img src="https://w7.pngwing.com/pngs/910/897/png-transparent-twitter-verified-badge-hd-logo.png" alt="" class="verified">
                                    <p class="postTime"> 1H </p>
                                </div>

                                <div class="postContent">
                                    <p class="textPost">🌟🏡 "La Vendée, c'est la pépite de la France ! Des plages magnifiques, une culture riche, et une histoire profonde. Quand je ne suis pas en train de savourer nos délicieux fruits de mer ou nos vins locaux incroyables, vous me trouverez en train de porter fièrement les couleurs du Borussia Dortmund. Un mélange de l'élégance à la française et de la passion du football allemand ! 💛⚽"</p> <a href="#" style="color: #1D9BF0;">#Vendée #Haaland #EchteLiebe #12anscestparfait #stonks</a>
                                    <a href="https://img.freepik.com/photos-gratuite/crane-nombreuses-parties-differentes-dessus_698780-1005.jpg?w=740&t=st=1695668788~exp=1695669388~hmac=9936392524ad6b11019c2d029dd22d7f6109b088b006ce6f6ff7b1194329e075" class="without-caption image-link">
                                        <img src="https://cdn.discordapp.com/attachments/893102098953166949/900024945709576202/IMG_20211019_160836.jpg" alt="" class="imgPost">
                                    </a>
                                </div>

                                <div class="likePost">
                                    <span class="material-symbols-outlined" style="font-size: 22px;">
                                        favorite
                                    </span>
                                    <p class="numberLike">5</p>
                                </div>
                            </div>
                        </div>

                        <div class='panel'>
                            <div class="unitPanel">
                                <div class="userPost">
                                    <a href="#" class="linkAvatarUser">
                                        <img src="https://cdn.discordapp.com/attachments/893102098953166949/893102250690494545/IMG_20210930_134435.jpg" alt="" class="avatarUserPost">
                                    </a>
                                    <a href="#" class="userName">Pierre (la ruche)</a>
                                    <img src="https://w7.pngwing.com/pngs/910/897/png-transparent-twitter-verified-badge-hd-logo.png" alt="" class="verified">
                                    <p class="postTime"> 1H </p>
                                </div>

                                <div class="postContent">
                                    <p class="textPost">🌟🏡 "La Vendée, c'est la pépite de la France ! Des plages magnifiques, une culture riche, et une histoire profonde. Quand je ne suis pas en train de savourer nos délicieux fruits de mer ou nos vins locaux incroyables, vous me trouverez en train de porter fièrement les couleurs du Borussia Dortmund. Un mélange de l'élégance à la française et de la passion du football allemand ! 💛⚽"</p> <a href="#" style="color: #1D9BF0;">#Vendée #Haaland #EchteLiebe #12anscestparfait #stonks</a>
                                    <a href="https://img.freepik.com/photos-gratuite/crane-nombreuses-parties-differentes-dessus_698780-1005.jpg?w=740&t=st=1695668788~exp=1695669388~hmac=9936392524ad6b11019c2d029dd22d7f6109b088b006ce6f6ff7b1194329e075" class="without-caption image-link">
                                        <img src="https://cdn.discordapp.com/attachments/893102098953166949/900024945709576202/IMG_20211019_160836.jpg" alt="" class="imgPost">
                                    </a>
                                </div>

                                <div class="likePost">
                                    <span class="material-symbols-outlined" style="font-size: 22px;">
                                        favorite
                                    </span>
                                    <p class="numberLike">5</p>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
</body>

</html>