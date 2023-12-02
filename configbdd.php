<?php

try {
    $bdd = new PDO("mysql:host=mysql-squirel.alwaysdata.net;dbname=squirel_bdd;charset=utf8mb4", "squirel", "Squirel13013@");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
