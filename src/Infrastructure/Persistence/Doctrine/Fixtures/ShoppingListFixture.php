<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixtures;

use App\Domain\Shopping\ShoppingList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ShoppingListFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $shoppingList = new ShoppingList(
            '0b507871-8b5e-4575-b297-a630310fc06e',
            'Leclerc Saint-Ouen',
            $this->getReference('mmarchois'),
        );

        $shoppingList2 = new ShoppingList(
            '8c6c9813-3b58-4cb7-9056-5c432c230446',
            'Leclerc Aix',
            $this->getReference('mmarchois'),
        );

        $manager->persist($shoppingList);
        $manager->persist($shoppingList2);
        $manager->flush();

        $this->addReference('shoppingList', $shoppingList);
        $this->addReference('shoppingList2', $shoppingList2);
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
