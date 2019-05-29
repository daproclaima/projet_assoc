<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190528122835 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE featured_image featured_image VARCHAR(180) DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E666A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_23A0E666A99F74A ON article (membre_id)');
        $this->addSql('ALTER TABLE categorie ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE contact ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE evenement CHANGE prix_enfant prix_enfant INT DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EA21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_B26681EA21214B7 ON evenement (categories_id)');
        $this->addSql('ALTER TABLE membre CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE paiement ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E6A99F74A ON paiement (membre_id)');
        $this->addSql('ALTER TABLE photos ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E666A99F74A');
        $this->addSql('DROP INDEX IDX_23A0E666A99F74A ON article');
        $this->addSql('ALTER TABLE article DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE article CHANGE featured_image featured_image VARCHAR(180) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE categorie MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE categorie DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE contact MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE contact DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE evenement MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EA21214B7');
        $this->addSql('DROP INDEX IDX_B26681EA21214B7 ON evenement');
        $this->addSql('ALTER TABLE evenement DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE evenement CHANGE prix_enfant prix_enfant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE membre MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE membre DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE membre CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE paiement MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E6A99F74A');
        $this->addSql('DROP INDEX IDX_B1DC7A1E6A99F74A ON paiement');
        $this->addSql('ALTER TABLE paiement DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE photos MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE photos DROP PRIMARY KEY');
    }
}
