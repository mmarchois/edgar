<?php

declare(strict_types=1);

namespace App\Domain\Card;

use App\Domain\User\User;

final class Card
{
    private iterable $groups = [];

    public function __construct(
        private string $uuid,
        private string $name,
        private string $code,
        private User $user,
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getGroups(): iterable
    {
        return $this->groups;
    }
}
