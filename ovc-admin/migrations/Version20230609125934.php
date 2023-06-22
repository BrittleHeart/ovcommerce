<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609125934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE plugin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE plugin (id INT NOT NULL, name VARCHAR(140) NOT NULL, author VARCHAR(255) NOT NULL, author_url VARCHAR(255) DEFAULT NULL, license VARCHAR(10) NOT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, version VARCHAR(30) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN plugin.added_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN plugin.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN plugin.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE product ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_card_ranking_history ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_order ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_payment ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_payment ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_product_order_point_history ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE visited_url ALTER created_at SET DEFAULT \'now()\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE plugin_id_seq CASCADE');
        $this->addSql('DROP TABLE plugin');
        $this->addSql('ALTER TABLE user_card_ranking_history ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'2023-05-27\'');
        $this->addSql('ALTER TABLE user_order ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE product ALTER updated_at TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE visited_url ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'2023-05-27\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE user_payment ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE user_payment ALTER updated_at SET DEFAULT \'2023-05-27\'');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
        $this->addSql('ALTER TABLE user_product_order_point_history ALTER created_at SET DEFAULT \'2023-05-27 16:37:09.795464\'');
    }
}
