<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Shopping\Fragment;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class GetShoppingSuggestionsFragmentControllerTest extends AbstractWebTestCase
{
    public function testEauSuggestions(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/_fragment/shopping-suggestions?search=eau');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();

        $li = $crawler->filter('li');
        $this->assertSame(11, $li->count());

        $this->assertSame('Eau 🥤 Boissons 3', $li->eq(0)->text());
        $this->assertSame('Eau aromatisée 🥤 Boissons 3', $li->eq(1)->text());
        $this->assertSame('Eau gazeuse 🥤 Boissons 3', $li->eq(2)->text());
        $this->assertSame('Eau minérale 🥤 Boissons 3', $li->eq(3)->text());
        $this->assertSame('Eau Mont roucous 🥤 Boissons 3', $li->eq(4)->text());
        $this->assertSame('Eau pétillante 🥤 Boissons 3', $li->eq(5)->text());
        $this->assertSame('Eau de javel 🧽 Entretien & ménage 3', $li->eq(6)->text());
        $this->assertSame('Eau déminéralisée 🧽 Entretien & ménage 3', $li->eq(7)->text());
        $this->assertSame('Eau distillée 🧽 Entretien & ménage 3', $li->eq(8)->text());
        $this->assertSame('Récupérateur d\'eau 🌼 Jardinage 3', $li->eq(9)->text());
        $this->assertSame('Verre à eau 🏡 Maison & loisir 3', $li->eq(10)->text());
    }

    public function testNocioSuggestions(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/_fragment/shopping-suggestions?search=nocio');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();

        $li = $crawler->filter('li');
        $this->assertSame(2, $li->count());

        $this->assertSame('Nocio', $li->eq(0)->text()); // User value
        $this->assertSame('Nociollata 🥐 Petit déjeuner 3', $li->eq(1)->text());
    }

    public function testSearchMissing(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/_fragment/shopping-suggestions');
        $this->assertResponseStatusCodeSame(400);
    }

    public function testWithoutAuthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/_fragment/shopping-suggestions?search=eau');
        $this->assertResponseRedirects('http://localhost/auth/login', 302);
    }
}
