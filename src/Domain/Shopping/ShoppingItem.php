<?php

declare(strict_types=1);

namespace App\Domain\Shopping;

use App\Domain\User\User;

final class ShoppingItem
{
    public function __construct(
        private string $uuid,
        private ShoppingList $shoppingList,
        private ShoppingCategory $shoppingCategory,
        private User $user,
        private string $name,
        private int $quantity,
        private bool $bought,
        private ?string $comment,
        private ?string $unit,
        private ?int $price,
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

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getComent(): ?string
    {
        return $this->comment;
    }

    public function isBought(): bool
    {
        return $this->bought;
    }

    public function getShoppingList(): ShoppingList
    {
        return $this->shoppingList;
    }

    public function getShoppingCategory(): ShoppingCategory
    {
        return $this->shoppingCategory;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
