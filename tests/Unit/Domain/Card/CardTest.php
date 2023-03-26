<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Card;

use App\Domain\Card\Card;
use App\Domain\User\User;
use PHPUnit\Framework\TestCase;

final class CardTest extends TestCase
{
    public function testGetters(): void
    {
        $user = $this->createMock(User::class);
        $card = new Card(
            '9cebe00d-04d8-48da-89b1-059f6b7bfe44',
            'Leclerc',
            'A86686SKHU989',
            $user,
        );

        $this->assertSame('9cebe00d-04d8-48da-89b1-059f6b7bfe44', $card->getUuid());
        $this->assertSame('Leclerc', $card->getName());
        $this->assertSame('A86686SKHU989', $card->getCode());
        $this->assertSame($user, $card->getUser());
        $this->assertSame([], $card->getGroups()); // Set by Doctrine
    }
}
