<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User;

use App\Domain\User\Group;
use PHPUnit\Framework\TestCase;

final class GroupTest extends TestCase
{
    public function testGetters(): void
    {
        $start = new \DateTimeImmutable('2023-05-10');
        $end = new \DateTimeImmutable('2023-05-20');
        $group = new Group(
            '9cebe00d-04d8-48da-89b1-059f6b7bfe44',
            'Vacances H&M',
            $start,
            $end,
        );

        $this->assertSame('9cebe00d-04d8-48da-89b1-059f6b7bfe44', $group->getUuid());
        $this->assertSame('Vacances H&M', $group->getName());
        $this->assertSame($start, $group->getStartDate());
        $this->assertSame($end, $group->getEndDate());
        $this->assertSame([], $group->getUsers()); // Set by Doctrine
        $this->assertSame([], $group->getCards()); // Set by Doctrine
    }
}
