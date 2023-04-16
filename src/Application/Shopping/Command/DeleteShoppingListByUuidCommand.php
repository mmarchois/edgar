<?php

declare(strict_types=1);

namespace App\Application\Shopping\Command;

use App\Application\CommandInterface;
use App\Domain\User\User;

final class DeleteShoppingListByUuidCommand implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly User $user,
    ) {
    }
}
