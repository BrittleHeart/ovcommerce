<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507082545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added start / end date for reports';
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
        $this->addSql('ALTER TABLE product ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE report ADD start_date DATE NOT NULL');
        $this->addSql('ALTER TABLE report ADD end_date DATE NOT NULL');
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
        $this->addSql('ALTER TABLE report DROP start_date');
        $this->addSql('ALTER TABLE report DROP end_date');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE visited_url ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE user_product_order_point_history ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE user_payment ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE user_payment ALTER updated_at SET DEFAULT \'2023-05-02\'');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE product ALTER updated_at TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'2023-05-02\'');
        $this->addSql('ALTER TABLE user_card_ranking_history ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE user_order ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'2023-05-02\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'2023-05-02 12:28:24.341562\'');
    }
}
