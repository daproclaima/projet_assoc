<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190112110236 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE evenement CHANGE contenu contenu LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666A99F74A');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E6A99F74A');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666A99F74A');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE evenement CHANGE contenu contenu VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E6A99F74A');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
    }
}
