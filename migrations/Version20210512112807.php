<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210512112807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE endpoints ALTER response_body DROP NOT NULL');
        $this->addSql('ALTER INDEX projects_name_key RENAME TO UNIQ_5C93B3A45E237E06');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "endpoints" ALTER response_body SET NOT NULL');
        $this->addSql('ALTER INDEX uniq_5c93b3a45e237e06 RENAME TO projects_name_key');
    }
}
