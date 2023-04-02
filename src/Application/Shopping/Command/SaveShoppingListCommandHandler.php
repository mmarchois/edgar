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

    public function __invoke(SaveShoppingListCommand $command): string
    {
        $name = trim($command->name);

        if ($command->shoppingList instanceof ShoppingList) {
            $command->shoppingList->updateName($name);

            return $command->shoppingList->getUuid();
        }

        $shoppingList = $this->shoppingListRepository->add(
            new ShoppingList(
                uuid: $this->idFactory->make(),
                name: $name,
                owner: $command->owner,
            ),
        );
        $shoppingList->addUser($command->owner);

        return $shoppingList->getUuid();
    }
}
