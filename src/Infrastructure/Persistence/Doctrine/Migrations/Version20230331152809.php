<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331152809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT FK_3DC1A459F8250BD6');
        $this->addSql('ALTER TABLE shopping_list ADD user_uuid UUID NOT NULL');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A459ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES "user" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A459F8250BD6 FOREIGN KEY (group_uuid) REFERENCES "group" (uuid) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3DC1A459ABFE1C6F ON shopping_list (user_uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT FK_3DC1A459ABFE1C6F');
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT fk_3dc1a459f8250bd6');
        $this->addSql('DROP INDEX IDX_3DC1A459ABFE1C6F');
        $this->addSql('ALTER TABLE shopping_list DROP user_uuid');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT fk_3dc1a459f8250bd6 FOREIGN KEY (group_uuid) REFERENCES "group" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
