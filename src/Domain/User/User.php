<?php

declare(strict_types=1);

namespace App\Domain\User;

class User
{
    private iterable $shoppingLists = [];

    public function __construct(
        private string $uuid,
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getShoppingLists(): iterable
    {
        return $this->shoppingLists;
    }
}
