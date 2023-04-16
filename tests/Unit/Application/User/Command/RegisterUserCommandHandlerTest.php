<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\User\Command;

use App\Application\IdFactoryInterface;
use App\Application\PasswordHasherInterface;
use App\Application\User\Command\RegisterUserCommand;
use App\Application\User\Command\RegisterUserCommandHandler;
use App\Domain\User\Exception\UserAlreadyRegisteredException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\IsUserAlreadyRegistered;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class RegisterUserCommandHandlerTest extends TestCase
{
    private $idFactory;
    private $passwordHasher;
    private $userRepository;
    private $isUserAlreadyRegistered;

    public function setUp(): void
    {
        $this->idFactory = $this->createMock(IdFactoryInterface::class);
        $this->passwordHasher = $this->createMock(PasswordHasherInterface::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->isUserAlreadyRegistered = $this->createMock(IsUserAlreadyRegistered::class);
    }

    public function testRegister(): void
    {
        $createdUser = $this->createMock(User::class);

        $this->isUserAlreadyRegistered
            ->expects(self::once())
            ->method('isSatisfiedBy')
            ->with('mathieu.marchois@gmail.com')
            ->willReturn(false);

        $this->passwordHasher
            ->expects(self::once())
            ->method('hash')
            ->willReturn('hashPassword');

        $this->idFactory
            ->expects(self::once())
            ->method('make')
            ->willReturn('ff143a4c-3994-4e7a-8d95-60904211dc73');

        $this->userRepository
            ->expects(self::once())
            ->method('add')
            ->with(
                new User(
                    uuid: 'ff143a4c-3994-4e7a-8d95-60904211dc73',
                    firstName: 'Mathieu',
                    lastName: 'Marchois',
                    email: 'mathieu.marchois@gmail.com',
                    password: 'hashPassword',
                ),
            )
            ->willReturn($createdUser);

        $handler = new RegisterUserCommandHandler(
            $this->userRepository,
            $this->isUserAlreadyRegistered,
            $this->idFactory,
            $this->passwordHasher,
        );

        $command = new RegisterUserCommand();
        $command->firstName = 'Mathieu';
        $command->lastName = 'Marchois';
        $command->email = '  Mathieu.MArchois@gmail.com  ';
        $command->password = 'password';

        $result = $handler($command);

        $this->assertSame($createdUser, $result);
    }

    public function testAlreadyRegistered(): void
    {
        $this->expectException(UserAlreadyRegisteredException::class);

        $this->isUserAlreadyRegistered
            ->expects(self::once())
            ->method('isSatisfiedBy')
            ->with('mathieu.marchois@gmail.com')
            ->willReturn(true);

        $this->passwordHasher
            ->expects(self::never())
            ->method('hash');

        $this->idFactory
            ->expects(self::never())
            ->method('make');

        $this->userRepository
            ->expects(self::never())
            ->method('add');

        $handler = new RegisterUserCommandHandler(
            $this->userRepository,
            $this->isUserAlreadyRegistered,
            $this->idFactory,
            $this->passwordHasher,
        );

        $command = new RegisterUserCommand();
        $command->firstName = 'Mathieu';
        $command->lastName = 'Marchois';
        $command->email = 'Mathieu.MArchois@gmail.com';
        $command->password = 'password';

        $handler($command);
    }
}
