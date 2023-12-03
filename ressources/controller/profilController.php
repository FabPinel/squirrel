<?php
session_start();
require('../class/User.php');
require('../../configbdd.php');
//Mise à jour d'une thématique
if (isset($_POST['editUser'])) {
    $idUser = $_POST['idUser'];
    $nickname = $_POST['nickname'];
    $bio = $_POST['bio'];
    $birthday = $_POST['birthday'];
    $banner = $_POST['bannerEdit'];
    $picture = $_POST['pictureEdit'];

    var_dump($idUser, $nickname, $bio, $birthday);

    User::editUser($idUser, $nickname, $bio, $birthday, $banner, $picture);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}
