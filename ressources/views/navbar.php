<?php if (isset($_SESSION['user'])) {
    $affich_users = $bdd->prepare('SELECT * FROM users WHERE id=?');
    $affich_users->execute(array($_SESSION['user']));
    $affichage = $affich_users->fetch();
}
$current_page = $_SESSION['current_page'] = basename($_SERVER['REQUEST_URI']);
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
            <a href="#" class="post-button">POSTER</a>
            <?php if (!isset($_SESSION['user'])) { ?>
                <a href="/ressources/views/login.php" class="login-button">Se connecter</a>
            <?php } else { ?>
                <a href="/ressources/views/logout.php" class="login-button">Se déconnecter</a>
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
                    <li class="products" data-where="add">
                        <span class="material-icons-outlined icons-nav-mobile">maps_ugc</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <section></section>
    <script src="../js/navbar.js"></script>
</body>

</html>