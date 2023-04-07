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
        $shoppingList->addUser($this->getReference('mmarchois'));
        $shoppingList->addUser($this->getReference('hmarchois'));

        $shoppingList2 = new ShoppingList(
            '8c6c9813-3b58-4cb7-9056-5c432c230446',
            'Leclerc Aix',
            $this->getReference('mmarchois'),
        );
        $shoppingList2->addUser($this->getReference('hmarchois'));
        $shoppingList2->addUser($this->getReference('mmarchois'));

        $shoppingList3 = new ShoppingList(
            'e999a808-21ee-4533-8e05-a7bdd82d5934',
            'Aroma-Zone',
            $this->getReference('hmarchois'),
        );
        $shoppingList3->addUser($this->getReference('hmarchois'));

        $manager->persist($shoppingList);
        $manager->persist($shoppingList2);
        $manager->persist($shoppingList3);
        $manager->flush();

        $this->addReference('shoppingList', $shoppingList);
        $this->addReference('shoppingList2', $shoppingList2);
        $this->addReference('shoppingList3', $shoppingList3);
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
