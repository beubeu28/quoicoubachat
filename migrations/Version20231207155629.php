<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231207155629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, stock INT NOT NULL, image VARCHAR(511) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, utilisateurid_id INT DEFAULT NULL, date DATE NOT NULL, montant_totale DOUBLE PRECISION NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67DEBE08276 (utilisateurid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messagerie (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, user_mail VARCHAR(255) NOT NULL, motif VARCHAR(255) NOT NULL, description VARCHAR(511) NOT NULL, date DATETIME NOT NULL, INDEX IDX_14E8F60CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, telephone VARCHAR(10) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DEBE08276 FOREIGN KEY (utilisateurid_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE messagerie ADD CONSTRAINT FK_14E8F60CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA6490DEFAF FOREIGN KEY (commandeid_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA69223694D FOREIGN KEY (articleid_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA69223694D');
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA6490DEFAF');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DEBE08276');
        $this->addSql('ALTER TABLE messagerie DROP FOREIGN KEY FK_14E8F60CFB88E14F');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE messagerie');
        $this->addSql('DROP TABLE user');
    }
}
