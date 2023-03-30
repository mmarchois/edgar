<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User\Specification;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\IsUserAlreadyRegistered;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class IsUserAlreadyRegisteredTest extends TestCase
{
    public function testNotSatisfiedBy(): void
    {
        $user = $this->createMock(User::class);
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository
            ->expects(self::once())
            ->method('findOneByEmail')
            ->with('mathieu.marchois@gmail.com')
            ->willReturn($user);

        $specification = new IsUserAlreadyRegistered($userRepository);
        $this->assertTrue($specification->isSatisfiedBy('mathieu.marchois@gmail.com'));
    }

    public function testSatisfiedBy(): void
    {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository
            ->expects(self::once())
            ->method('findOneByEmail')
            ->with('mathieu.marchois@gmail.com')
            ->willReturn(null);

        $specification = new IsUserAlreadyRegistered($userRepository);
        $this->assertFalse($specification->isSatisfiedBy('mathieu.marchois@gmail.com'));
    }
}
