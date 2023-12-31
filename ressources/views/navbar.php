<link rel="stylesheet" href="/ressources/css/navbar.css">

<?php if (isset($_SESSION['user'])) {
    $affich_users = $bdd->prepare('SELECT * FROM users WHERE id=?');
    $affich_users->execute(array($_SESSION['user']));
    $affichage = $affich_users->fetch();
}
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<?php include 'ancre.php' ?>
<!--PARTIE DESKTOP-->

<div class="desktopBar">
    <div class="sidebar">
        <div class="sidebar-top-logo">
            <img class="logo" src="https://image.noelshack.com/fichiers/2023/39/1/1695652660-logo-squirrel.png" alt="Logo">
        </div>
        <ul>
            <li><a href="../../"><span class="material-icons-outlined iconNav">home</span>Accueil</a></li>
            <?php if (isset($_SESSION['user'])) { ?>
                <li><a href="/ressources/views/profil.php?user=<?= $affichage['id'] ?>"><span class="material-icons-outlined iconNav">person</span>Mon profil</a></li>
            <?php } else { ?>
                <li><a href="/ressources/views/login.php"><span class="material-icons-outlined iconNav">person</span>Mon profil</a></li>
            <?php } ?>
            <li><a href="/ressources/views/explorer.php"><span class="material-icons-outlined iconNav">search</span>Explorer</a></li>
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
                    <img src="<?= $affichage['picture']; ?>" alt="Profil utilisateur" class="avatarUserNav">
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
<script src="/ressources/js/navbar.js"></script>