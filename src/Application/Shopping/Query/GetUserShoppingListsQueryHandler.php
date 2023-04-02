<?php

declare(strict_types=1);

namespace App\Application\Shopping\Query;

use App\Application\Shopping\View\ShoppingListView;
use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;

final class GetUserShoppingListsQueryHandler
{
    public function __construct(
        private readonly ShoppingListRepositoryInterface $shoppingListRepository,
    ) {
    }

    public function __invoke(GetUserShoppingListsQuery $query): array
    {
        $views = [];
        $shoppingLists = $this->shoppingListRepository->findByUser($query->user);

        foreach ($shoppingLists as $shoppingList) {
            $views[] = new ShoppingListView(
                uuid: $shoppingList->getUuid(),
                name: $shoppingList->getName(),
            );
        }

        return $views;
    }
}
