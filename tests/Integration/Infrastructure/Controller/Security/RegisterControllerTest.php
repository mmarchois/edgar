<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Security;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class RegisterControllerTest extends AbstractWebTestCase
{
    public function testSuccessfullyRegister(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Enchanté !', $crawler->filter('h1')->text());
        $this->assertSame('Remplissez le formulaire pour pouvoir créer votre compte, gratuitement, en 1min.', $crawler->filter('h4')->text());
        $this->assertMetaTitle("Créer mon compte - Edgar, vos courses différemment", $crawler);

        $saveButton = $crawler->selectButton('Créer mon compte');
        $form = $saveButton->form();
        $form["register_form[pseudo]"] = "helene";
        $form["register_form[email]"] = "helene@gmail.com";
        $form["register_form[password][first]"] = "password";
        $form["register_form[password][second]"] = "password";
        $client->submit($form);
        $this->assertResponseStatusCodeSame(303);

        $crawler = $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
        $this->assertRouteSame('app_dashboard');
    }

    public function testEmptyValues(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $saveButton = $crawler->selectButton('Créer mon compte');
        $form = $saveButton->form();
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#register_form_pseudo_error')->text());
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#register_form_email_error')->text());
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#register_form_password_first_error')->text());
    }

    public function testBadValues(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $saveButton = $crawler->selectButton('Créer mon compte');
        $form = $saveButton->form();
        $form["register_form[pseudo]"] = str_repeat('a', 101);
        $form["register_form[email]"] = "helene";
        $form["register_form[password][first]"] = "password1";
        $form["register_form[password][second]"] = "password2";

        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette chaîne est trop longue. Elle doit avoir au maximum 100 caractères.", $crawler->filter('#register_form_pseudo_error')->text());
        $this->assertSame("Cette valeur n'est pas une adresse email valide.", $crawler->filter('#register_form_email_error')->text());
        $this->assertSame("Les mots de passe ne sont pas identiques.", $crawler->filter('#register_form_password_first_error')->text());
    }

    public function testEmailAlreadyRegistered(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $saveButton = $crawler->selectButton('Créer mon compte');
        $form = $saveButton->form();
        $form["register_form[pseudo]"] = 'mmarchois';
        $form["register_form[email]"] = "mathieu.Marchois@gmail.Com";
        $form["register_form[password][first]"] = "password";
        $form["register_form[password][second]"] = "password";

        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette adresse email est déjà associée à un compte utilisateur.", $crawler->filter('#register_form_email_error')->text());
    }
}
