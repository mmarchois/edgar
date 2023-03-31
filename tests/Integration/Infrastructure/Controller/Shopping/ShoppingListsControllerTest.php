<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ShoppingListsControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = $this->login();
        $client->request('GET', '/shopping-lists');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/shopping-lists');
        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
