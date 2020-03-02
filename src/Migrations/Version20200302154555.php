<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200302154555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment ADD poster_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5BB66C05 FOREIGN KEY (poster_id) REFERENCES poster (id)');
        $this->addSql('CREATE INDEX IDX_9474526C5BB66C05 ON comment (poster_id)');
        $this->addSql('ALTER TABLE poster CHANGE department_id department_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5BB66C05');
        $this->addSql('DROP INDEX IDX_9474526C5BB66C05 ON comment');
        $this->addSql('ALTER TABLE comment DROP poster_id');
        $this->addSql('ALTER TABLE poster CHANGE department_id department_id INT DEFAULT NULL');
    }
}
