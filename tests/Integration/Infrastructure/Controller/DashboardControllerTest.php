<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class DashboardControllerTest extends AbstractWebTestCase
{
    public function testDashboard(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/dashboard');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Mes listes', $crawler->filter('h2')->text());
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/dashboard');
        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
