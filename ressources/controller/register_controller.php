<?php
//connection à la bdd
require_once('C:\wamp64\www\g4arena\configbdd.php');
$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['tel']) && !empty($_POST['password'])) {


    // patch xss (sécurité)
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['tel']);
    $password = htmlspecialchars($_POST['password']);

    // vérification si l'utilisateur existe déjà pour éviter les doublons
    $check = $bdd->prepare('SELECT name, email, telephone, password FROM users WHERE email=?');
    $check->execute(array($email));
    $verif_user = $check->fetch();
    $row =  $check->rowCount();

    // Tous les caractères majuscules seront transformés en minuscules pour éviter les majuscules dans les mails.
    $email = strtolower($email);

    // si la vérification ($check) renvoie aucune ligne (0) alors l'utilisateur n'existe pas,
    // alors nous pouvont l'insérer dans la base de données (dans la requête ci-dessous)

    if ($row == 0) { //si il y a 0 lignes (en gros que l'utilisateur n'existe pas)

        if (strlen($name) <= 50) { // on vérifie que le pseudo ait maximum 50 caractères

            if (strlen($email) <= 100) { //on vérifie que l'email soit de maximum 100 caractères

                if (strlen($telephone) == 10) { // on vérifie que le numéro de téléphone fasse 10 caractères

                    if (strlen($password) >= 8) {

                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {  //on vérifie que l'email ait la bonne forme

                            // if (isset($_FILES)) {
                            //     $img_name = $_FILES['img']['name'];
                            //     $extension_file = strrchr($img_name, ".");
                            //     $img_tmp_name = $_FILES['img']['tmp_name'];
                            //     $autorized_extensions = array('.jpeg', '.gif', '.png', '.jpg');
                            //     $dossier_img = 'ressources/img/' . $img_name;
                            //     if (in_array($extension_file, $autorized_extensions)) {
                            //         if (move_uploaded_file($img_tmp_name, $dossier_img));

                            // hashes du mot de passe par Bcrypt
                            $password = password_hash($password, PASSWORD_BCRYPT);

                            $insert_db = $bdd->prepare('INSERT INTO users(name, email, telephone, password) VALUES(:name, :email, :telephone, :password)');
                            $insert_db->execute(array(
                                'name' => $name,
                                'email' => $email,
                                'telephone' => $telephone,
                                'password' => $password,
                                // 'img_name' => $img_name,
                                // 'img_url' => $dossier_img
                            ));
                            header('Location:login.php');
                            //     }
                            // } else {
                            //     echo 'Les extensions de fichier autorisés sont .jpeg, .gif, .png, .jgp';
                            // }
                        } else {
                            echo "L'email n'est pas valide";
                        }
                    } else {
                        echo 'Votre mot de passe doit faire au minimum 8 caractères';
                    }
                } else {
                    echo "L'âge requis est de 12 ans minimum";
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
    echo "Vous n'avez rempli aucun champ";
}
