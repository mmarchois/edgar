<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Shopping;

use App\Application\QueryBusInterface;
use App\Application\Shopping\Query\GetShoppingListByUuidQuery;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

abstract class AbstractShoppingListController
{
    public function __construct(
        protected QueryBusInterface $queryBus,
    ) {
    }

    protected function getShoppingList(string $uuid, User $user): ShoppingList
    {
        if (!Uuid::isValid($uuid)) {
            throw new BadRequestHttpException();
        }

        $shoppingList = $this->queryBus->handle(new GetShoppingListByUuidQuery($uuid, $user));

        if (!$shoppingList instanceof ShoppingList) {
            throw new NotFoundHttpException();
        }

        return $shoppingList;
    }
}
