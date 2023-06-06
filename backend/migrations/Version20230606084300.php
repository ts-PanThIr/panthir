<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606084300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE financial_account_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE financial_installment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE financial_movement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE financial_payment_condition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE financial_title_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE person_contact DROP CONSTRAINT fk_6efc55b1217bbb47');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT fk_34dcd176cd4fdb16');
        $this->addSql('ALTER TABLE person DROP CONSTRAINT fk_34dcd176df595129');
        $this->addSql('ALTER TABLE financial_title DROP CONSTRAINT fk_5a579244217bbb47');
        $this->addSql('ALTER TABLE financial_title DROP CONSTRAINT fk_5a57924496aba05f');
        $this->addSql('ALTER TABLE financial_title DROP CONSTRAINT fk_5a5792448ce5f2c8');
        $this->addSql('ALTER TABLE person_address DROP CONSTRAINT fk_2fd0dc08217bbb47');
        $this->addSql('ALTER TABLE financial_movement DROP CONSTRAINT fk_59e8def334503cd4');
        $this->addSql('ALTER TABLE financial_movement DROP CONSTRAINT fk_59e8def396aba05f');
        $this->addSql('ALTER TABLE financial_movement DROP CONSTRAINT fk_59e8def3606374f2');
        $this->addSql('ALTER TABLE financial_installment DROP CONSTRAINT fk_9407051e9363f3f');
        $this->addSql('DROP TABLE person_contact');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE financial_title');
        $this->addSql('DROP TABLE financial_account');
        $this->addSql('DROP TABLE person_address');
        $this->addSql('DROP TABLE financial_payment_condition');
        $this->addSql('DROP TABLE financial_movement');
        $this->addSql('DROP TABLE financial_installment');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE financial_account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE financial_installment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE financial_movement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE financial_payment_condition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE financial_title_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE person_contact (id INT NOT NULL, person_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_6efc55b1217bbb47 ON person_contact (person_id)');
        $this->addSql('CREATE TABLE person (id INT NOT NULL, main_address_id INT DEFAULT NULL, main_contact_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, document VARCHAR(255) NOT NULL, secondary_document VARCHAR(255) DEFAULT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, additional_information TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_34dcd176df595129 ON person (main_contact_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_34dcd176cd4fdb16 ON person (main_address_id)');
        $this->addSql('CREATE TABLE financial_title (id INT NOT NULL, person_id INT DEFAULT NULL, account_financial_id INT DEFAULT NULL, counterpart_account_financial_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, is_individual_person BOOLEAN NOT NULL, entry_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_5a5792448ce5f2c8 ON financial_title (counterpart_account_financial_id)');
        $this->addSql('CREATE INDEX idx_5a57924496aba05f ON financial_title (account_financial_id)');
        $this->addSql('CREATE INDEX idx_5a579244217bbb47 ON financial_title (person_id)');
        $this->addSql('CREATE TABLE financial_account (id INT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE person_address (id INT NOT NULL, person_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, number VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_2fd0dc08217bbb47 ON person_address (person_id)');
        $this->addSql('CREATE TABLE financial_payment_condition (id INT NOT NULL, name VARCHAR(255) NOT NULL, maximum_installment_quantity INT NOT NULL, first_interval INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE financial_movement (id INT NOT NULL, installment_financial_id INT DEFAULT NULL, account_financial_id INT DEFAULT NULL, counterpart_id INT DEFAULT NULL, value DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_59e8def3606374f2 ON financial_movement (counterpart_id)');
        $this->addSql('CREATE INDEX idx_59e8def396aba05f ON financial_movement (account_financial_id)');
        $this->addSql('CREATE INDEX idx_59e8def334503cd4 ON financial_movement (installment_financial_id)');
        $this->addSql('CREATE TABLE financial_installment (id INT NOT NULL, title_financial_id INT DEFAULT NULL, number INT NOT NULL, value DOUBLE PRECISION NOT NULL, fees DOUBLE PRECISION NOT NULL, fine DOUBLE PRECISION NOT NULL, extra DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, paid DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_9407051e9363f3f ON financial_installment (title_financial_id)');
        $this->addSql('ALTER TABLE person_contact ADD CONSTRAINT fk_6efc55b1217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT fk_34dcd176cd4fdb16 FOREIGN KEY (main_address_id) REFERENCES person_address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT fk_34dcd176df595129 FOREIGN KEY (main_contact_id) REFERENCES person_contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_title ADD CONSTRAINT fk_5a579244217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_title ADD CONSTRAINT fk_5a57924496aba05f FOREIGN KEY (account_financial_id) REFERENCES financial_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_title ADD CONSTRAINT fk_5a5792448ce5f2c8 FOREIGN KEY (counterpart_account_financial_id) REFERENCES financial_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_address ADD CONSTRAINT fk_2fd0dc08217bbb47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_movement ADD CONSTRAINT fk_59e8def334503cd4 FOREIGN KEY (installment_financial_id) REFERENCES financial_installment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_movement ADD CONSTRAINT fk_59e8def396aba05f FOREIGN KEY (account_financial_id) REFERENCES financial_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_movement ADD CONSTRAINT fk_59e8def3606374f2 FOREIGN KEY (counterpart_id) REFERENCES financial_movement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE financial_installment ADD CONSTRAINT fk_9407051e9363f3f FOREIGN KEY (title_financial_id) REFERENCES financial_title (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE INT');
    }
}
