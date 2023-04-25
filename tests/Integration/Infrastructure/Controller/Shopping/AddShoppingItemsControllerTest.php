<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class AddShoppingItemsControllerTest extends AbstractWebTestCase
{
    public function testAdd(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/0b507871-8b5e-4575-b297-a630310fc06e/add');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();

        $this->assertSame('De quoi avez-vous besoin ?', $crawler->filter('div.pageTitle')->text());
        $this->assertMetaTitle('De quoi avez-vous besoin ? - Edgar, vos courses différemment', $crawler);
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/0b507871-8b5e-4575-b297-a630310fc06e/add');
        $this->assertResponseRedirects('http://localhost/auth/login', 302);
    }
}
