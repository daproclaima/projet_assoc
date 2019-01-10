<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110153559 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, album_id INT NOT NULL, titre VARCHAR(255) NOT NULL, featured_image VARCHAR(255) NOT NULL, date_album DATETIME NOT NULL, image_size INT DEFAULT NULL, INDEX IDX_876E0D91137ABCF (album_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D91137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EBCF5E72D');
        $this->addSql('DROP INDEX IDX_B26681EBCF5E72D ON evenement');
        $this->addSql('ALTER TABLE evenement ADD slug VARCHAR(50) NOT NULL, CHANGE prix_enfant prix_enfant INT DEFAULT NULL, CHANGE categorie_id categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EA21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_B26681EA21214B7 ON evenement (categories_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D91137ABCF');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE photos');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EA21214B7');
        $this->addSql('DROP INDEX IDX_B26681EA21214B7 ON evenement');
        $this->addSql('ALTER TABLE evenement DROP slug, CHANGE prix_enfant prix_enfant INT NOT NULL, CHANGE categories_id categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_B26681EBCF5E72D ON evenement (categorie_id)');
    }
}
