<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Security;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class LoginControllerTest extends AbstractWebTestCase
{
    public function testLoginSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Bonjour 👋', $crawler->filter('h1')->text());
        $this->assertMetaTitle("Me connecter - Edgar, vos courses différemment", $crawler);

        $saveButton = $crawler->selectButton('Me connecter');
        $form = $saveButton->form();
        $form["email"] = "mathieu.marchois@gmail.com";
        $form["password"] = "password";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame('app_dashboard');
    }

    public function testLoginWithUnknownAccount(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(200);

        $saveButton = $crawler->selectButton('Me connecter');
        $form = $saveButton->form();
        $form["email"] = "mathieu@fairness.coop";
        $form["password"] = "password";

        $client->submit($form);
        $this->assertResponseStatusCodeSame(302);
        $crawler = $client->followRedirect();

        $this->assertSame('Identifiants invalides.', $crawler->filter('div.alert')->text());
    }
}
