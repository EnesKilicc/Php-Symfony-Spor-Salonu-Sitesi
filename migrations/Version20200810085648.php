<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810085648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD paket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AA0F25E5 FOREIGN KEY (paket_id) REFERENCES spor_paket (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AA0F25E5 ON user (paket_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AA0F25E5');
        $this->addSql('DROP INDEX IDX_8D93D649AA0F25E5 ON user');
        $this->addSql('ALTER TABLE user DROP paket_id');
    }
}
