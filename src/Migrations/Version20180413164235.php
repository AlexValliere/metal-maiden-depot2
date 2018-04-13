<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180413164235 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE attire_category (id INT AUTO_INCREMENT NOT NULL, abbreviation VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metal_maiden (id INT AUTO_INCREMENT NOT NULL, attire_category_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, attire VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A18047EDFDB27294 (attire), INDEX IDX_A18047ED68D60284 (attire_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metal_maiden ADD CONSTRAINT FK_A18047ED68D60284 FOREIGN KEY (attire_category_id) REFERENCES attire_category (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metal_maiden DROP FOREIGN KEY FK_A18047ED68D60284');
        $this->addSql('DROP TABLE attire_category');
        $this->addSql('DROP TABLE metal_maiden');
    }
}
