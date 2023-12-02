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
            <header>
                <img class="logo" src="https://image.noelshack.com/fichiers/2023/39/1/1695652660-logo-squirrel.png" alt="Logo">
            </header>
            <ul>
                <li><a href="#"><i class="fas fa-home"></i>Accueil</a></li>
                <li><a href="#"><i class="fas fa-user"></i>Mon profil</a></li>
                <li><a href="#"><i class="fas fa-bell"></i>Notifications</a></li>
                <li><a href="#"><i class="fas fa-sliders-h"></i>Paramètres</a></li>
            </ul>
            <a href="#" class="post-button">POSTER</a>
            <a href="#" class="login-button">Se connecter</a>
        </div>
    </div>
    <!--PARTIE MOBILE-->
    <div class="mobileBar">
        <div class="topbar">
            <div class="profile-icon">
                <a href="#profile">
                    <i class="fas fa-user"></i>
                </a>
            </div>
            <div class="logo">
                <img src="https://image.noelshack.com/fichiers/2023/39/1/1695652660-logo-squirrel.png" alt="Logo" />
            </div>
            <div class="empty-space"></div>
        </div>

        <div class="container stage">
            <div class="tabbar tab-style3">
                <ul class="flex-center">
                    <li class="home active" data-where="accueil">
                        <span class="material-icons-outlined">home</span>
                    </li>
                    <li class="products" data-where="recherche">
                        <span class="material-icons-outlined">search</span>
                    </li>
                    <li class="services" data-where="notifications">
                        <span class="material-icons-outlined">notifications</span>
                    </li>
                    <li class="help" data-where="parametres">
                        <span class="material-icons-outlined">settings</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="content">
        <!-- Contenu principal -->
    </div>

    <section></section>
    <script src="../js/navbar.js"></script>
</body>

</html>