<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ShoppingListDetailControllerTest extends AbstractWebTestCase
{
    public function testDetail(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/shopping-lists/8c6c9813-3b58-4cb7-9056-5c432c230446');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();

        $this->assertSame('Leclerc Aix', $crawler->filter('div.pageTitle')->text());
        $this->assertMetaTitle('Leclerc Aix - Edgar, vos courses différemment', $crawler);
    }

    public function testDetailWithBadUuidFormat(): void
    {
        $client = $this->login();
        $client->request('GET', '/shopping-lists/0b507871');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testDetailNonAuthorizedShoppingList(): void
    {
        $client = $this->login();
        $client->request('GET', '/shopping-lists/e999a808-21ee-4533-8e05-a7bdd82d5934');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/shopping-lists/8c6c9813-3b58-4cb7-9056-5c432c230446');
        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
