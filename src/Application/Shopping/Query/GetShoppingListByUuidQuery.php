<?php

declare(strict_types=1);

namespace App\Application\Shopping\Query;

use App\Application\QueryInterface;
use App\Domain\User\User;

final class GetShoppingListByUuidQuery implements QueryInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly User $user,
    ) {
    }
}
