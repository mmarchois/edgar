<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Shopping\Query;

use App\Application\Shopping\Query\GetShoppingListByUuidQuery;
use App\Application\Shopping\Query\GetShoppingListByUuidQueryHandler;
use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class GetShoppingListByUuidQueryHandlerTest extends TestCase
{
    private $shoppingListRepository;

    public function setUp(): void
    {
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
    }

    public function testGetShoppingList(): void
    {
        $user = $this->createMock(User::class);
        $shoppingList = $this->createMock(ShoppingList::class);

        $this->shoppingListRepository
            ->expects(self::once())
            ->method('findOneByUuidAndUser')
            ->with('ff143a4c-3994-4e7a-8d95-60904211dc73', $user)
            ->willReturn($shoppingList);

        $handler = new GetShoppingListByUuidQueryHandler(
            $this->shoppingListRepository,
        );

        $query = new GetShoppingListByUuidQuery('ff143a4c-3994-4e7a-8d95-60904211dc73', $user);
        $result = $handler($query);

        $this->assertEquals($shoppingList, $result);
    }
}
