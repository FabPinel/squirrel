<?php
require($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $nickname;
    private string $email;
    private string $picture;
    private string $banner;
    private string $bio;
    private string $role;
    private string $createdDate;
    private string $birthday;
    private bool $isVerified;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $nickname,
        string $email,
        string $picture,
        string $banner,
        string $bio,
        string $role,
        string $createdDate,
        string $birthday,
        bool $isVerified
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->nickname = $nickname;
        $this->email = $email;
        $this->picture = $picture;
        $this->banner = $banner;
        $this->bio = $bio;
        $this->role = $role;
        $this->createdDate = $createdDate;
        $this->birthday = $birthday;
        $this->isVerified = $isVerified;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    public function getBanner(): string
    {
        return $this->banner;
    }

    public function setBanner(string $banner): void
    {
        $this->banner = $banner;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function setCreatedDate(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): void
    {
        $this->isVerified = $isVerified;
    }

    //Récupération de l'utilisateur connecté, utilisation info navbar et pour savoir si visiteur ou non du profil
    public static function getSessionUser($bdd)
    {
        try {
            if (isset($_SESSION['user'])) {
                $affich_users = $bdd->prepare('SELECT * FROM users WHERE id = ?');
                $affich_users->execute(array($_SESSION['user']));
                $userSession = $affich_users->fetch(PDO::FETCH_ASSOC);

                if ($userSession) {
                    return new User(
                        $userSession['id'],
                        $userSession['firstName'],
                        $userSession['lastName'],
                        $userSession['nickname'],
                        $userSession['email'],
                        $userSession['picture'],
                        $userSession['banner'],
                        $userSession['bio'],
                        $userSession['role'],
                        $userSession['createdDate'],
                        $userSession['birthday'],
                        $userSession['isVerify']
                    );
                }
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des données : " . $e->getMessage();
        }

        return null;
    }

    //Récupération des informations de l'utilisateur, utilisation pour affichage profil
    public static function getUserById($userId)
    {
        global $bdd;

        $query = $bdd->prepare("SELECT * FROM users WHERE id = :userId");
        $query->execute(array('userId' => $userId));

        $userById = $query->fetch(PDO::FETCH_ASSOC);

        if ($userById) {
            return new User(
                $userById['id'],
                $userById['firstName'],
                $userById['lastName'],
                $userById['nickname'],
                $userById['email'],
                $userById['picture'],
                $userById['banner'],
                $userById['bio'],
                $userById['role'],
                $userById['createdDate'],
                $userById['birthday'],
                $userById['isVerify']
            );
        }

        return null;
    }

    public static function getAllUsers()
    {
        global $bdd;

        $query = $bdd->prepare("SELECT * FROM users");
        $query->execute();

        $users = [];

        while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $user['id'],
                $user['firstName'],
                $user['lastName'],
                $user['nickname'],
                $user['email'],
                $user['picture'],
                $user['banner'],
                $user['bio'],
                $user['role'],
                $user['createdDate'],
                $user['birthday'],
                $user['isVerify']
            );
        }

        return $users;
    }


    //Formater la date d'anniversaire
    public static function formatBirthday($birthday)
    {
        $date = new DateTime($birthday);
        $monthNames = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];

        $formattedDate = $date->format('d ') . $monthNames[$date->format('n') - 1] . $date->format(' Y');
        return ucfirst($formattedDate);
    }

    //Formater la date de création
    public static function formatCreatedDate($date)
    {
        $date = new DateTime($date);
        $monthNames = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];

        $formattedDate = $monthNames[$date->format('n') - 1] . $date->format(' Y');
        return ucfirst($formattedDate);
    }

    //Modification des informations de l'utilisateur, utilisation profil
    public static function editUser($idUser, $nickname, $bio, $birthday, $banner, $picture)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryEditUser = $bdd->prepare("UPDATE users SET nickname=:nickname, bio=:bio, birthday=:birthday, banner=:banner, picture=:picture WHERE id=:id ");

                if ($queryEditUser) {
                    $queryEditUser->execute(array('nickname' => $nickname, 'bio' => $bio, 'birthday' => $birthday, 'banner' => $banner, 'picture' => $picture, 'id' => $idUser));
                } else {
                    echo "Erreur de préparation de la requête.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    }

    //Vérifier si l'utilisateur suit le profil qu'il visite
    public static function getFollow($sessionUser, $userProfil)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryFollowUser = $bdd->prepare("SELECT * FROM followers WHERE user=:user AND follower=:follower");

                if ($queryFollowUser) {
                    $queryFollowUser->execute(array('user' => $sessionUser, 'follower' => $userProfil));

                    $isFollow = $queryFollowUser->rowCount() > 0;

                    return $isFollow;
                } else {
                    echo "Erreur de préparation de la requête.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors du follow de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }

        return false;
    }

    //Suivre un utilisateur
    public static function follow($sessionUser, $userProfil)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryFollowUser = $bdd->prepare("INSERT INTO followers (user, follower) VALUES (:user ,:follower)");

                if ($queryFollowUser) {
                    $queryFollowUser->execute(array('user' => $sessionUser, 'follower' => $userProfil));
                } else {
                    echo "Erreur de préparation de la requête.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors du follow de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    }

    // Désabonner un utilisateur
    public static function unfollow($sessionUser, $userProfil)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryUnfollowUser = $bdd->prepare("DELETE FROM followers WHERE user=:user AND follower=:follower");

                if ($queryUnfollowUser) {
                    $queryUnfollowUser->execute(array('user' => $sessionUser, 'follower' => $userProfil));
                } else {
                    echo "Erreur de préparation de la requête de désabonnement.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors du désabonnement de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    }

    // Gérer le suivi/désabonnement en fonction de l'état actuel
    public static function toggleFollow($sessionUser, $userProfil)
    {
        $isFollow = self::getFollow($sessionUser, $userProfil);

        if ($isFollow) {
            self::unfollow($sessionUser, $userProfil);
        } else {
            self::follow($sessionUser, $userProfil);
        }
    }

    //Vérifier si l'utilisateur est certifié
    public static function getCertif($idUser)
    {
        $user = self::getUserById($idUser);

        if ($user) {
            return $user->isVerified();
        }

        return false;
    }

    //Cerifier un utilisateur
    public static function certified($idUser)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryCertifwUser = $bdd->prepare("UPDATE users SET isVerify = true WHERE id=:user ");

                if ($queryCertifwUser) {
                    $queryCertifwUser->execute(array('user' => $idUser));
                } else {
                    echo "Erreur de préparation de la requête.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors de la certification de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    }

    // Désabonner un utilisateur
    public static function uncertified($idUser)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryUnCertifiedUser = $bdd->prepare("UPDATE users SET isVerify = false WHERE id=:user ");

                if ($queryUnCertifiedUser) {
                    $queryUnCertifiedUser->execute(array('user' => $idUser));
                } else {
                    echo "Erreur de préparation de la requête de désabonnement.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors de la dé certification de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    }

    // Gérer le suivi/désabonnement en fonction de l'état actuel
    public static function toggleCertified($idUser)
    {
        $isCertified = self::getCertif($idUser);

        if ($isCertified) {
            self::uncertified($idUser);
        } else {
            self::certified($idUser);
        }
    }

    //Vérifier si l'utilisateur est ban
    public static function getBan($idUser)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryBanUser = $bdd->prepare("SELECT * FROM bans WHERE user=:user");

                if ($queryBanUser) {
                    $queryBanUser->execute(array('user' => $idUser));

                    $isBanned = $queryBanUser->rowCount() > 0;

                    return $isBanned;
                } else {
                    echo "Erreur de préparation de la requête.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors du follow de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }

        return false;
    }

    //Suivre un utilisateur
    public static function ban($idUser, $sessionUser)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryBanUser = $bdd->prepare("INSERT INTO bans (user, bannedBy) VALUES (:user ,:sessionUser)");

                if ($queryBanUser) {
                    $queryBanUser->execute(array('user' => $idUser, 'sessionUser' => $sessionUser));
                } else {
                    echo "Erreur de préparation de la requête.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors du ban de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    }

    // Désabonner un utilisateur
    public static function unBan($sessionUser)
    {
        global $bdd;

        if ($bdd) {
            try {
                $queryUnfollowUser = $bdd->prepare("DELETE FROM bans WHERE user=:user");

                if ($queryUnfollowUser) {
                    $queryUnfollowUser->execute(array('user' => $sessionUser));
                } else {
                    echo "Erreur de préparation de la requête de désabonnement.";
                }
            } catch (PDOException $e) {
                echo "Erreur lors du unban de l'utilisateur : " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    }

    // Gérer le suivi/désabonnement en fonction de l'état actuel
    public static function toggleBan($sessionUser, $idUser)
    {
        $isBanned = self::getBan($idUser);

        if ($isBanned) {
            self::unBan($idUser);
        } else {
            self::ban($idUser, $sessionUser);
        }
    }

    //Compter les comptes suivi par l'utilisateur, utilisation profil
    public static function countFollowByUserId($id)
    {
        global $bdd;
        $queryCountFollow = $bdd->prepare("SELECT COUNT(*) as total FROM followers WHERE user=:idUser");
        $queryCountFollow->execute(array('idUser' => $id));

        $result = $queryCountFollow->fetch();

        if ($result) {
            $totalLikes = $result['total'];
            return $totalLikes;
        } else {
            return 0;
        }
    }

    //Compter les compte qui suivent l'utilisateur, utilisation profil
    public static function countFollowersByUserId($id)
    {
        global $bdd;
        $queryCountFollowers = $bdd->prepare("SELECT COUNT(*) as total FROM followers WHERE follower=:idUser");
        $queryCountFollowers->execute(array('idUser' => $id));

        $result = $queryCountFollowers->fetch();

        if ($result) {
            $totalLikes = $result['total'];
            return $totalLikes;
        } else {
            return 0;
        }
    }

    public static function isFollower($sessionUser, $idUser)
    {
        global $bdd;
        $queryCountFollowers = $bdd->prepare("SELECT * FROM followers WHERE user=:idUser AND follower=:sessionUser");
        $queryCountFollowers->execute(array('sessionUser' => $sessionUser, 'idUser' => $idUser));

        $result = $queryCountFollowers->fetch();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    //Avoir des suggestion de 3 utilisateurs
    public static function getSuggestUsers($userId)
    {
        global $bdd;
        $limit = 3;

        $query = $bdd->prepare("SELECT * FROM users WHERE id <> :userId ORDER BY RAND()");
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        $users = [];

        while ($user = $query->fetch(PDO::FETCH_ASSOC)) {
            $userObj = new User(
                $user['id'],
                $user['firstName'],
                $user['lastName'],
                $user['nickname'],
                $user['email'],
                $user['picture'],
                $user['banner'],
                $user['bio'],
                $user['role'],
                $user['createdDate'],
                $user['birthday'],
                $user['isVerify']
            );

            // Vérifier si l'utilisateur connecté suit déjà ce compte
            $isFollowing = self::getFollow($userId, $user['id']);

            // Ajouter l'utilisateur à la liste seulement s'il n'est pas déjà suivi
            if (!$isFollowing) {
                $users[] = $userObj;
            }

            // Si nous avons déjà atteint la limite de 3 utilisateurs, sortir de la boucle
            if (count($users) >= $limit) {
                break;
            }
        }

        return $users;
    }
}
