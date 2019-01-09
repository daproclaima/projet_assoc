<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190109151509 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article ADD membre_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('CREATE INDEX IDX_23A0E666A99F74A ON article (membre_id)');
        $this->addSql('ALTER TABLE evenement ADD categorie_id INT NOT NULL, CHANGE prix_enfant prix_enfant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_B26681EBCF5E72D ON evenement (categorie_id)');
        $this->addSql('ALTER TABLE paiement ADD membre_id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E6A99F74A ON paiement (membre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666A99F74A');
        $this->addSql('DROP INDEX IDX_23A0E666A99F74A ON article');
        $this->addSql('ALTER TABLE article DROP membre_id');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EBCF5E72D');
        $this->addSql('DROP INDEX IDX_B26681EBCF5E72D ON evenement');
        $this->addSql('ALTER TABLE evenement DROP categorie_id, CHANGE prix_enfant prix_enfant INT NOT NULL');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E6A99F74A');
        $this->addSql('DROP INDEX IDX_B1DC7A1E6A99F74A ON paiement');
        $this->addSql('ALTER TABLE paiement DROP membre_id');
    }
}
