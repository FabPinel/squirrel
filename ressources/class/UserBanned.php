<?php
require_once('../Class/User.php');
class UserBanned extends User
{
    private int $id;
    private User $user;
    private string $message;
    private string $createdDate;
    private User $bannedBy;

    public function __construct(int $id, User $user, string $message, string $createdDate, User $bannedBy)
    {
        $this->id = $id;
        $this->user = $user;
        $this->message = $message;
        $this->createdDate = $createdDate;
        $this->bannedBy = $bannedBy;
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

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getCreatedDateBan(): string
    {
        return $this->createdDate;
    }

    public function setCreatedDateBan(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getBannedBy(): User
    {
        return $this->bannedBy;
    }

    public function setBannedBy(User $bannedBy): void
    {
        $this->bannedBy = $bannedBy;
    }

    public static function getAllUsersBanned($bdd)
    {
        $queryUsersBanned = $bdd->prepare("SELECT b.*,
            u.nickname as user_nickname, 
            u.id as user_id, 
            u.lastName as user_lastName, 
            u.firstName as user_firstName, 
            u.email as user_email, 
            u.role as user_role, 
            u.banner as user_banner, 
            u.picture as user_picture, 
            u.bio as user_bio, 
            u.createdDate as user_createdDate, 
            u.birthday as user_birthday, 
            u.isVerify as user_isVerify,
            bannedByUser.nickname as bannedBy_nickname,
            bannedByUser.id as bannedBy_id,
            bannedByUser.lastName as bannedBy_lastName,
            bannedByUser.firstName as bannedBy_firstName,
            bannedByUser.email as bannedBy_email,
            bannedByUser.role as bannedBy_role,
            bannedByUser.banner as bannedBy_banner,
            bannedByUser.picture as bannedBy_picture,
            bannedByUser.bio as bannedBy_bio,
            bannedByUser.createdDate as bannedBy_createdDate,
            bannedByUser.birthday as bannedBy_birthday,
            bannedByUser.isVerify as bannedBy_isVerify
            FROM bans b
            JOIN users u ON b.user = u.id
            JOIN users bannedByUser ON b.bannedBy = bannedByUser.id");
        $queryUsersBanned->execute();

        $banned = [];

        while ($row = $queryUsersBanned->fetch(PDO::FETCH_ASSOC)) {
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

            $bannedByUser = new User(
                $row['bannedBy_id'],
                $row['bannedBy_firstName'],
                $row['bannedBy_lastName'],
                $row['bannedBy_nickname'],
                $row['bannedBy_email'],
                $row['bannedBy_picture'],
                $row['bannedBy_banner'],
                $row['bannedBy_bio'],
                $row['bannedBy_role'],
                $row['bannedBy_createdDate'],
                $row['bannedBy_birthday'],
                $row['bannedBy_isVerify']
            );

            $banned[] = new UserBanned(
                $row['id'],
                $user,
                $row['msg'],
                $row['createdDate'],
                $bannedByUser
            );
        }

        return $banned;
    }
}
