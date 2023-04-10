<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410131731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO shopping_category VALUES('e2e9bf0c-7c9d-41ce-b775-67d8b77a25d2', '🐄 Crèmerie', 1)");
        $this->addSql("INSERT INTO shopping_category VALUES('c7885dd2-98f0-4d7e-8bdd-246e3f720a19', '🍏 Fruits & légumes', 2)");
        $this->addSql("INSERT INTO shopping_category VALUES('577f03b9-8b04-43de-942c-4a240bea58ef', '🥩 Viandes & poissons', 3)");
        $this->addSql("INSERT INTO shopping_category VALUES('a5b582ac-0ce3-45a2-884a-3b166513fe92', '🥖 Pain & pâtisserie', 4)");
        $this->addSql("INSERT INTO shopping_category VALUES('945d574c-0c3b-4232-9b4e-31f2983e958b', '🥐 Petit déjeuner', 5)");
        $this->addSql("INSERT INTO shopping_category VALUES('88c50796-7162-4c62-9535-3ef45dcefe09', '🧂 Epicerie salée', 6)");
        $this->addSql("INSERT INTO shopping_category VALUES('ddb3bfdf-2f24-41e6-aaf1-c3c2c755edd6', '🍬 Epicerie sucrée', 7)");
        $this->addSql("INSERT INTO shopping_category VALUES('662bf1db-3226-4f9d-a605-d114b9e9fc32', '🥫 Conserves', 8)");
        $this->addSql("INSERT INTO shopping_category VALUES('a248a4b5-8145-4f49-9a0d-0b2b53526a79', '🥶 Surgelés', 9)");
        $this->addSql("INSERT INTO shopping_category VALUES('e0e5b5e6-c533-4fc2-b22d-be277aa9f60c', '🌾 Vegan', 10)");
        $this->addSql("INSERT INTO shopping_category VALUES('ea486942-4294-4326-98ed-1dd8673a4cef', '🍺 Alcool', 11)");
        $this->addSql("INSERT INTO shopping_category VALUES('934ab6e3-424f-4b50-8ff1-5949db2e6935', '🥤 Boissons', 12)");
        $this->addSql("INSERT INTO shopping_category VALUES('7adfd532-fb6a-4670-bd7e-8494c12690c0', '🧴 Hygiène & beauté', 13)");
        $this->addSql("INSERT INTO shopping_category VALUES('53cd68e0-742e-4b73-99d6-4401ce34ffcd', '🍼 Bébé', 14)");
        $this->addSql("INSERT INTO shopping_category VALUES('5817249d-0bda-4388-a8b5-e20025bf8b46', '🧽 Entretien & ménage', 15)");
        $this->addSql("INSERT INTO shopping_category VALUES('d1f66904-a6f1-42c7-a197-5084c3fb2fbd', '🐶 Animaux', 16)");
        $this->addSql("INSERT INTO shopping_category VALUES('845a84c2-d0b3-4055-ab08-a8bfefbb0439', '👖 Prêt-à-porter', 17)");
        $this->addSql("INSERT INTO shopping_category VALUES('053a4dc8-bc36-4bb4-bd1f-8ec7d3cd1e40', '🏡 Maison & loisir', 18)");
        $this->addSql("INSERT INTO shopping_category VALUES('bb399234-195f-435e-825c-48bf4aed3f07', '💊 Pharmacie', 19)");
        $this->addSql("INSERT INTO shopping_category VALUES('a60c41b5-2e5b-4936-bba7-cc3f90549b25', '🔨 Bricolage', 20)");
        $this->addSql("INSERT INTO shopping_category VALUES('ba47978e-f910-48f5-88b8-845b4994d588', '🌼 Jardinage', 21)");
        $this->addSql("INSERT INTO shopping_category VALUES('951ed311-76f8-4361-85db-a74d081d9955', '🏀 Sport', 22)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE from shopping_category;');
    }
}
