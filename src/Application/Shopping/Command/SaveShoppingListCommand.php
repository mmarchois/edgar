<?php

declare(strict_types=1);

namespace App\Application\Shopping\Command;

use App\Application\CommandInterface;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;

final class SaveShoppingListCommand implements CommandInterface
{
    public function __construct(
        public readonly User $owner,
        public readonly ?ShoppingList $shoppingList,
    ) {
        $this->name = $shoppingList?->getName();
    }

    public ?string $name;
}
