<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Shopping\Query;

use App\Application\Shopping\Query\GetUserShoppingListsQuery;
use App\Application\Shopping\Query\GetUserShoppingListsQueryHandler;
use App\Application\Shopping\View\ShoppingListView;
use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class GetUserShoppingListsQueryHandlerTest extends TestCase
{
    private $shoppingListRepository;

    public function setUp(): void
    {
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
    }

    public function testGetShoppingLists(): void
    {
        $user = $this->createMock(User::class);
        $shoppingList = $this->createMock(ShoppingList::class);
        $shoppingList
            ->expects(self::once())
            ->method('getUuid')
            ->willReturn('ff143a4c-3994-4e7a-8d95-60904211dc73');
        $shoppingList
            ->expects(self::once())
            ->method('getName')
            ->willReturn('Leclerc Saint-Ouen');

        $shoppingList2 = $this->createMock(ShoppingList::class);
        $shoppingList2
            ->expects(self::once())
            ->method('getUuid')
            ->willReturn('327e6f53-693e-4646-af9b-4ea10e512232');
        $shoppingList2
            ->expects(self::once())
            ->method('getName')
            ->willReturn('Leclerc Aix');

        $this->shoppingListRepository
            ->expects(self::once())
            ->method('findByUser')
            ->with($user)
            ->willReturn([$shoppingList, $shoppingList2]);

        $handler = new GetUserShoppingListsQueryHandler(
            $this->shoppingListRepository,
        );

        $query = new GetUserShoppingListsQuery($user);
        $result = $handler($query);
        $expectedResult = [
            new ShoppingListView(
                'ff143a4c-3994-4e7a-8d95-60904211dc73',
                'Leclerc Saint-Ouen'
            ),
            new ShoppingListView(
                '327e6f53-693e-4646-af9b-4ea10e512232',
                'Leclerc Aix',
            ),
        ];

        $this->assertEquals($expectedResult, $result);
    }
}
