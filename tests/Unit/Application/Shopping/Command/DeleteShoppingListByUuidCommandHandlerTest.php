<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Shopping\Command;

use App\Application\Shopping\Command\DeleteShoppingListByUuidCommand;
use App\Application\Shopping\Command\DeleteShoppingListByUuidCommandHandler;
use App\Domain\Shopping\Exception\ShoppingListNotFoundException;
use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class DeleteShoppingListByUuidCommandHandlerTest extends TestCase
{
    private $shoppingListRepository;

    public function setUp(): void
    {
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
    }

    public function testDelete(): void
    {
        $user = $this->createMock(User::class);
        $shoppingList = $this->createMock(ShoppingList::class);

        $this->shoppingListRepository
            ->expects(self::once())
            ->method('findOneByUuidAndUser')
            ->willReturn($shoppingList);

        $this->shoppingListRepository
            ->expects(self::once())
            ->method('delete')
            ->with($shoppingList);

        $handler = new DeleteShoppingListByUuidCommandHandler(
            $this->shoppingListRepository,
        );

        $command = new DeleteShoppingListByUuidCommand('ff143a4c-3994-4e7a-8d95-60904211dc73', $user);
        $handler($command);
    }

    public function testShoppingListNotFound(): void
    {
        $this->expectException(ShoppingListNotFoundException::class);
        $user = $this->createMock(User::class);

        $this->shoppingListRepository
            ->expects(self::once())
            ->method('findOneByUuidAndUser')
            ->willReturn(null);

        $this->shoppingListRepository
            ->expects(self::never())
            ->method('delete');

        $handler = new DeleteShoppingListByUuidCommandHandler(
            $this->shoppingListRepository,
        );

        $command = new DeleteShoppingListByUuidCommand('ff143a4c-3994-4e7a-8d95-60904211dc73', $user);
        $handler($command);
    }
}
