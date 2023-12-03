<?php
require($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
require('User.php');
class Post
{
    private int $id;
    private string $texte;
    private string $media;
    private User $user;
    private string $createdDate;

    public function __construct(int $id, string $texte, string $media, User $user, string $createdDate)
    {
        $this->id = $id;
        $this->texte = $texte;
        $this->media = $media;
        $this->user = $user;
        $this->createdDate = $createdDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTexte(): string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): void
    {
        $this->texte = $texte;
    }

    public function getMedia(): string
    {
        return $this->media;
    }

    public function setMedia(string $media): void
    {
        $this->media = $media;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function setCreatedDate(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    //Compter les postes de l'utilisateur, utilisation profil
    public static function countPostByUserId($id)
    {
        global $bdd;
        $queryCountPosts = $bdd->prepare("SELECT COUNT(*) as total FROM posts WHERE user=:idUser");
        $queryCountPosts->execute(array('idUser' => $id));

        $result = $queryCountPosts->fetch();

        if ($result) {
            $totalLikes = $result['total'];
            return $totalLikes;
        } else {
            return 0;
        }
    }

    //Récupérer tous les post
    public static function getAllPosts()
    {
        global $bdd;

        $queryCards = $bdd->prepare("SELECT p.*, u.nickname as user_nickname, u.id as user_id, u.lastName as user_lastName, u.firstName as user_firstName, u.email as user_email, u.role as user_role, u.picture as user_picture, u.banner as user_banner, u.bio as user_bio, u.createdDate as user_createdDate, u.birthday as user_birthday, u.isVerify as user_isVerify FROM posts p
        JOIN users u ON p.user = u.id ORDER BY p.createdDate DESC");
        $queryCards->execute();

        $posts = [];

        while ($row = $queryCards->fetch(PDO::FETCH_ASSOC)) {
            $user = new User(
                $row['user_id'],
                $row['user_firstName'],
                $row['user_lastName'],
                $row['user_nickname'],
                $row['user_email'],
                $row['user_picture'],
                $row['user_banner'],
                $row['user_bio'],
                $row['user_role'],
                $row['user_createdDate'],
                $row['user_birthday'],
                $row['user_isVerify']
            );

            $posts[] = new Post(
                $row['id'],
                $row['texte'],
                $row['media'],
                $user,
                $row['createdDate']
            );
        }

        return $posts;
    }

    //Récupérer tous les post
    public static function getAllPostsByUserId($idUser)
    {
        global $bdd;

        $queryCards = $bdd->prepare("SELECT p.*, u.nickname as user_nickname, u.id as user_id, u.lastName as user_lastName, u.firstName as user_firstName, u.email as user_email, u.role as user_role, u.picture as user_picture, u.banner as user_banner, u.bio as user_bio, u.createdDate as user_createdDate, u.birthday as user_birthday, u.isVerify as user_isVerify FROM posts p
            JOIN users u ON p.user = u.id WHERE p.user=:idUser ORDER BY p.createdDate DESC");
        $queryCards->execute(array('idUser' => $idUser));

        $posts = [];

        while ($row = $queryCards->fetch(PDO::FETCH_ASSOC)) {
            $user = new User(
                $row['user_id'],
                $row['user_firstName'],
                $row['user_lastName'],
                $row['user_nickname'],
                $row['user_email'],
                $row['user_picture'],
                $row['user_banner'],
                $row['user_bio'],
                $row['user_role'],
                $row['user_createdDate'],
                $row['user_birthday'],
                $row['user_isVerify']
            );

            $posts[] = new Post(
                $row['id'],
                $row['texte'],
                $row['media'],
                $user,
                $row['createdDate']
            );
        }

        return $posts;
    }

    //Calculer la durée du post, après 23H affichage de la date
    public static function getTimeElapsedString($createdDate)
    {
        $createdTimestamp = strtotime($createdDate);
        $currentTime = time();
        $timeDifference = $currentTime - $createdTimestamp;

        if ($timeDifference < 3600) { // moins d'une heure affichage des minutes
            $elapsedTime = round($timeDifference / 60);
            return "$elapsedTime min";
        } else {
            $elapsedTime = round($timeDifference / 3600); // moins d'un jour affichage des heures
            if ($elapsedTime <= 23) {
                return "$elapsedTime h";
            } else {
                return date('j M', $createdTimestamp); // plus d'un jour affichage de la date
            }
        }
    }
}
