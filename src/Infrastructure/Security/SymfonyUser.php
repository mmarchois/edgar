<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Domain\User\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SymfonyUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    private string $uuid;
    private string $email;
    private string $password;
    private array $roles;

    public function __construct(User $user)
    {
        $this->uuid = $user->getUuid();
        $this->email = $user->getEmail();
        $this->password = $user->getPassword();
        $this->roles = ['ROLE_USER'];
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function eraseCredentials(): void
    {
    }
}
