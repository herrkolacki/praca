<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230821121444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD www VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE company ADD kind VARCHAR(100) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN company.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT fk_462ce4f52cb716c7');
        $this->addSql('DROP INDEX idx_462ce4f52cb716c7');
        $this->addSql('ALTER TABLE position ADD uuid UUID NOT NULL');
        $this->addSql('ALTER TABLE position RENAME COLUMN yes_id TO company_id');
        $this->addSql('COMMENT ON COLUMN position.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_462CE4F5979B1AD6 ON position (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company DROP www');
        $this->addSql('ALTER TABLE company DROP created_at');
        $this->addSql('ALTER TABLE company DROP kind');
        $this->addSql('ALTER TABLE position DROP CONSTRAINT FK_462CE4F5979B1AD6');
        $this->addSql('DROP INDEX IDX_462CE4F5979B1AD6');
        $this->addSql('ALTER TABLE position DROP uuid');
        $this->addSql('ALTER TABLE position RENAME COLUMN company_id TO yes_id');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT fk_462ce4f52cb716c7 FOREIGN KEY (yes_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_462ce4f52cb716c7 ON position (yes_id)');
    }
}
