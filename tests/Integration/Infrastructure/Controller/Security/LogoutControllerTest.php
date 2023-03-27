<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Security;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class LogoutControllerTest extends AbstractWebTestCase
{
    public function testLogout(): void
    {
        $client = $this->login();
        $client->request('GET', '/logout');

        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();
        $this->assertRouteSame('app_landing');
    }
}
