<?php
session_start();
require('../class/Post.php');
require('../../configbdd.php');

//Mise à jour d'un user
if (isset($_POST['editUser'])) {
    $idUser = $_POST['idUser'];
    $nickname = $_POST['nickname'];
    $bio = $_POST['bio'];
    $birthday = $_POST['birthday'];
    $banner = $_POST['bannerEdit'];
    $picture = $_POST['pictureEdit'];

    User::editUser($idUser, $nickname, $bio, $birthday, $banner, $picture);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}

//Follow d'un user
if (isset($_POST['follow'])) {
    $sessionUser = $_POST['sessionUser'];
    $userProfil = $_POST['userProfil'];

    User::toggleFollow($sessionUser, $userProfil);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}

//Certif d'un user
if (isset($_POST['certif'])) {
    $userProfil = $_POST['userProfil'];

    User::toggleCertified($userProfil);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}

//Ban d'un user
if (isset($_POST['ban'])) {
    $userProfil = $_POST['userProfil'];
    $sessionUser = $_POST['sessionUser'];

    User::toggleBan($sessionUser, $userProfil);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}

// Gestion des likes / dislikes
if (isset($_POST['action']) && $_POST['action'] == 'toggleLike') {
    $postId = $_POST['postId'];
    $userId = $_POST['userId'];

    Post::toggleLike($postId, $userId);

    // Récupérez le nouveau nombre de likes après le toggle
    $likesCount = Post::countLikeByPostId($postId);

    // Ajoutez un message de débogage
    echo json_encode(['isLiked' => Post::isLiked($postId, $userId), 'likesCount' => $likesCount]);
    exit;
}
