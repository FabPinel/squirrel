<?php
require($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
require('User.php');
class Post
{
    private int $id;
    private string $texte;
    private string $media;
    private User $user;
    private DateTime $createdDate;

    public function __construct(int $id, string $texte, string $media, User $user, DateTime $createdDate)
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

    public function getCreatedDate(): DateTime
    {
        return $this->createdDate;
    }

    public function setCreatedDate(DateTime $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    //Compter les postes de l'utilisateur, utilisation profil
    public static function countPostByUserId($id)
    {
        global $bdd;
        $queryCards = $bdd->prepare("SELECT COUNT(*) as total FROM posts WHERE user=:idUser");
        $queryCards->execute(array('idUser' => $id));

        $result = $queryCards->fetch();

        if ($result) {
            $totalLikes = $result['total'];
            return $totalLikes;
        } else {
            return 0;
        }
    }

    //Compter les comptes suivi par l'utilisateur, utilisation profil
    public static function countFollowByUserId($id)
    {
        global $bdd;
        $queryCards = $bdd->prepare("SELECT COUNT(*) as total FROM followers WHERE user=:idUser");
        $queryCards->execute(array('idUser' => $id));

        $result = $queryCards->fetch();

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
        $queryCards = $bdd->prepare("SELECT COUNT(*) as total FROM followers WHERE follower=:idUser");
        $queryCards->execute(array('idUser' => $id));

        $result = $queryCards->fetch();

        if ($result) {
            $totalLikes = $result['total'];
            return $totalLikes;
        } else {
            return 0;
        }
    }
}
