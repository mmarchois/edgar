<?php

declare(strict_types=1);

namespace App\Domain\Shopping;

use App\Domain\Card\Card;
use App\Domain\User\Group;
use App\Domain\User\User;

final class ShoppingList
{
    public function __construct(
        private string $uuid,
        private string $name,
        private User $user,
        private ?Group $group = null,
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

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
