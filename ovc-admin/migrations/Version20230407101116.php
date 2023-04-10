<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407101116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added new columns for LoyalityCard, LoyalityReward and added new table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_card_ranking_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_card_ranking_history (id INT NOT NULL, for_user_id INT NOT NULL, loyality_card_id INT NOT NULL, action INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FF6DEAD39B5BB4B8 ON user_card_ranking_history (for_user_id)');
        $this->addSql('CREATE INDEX IDX_FF6DEAD3DF7A1D6 ON user_card_ranking_history (loyality_card_id)');
        $this->addSql('COMMENT ON COLUMN user_card_ranking_history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user_card_ranking_history ADD CONSTRAINT FK_FF6DEAD39B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_card_ranking_history ADD CONSTRAINT FK_FF6DEAD3DF7A1D6 FOREIGN KEY (loyality_card_id) REFERENCES loyality_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE category ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_card ADD is_active BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE loyality_card ADD is_renewable BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE loyality_card ADD renewed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_reward ADD loyality_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE loyality_reward ALTER reward_value DROP NOT NULL');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE loyality_reward ADD CONSTRAINT FK_C725FBBDDF7A1D6 FOREIGN KEY (loyality_card_id) REFERENCES loyality_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C725FBBDDF7A1D6 ON loyality_reward (loyality_card_id)');
        $this->addSql('ALTER TABLE opinion ADD is_approved BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE product ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'now()\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'now()\'');
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
        $this->addSql('DROP SEQUENCE user_card_ranking_history_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_card_ranking_history DROP CONSTRAINT FK_FF6DEAD39B5BB4B8');
        $this->addSql('ALTER TABLE user_card_ranking_history DROP CONSTRAINT FK_FF6DEAD3DF7A1D6');
        $this->addSql('DROP TABLE user_card_ranking_history');
        $this->addSql('ALTER TABLE visited_url ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE user_order ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE product ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE product ALTER updated_at SET DEFAULT \'2023-04-04\'');
        $this->addSql('ALTER TABLE opinion DROP is_approved');
        $this->addSql('ALTER TABLE "user" ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET DEFAULT \'2023-04-04\'');
        $this->addSql('ALTER TABLE user_product_order_point_history ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE user_payment ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE user_payment ALTER updated_at SET DEFAULT \'2023-04-04\'');
        $this->addSql('ALTER TABLE report ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE report ALTER updated_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE loyality_reward DROP CONSTRAINT FK_C725FBBDDF7A1D6');
        $this->addSql('DROP INDEX IDX_C725FBBDDF7A1D6');
        $this->addSql('ALTER TABLE loyality_reward DROP loyality_card_id');
        $this->addSql('ALTER TABLE loyality_reward ALTER reward_value SET NOT NULL');
        $this->addSql('ALTER TABLE loyality_reward ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE user_address_history ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE user_address ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE user_account_status_history ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE loyality_card DROP is_active');
        $this->addSql('ALTER TABLE loyality_card DROP is_renewable');
        $this->addSql('ALTER TABLE loyality_card DROP renewed_at');
        $this->addSql('ALTER TABLE category ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE category ALTER updated_at SET DEFAULT \'2023-04-04\'');
        $this->addSql('ALTER TABLE order_item ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE order_item ALTER updated_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE loyality_point ALTER created_at SET DEFAULT \'2023-04-04 15:53:54.338633\'');
        $this->addSql('ALTER TABLE loyality_point ALTER updated_at SET DEFAULT \'2023-04-04\'');
    }
}
