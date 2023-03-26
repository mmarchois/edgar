<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326120245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card (uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, code VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE card_group (card_uuid UUID NOT NULL, group_uuid UUID NOT NULL, PRIMARY KEY(card_uuid, group_uuid))');
        $this->addSql('CREATE INDEX IDX_55F4B5033D4C5204 ON card_group (card_uuid)');
        $this->addSql('CREATE INDEX IDX_55F4B503F8250BD6 ON card_group (group_uuid)');
        $this->addSql('ALTER TABLE card_group ADD CONSTRAINT FK_55F4B5033D4C5204 FOREIGN KEY (card_uuid) REFERENCES card (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE card_group ADD CONSTRAINT FK_55F4B503F8250BD6 FOREIGN KEY (group_uuid) REFERENCES "group" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "group" ALTER name TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE shopping_category ALTER name TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE shopping_item ALTER shopping_category_uuid SET NOT NULL');
        $this->addSql('ALTER TABLE shopping_item ALTER shopping_list_uuid SET NOT NULL');
        $this->addSql('ALTER TABLE shopping_item ALTER user_uuid SET NOT NULL');
        $this->addSql('ALTER TABLE shopping_list ADD card_uuid UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE shopping_list ALTER group_uuid SET NOT NULL');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A4593D4C5204 FOREIGN KEY (card_uuid) REFERENCES card (uuid) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3DC1A4593D4C5204 ON shopping_list (card_uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT FK_3DC1A4593D4C5204');
        $this->addSql('ALTER TABLE card_group DROP CONSTRAINT FK_55F4B5033D4C5204');
        $this->addSql('ALTER TABLE card_group DROP CONSTRAINT FK_55F4B503F8250BD6');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE card_group');
        $this->addSql('ALTER TABLE "group" ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE shopping_item ALTER shopping_category_uuid DROP NOT NULL');
        $this->addSql('ALTER TABLE shopping_item ALTER shopping_list_uuid DROP NOT NULL');
        $this->addSql('ALTER TABLE shopping_item ALTER user_uuid DROP NOT NULL');
        $this->addSql('DROP INDEX IDX_3DC1A4593D4C5204');
        $this->addSql('ALTER TABLE shopping_list DROP card_uuid');
        $this->addSql('ALTER TABLE shopping_list ALTER group_uuid DROP NOT NULL');
        $this->addSql('ALTER TABLE shopping_category ALTER name TYPE VARCHAR(255)');
    }
}
