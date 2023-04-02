<?php

declare(strict_types=1);

namespace App\Domain\Card;

use App\Domain\User\User;

final class Card
{
    public function __construct(
        private string $uuid,
        private string $name,
        private string $code,
        private User $owner,
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

    public function getOwner(): User
    {
        return $this->owner;
    }
}
