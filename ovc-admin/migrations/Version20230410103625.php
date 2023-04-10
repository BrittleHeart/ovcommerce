<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410103625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE coupon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE loyality_card_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE loyality_point_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE loyality_reward_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE opinion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE order_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_account_status_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_address_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_card_ranking_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_favorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_product_order_point_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE visited_url_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(45) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at DATE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C15E237E06 ON category (name)');
        $this->addSql('COMMENT ON COLUMN category.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE coupon (id INT NOT NULL, name VARCHAR(10) NOT NULL, description VARCHAR(45) NOT NULL, value NUMERIC(7, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BF3F025E237E06 ON coupon (name)');
        $this->addSql('CREATE TABLE loyality_card (id INT NOT NULL, card_type INT DEFAULT 1 NOT NULL, card_number VARCHAR(16) NOT NULL, issue_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expiration_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_active BOOLEAN NOT NULL, is_renewable BOOLEAN NOT NULL, renewed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B65BABA2E4AF4C20 ON loyality_card (card_number)');
        $this->addSql('COMMENT ON COLUMN loyality_card.issue_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN loyality_card.expiration_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE loyality_point (id INT NOT NULL, card_id INT NOT NULL, points INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at DATE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9007FDBD4ACC9A20 ON loyality_point (card_id)');
        $this->addSql('COMMENT ON COLUMN loyality_point.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE loyality_reward (id INT NOT NULL, loyality_card_id INT DEFAULT NULL, points_required INT NOT NULL, reward_type INT NOT NULL, reward_value INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C725FBBDDF7A1D6 ON loyality_reward (loyality_card_id)');
        $this->addSql('COMMENT ON COLUMN loyality_reward.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE opinion (id INT NOT NULL, by_user_id INT NOT NULL, product_id INT NOT NULL, product_rate INT NOT NULL, product_comment VARCHAR(255) DEFAULT NULL, is_approved BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB02B027DC9C2434 ON opinion (by_user_id)');
        $this->addSql('CREATE INDEX IDX_AB02B0274584665A ON opinion (product_id)');
        $this->addSql('CREATE TABLE order_item (id INT NOT NULL, for_order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, price NUMERIC(7, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52EA1F09C87C042A ON order_item (for_order_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F094584665A ON order_item (product_id)');
        $this->addSql('COMMENT ON COLUMN order_item.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, category_id INT NOT NULL, coupon_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description TEXT NOT NULL, price NUMERIC(7, 2) NOT NULL, quantity INT NOT NULL, cover_url VARCHAR(255) NOT NULL, background_url VARCHAR(255) NOT NULL, merged_url VARCHAR(255) NOT NULL, is_on_sale BOOLEAN DEFAULT false NOT NULL, points INT NOT NULL, available_on INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at DATE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD5E237E06 ON product (name)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD66C5951B ON product (coupon_id)');
        $this->addSql('COMMENT ON COLUMN product.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE report (id INT NOT NULL, report_type INT NOT NULL, report_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, report_data_type INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN report.report_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN report.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, loyality_card_id INT DEFAULT NULL, uuid VARCHAR(36) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(30) NOT NULL, status INT DEFAULT 5 NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, is_email_verified BOOLEAN DEFAULT false NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at DATE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D17F50A6 ON "user" (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE INDEX IDX_8D93D649DF7A1D6 ON "user" (loyality_card_id)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_account_status_history (id INT NOT NULL, for_user_id INT NOT NULL, operator_id INT NOT NULL, action INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CAE09BB29B5BB4B8 ON user_account_status_history (for_user_id)');
        $this->addSql('CREATE INDEX IDX_CAE09BB2584598A3 ON user_account_status_history (operator_id)');
        $this->addSql('COMMENT ON COLUMN user_account_status_history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_address (id INT NOT NULL, for_user_id INT NOT NULL, address_1 VARCHAR(255) NOT NULL, address_2 VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(8) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(16) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5543718B9B5BB4B8 ON user_address (for_user_id)');
        $this->addSql('COMMENT ON COLUMN user_address.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_address_history (id INT NOT NULL, for_user_id INT NOT NULL, new_country VARCHAR(16) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6E83EB5C9B5BB4B8 ON user_address_history (for_user_id)');
        $this->addSql('COMMENT ON COLUMN user_address_history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_card_ranking_history (id INT NOT NULL, for_user_id INT NOT NULL, loyality_card_id INT NOT NULL, action INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FF6DEAD39B5BB4B8 ON user_card_ranking_history (for_user_id)');
        $this->addSql('CREATE INDEX IDX_FF6DEAD3DF7A1D6 ON user_card_ranking_history (loyality_card_id)');
        $this->addSql('COMMENT ON COLUMN user_card_ranking_history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_favorite (id INT NOT NULL, by_user_id INT NOT NULL, product_id INT NOT NULL, liked_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, disliked_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_88486AD9DC9C2434 ON user_favorite (by_user_id)');
        $this->addSql('CREATE INDEX IDX_88486AD94584665A ON user_favorite (product_id)');
        $this->addSql('COMMENT ON COLUMN user_favorite.liked_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_favorite.disliked_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_order (id INT NOT NULL, by_user_id INT NOT NULL, shipping_address_id INT NOT NULL, payment_method_id INT NOT NULL, order_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, total_price NUMERIC(7, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_17EB68C0DC9C2434 ON user_order (by_user_id)');
        $this->addSql('CREATE INDEX IDX_17EB68C04D4CFF2B ON user_order (shipping_address_id)');
        $this->addSql('CREATE INDEX IDX_17EB68C05AA1164F ON user_order (payment_method_id)');
        $this->addSql('COMMENT ON COLUMN user_order.order_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_order.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_payment (id INT NOT NULL, for_user_id INT NOT NULL, payment_type INT NOT NULL, card_number VARCHAR(16) DEFAULT NULL, cardholder_name VARCHAR(255) DEFAULT NULL, card_expiration_day DATE DEFAULT NULL, status INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at DATE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35259A07E4AF4C20 ON user_payment (card_number)');
        $this->addSql('CREATE INDEX IDX_35259A079B5BB4B8 ON user_payment (for_user_id)');
        $this->addSql('COMMENT ON COLUMN user_payment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_payment_user_address (user_payment_id INT NOT NULL, user_address_id INT NOT NULL, PRIMARY KEY(user_payment_id, user_address_id))');
        $this->addSql('CREATE INDEX IDX_8D9215EEA3A46557 ON user_payment_user_address (user_payment_id)');
        $this->addSql('CREATE INDEX IDX_8D9215EE52D06999 ON user_payment_user_address (user_address_id)');
        $this->addSql('CREATE TABLE user_product_order_point_history (id INT NOT NULL, for_user_id INT NOT NULL, product_id INT NOT NULL, for_order_id INT NOT NULL, points_earned INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EBCADB999B5BB4B8 ON user_product_order_point_history (for_user_id)');
        $this->addSql('CREATE INDEX IDX_EBCADB994584665A ON user_product_order_point_history (product_id)');
        $this->addSql('CREATE INDEX IDX_EBCADB99C87C042A ON user_product_order_point_history (for_order_id)');
        $this->addSql('COMMENT ON COLUMN user_product_order_point_history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE visited_url (id INT NOT NULL, by_user_id INT NOT NULL, product_id INT NOT NULL, url_token VARCHAR(255) NOT NULL, visited_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E29D7A72DC9C2434 ON visited_url (by_user_id)');
        $this->addSql('CREATE INDEX IDX_E29D7A724584665A ON visited_url (product_id)');
        $this->addSql('COMMENT ON COLUMN visited_url.visited_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN visited_url.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE loyality_point ADD CONSTRAINT FK_9007FDBD4ACC9A20 FOREIGN KEY (card_id) REFERENCES loyality_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE loyality_reward ADD CONSTRAINT FK_C725FBBDDF7A1D6 FOREIGN KEY (loyality_card_id) REFERENCES loyality_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027DC9C2434 FOREIGN KEY (by_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B0274584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09C87C042A FOREIGN KEY (for_order_id) REFERENCES user_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD66C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649DF7A1D6 FOREIGN KEY (loyality_card_id) REFERENCES loyality_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_account_status_history ADD CONSTRAINT FK_CAE09BB29B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_account_status_history ADD CONSTRAINT FK_CAE09BB2584598A3 FOREIGN KEY (operator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718B9B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_address_history ADD CONSTRAINT FK_6E83EB5C9B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_card_ranking_history ADD CONSTRAINT FK_FF6DEAD39B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_card_ranking_history ADD CONSTRAINT FK_FF6DEAD3DF7A1D6 FOREIGN KEY (loyality_card_id) REFERENCES loyality_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_favorite ADD CONSTRAINT FK_88486AD9DC9C2434 FOREIGN KEY (by_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_favorite ADD CONSTRAINT FK_88486AD94584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C0DC9C2434 FOREIGN KEY (by_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C04D4CFF2B FOREIGN KEY (shipping_address_id) REFERENCES user_address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_order ADD CONSTRAINT FK_17EB68C05AA1164F FOREIGN KEY (payment_method_id) REFERENCES user_payment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_payment ADD CONSTRAINT FK_35259A079B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_payment_user_address ADD CONSTRAINT FK_8D9215EEA3A46557 FOREIGN KEY (user_payment_id) REFERENCES user_payment (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_payment_user_address ADD CONSTRAINT FK_8D9215EE52D06999 FOREIGN KEY (user_address_id) REFERENCES user_address (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_product_order_point_history ADD CONSTRAINT FK_EBCADB999B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_product_order_point_history ADD CONSTRAINT FK_EBCADB994584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_product_order_point_history ADD CONSTRAINT FK_EBCADB99C87C042A FOREIGN KEY (for_order_id) REFERENCES user_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visited_url ADD CONSTRAINT FK_E29D7A72DC9C2434 FOREIGN KEY (by_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE visited_url ADD CONSTRAINT FK_E29D7A724584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE coupon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE loyality_card_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE loyality_point_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE loyality_reward_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE opinion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE order_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE report_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_account_status_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_address_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_card_ranking_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_favorite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_order_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_product_order_point_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE visited_url_id_seq CASCADE');
        $this->addSql('ALTER TABLE loyality_point DROP CONSTRAINT FK_9007FDBD4ACC9A20');
        $this->addSql('ALTER TABLE loyality_reward DROP CONSTRAINT FK_C725FBBDDF7A1D6');
        $this->addSql('ALTER TABLE opinion DROP CONSTRAINT FK_AB02B027DC9C2434');
        $this->addSql('ALTER TABLE opinion DROP CONSTRAINT FK_AB02B0274584665A');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F09C87C042A');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F094584665A');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD66C5951B');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649DF7A1D6');
        $this->addSql('ALTER TABLE user_account_status_history DROP CONSTRAINT FK_CAE09BB29B5BB4B8');
        $this->addSql('ALTER TABLE user_account_status_history DROP CONSTRAINT FK_CAE09BB2584598A3');
        $this->addSql('ALTER TABLE user_address DROP CONSTRAINT FK_5543718B9B5BB4B8');
        $this->addSql('ALTER TABLE user_address_history DROP CONSTRAINT FK_6E83EB5C9B5BB4B8');
        $this->addSql('ALTER TABLE user_card_ranking_history DROP CONSTRAINT FK_FF6DEAD39B5BB4B8');
        $this->addSql('ALTER TABLE user_card_ranking_history DROP CONSTRAINT FK_FF6DEAD3DF7A1D6');
        $this->addSql('ALTER TABLE user_favorite DROP CONSTRAINT FK_88486AD9DC9C2434');
        $this->addSql('ALTER TABLE user_favorite DROP CONSTRAINT FK_88486AD94584665A');
        $this->addSql('ALTER TABLE user_order DROP CONSTRAINT FK_17EB68C0DC9C2434');
        $this->addSql('ALTER TABLE user_order DROP CONSTRAINT FK_17EB68C04D4CFF2B');
        $this->addSql('ALTER TABLE user_order DROP CONSTRAINT FK_17EB68C05AA1164F');
        $this->addSql('ALTER TABLE user_payment DROP CONSTRAINT FK_35259A079B5BB4B8');
        $this->addSql('ALTER TABLE user_payment_user_address DROP CONSTRAINT FK_8D9215EEA3A46557');
        $this->addSql('ALTER TABLE user_payment_user_address DROP CONSTRAINT FK_8D9215EE52D06999');
        $this->addSql('ALTER TABLE user_product_order_point_history DROP CONSTRAINT FK_EBCADB999B5BB4B8');
        $this->addSql('ALTER TABLE user_product_order_point_history DROP CONSTRAINT FK_EBCADB994584665A');
        $this->addSql('ALTER TABLE user_product_order_point_history DROP CONSTRAINT FK_EBCADB99C87C042A');
        $this->addSql('ALTER TABLE visited_url DROP CONSTRAINT FK_E29D7A72DC9C2434');
        $this->addSql('ALTER TABLE visited_url DROP CONSTRAINT FK_E29D7A724584665A');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE loyality_card');
        $this->addSql('DROP TABLE loyality_point');
        $this->addSql('DROP TABLE loyality_reward');
        $this->addSql('DROP TABLE opinion');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_account_status_history');
        $this->addSql('DROP TABLE user_address');
        $this->addSql('DROP TABLE user_address_history');
        $this->addSql('DROP TABLE user_card_ranking_history');
        $this->addSql('DROP TABLE user_favorite');
        $this->addSql('DROP TABLE user_order');
        $this->addSql('DROP TABLE user_payment');
        $this->addSql('DROP TABLE user_payment_user_address');
        $this->addSql('DROP TABLE user_product_order_point_history');
        $this->addSql('DROP TABLE visited_url');
    }
}
