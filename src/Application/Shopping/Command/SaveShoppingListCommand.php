<?php

declare(strict_types=1);

namespace App\Application\Shopping\Command;

use App\Application\CommandInterface;
use App\Domain\User\User;

final class SaveShoppingListCommand implements CommandInterface
{
    public function __construct(
        public readonly User $user,
    ) {
    }

    public ?string $name;
}
