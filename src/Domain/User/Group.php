<?php

declare(strict_types=1);

namespace App\Domain\User;

class Group
{
    private iterable $users = [];
    private iterable $cards = [];

    public function __construct(
        private string $uuid,
        private string $name,
        private \DateTimeInterface $startDate,
        private ?\DateTimeInterface $endDate = null,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function getUsers(): iterable
    {
        return $this->users;
    }

    public function getCards(): iterable
    {
        return $this->cards;
    }
}
