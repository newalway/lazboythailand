<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190429072301 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE banner_ads (id INT AUTO_INCREMENT NOT NULL, banner_name VARCHAR(255) NOT NULL, banner_value VARCHAR(255) DEFAULT NULL, banner_url VARCHAR(255) DEFAULT NULL, banner_group VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, image_size VARCHAR(255) DEFAULT NULL, image_mobile VARCHAR(255) DEFAULT NULL, image_mobile_size VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_ads_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, website TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_FCD7F2D32C2AC5D3 (translatable_id), UNIQUE INDEX banner_ads_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE banner_ads_translation ADD CONSTRAINT FK_FCD7F2D32C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES banner_ads (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE banner_ads_translation DROP FOREIGN KEY FK_FCD7F2D32C2AC5D3');
        $this->addSql('DROP TABLE banner_ads');
        $this->addSql('DROP TABLE banner_ads_translation');
    }
}
