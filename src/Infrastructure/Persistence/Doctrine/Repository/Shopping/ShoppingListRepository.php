<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Shopping;

use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ShoppingListRepository extends ServiceEntityRepository implements ShoppingListRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingList::class);
    }

    public function save(ShoppingList $shoppingList): ShoppingList
    {
        $this->getEntityManager()->persist($shoppingList);

        return $shoppingList;
    }
}
