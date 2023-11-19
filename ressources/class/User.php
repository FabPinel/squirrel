<?php

class User
{
    private int $id;
    private string $nickname;
    private string $lastName;
    private string $firstName;
    private string $email;
    private string $birthday;
    private string $picture;
    private string $bio;
    private string $role;
    private string $createdDate;
    private bool $isVerified;

    public function __construct(
        int $id,
        string $nickname,
        string $lastName,
        string $firstName,
        string $email,
        string $birthday,
        string $picture,
        string $bio,
        string $role,
        string $createdDate,
        bool $isVerified
    ) {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->picture = $picture;
        $this->bio = $bio;
        $this->role = $role;
        $this->createdDate = $createdDate;
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

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): void
    {
        $this->isVerified = $isVerified;
    }
}
