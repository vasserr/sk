<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430064353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "endpoints_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "endpoints" (id INT NOT NULL, project_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, response_code INT NOT NULL, response_body JSON NOT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DC1D25B0166D1F9C ON "endpoints" (project_id)');
        $this->addSql('ALTER TABLE "endpoints" ADD CONSTRAINT FK_DC1D25B0166D1F9C FOREIGN KEY (project_id) REFERENCES "projects" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE "endpoints_id_seq" CASCADE');
        $this->addSql('DROP TABLE "endpoints"');
    }
}
