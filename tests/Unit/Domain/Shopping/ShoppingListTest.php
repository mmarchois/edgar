<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shopping;

use App\Domain\Card\Card;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class ShoppingListTest extends TestCase
{
    public function testGetters(): void
    {
        $owner = $this->createMock(User::class);
        $user = $this->createMock(User::class);
        $card = $this->createMock(Card::class);
        $list = new ShoppingList(
            '9cebe00d-04d8-48da-89b1-059f6b7bfe44',
            'Leclerc',
            $owner,
            $card,
        );
        $list->addUser($owner);
        $list->addUser($user);

        $this->assertSame('9cebe00d-04d8-48da-89b1-059f6b7bfe44', $list->getUuid());
        $this->assertSame('Leclerc', $list->getName());
        $this->assertSame($card, $list->getCard());
        $this->assertSame($owner, $list->getOwner());
        $this->assertSame([$owner, $user], $list->getUsers());
    }
}
