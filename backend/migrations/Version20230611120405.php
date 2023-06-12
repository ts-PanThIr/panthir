<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611120405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create customer and user tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id VARCHAR(255) NOT NULL, main_address_id VARCHAR(255) DEFAULT NULL, main_contact_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, document VARCHAR(255) NOT NULL, secondary_document VARCHAR(255) DEFAULT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, additional_information TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09CD4FDB16 ON customer (main_address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09DF595129 ON customer (main_contact_id)');
        $this->addSql('CREATE TABLE customer_address (id VARCHAR(255) NOT NULL, customer_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1193CB3F9395C3F3 ON customer_address (customer_id)');
        $this->addSql('CREATE TABLE customer_contact (id VARCHAR(255) NOT NULL, customer_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50BF42869395C3F3 ON customer_contact (customer_id)');
        $this->addSql('CREATE TABLE "user" (id VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password_reset_token TEXT DEFAULT NULL, password VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09CD4FDB16 FOREIGN KEY (main_address_id) REFERENCES customer_address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09DF595129 FOREIGN KEY (main_contact_id) REFERENCES customer_contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_address ADD CONSTRAINT FK_1193CB3F9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_contact ADD CONSTRAINT FK_50BF42869395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE customer DROP CONSTRAINT FK_81398E09CD4FDB16');
        $this->addSql('ALTER TABLE customer DROP CONSTRAINT FK_81398E09DF595129');
        $this->addSql('ALTER TABLE customer_address DROP CONSTRAINT FK_1193CB3F9395C3F3');
        $this->addSql('ALTER TABLE customer_contact DROP CONSTRAINT FK_50BF42869395C3F3');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_address');
        $this->addSql('DROP TABLE customer_contact');
        $this->addSql('DROP TABLE "user"');
    }
}
