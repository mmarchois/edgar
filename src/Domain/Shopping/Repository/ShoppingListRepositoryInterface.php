<?php

declare(strict_types=1);

namespace App\Domain\Shopping\Repository;

use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;

interface ShoppingListRepositoryInterface
{
    public function save(ShoppingList $shoppingList): ShoppingList;

    public function findByUser(User $user): array;
}
