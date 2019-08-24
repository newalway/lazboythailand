<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190425035230 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE distributor (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, distributor_category_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, place_id VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, position SMALLINT NOT NULL, status SMALLINT NOT NULL, INDEX IDX_A3C557719F2C3FAB (zone_id), INDEX IDX_A3C55771E12E51EC (distributor_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE distributor_category (id INT AUTO_INCREMENT NOT NULL, position SMALLINT NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE distributor_category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_CD66E7DB2C2AC5D3 (translatable_id), UNIQUE INDEX distributor_category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE distributor_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_470189612C2AC5D3 (translatable_id), UNIQUE INDEX distributor_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, position SMALLINT NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_144346042C2AC5D3 (translatable_id), UNIQUE INDEX zone_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE distributor ADD CONSTRAINT FK_A3C557719F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE distributor ADD CONSTRAINT FK_A3C55771E12E51EC FOREIGN KEY (distributor_category_id) REFERENCES distributor_category (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE distributor_category_translation ADD CONSTRAINT FK_CD66E7DB2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES distributor_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE distributor_translation ADD CONSTRAINT FK_470189612C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES distributor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zone_translation ADD CONSTRAINT FK_144346042C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES zone (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE distributor_translation DROP FOREIGN KEY FK_470189612C2AC5D3');
        $this->addSql('ALTER TABLE distributor DROP FOREIGN KEY FK_A3C55771E12E51EC');
        $this->addSql('ALTER TABLE distributor_category_translation DROP FOREIGN KEY FK_CD66E7DB2C2AC5D3');
        $this->addSql('ALTER TABLE distributor DROP FOREIGN KEY FK_A3C557719F2C3FAB');
        $this->addSql('ALTER TABLE zone_translation DROP FOREIGN KEY FK_144346042C2AC5D3');
        $this->addSql('DROP TABLE distributor');
        $this->addSql('DROP TABLE distributor_category');
        $this->addSql('DROP TABLE distributor_category_translation');
        $this->addSql('DROP TABLE distributor_translation');
        $this->addSql('DROP TABLE zone');
        $this->addSql('DROP TABLE zone_translation');
    }
}
