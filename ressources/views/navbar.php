<?php if (isset($_SESSION['user'])) {
    $affich_users = $bdd->prepare('SELECT * FROM users WHERE id=?');
    $affich_users->execute(array($_SESSION['user']));
    $affichage = $affich_users->fetch();
}
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Squirrel</title>
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'ancre.php' ?>
    <!--PARTIE DESKTOP-->

    <div class="desktopBar">
        <div class="sidebar">
            <div class="sidebar-top-logo">
                <img class="logo" src="https://image.noelshack.com/fichiers/2023/39/1/1695652660-logo-squirrel.png" alt="Logo">
            </div>
            <ul>
                <li><a href="../../"><i class="fas fa-home"></i>Accueil</a></li>
                <?php if (isset($_SESSION['user'])) { ?>
                    <li><a href="/ressources/views/profil.php?user=<?= $affichage['id'] ?>"><i class="fas fa-user"></i>Mon profil</a></li>
                <?php } else { ?>
                    <li><a href="/ressources/views/login.php"><i class="fas fa-user"></i>Mon profil</a></li>
                <?php } ?>
                <li><a href="/ressources/views/explorer.php"><i class="fas fa-search"></i>Explorer</a></li>
            </ul>
            <?php
            if (isset($_SESSION['user'])) {
            ?>
                <button class="post-button show-modal">POSTER</button>
            <?php
            } else {
            ?>
                <a href="/ressources/views/login.php" class="post-button">POSTER</a>
            <?php
            }
            ?>

            <?php if (!isset($_SESSION['user'])) { ?>
                <a href="/ressources/views/login.php" class="login-button">SE CONNECTER</a>
            <?php } else { ?>
                <a href="/ressources/views/logout.php" class="login-button">SE DÉCONNECTER</a>
            <?php } ?>

            <?php if (isset($_SESSION['user'])) { ?>
                <div class="userNav">
                    <a href="/ressources/views/profil.php?user=<?= $affichage['id']; ?>" class="linkAvatarUserNav">
                        <img src="<?= $affichage['picture']; ?>" alt="" class="avatarUserNav">
                    </a>
                    <a href="/ressources/views/profil.php?user=<?= $affichage['id']; ?>" class="userNameNav"><?= $affichage['nickname']; ?></a>
                    <?php if ($affichage['isVerify']) { ?>
                        <img src="https://image.noelshack.com/fichiers/2023/48/6/1701552525-squirrel-verified.png" alt="" class="verifiedNav">
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <!--PARTIE MOBILE-->
    <div class="mobileBar">
        <div class="container stage">
            <div class="tabbar tab-style3">
                <ul class="flex-center">
                    <li class="home <?php echo ($current_page === '') || ($current_page === 'index') ? 'active' : ''; ?>" data-where="accueil">
                        <a href="../../"><span class="material-icons-outlined icons-nav-mobile">home</span></a>
                    </li>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <li class="profil <?php echo (strpos($current_page, 'profil.php') !== false) ? 'active' : ''; ?>" data-where="profil">
                            <a href="/ressources/views/profil.php?user=<?= $affichage['id'] ?>">
                                <span class="material-icons-outlined icons-nav-mobile">person</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="profil" data-where="profil">
                            <a href="/ressources/views/login.php"><span class="material-icons-outlined icons-nav-mobile">person</span></a>
                        </li>
                    <?php } ?>
                    <li class="search <?php echo ($current_page === 'explorer.php') ? 'active' : ''; ?>" data-where="explorer">
                        <a href="/ressources/views/explorer.php"><span class="material-icons-outlined icons-nav-mobile">search</span></a>
                    </li>

                    <li class="products show-modal" data-where="add">
                        <?php
                        if (isset($_SESSION['user'])) {
                        ?>
                            <span class="material-icons-outlined icons-nav-mobile">maps_ugc</span>
                        <?php
                        } else {
                        ?>
                            <a href="/ressources/views/login.php" class="material-icons-outlined icons-nav-mobile">maps_ugc</a>
                        <?php
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <section></section>
    <script src="../js/navbar.js"></script>
</body>

</html>