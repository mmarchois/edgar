<?php

declare(strict_types=1);

namespace App\Application\Shopping\Command;

use App\Domain\Shopping\Exception\ShoppingListNotFoundException;
use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;

final class DeleteShoppingListByUuidCommandHandler
{
    public function __construct(
        private readonly ShoppingListRepositoryInterface $shoppingListRepository,
    ) {
    }

    public function __invoke(DeleteShoppingListByUuidCommand $query): void
    {
        $shoppingList = $this->shoppingListRepository->findOneByUuidAndUser($query->uuid, $query->user);
        if (!$shoppingList instanceof ShoppingList) {
            throw new ShoppingListNotFoundException();
        }

        $this->shoppingListRepository->delete($shoppingList);
    }
}
