<?php
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
}
