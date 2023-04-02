<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230402150315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT fk_3dc1a459f8250bd6');
        $this->addSql('CREATE TABLE user_shoppinglist (shoppinglist_uuid UUID NOT NULL, user_uuid UUID NOT NULL, PRIMARY KEY(shoppinglist_uuid, user_uuid))');
        $this->addSql('CREATE INDEX IDX_5C8B78E94645072 ON user_shoppinglist (shoppinglist_uuid)');
        $this->addSql('CREATE INDEX IDX_5C8B78E9ABFE1C6F ON user_shoppinglist (user_uuid)');
        $this->addSql('ALTER TABLE user_shoppinglist ADD CONSTRAINT FK_5C8B78E94645072 FOREIGN KEY (shoppinglist_uuid) REFERENCES shopping_list (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_shoppinglist ADD CONSTRAINT FK_5C8B78E9ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES "user" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group DROP CONSTRAINT fk_8f02bf9df8250bd6');
        $this->addSql('ALTER TABLE user_group DROP CONSTRAINT fk_8f02bf9dabfe1c6f');
        $this->addSql('ALTER TABLE card_group DROP CONSTRAINT fk_55f4b5033d4c5204');
        $this->addSql('ALTER TABLE card_group DROP CONSTRAINT fk_55f4b503f8250bd6');
        $this->addSql('DROP TABLE user_group');
        $this->addSql('DROP TABLE card_group');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('ALTER TABLE card ADD owner_uuid UUID NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D347D93336 FOREIGN KEY (owner_uuid) REFERENCES "user" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_161498D347D93336 ON card (owner_uuid)');
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT fk_3dc1a459abfe1c6f');
        $this->addSql('DROP INDEX idx_3dc1a459abfe1c6f');
        $this->addSql('DROP INDEX idx_3dc1a459f8250bd6');
        $this->addSql('ALTER TABLE shopping_list DROP group_uuid');
        $this->addSql('ALTER TABLE shopping_list RENAME COLUMN user_uuid TO owner_uuid');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A45947D93336 FOREIGN KEY (owner_uuid) REFERENCES "user" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3DC1A45947D93336 ON shopping_list (owner_uuid)');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN pseudo TO first_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE user_group (group_uuid UUID NOT NULL, user_uuid UUID NOT NULL, PRIMARY KEY(group_uuid, user_uuid))');
        $this->addSql('CREATE INDEX idx_8f02bf9dabfe1c6f ON user_group (user_uuid)');
        $this->addSql('CREATE INDEX idx_8f02bf9df8250bd6 ON user_group (group_uuid)');
        $this->addSql('CREATE TABLE card_group (card_uuid UUID NOT NULL, group_uuid UUID NOT NULL, PRIMARY KEY(card_uuid, group_uuid))');
        $this->addSql('CREATE INDEX idx_55f4b503f8250bd6 ON card_group (group_uuid)');
        $this->addSql('CREATE INDEX idx_55f4b5033d4c5204 ON card_group (card_uuid)');
        $this->addSql('CREATE TABLE "group" (uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, start_date TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, end_date TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT fk_8f02bf9df8250bd6 FOREIGN KEY (group_uuid) REFERENCES "group" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_group ADD CONSTRAINT fk_8f02bf9dabfe1c6f FOREIGN KEY (user_uuid) REFERENCES "user" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE card_group ADD CONSTRAINT fk_55f4b5033d4c5204 FOREIGN KEY (card_uuid) REFERENCES card (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE card_group ADD CONSTRAINT fk_55f4b503f8250bd6 FOREIGN KEY (group_uuid) REFERENCES "group" (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_shoppinglist DROP CONSTRAINT FK_5C8B78E94645072');
        $this->addSql('ALTER TABLE user_shoppinglist DROP CONSTRAINT FK_5C8B78E9ABFE1C6F');
        $this->addSql('DROP TABLE user_shoppinglist');
        $this->addSql('ALTER TABLE "user" ADD pseudo VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT FK_3DC1A45947D93336');
        $this->addSql('DROP INDEX IDX_3DC1A45947D93336');
        $this->addSql('ALTER TABLE shopping_list ADD group_uuid UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE shopping_list RENAME COLUMN owner_uuid TO user_uuid');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT fk_3dc1a459abfe1c6f FOREIGN KEY (user_uuid) REFERENCES "user" (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT fk_3dc1a459f8250bd6 FOREIGN KEY (group_uuid) REFERENCES "group" (uuid) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3dc1a459abfe1c6f ON shopping_list (user_uuid)');
        $this->addSql('CREATE INDEX idx_3dc1a459f8250bd6 ON shopping_list (group_uuid)');
        $this->addSql('ALTER TABLE card DROP CONSTRAINT FK_161498D347D93336');
        $this->addSql('DROP INDEX IDX_161498D347D93336');
        $this->addSql('ALTER TABLE card DROP owner_uuid');
    }
}
