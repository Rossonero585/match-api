<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190928140221 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE team ADD cleared_name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX name_indx ON team (cleared_name)');
        $this->addSql('ALTER TABLE league ADD cleared_name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX name_indx ON league (cleared_name)');
        $this->addSql('ALTER TABLE sport ADD cleared_name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE INDEX name_indx ON sport (cleared_name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX name_indx ON league');
        $this->addSql('ALTER TABLE league DROP cleared_name');
        $this->addSql('DROP INDEX name_indx ON sport');
        $this->addSql('ALTER TABLE sport DROP cleared_name');
        $this->addSql('DROP INDEX name_indx ON team');
        $this->addSql('ALTER TABLE team DROP cleared_name');
    }
}
