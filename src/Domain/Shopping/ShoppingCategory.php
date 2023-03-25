<?php

declare(strict_types=1);

namespace App\Domain\Shopping;

class ShoppingCategory
{
    public function __construct(
        private string $uuid,
        private string $name,
        private int $position,
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

    public function getPosition(): int
    {
        return $this->position;
    }
}
