<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shopping;

use App\Domain\Shopping\ShoppingList;
use App\Domain\User\Group;
use PHPUnit\Framework\TestCase;

final class ShoppingListTest extends TestCase
{
    public function testGetters(): void
    {
        $group = $this->createMock(Group::class);
        $list = new ShoppingList(
            '9cebe00d-04d8-48da-89b1-059f6b7bfe44',
            'Leclerc',
            $group,
        );

        $this->assertSame('9cebe00d-04d8-48da-89b1-059f6b7bfe44', $list->getUuid());
        $this->assertSame('Leclerc', $list->getName());
        $this->assertSame($group, $list->getGroup());
    }
}