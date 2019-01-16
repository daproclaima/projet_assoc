<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190115144825 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE featured_image featured_image VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE contact CHANGE ville ville VARCHAR(255) NOT NULL, CHANGE telephone telephone VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE membre ADD reset_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE featured_image featured_image VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE contact CHANGE ville ville VARCHAR(80) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE telephone telephone VARCHAR(14) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE membre DROP reset_token');
    }
}
