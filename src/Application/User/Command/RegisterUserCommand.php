<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Application\CommandInterface;

final class RegisterUserCommand implements CommandInterface
{
    public ?string $pseudo;
    public ?string $email;
    public ?string $password;
}
