<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230325195059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER INDEX idx_a51def092831c2f6 RENAME TO IDX_6612795F2831C2F6');
        $this->addSql('ALTER INDEX idx_a51def0981d5b79c RENAME TO IDX_6612795F81D5B79C');
        $this->addSql('ALTER INDEX idx_a51def09abfe1c6f RENAME TO IDX_6612795FABFE1C6F');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER INDEX idx_6612795fabfe1c6f RENAME TO idx_a51def09abfe1c6f');
        $this->addSql('ALTER INDEX idx_6612795f81d5b79c RENAME TO idx_a51def0981d5b79c');
        $this->addSql('ALTER INDEX idx_6612795f2831c2f6 RENAME TO idx_a51def092831c2f6');
    }
}
