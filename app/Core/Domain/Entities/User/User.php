<?php

namespace App\Core\Domain\Entities\User;

class User
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $phone;

    private ?int $avatarId;

    public function __construct(string $firstname, string $lastname, string $phone, ?int $avatarId){
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phone = $phone;
        $this->avatarId = $avatarId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }

    public function setAvatarId(?int $avatarId): void
    {
        $this->avatarId = $avatarId;
    }
}
