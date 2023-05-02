<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502085024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_card_ranking_history ALTER for_user_id DROP NOT NULL');
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
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE product ALTER updated_at TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE user_order ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'2023-04-23\'');
        $this->addSql('ALTER TABLE visited_url ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE user_product_order_point_history ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE user_payment ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE user_payment ALTER updated_at SET DEFAULT \'2023-04-23\'');
        $this->addSql('ALTER TABLE user_card_ranking_history ALTER for_user_id SET NOT NULL');
        $this->addSql('ALTER TABLE user_card_ranking_history ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'2023-04-23\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'2023-04-23 10:44:22.281459\'');
    }
}
