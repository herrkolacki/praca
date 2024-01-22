<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122154823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE customer_id_seq CASCADE');
        $this->addSql('DROP TABLE customer');
        $this->addSql('ALTER TABLE company ADD uuid UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN company.uuid IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE customer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, kind VARCHAR(30) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) DEFAULT NULL, street VARCHAR(255) NOT NULL, number VARCHAR(100) DEFAULT NULL, city VARCHAR(255) NOT NULL, zip_code VARCHAR(10) DEFAULT NULL, region VARCHAR(100) NOT NULL, tele VARCHAR(100) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, pesel VARCHAR(11) DEFAULT NULL, nip VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE company DROP uuid');
    }
}
