<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190930193900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team CHANGE name_en name_en VARCHAR(255) DEFAULT NULL, CHANGE name_ru name_ru VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE league CHANGE name_en name_en VARCHAR(255) DEFAULT NULL, CHANGE name_ru name_ru VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sport CHANGE name_en name_en VARCHAR(255) DEFAULT NULL, CHANGE name_ru name_ru VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE league CHANGE name_en name_en VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE name_ru name_ru VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE sport CHANGE name_en name_en VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE name_ru name_ru VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE team CHANGE name_en name_en VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE name_ru name_ru VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
