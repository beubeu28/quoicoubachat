<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205080802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DEBE08276');
        $this->addSql('DROP INDEX IDX_6EEAA67DEBE08276 ON commande');
        $this->addSql('ALTER TABLE commande ADD utilisateurid VARCHAR(255) NOT NULL, DROP utilisateurid_id, CHANGE date date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD utilisateurid_id INT DEFAULT NULL, DROP utilisateurid, CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DEBE08276 FOREIGN KEY (utilisateurid_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DEBE08276 ON commande (utilisateurid_id)');
    }
}
