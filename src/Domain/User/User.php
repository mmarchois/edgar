<?php

declare(strict_types=1);

namespace App\Domain\User;

class User
{
    private iterable $groups = [];

    public function __construct(
        private string $uuid,
        private string $pseudo,
        private string $email,
        private string $password,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getGroups(): iterable
    {
        return $this->groups;
    }
}
