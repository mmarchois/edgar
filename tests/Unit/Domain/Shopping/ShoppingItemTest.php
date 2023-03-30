<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shopping;

use App\Domain\Shopping\ShoppingCategory;
use App\Domain\Shopping\ShoppingItem;
use App\Domain\Shopping\ShoppingList;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class ShoppingItemTest extends TestCase
{
    public function testGetters(): void
    {
        $list = $this->createMock(ShoppingList::class);
        $category = $this->createMock(ShoppingCategory::class);
        $user = $this->createMock(User::class);
        $item = new ShoppingItem(
            '9cebe00d-04d8-48da-89b1-059f6b7bfe44',
            $list,
            $category,
            $user,
            'Comté',
            2,
            false,
            'Penser à regarder dans le rayon bio',
            'kg',
            1000,
        );

        $this->assertSame('9cebe00d-04d8-48da-89b1-059f6b7bfe44', $item->getUuid());
        $this->assertSame('Comté', $item->getName());
        $this->assertSame($category, $item->getShoppingCategory());
        $this->assertSame($list, $item->getShoppingList());
        $this->assertSame($user, $item->getUser());
        $this->assertSame(2, $item->getQuantity());
        $this->assertSame(1000, $item->getPrice());
        $this->assertSame(false, $item->isBought());
        $this->assertSame('kg', $item->getUnit());
        $this->assertSame('Penser à regarder dans le rayon bio', $item->getComent());
    }
}
