<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\IdFactoryInterface;
use App\Application\PasswordHasherInterface;
use App\Domain\User\Exception\UserAlreadyRegisteredException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\IsUserAlreadyRegistered;
use App\Domain\User\User;

final class RegisterUserCommandHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly IsUserAlreadyRegistered $isUserAlreadyRegistered,
        private readonly IdFactoryInterface $idFactory,
        private readonly PasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(RegisterUserCommand $registerUserCommand): User
    {
        $email = trim(strtolower($registerUserCommand->email));

        if ($this->isUserAlreadyRegistered->isSatisfiedBy($email)) {
            throw new UserAlreadyRegisteredException();
        }

        $uuid = $this->idFactory->make();
        $password = $this->passwordHasher->hash($registerUserCommand->password);

        return $this->userRepository->add(
            new User(
                uuid: $uuid,
                firstName: $registerUserCommand->firstName,
                lastName: $registerUserCommand->lastName,
                email: $email,
                password: $password,
            ),
        );
    }
}
