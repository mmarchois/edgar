<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Shopping\Command;

use App\Application\IdFactoryInterface;
use App\Application\Shopping\Command\SaveShoppingListCommand;
use App\Application\Shopping\Command\SaveShoppingListCommandHandler;
use App\Domain\Shopping\Repository\ShoppingListRepositoryInterface;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class SaveShoppingListCommandHandlerTest extends TestCase
{
    private $idFactory;
    private $shoppingListRepository;

    public function setUp(): void
    {
        $this->idFactory = $this->createMock(IdFactoryInterface::class);
        $this->shoppingListRepository = $this->createMock(ShoppingListRepositoryInterface::class);
    }

    public function testSuccessfullyCreated(): void
    {
        $user = $this->createMock(User::class);
        $createdShoppingList = $this->createMock(ShoppingList::class);
        $createdShoppingList
            ->expects(self::once())
            ->method('getUuid')
            ->willReturn('ff143a4c-3994-4e7a-8d95-60904211dc73');
        $createdShoppingList
            ->expects(self::once())
            ->method('addUser')
            ->with($user);

        $this->idFactory
            ->expects(self::once())
            ->method('make')
            ->willReturn('ff143a4c-3994-4e7a-8d95-60904211dc73');

        $this->shoppingListRepository
            ->expects(self::once())
            ->method('add')
            ->with(
                new ShoppingList(
                    uuid: 'ff143a4c-3994-4e7a-8d95-60904211dc73',
                    name: 'Leclerc H&M',
                    owner: $user,
                ),
            )
            ->willReturn($createdShoppingList);

        $handler = new SaveShoppingListCommandHandler(
            $this->idFactory,
            $this->shoppingListRepository,
        );

        $command = new SaveShoppingListCommand($user, null);
        $command->name = '   Leclerc H&M  ';

        $result = $handler($command);

        $this->assertSame('ff143a4c-3994-4e7a-8d95-60904211dc73', $result);
    }

    public function testSuccessfullyUpdated(): void
    {
        $user = $this->createMock(User::class);
        $updatedShoppingList = $this->createMock(ShoppingList::class);
        $updatedShoppingList
            ->expects(self::once())
            ->method('getUuid')
            ->willReturn('ff143a4c-3994-4e7a-8d95-60904211dc73');
        $updatedShoppingList
            ->expects(self::never())
            ->method('addUser');
        $updatedShoppingList
            ->expects(self::once())
            ->method('updateName')
            ->with('Leclerc');

        $this->idFactory
            ->expects(self::never())
            ->method('make');

        $this->shoppingListRepository
            ->expects(self::never())
            ->method('add');

        $handler = new SaveShoppingListCommandHandler(
            $this->idFactory,
            $this->shoppingListRepository,
        );

        $command = new SaveShoppingListCommand($user, $updatedShoppingList);
        $command->name = ' Leclerc    ';

        $result = $handler($command);

        $this->assertSame('ff143a4c-3994-4e7a-8d95-60904211dc73', $result);
    }
}
