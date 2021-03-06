<?php

declare(strict_types=1);

namespace App\Domain\Shopping;

use App\Domain\Card\Card;
use App\Domain\User\User;

final class ShoppingList
{
    private iterable $users = [];

    public function __construct(
        private string $uuid,
        private string $name,
        private User $owner,
        private ?Card $card = null,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getUsers(): iterable
    {
        return $this->users;
    }

    public function addUser(User $user): void
    {
        $this->users[] = $user;
    }

    public function updateName(string $name): void
    {
        $this->name = $name;
    }
}
