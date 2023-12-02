<?php

class UserBanned extends User
{
    private int $id;
    private User $user;
    private string $message;
    private DateTime $createdDate;
    private User $bannedBy;

    public function __construct(int $id, User $user, string $message, DateTime $createdDate, User $bannedBy)
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

    public function getCreatedDateBan(): DateTime
    {
        return $this->createdDate;
    }

    public function setCreatedDateBan(DateTime $createdDate): void
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
}
