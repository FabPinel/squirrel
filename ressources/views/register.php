<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\login.css">
    <link rel="icon" type="image/x-icon" href="https://image.noelshack.com/fichiers/2023/39/1/1695652660-favicon-squirrel.png" />
    <title>Squirrel - S'inscrire</title>
</head>

<body>
    <div class="center">
        <h1>S'inscrire</h1>
        <form action="../controller/registerController.php" method="post" action="_URL_" enctype="multipart/form-data">
            <div class="txt_field">
                <input type="text" required name="lastname">
                <span></span>
                <label>Nom</label>
            </div>
            <div class="txt_field">
                <input type="text" required name="firstname">
                <span></span>
                <label>Prénom</label>
            </div>
            <div class="txt_field">
                <input type="text" required name="nickname">
                <span></span>
                <label>Pseudo</label>
            </div>
            <div class="txt_field">
                <input type="date" required name="birthday">
                <span></span>
                <!-- <label>Date de naissance</label> -->
            </div>
            <div class="txt_field">
                <input type="text" required name="email">
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" required name="password">
                <span></span>
                <label>Mot de passe</label>
            </div>
            <input type="submit" value="S'inscrire">
            <div class="signup_link">
            </div>
        </form>
        <a href="/index.php">
            <button class="BtnRetour"> Retourner à la page d'accueil</button>
        </a>
    </div>
</body>

</html>