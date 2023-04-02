<?php

declare(strict_types=1);

namespace App\Application\Shopping\Query;

use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;

final class GetShoppingListByUuidQueryHandler
{
    public function __construct(
        private readonly ShoppingListRepositoryInterface $shoppingListRepository,
    ) {
    }

    public function __invoke(GetShoppingListByUuidQuery $query): ?ShoppingList
    {
        return $this->shoppingListRepository->findOneByUuidAndUser($query->uuid, $query->user);
    }
}
