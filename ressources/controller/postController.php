<?php
session_start();
require_once('../class/Post.php');
require_once('../class/Comment.php');
require('../../configbdd.php');

// Création d'un commentaire
if (isset($_POST['newComment'])) {
    $content = $_POST['reponse'];
    $sessionUser = $_POST['sessionUser'];
    $idPost = $_POST['idPost'];

    Comment::createComment($content, $sessionUser, $idPost);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}
