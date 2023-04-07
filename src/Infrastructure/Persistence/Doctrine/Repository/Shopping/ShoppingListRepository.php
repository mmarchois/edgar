<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Shopping;

use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ShoppingListRepository extends ServiceEntityRepository implements ShoppingListRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShoppingList::class);
    }

    public function add(ShoppingList $shoppingList): ShoppingList
    {
        $this->getEntityManager()->persist($shoppingList);

        return $shoppingList;
    }

    public function findOneByUuidAndUser(string $uuid, User $user): ?ShoppingList
    {
        return $this->createQueryBuilder('s')
            ->where('s.uuid = :uuid')
            ->innerJoin('s.users', 'u', 'WITH', 'u.uuid = :userUuid')
            ->setParameters([
                'userUuid' => $user->getUuid(),
                'uuid' => $uuid,
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.owner', 'o')
            ->innerJoin('s.users', 'u', 'WITH', 'u.uuid = :uuid')
            ->setParameter('uuid', $user->getUuid())
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
