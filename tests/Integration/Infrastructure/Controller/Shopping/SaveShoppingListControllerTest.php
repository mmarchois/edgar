<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class SaveShoppingListControllerTest extends AbstractWebTestCase
{
    public function testSuccessfullyCreated(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/shopping-lists/save');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Nouvelle liste', $crawler->filter('div.pageTitle')->text());
        $this->assertMetaTitle("Nouvelle liste - Edgar, vos courses différemment", $crawler);

        $saveButton = $crawler->selectButton('Valider');
        $form = $saveButton->form();
        $form["shopping_list_form[name]"] = "Leclerc";
        $client->submit($form);
        $this->assertResponseStatusCodeSame(303);

        $crawler = $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame('app_dashboard');
    }

    public function testEmptyValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/shopping-lists/save');

        $saveButton = $crawler->selectButton('Valider');
        $form = $saveButton->form();
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#shopping_list_form_name_error')->text());
    }

    public function testBadValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/shopping-lists/save');

        $saveButton = $crawler->selectButton('Valider');
        $form = $saveButton->form();
        $form["shopping_list_form[name]"] = str_repeat('a', 51);

        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette chaîne est trop longue. Elle doit avoir au maximum 50 caractères.", $crawler->filter('#shopping_list_form_name_error')->text());
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/shopping-lists/save');
        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
