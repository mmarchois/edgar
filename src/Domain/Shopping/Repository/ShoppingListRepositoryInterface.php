<?php

declare(strict_types=1);

namespace App\Domain\Shopping\Repository;

use App\Domain\Shopping\ShoppingList;

interface ShoppingListRepositoryInterface
{
    public function save(ShoppingList $shoppingList): ShoppingList;
}
