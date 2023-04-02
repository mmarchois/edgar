<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Domain\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $mmarchois = new User(
            '0b507871-8b5e-4575-b297-a630310fc06e',
            'Mathieu',
            'MARCHOIS',
            'mathieu.marchois@gmail.com',
            'password',
        );

        $hmarchois = new User(
            'b6c12b6c-d589-415d-a569-c3ca231ee4c6',
            'Hélène',
            'MAITRE-MARCHOIS',
            'helene.m.maitre@gmail.com',
            'password',
        );

        $manager->persist($hmarchois);
        $manager->persist($mmarchois);
        $manager->flush();

        $this->addReference('mmarchois', $mmarchois);
        $this->addReference('hmarchois', $hmarchois);
    }
}
