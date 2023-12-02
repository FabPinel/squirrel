<?php

class Comment
{
    private int $kd;
    private string $content;
    private DateTime $createdDate;
    private User $user;
    private Post $post;
    private Comment $comment;

    public function __construct(int $kd, string $content, DateTime $createdDate, User $user, Post $post, Comment $comment)
    {
        $this->kd = $kd;
        $this->content = $content;
        $this->createdDate = $createdDate;
        $this->user = $user;
        $this->post = $post;
        $this->comment = $comment;
    }

    public function getKd(): int
    {
        return $this->kd;
    }

    public function setKd(int $kd): void
    {
        $this->kd = $kd;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getCreatedDate(): DateTime
    {
        return $this->createdDate;
    }

    public function setCreatedDate(DateTime $createdDate): void
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

    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function setComment(Comment $comment): void
    {
        $this->comment = $comment;
    }
}
