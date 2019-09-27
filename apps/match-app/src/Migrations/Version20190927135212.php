<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190927135212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, team1_id INT NOT NULL, team2_id INT NOT NULL, league_id INT NOT NULL, sport_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_232B318CE72BCFA4 (team1_id), INDEX IDX_232B318CF59E604A (team2_id), INDEX IDX_232B318C58AFC4DE (league_id), INDEX IDX_232B318CAC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_buffer (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, sport VARCHAR(255) NOT NULL, league VARCHAR(255) NOT NULL, team1 VARCHAR(255) NOT NULL, team2 VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, source VARCHAR(255) NOT NULL, INDEX IDX_4C6F5D3AE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3EB4C318AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C4E0A61FAC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CE72BCFA4 FOREIGN KEY (team1_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF59E604A FOREIGN KEY (team2_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3AE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_buffer DROP FOREIGN KEY FK_4C6F5D3AE48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C58AFC4DE');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CAC78BCF8');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C318AC78BCF8');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FAC78BCF8');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CE72BCFA4');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF59E604A');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_buffer');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE team');
    }
}
