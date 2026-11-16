<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261116094740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, color VARCHAR(7) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE coaster (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, max_speed INT DEFAULT NULL, length INT DEFAULT NULL, max_height INT DEFAULT NULL, operating TINYINT NOT NULL, description LONGTEXT DEFAULT NULL, park_id INT DEFAULT NULL, INDEX IDX_F6312A7844990C25 (park_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE coaster_category (coaster_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_C69E1710216303C (coaster_id), INDEX IDX_C69E171012469DE2 (category_id), PRIMARY KEY (coaster_id, category_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE park (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, country VARCHAR(2) NOT NULL, opening_year INT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE coaster ADD CONSTRAINT FK_F6312A7844990C25 FOREIGN KEY (park_id) REFERENCES park (id)');
        $this->addSql('ALTER TABLE coaster_category ADD CONSTRAINT FK_C69E1710216303C FOREIGN KEY (coaster_id) REFERENCES coaster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coaster_category ADD CONSTRAINT FK_C69E171012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coaster DROP FOREIGN KEY FK_F6312A7844990C25');
        $this->addSql('ALTER TABLE coaster_category DROP FOREIGN KEY FK_C69E1710216303C');
        $this->addSql('ALTER TABLE coaster_category DROP FOREIGN KEY FK_C69E171012469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE coaster');
        $this->addSql('DROP TABLE coaster_category');
        $this->addSql('DROP TABLE park');
    }
}
