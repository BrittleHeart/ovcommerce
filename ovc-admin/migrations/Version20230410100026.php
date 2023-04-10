<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410100026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE category ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE product ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE "user" ADD uuid UUID NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('COMMENT ON COLUMN "user".uuid IS \'(DC2Type:uuid)\'');
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
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.748872\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'2023-04-10 08:44:21.748872\'');
        $this->addSql('ALTER TABLE user_card_ranking_history ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.797529\'');
        $this->addSql('ALTER TABLE visited_url ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.845053\'');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.764874\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'2023-04-10 08:44:21.764874\'');
        $this->addSql('ALTER TABLE user_product_order_point_history ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.836953\'');
        $this->addSql('ALTER TABLE product ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.755167\'');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'2023-04-10\'');
        $this->addSql('ALTER TABLE category ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.719163\'');
        $this->addSql('ALTER TABLE category ALTER updated_at SET DEFAULT \'2023-04-10\'');
        $this->addSql('ALTER TABLE user_payment ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.824044\'');
        $this->addSql('ALTER TABLE user_payment ALTER updated_at SET DEFAULT \'2023-04-10\'');
        $this->addSql('ALTER TABLE user_order ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.812863\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.792686\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.778504\'');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.738808\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.786063\'');
        $this->addSql('ALTER TABLE "user" DROP uuid');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.768093\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'2023-04-10\'');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'2023-04-10 08:44:21.734111\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'2023-04-10\'');
    }
}
