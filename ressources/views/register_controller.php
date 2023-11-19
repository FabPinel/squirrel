<?php
//connection à la bdd
require_once('C:\wamp64\www\squirrel\configbdd.php');
if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['nickname']) && !empty($_POST['email'] && !empty($_POST['password']))) {


    // patch xss (sécurité)
    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $nickname = htmlspecialchars($_POST['nickname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);


    // vérification si l'utilisateur existe déjà pour éviter les doublons
    $check = $bdd->prepare('SELECT firstName, lastName, nickname, password FROM users WHERE email=?');
    $check->execute(array($email));
    $verif_user = $check->fetch();
    $row =  $check->rowCount();

    // Tous les caractères majuscules seront transformés en minuscules pour éviter les majuscules dans les mails.
    $email = strtolower($email);

    // si la vérification ($check) renvoie aucune ligne (0) alors l'utilisateur n'existe pas,
    // alors nous pouvont l'insérer dans la base de données (dans la requête ci-dessous)

    if ($row == 0) { //si il y a 0 lignes (en gros que l'utilisateur n'existe pas)

        if (strlen($nickname) <= 50) { // on vérifie que le pseudo ait maximum 50 caractères

            if (strlen($email) <= 100) { //on vérifie que l'email soit de maximum 100 caractères

                if (strlen($password) >= 8) {

                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {  //on vérifie que l'email ait la bonne forme

                        // hashes du mot de passe par Bcrypt
                        $password = password_hash($password, PASSWORD_BCRYPT);

                        $insert_db = $bdd->prepare('INSERT INTO users(firstName, lastName, nickname, email, password) VALUES(:firstName, :lasttName, :nickname, :email, :password)');
                        $insert_db->execute(array(
                            'firstName' => $firstname,
                            'lasttName' => $lastname,
                            'nickname' => $nickname,
                            'email' => $email,
                            'password' => $password,
                        ));
                        header('Location:index.php');
                    } else {
                        echo "L'email n'est pas valide";
                    }
                } else {
                    echo 'Votre mot de passe doit faire au minimum 8 caractères';
                }
            } else {
                echo 'Votre email est trop long';
            }
        } else {
            echo 'Votre pseudo est trop long';
        }
    } else {
        echo 'Le compte existe déjà';
    }
} else {
    echo "Vous avez rempli aucun champ";
}
