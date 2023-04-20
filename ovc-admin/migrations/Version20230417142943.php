<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417142943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_payment_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_payment_history (id INT NOT NULL, for_user_id INT NOT NULL, payment_method_status INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2C2F122E9B5BB4B8 ON user_payment_history (for_user_id)');
        $this->addSql('COMMENT ON COLUMN user_payment_history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_payment_history ADD CONSTRAINT FK_2C2F122E9B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('DROP SEQUENCE user_payment_history_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_payment_history DROP CONSTRAINT FK_2C2F122E9B5BB4B8');
        $this->addSql('DROP TABLE user_payment_history');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE user_card_ranking_history ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'2023-04-17\'');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE user_product_order_point_history ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE visited_url ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE product ALTER updated_at TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_order ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'2023-04-17\'');
        $this->addSql('ALTER TABLE user_payment ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE user_payment ALTER updated_at SET DEFAULT \'2023-04-17\'');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'2023-04-17 12:28:37.979055\'');
    }
}
