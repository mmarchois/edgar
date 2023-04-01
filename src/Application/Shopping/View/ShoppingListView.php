<?php

declare(strict_types=1);

namespace App\Application\Shopping\View;

final class ShoppingListView
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
    ) {
    }
}
