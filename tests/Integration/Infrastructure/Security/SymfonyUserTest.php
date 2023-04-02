<?php

declare(strict_types=1);

namespace App\Test\Unit\Infrastructure\Security;

use App\Domain\User\User;
use App\Infrastructure\Security\SymfonyUser;
use PHPUnit\Framework\TestCase;

class SymfonyUserTest extends TestCase
{
    public function testUser()
    {
        $user = $this->createMock(User::class);
        $user
            ->expects(self::once())
            ->method('getUuid')
            ->willReturn('2d3724f1-2910-48b4-ba56-81796f6e100b');
        $user
            ->expects(self::once())
            ->method('getEmail')
            ->willReturn('mathieu.marchois@gmail.com');
        $user
            ->expects(self::once())
            ->method('getPassword')
            ->willReturn('password');

        $sfUser = new SymfonyUser($user);

        $this->assertSame('2d3724f1-2910-48b4-ba56-81796f6e100b', $sfUser->getUuid());
        $this->assertSame(['ROLE_USER'], $sfUser->getRoles());
        $this->assertSame(null, $sfUser->getSalt());
        $this->assertSame('mathieu.marchois@gmail.com', $sfUser->getUsername());
        $this->assertSame('mathieu.marchois@gmail.com', $sfUser->getUserIdentifier());
        $this->assertSame('password', $sfUser->getPassword());
        $this->assertEmpty($sfUser->eraseCredentials());
    }
}
