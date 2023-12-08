<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/configbdd.php');
require_once('Post.php');
class Comment
{
    private int $id;
    private string $content;
    private string $createdDate;
    private User $user;
    private Post $post;

    public function __construct(int $id, string $content, string $createdDate, User $user, Post $post)
    {
        $this->id = $id;
        $this->content = $content;
        $this->createdDate = $createdDate;
        $this->user = $user;
        $this->post = $post;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedDate(): string
    {
        return $this->createdDate;
    }

    public function setCreatedDate(string $createdDate): void
    {
        $this->createdDate = $createdDate;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    public static function getCommentsByPostId($postId)
    {
        global $bdd;

        $query = $bdd->prepare("SELECT c.*, 
                                u.nickname as user_nickname, 
                                u.id as user_id, 
                                u.lastName as user_lastName, 
                                u.firstName as user_firstName, 
                                u.email as user_email, 
                                u.role as user_role, 
                                u.picture as user_picture, 
                                u.banner as user_banner, 
                                u.bio as user_bio, 
                                u.createdDate as user_createdDate, 
                                u.birthday as user_birthday, 
                                u.isVerify as user_isVerify,
                                p.id as post_id,
                                p.texte as post_texte,
                                p.media as post_media,
                                p.createdDate as post_createdDate
                                FROM comments c
                                JOIN users u ON c.user = u.id
                                JOIN posts p ON c.post = p.id
                                WHERE c.post = :postId
                                ORDER BY c.createdDate DESC");

        $query->execute(array('postId' => $postId));

        $comments = [];

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
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

            $post = new Post(
                $row['post_id'],
                $row['post_texte'],
                $row['post_media'],
                $user,
                $row['post_createdDate']
            );

            $comment = new Comment(
                $row['id'],
                $row['content'],
                $row['createdDate'],
                $user,
                $post
            );

            $comments[] = $comment;
        }

        return $comments;
    }

    public static function createComment($content, $idUser, $idPost)
    {
        global $bdd;
        $queryComment = $bdd->prepare("INSERT INTO comments (content, user, post) VALUES (:content, :idUser, :idPost)");
        $queryComment->execute(array('content' => $content, 'idUser' => $idUser, 'idPost' => $idPost));
    }

    public static function deleteComment($idComment)
    {
        global $bdd;
        $queryComment = $bdd->prepare("DELETE FROM comments WHERE id =:idComment");
        $queryComment->execute(array('idComment' => $idComment));
    }
}
