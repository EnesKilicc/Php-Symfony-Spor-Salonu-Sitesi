<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810195623 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) DEFAULT NULL, subject VARCHAR(75) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, status VARCHAR(10) DEFAULT NULL, ip VARCHAR(15) DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, email VARCHAR(70) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AA0F25E5');
        $this->addSql('DROP INDEX IDX_8D93D649AA0F25E5 ON user');
        $this->addSql('ALTER TABLE user DROP paket_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messages');
        $this->addSql('ALTER TABLE user ADD paket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AA0F25E5 FOREIGN KEY (paket_id) REFERENCES spor_paket (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AA0F25E5 ON user (paket_id)');
    }
}
