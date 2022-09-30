<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930190801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_individual_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_individual_brasil_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_individual_portugal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_juridical_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE person (id INT NOT NULL, name VARCHAR(255) NOT NULL, additional_information TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE person_address (id INT NOT NULL, individual_person_id INT DEFAULT NULL, juridical_person_id INT DEFAULT NULL, country VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, address_complement VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2FD0DC0835E9D72B ON person_address (individual_person_id)');
        $this->addSql('CREATE INDEX IDX_2FD0DC088A15D0A8 ON person_address (juridical_person_id)');
        $this->addSql('CREATE TABLE person_contact (id INT NOT NULL, individual_person_id INT DEFAULT NULL, juridical_person_id INT DEFAULT NULL, contact_name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6EFC55B135E9D72B ON person_contact (individual_person_id)');
        $this->addSql('CREATE INDEX IDX_6EFC55B18A15D0A8 ON person_contact (juridical_person_id)');
        $this->addSql('CREATE TABLE person_individual (id INT NOT NULL, person_id INT DEFAULT NULL, main_address_id INT DEFAULT NULL, main_contact_id INT DEFAULT NULL, birth_date VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1289F02217BBB47 ON person_individual (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1289F02CD4FDB16 ON person_individual (main_address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1289F02DF595129 ON person_individual (main_contact_id)');
        $this->addSql('CREATE TABLE person_individual_brasil (id INT NOT NULL, individual_person_id INT DEFAULT NULL, cpf VARCHAR(255) NOT NULL, rg VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_841918A935E9D72B ON person_individual_brasil (individual_person_id)');
        $this->addSql('CREATE TABLE person_individual_portugal (id INT NOT NULL, individual_person_id INT DEFAULT NULL, nif VARCHAR(255) NOT NULL, niss VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFD1E3E35E9D72B ON person_individual_portugal (individual_person_id)');
        $this->addSql('CREATE TABLE person_juridical (id INT NOT NULL, person_id INT DEFAULT NULL, main_address_id INT DEFAULT NULL, main_contact_id INT DEFAULT NULL, nickname VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7F3E97B2217BBB47 ON person_juridical (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7F3E97B2CD4FDB16 ON person_juridical (main_address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7F3E97B2DF595129 ON person_juridical (main_contact_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE person_address ADD CONSTRAINT FK_2FD0DC0835E9D72B FOREIGN KEY (individual_person_id) REFERENCES person_individual (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_address ADD CONSTRAINT FK_2FD0DC088A15D0A8 FOREIGN KEY (juridical_person_id) REFERENCES person_juridical (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_contact ADD CONSTRAINT FK_6EFC55B135E9D72B FOREIGN KEY (individual_person_id) REFERENCES person_individual (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_contact ADD CONSTRAINT FK_6EFC55B18A15D0A8 FOREIGN KEY (juridical_person_id) REFERENCES person_juridical (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_individual ADD CONSTRAINT FK_B1289F02217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_individual ADD CONSTRAINT FK_B1289F02CD4FDB16 FOREIGN KEY (main_address_id) REFERENCES person_address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_individual ADD CONSTRAINT FK_B1289F02DF595129 FOREIGN KEY (main_contact_id) REFERENCES person_contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_individual_brasil ADD CONSTRAINT FK_841918A935E9D72B FOREIGN KEY (individual_person_id) REFERENCES person_individual (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_individual_portugal ADD CONSTRAINT FK_CFD1E3E35E9D72B FOREIGN KEY (individual_person_id) REFERENCES person_individual (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_juridical ADD CONSTRAINT FK_7F3E97B2217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_juridical ADD CONSTRAINT FK_7F3E97B2CD4FDB16 FOREIGN KEY (main_address_id) REFERENCES person_address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_juridical ADD CONSTRAINT FK_7F3E97B2DF595129 FOREIGN KEY (main_contact_id) REFERENCES person_contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE person_individual DROP CONSTRAINT FK_B1289F02217BBB47');
        $this->addSql('ALTER TABLE person_juridical DROP CONSTRAINT FK_7F3E97B2217BBB47');
        $this->addSql('ALTER TABLE person_individual DROP CONSTRAINT FK_B1289F02CD4FDB16');
        $this->addSql('ALTER TABLE person_juridical DROP CONSTRAINT FK_7F3E97B2CD4FDB16');
        $this->addSql('ALTER TABLE person_individual DROP CONSTRAINT FK_B1289F02DF595129');
        $this->addSql('ALTER TABLE person_juridical DROP CONSTRAINT FK_7F3E97B2DF595129');
        $this->addSql('ALTER TABLE person_address DROP CONSTRAINT FK_2FD0DC0835E9D72B');
        $this->addSql('ALTER TABLE person_contact DROP CONSTRAINT FK_6EFC55B135E9D72B');
        $this->addSql('ALTER TABLE person_individual_brasil DROP CONSTRAINT FK_841918A935E9D72B');
        $this->addSql('ALTER TABLE person_individual_portugal DROP CONSTRAINT FK_CFD1E3E35E9D72B');
        $this->addSql('ALTER TABLE person_address DROP CONSTRAINT FK_2FD0DC088A15D0A8');
        $this->addSql('ALTER TABLE person_contact DROP CONSTRAINT FK_6EFC55B18A15D0A8');
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_individual_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_individual_brasil_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_individual_portugal_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_juridical_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE person_address');
        $this->addSql('DROP TABLE person_contact');
        $this->addSql('DROP TABLE person_individual');
        $this->addSql('DROP TABLE person_individual_brasil');
        $this->addSql('DROP TABLE person_individual_portugal');
        $this->addSql('DROP TABLE person_juridical');
        $this->addSql('DROP TABLE "user"');
    }
}
