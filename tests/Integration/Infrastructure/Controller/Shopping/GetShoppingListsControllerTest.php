<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class GetShoppingListsControllerTest extends AbstractWebTestCase
{
    public function testMathieuList(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/shopping-lists');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Mes listes', $crawler->filter('div.pageTitle')->text());
        $this->assertMetaTitle('Mes listes - Edgar, vos courses différemment', $crawler);

        $item = $crawler->filter('div.item');
        $shoppingLinks = $item->filter('a.shopping');
        $editLinks = $item->filter('a.edit');
        $this->assertSame(2, $item->count());
        $this->assertSame('Leclerc Saint-Ouen', $item->eq(0)->filter('h4')->text());
        $this->assertSame('http://localhost/shopping-lists/0b507871-8b5e-4575-b297-a630310fc06e', $shoppingLinks->eq(0)->link()->getUri());
        $this->assertSame('http://localhost/shopping-lists/save/0b507871-8b5e-4575-b297-a630310fc06e', $editLinks->eq(0)->link()->getUri());

        $this->assertSame('Leclerc Aix', $item->eq(1)->filter('h4')->text());
        $this->assertSame('http://localhost/shopping-lists/8c6c9813-3b58-4cb7-9056-5c432c230446', $shoppingLinks->eq(1)->link()->getUri());
        $this->assertSame('http://localhost/shopping-lists/save/8c6c9813-3b58-4cb7-9056-5c432c230446', $editLinks->eq(1)->link()->getUri());
    }

    public function testHeleneList(): void
    {
        $client = $this->login('helene.m.maitre@gmail.com');
        $crawler = $client->request('GET', '/shopping-lists');

        $this->assertResponseStatusCodeSame(200);

        $item = $crawler->filter('div.item');
        $shoppingLinks = $item->filter('a.shopping');
        $editLinks = $item->filter('a.edit');
        $this->assertSame(3, $item->count());
        $this->assertSame('Leclerc Saint-Ouen', $item->eq(0)->filter('h4')->text());
        $this->assertSame('http://localhost/shopping-lists/0b507871-8b5e-4575-b297-a630310fc06e', $shoppingLinks->eq(0)->link()->getUri());
        $this->assertSame('http://localhost/shopping-lists/save/0b507871-8b5e-4575-b297-a630310fc06e', $editLinks->eq(0)->link()->getUri());
        $this->assertSame('Leclerc Aix', $item->eq(1)->filter('h4')->text());
        $this->assertSame('http://localhost/shopping-lists/8c6c9813-3b58-4cb7-9056-5c432c230446', $shoppingLinks->eq(1)->link()->getUri());
        $this->assertSame('http://localhost/shopping-lists/save/8c6c9813-3b58-4cb7-9056-5c432c230446', $editLinks->eq(1)->link()->getUri());
        $this->assertSame('Aroma-Zone', $item->eq(2)->filter('h4')->text());
        $this->assertSame('http://localhost/shopping-lists/e999a808-21ee-4533-8e05-a7bdd82d5934', $shoppingLinks->eq(2)->link()->getUri());
        $this->assertSame('http://localhost/shopping-lists/save/e999a808-21ee-4533-8e05-a7bdd82d5934', $editLinks->eq(2)->link()->getUri());
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/shopping-lists');
        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
