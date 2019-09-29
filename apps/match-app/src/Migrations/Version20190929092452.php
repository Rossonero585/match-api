<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190929092452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX name_indx ON team');
        $this->addSql('ALTER TABLE team ADD name_ru VARCHAR(255) NOT NULL, CHANGE name name_en VARCHAR(255) NOT NULL');
        $this->addSql('CREATE FULLTEXT INDEX full_name_idx ON team (name_en, name_ru)');
        $this->addSql('DROP INDEX name_indx ON league');
        $this->addSql('ALTER TABLE league ADD name_ru VARCHAR(255) NOT NULL, CHANGE name name_en VARCHAR(255) NOT NULL');
        $this->addSql('CREATE FULLTEXT INDEX full_name_idx ON league (name_en, name_ru)');
        $this->addSql('DROP INDEX name_indx ON sport');
        $this->addSql('ALTER TABLE sport ADD name_ru VARCHAR(255) NOT NULL, CHANGE name name_en VARCHAR(255) NOT NULL');
        $this->addSql('CREATE FULLTEXT INDEX full_name_idx ON sport (name_en, name_ru)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX full_name_idx ON league');
        $this->addSql('ALTER TABLE league ADD name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP name_en, DROP name_ru');
        $this->addSql('CREATE INDEX name_indx ON league (cleared_name)');
        $this->addSql('DROP INDEX full_name_idx ON sport');
        $this->addSql('ALTER TABLE sport ADD name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP name_en, DROP name_ru');
        $this->addSql('CREATE INDEX name_indx ON sport (cleared_name)');
        $this->addSql('DROP INDEX full_name_idx ON team');
        $this->addSql('ALTER TABLE team ADD name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP name_en, DROP name_ru');
        $this->addSql('CREATE INDEX name_indx ON team (cleared_name)');
    }
}
