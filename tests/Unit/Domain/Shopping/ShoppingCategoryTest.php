<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shopping;

use App\Domain\Shopping\ShoppingCategory;
use PHPUnit\Framework\TestCase;

final class ShoppingCategoryTest extends TestCase
{
    public function testGetters(): void
    {
        $category = new ShoppingCategory(
            '9cebe00d-04d8-48da-89b1-059f6b7bfe44',
            '🐄 Crèmerie',
            1,
        );

        $this->assertSame('9cebe00d-04d8-48da-89b1-059f6b7bfe44', $category->getUuid());
        $this->assertSame('🐄 Crèmerie', $category->getName());
        $this->assertSame(1, $category->getPosition());
    }
}
