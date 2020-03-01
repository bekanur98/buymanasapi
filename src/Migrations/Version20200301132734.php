<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200301132734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faculty DROP faculty');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A64C076C9');
        $this->addSql('DROP INDEX IDX_CD1DE18A64C076C9 ON department');
        $this->addSql('ALTER TABLE department DROP faculty_id_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE department ADD faculty_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A64C076C9 FOREIGN KEY (faculty_id_id) REFERENCES faculty (id)');
        $this->addSql('CREATE INDEX IDX_CD1DE18A64C076C9 ON department (faculty_id_id)');
        $this->addSql('ALTER TABLE faculty ADD faculty INT NOT NULL');
    }
}
