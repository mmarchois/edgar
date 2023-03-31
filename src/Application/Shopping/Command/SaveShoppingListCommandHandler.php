<?php

declare(strict_types=1);

namespace App\Application\Shopping\Command;

use App\Application\IdFactoryInterface;
use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;

final class SaveShoppingListCommandHandler
{
    public function __construct(
        private readonly IdFactoryInterface $idFactory,
        private readonly ShoppingListRepositoryInterface $shoppingListRepository,
    ) {
    }

    public function __invoke(SaveShoppingListCommand $saveShoppingListCommand): string
    {
        $shoppingList = $this->shoppingListRepository->save(
            new ShoppingList(
                uuid: $this->idFactory->make(),
                name: trim($saveShoppingListCommand->name),
                user: $saveShoppingListCommand->user,
            ),
        );

        return $shoppingList->getUuid();
    }
}
