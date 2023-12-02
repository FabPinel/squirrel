<?php
require('../class/User.php');
require('../../configbdd.php');
//Mise à jour d'une thématique
if (isset($_POST['editUser'])) {
    $idUser = $_POST['idUser'];
    $nickname = $_POST['nickname'];
    $bio = $_POST['bio'];
    $birthday = $_POST['birthday'];

    var_dump($idUser, $nickname, $bio, $birthday);

    User::editUser($idUser, $nickname, $bio, $birthday);

    //header("Location: dashboard.php");
    exit;
}
