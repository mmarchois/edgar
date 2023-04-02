<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User;

use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testGetters(): void
    {
        $user = new User(
            '9cebe00d-04d8-48da-89b1-059f6b7bfe44',
            'Mathieu',
            'MARCHOIS',
            'mathieu.marchois@gmail.com',
            'password',
        );

        $this->assertSame('9cebe00d-04d8-48da-89b1-059f6b7bfe44', $user->getUuid());
        $this->assertSame('Mathieu', $user->getFirstName());
        $this->assertSame('MARCHOIS', $user->getLastName());
        $this->assertSame('mathieu.marchois@gmail.com', $user->getEmail());
        $this->assertSame('password', $user->getPassword());
        $this->assertSame([], $user->getShoppingLists()); // Set by Doctrine
    }
}
