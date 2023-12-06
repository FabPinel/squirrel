<?php
require($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
require_once('User.php');
class Follow
{
    private int $id;
    private User $user;
    private User $follower;

    public function __construct(int $id, User $user, User $follower)
    {
        $this->id = $id;
        $this->user = $user;
        $this->follower = $follower;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getFollower(): User
    {
        return $this->follower;
    }

    public function setFollower(User $follower): void
    {
        $this->follower = $follower;
    }

    public static function getAllFollowers($idUser)
    {
        global $bdd;

        $queryAllFollowers = $bdd->prepare("SELECT f.*, 
            u1.nickname as user_nickname, 
            u1.id as user_id, 
            u1.lastName as user_lastName, 
            u1.firstName as user_firstName,
            u1.email as user_email, 
            u1.role as user_role, 
            u1.picture as user_picture, 
            u1.banner as user_banner, 
            u1.bio as user_bio, 
            u1.createdDate as user_createdDate, 
            u1.birthday as user_birthday, 
            u1.isVerify as user_isVerify,
            u2.nickname as follower_nickname, 
            u2.id as follower_id, 
            u2.lastName as follower_lastName, 
            u2.firstName as follower_firstName,
            u2.email as follower_email, 
            u2.role as follower_role, 
            u2.picture as follower_picture, 
            u2.banner as follower_banner, 
            u2.bio as follower_bio, 
            u2.createdDate as follower_createdDate, 
            u2.birthday as follower_birthday, 
            u2.isVerify as follower_isVerify
            FROM followers f 
            JOIN users u1 ON f.user = u1.id
            JOIN users u2 ON f.follower = u2.id
            WHERE f.follower = :user");
        $queryAllFollowers->execute(array('user' => $idUser));

        $follows = [];

        while ($row = $queryAllFollowers->fetch(PDO::FETCH_ASSOC)) {
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

            $follower = new User(
                $row['follower_id'],
                $row['follower_firstName'],
                $row['follower_lastName'],
                $row['follower_nickname'],
                $row['follower_email'],
                $row['follower_picture'],
                $row['follower_banner'],
                $row['follower_bio'],
                $row['follower_role'],
                $row['follower_createdDate'],
                $row['follower_birthday'],
                $row['follower_isVerify']
            );

            $follows[] = new Follow(
                $row['id'],
                $user,
                $follower
            );
        }

        return $follows;
    }
    public static function getAllFollows($idUser)
    {
        global $bdd;

        $queryAllFollows = $bdd->prepare("SELECT f.*, 
            u1.nickname as user_nickname, 
            u1.id as user_id, 
            u1.lastName as user_lastName, 
            u1.firstName as user_firstName,
            u1.email as user_email, 
            u1.role as user_role, 
            u1.picture as user_picture, 
            u1.banner as user_banner, 
            u1.bio as user_bio, 
            u1.createdDate as user_createdDate, 
            u1.birthday as user_birthday, 
            u1.isVerify as user_isVerify,
            u2.nickname as follower_nickname, 
            u2.id as follower_id, 
            u2.lastName as follower_lastName, 
            u2.firstName as follower_firstName,
            u2.email as follower_email, 
            u2.role as follower_role, 
            u2.picture as follower_picture, 
            u2.banner as follower_banner, 
            u2.bio as follower_bio, 
            u2.createdDate as follower_createdDate, 
            u2.birthday as follower_birthday, 
            u2.isVerify as follower_isVerify
            FROM followers f 
            JOIN users u2 ON f.user = u2.id
            JOIN users u1 ON f.follower = u1.id
            WHERE f.user = :user");
        $queryAllFollows->execute(array('user' => $idUser));

        $follows = [];

        while ($row = $queryAllFollows->fetch(PDO::FETCH_ASSOC)) {
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

            $follower = new User(
                $row['follower_id'],
                $row['follower_firstName'],
                $row['follower_lastName'],
                $row['follower_nickname'],
                $row['follower_email'],
                $row['follower_picture'],
                $row['follower_banner'],
                $row['follower_bio'],
                $row['follower_role'],
                $row['follower_createdDate'],
                $row['follower_birthday'],
                $row['follower_isVerify']
            );

            $follows[] = new Follow(
                $row['id'],
                $user,
                $follower
            );
        }

        return $follows;
    }
}
