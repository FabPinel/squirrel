<?php
require '../Class/Post.php';
require($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
session_start();
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
$id_user = $_GET['user'];
$isUserSession = false;

$user = User::getUserById($id_user);
$totalPost = Post::countPostByUserId($id_user);
$followOfUser = Post::countFollowByUserId($id_user);
$followersOfUser = Post::countFollowersByUserId($id_user);

if (isset($_SESSION['user'])) {
    $sessionUser = User::getSessionUser($bdd);
    if ($id_user == $sessionUser->getId()) {
        $isUserSession = true;
    }
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
        <a href="http://" class="edit">
            <button class="profilEdit">Editer le profil</button>
        </a>
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
        </div>
        <div class='toggle'>
            <div class='tabs'>
                <div class='tab active'>Posts</div>
                <div class='tab'>Réponses</div>
                <div class='tab'>J'aime</div>
            </div>
            <div class='panels'>
                <div class='panel'>
                    <div class="unitPanel">
                        <div class="userPost">
                            <a href="#" class="linkAvatarUser">
                                <img src="https://cdn.discordapp.com/attachments/893102098953166949/893102250690494545/IMG_20210930_134435.jpg" alt="" class="avatarUserPost">
                            </a>
                            <a href="#" class="userName">Pierre (la ruche)</a>
                            <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verified">
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