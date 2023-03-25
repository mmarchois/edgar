<?php

declare(strict_types=1);

namespace App\Domain\Shopping;

use App\Domain\User\Group;

class ShoppingList
{
    public function __construct(
        private string $uuid,
        private string $name,
        private Group $group,
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

    public function getGroup(): Group
    {
        return $this->group;
    }
}
