<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200301132607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE faculty (id INT AUTO_INCREMENT NOT NULL, faculty_name_kg VARCHAR(255) NOT NULL, faculty_name_ru VARCHAR(255) NOT NULL, faculty_name_en VARCHAR(255) NOT NULL, faculty_name_tr VARCHAR(255) NOT NULL, faculty INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, faculty_id_id INT NOT NULL, dep_name_kg VARCHAR(255) NOT NULL, dep_name_ru VARCHAR(255) NOT NULL, dep_name_en VARCHAR(255) NOT NULL, dep_name_tr VARCHAR(255) NOT NULL, INDEX IDX_CD1DE18A64C076C9 (faculty_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A64C076C9 FOREIGN KEY (faculty_id_id) REFERENCES faculty (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A64C076C9');
        $this->addSql('DROP TABLE faculty');
        $this->addSql('DROP TABLE department');
    }
}
