<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230325194329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "group" (uuid UUID NOT NULL, name VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, end_date TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE user_group (group_uuid UUID NOT NULL, user_uuid UUID NOT NULL, PRIMARY KEY(group_uuid, user_uuid))');
        $this->addSql('CREATE INDEX IDX_8F02BF9DF8250BD6 ON user_group (group_uuid)');
        $this->addSql('CREATE INDEX IDX_8F02BF9DABFE1C6F ON user_group (user_uuid)');
        $this->addSql('CREATE TABLE shopping_category (uuid UUID NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE shopping_list (uuid UUID NOT NULL, group_uuid UUID DEFAULT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_3DC1A459F8250BD6 ON shopping_list (group_uuid)');
        $this->addSql('CREATE TABLE shopping_item (uuid UUID NOT NULL, shopping_category_uuid UUID DEFAULT NULL, shopping_list_uuid UUID DEFAULT NULL, user_uuid UUID DEFAULT NULL, name VARCHAR(100) NOT NULL, quantity INT DEFAULT 1 NOT NULL, bought BOOLEAN DEFAULT false NOT NULL, comment VARCHAR(255) DEFAULT NULL, unit VARCHAR(5) DEFAULT NULL, price INT DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_A51DEF092831C2F6 ON shopping_item (shopping_category_uuid)');
        $this->addSql('CREATE INDEX IDX_A51DEF0981D5B79C ON shopping_item (shopping_list_uuid)');
        $this->addSql('CREATE INDEX IDX_A51DEF09ABFE1C6F ON shopping_item (user_uuid)');
        $this->addSql('COMMENT ON COLUMN shopping_item.price IS \'Store in cents.\'');
        $this->addSql('CREATE TABLE "user" (uuid UUID NOT NULL, pseudo VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX user_email ON "user" (email)');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DF8250BD6 FOREIGN KEY (group_uuid) REFERENCES "group" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT FK_8F02BF9DABFE1C6F FOREIGN KEY (user_uuid) REFERENCES "user" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A459F8250BD6 FOREIGN KEY (group_uuid) REFERENCES "group" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_item ADD CONSTRAINT FK_A51DEF092831C2F6 FOREIGN KEY (shopping_category_uuid) REFERENCES shopping_category (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_item ADD CONSTRAINT FK_A51DEF0981D5B79C FOREIGN KEY (shopping_list_uuid) REFERENCES shopping_list (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_item ADD CONSTRAINT FK_A51DEF09ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES "user" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_group DROP CONSTRAINT FK_8F02BF9DF8250BD6');
        $this->addSql('ALTER TABLE user_group DROP CONSTRAINT FK_8F02BF9DABFE1C6F');
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT FK_3DC1A459F8250BD6');
        $this->addSql('ALTER TABLE shopping_item DROP CONSTRAINT FK_A51DEF092831C2F6');
        $this->addSql('ALTER TABLE shopping_item DROP CONSTRAINT FK_A51DEF0981D5B79C');
        $this->addSql('ALTER TABLE shopping_item DROP CONSTRAINT FK_A51DEF09ABFE1C6F');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE shopping_category');
        $this->addSql('DROP TABLE shopping_list');
        $this->addSql('DROP TABLE shopping_item');
        $this->addSql('DROP TABLE "user"');
    }
}
