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

//Supressions d'un commentaire
if (isset($_POST['deleteComment'])) {
    $idComment = $_POST['idComment'];

    Comment::deleteComment($idComment);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}

//Supressions d'un post
if (isset($_POST['deletePost'])) {
    $idPost = $_POST['idPost'];

    Post::deletePost($idPost);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['newPost'])) {
    $user = $_POST['id_user'];
    $texte = isset($_POST['texte']) ? $_POST['texte'] : '';
    $media = isset($_FILES['media']) ? $_FILES['media'] : '';

    $new_img_name = '';  // Initialise avec une valeur vide par défaut

    if (!empty($media)) {
        $media_name = $_FILES['media']['name'];
        $media_size = $_FILES['media']['size'];
        $tmp_name = $_FILES['media']['tmp_name'];
        $error = $_FILES['media']['error'];

        if ($error === 0) {
            if ($media_size > 15000000) {
                $em = "La taille du fichier est trop lourde, elle ne doit pas dépasser les 15 Mo";
                header("Location: index.php?error=$em");
                exit;
            } else {
                $img_ex = pathinfo($media_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png", "webp");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $root_path = $_SERVER['DOCUMENT_ROOT'];
                    $img_upload_path = $root_path . '/ressources/img/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                } else {
                    $em = "Vous ne pouvez pas télécharger de fichier de ce type";
                    header("Location: index.php?error=$em");
                    exit;
                }
            }
        }
    }

    Post::createPost($texte, $user, $new_img_name);

    header('Location: ' . $_SESSION['current_page']);
    exit;
}
