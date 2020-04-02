<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200402071624 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE poster_image (poster_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_31B9AF9A5BB66C05 (poster_id), INDEX IDX_31B9AF9A3DA5256D (image_id), PRIMARY KEY(poster_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE poster_image ADD CONSTRAINT FK_31B9AF9A5BB66C05 FOREIGN KEY (poster_id) REFERENCES poster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE poster_image ADD CONSTRAINT FK_31B9AF9A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE poster_image');
    }
}
