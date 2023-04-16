<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping\Fragment;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class DeleteShoppingListFragmentControllerTest extends AbstractWebTestCase
{
    public function testDelete(): void
    {
        $client = $this->login();
        $crawler = $client->request('DELETE', '/_fragment/shopping-lists/0b507871-8b5e-4575-b297-a630310fc06e');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();

        $streams = $crawler->filter('turbo-stream');

        $this->assertSame($streams->eq(0)->attr('target'), 'shopping_list_0b507871-8b5e-4575-b297-a630310fc06e');
        $this->assertSame($streams->eq(0)->attr('action'), 'remove');
    }

    public function testDeleteNonAuthorizedShoppingList(): void
    {
        $client = $this->login();
        $client->request('DELETE', '/_fragment/shopping-lists/e999a808-21ee-4533-8e05-a7bdd82d5934');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testBadUuidFormat(): void
    {
        $client = $this->login();
        $client->request('DELETE', '/_fragment/shopping-lists/abc');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/_fragment/shopping-lists/0b507871-8b5e-4575-b297-a630310fc06e');
        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
