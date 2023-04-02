<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ShoppingListsControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/shopping-lists');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Mes listes', $crawler->filter('div.pageTitle')->text());
        $this->assertMetaTitle("Mes listes - Edgar, vos courses différemment", $crawler);

        $goals = $crawler->filter('div.goals');
        $this->assertSame(2, $goals->filter('div.item')->count());
        $this->assertSame('Leclerc Saint-Ouen', $crawler->filter('div.item')->eq(0)->filter('h4')->text());
        $this->assertSame('Leclerc Aix', $crawler->filter('div.item')->eq(1)->filter('h4')->text());
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/shopping-lists');
        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
