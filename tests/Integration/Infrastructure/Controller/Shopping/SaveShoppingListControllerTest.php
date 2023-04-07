<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class SaveShoppingListControllerTest extends AbstractWebTestCase
{
    /**
     * @dataProvider accessUrlsProvider
     */
    public function testSuccessfullySaved(string $url): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', $url);

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();

        if ($url === '/shopping-lists/save') {
            $this->assertSame('Nouvelle liste', $crawler->filter('div.pageTitle')->text());
            $this->assertMetaTitle("Nouvelle liste - Edgar, vos courses différemment", $crawler);
        } else {
            $this->assertSame('Renommer "Leclerc Saint-O..."', $crawler->filter('div.pageTitle')->text());
            $this->assertMetaTitle('Renommer "Leclerc Saint-O..." - Edgar, vos courses différemment', $crawler);
        }

        $saveButton = $crawler->selectButton('Valider');
        $form = $saveButton->form();
        $form["shopping_list_form[name]"] = "Leclerc";
        $client->submit($form);
        $this->assertResponseStatusCodeSame(303);

        $crawler = $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame('app_shoppinglist_detail');
    }

    /**
     * @dataProvider accessUrlsProvider
     */
    public function testEmptyValues(string $url): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', $url);

        $saveButton = $crawler->selectButton('Valider');
        $form = $saveButton->form();
        $form["shopping_list_form[name]"] = "";
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#shopping_list_form_name_error')->text());
    }

    /**
     * @dataProvider accessUrlsProvider
     */
    public function testBadValues(string $url): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', $url);

        $saveButton = $crawler->selectButton('Valider');
        $form = $saveButton->form();
        $form["shopping_list_form[name]"] = str_repeat('a', 51);

        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette chaîne est trop longue. Elle doit avoir au maximum 50 caractères.", $crawler->filter('#shopping_list_form_name_error')->text());
    }

    public function testEditWithBadUuidFormat(): void
    {
        $client = $this->login();
        $client->request('GET', '/shopping-lists/save/0b507871');

        $this->assertResponseStatusCodeSame(400);
    }

    public function testEditNonAuthorizedShoppingList(): void
    {
        $client = $this->login();
        $client->request('GET', '/shopping-lists/save/e999a808-21ee-4533-8e05-a7bdd82d5934');

        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * @dataProvider accessUrlsProvider
     */
    public function testWithoutAuthenticatedUser(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $this->assertResponseRedirects('http://localhost/login', 302);
    }

    private function accessUrlsProvider(): array
    {
        return [
            ['/shopping-lists/save'],
            ['/shopping-lists/save/0b507871-8b5e-4575-b297-a630310fc06e'],
        ];
    }
}
