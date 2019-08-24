<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190418044402 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_desc TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_50A668562C2AC5D3 (translatable_id), UNIQUE INDEX faq_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos (id INT AUTO_INCREMENT NOT NULL, embed MEDIUMTEXT NOT NULL, public_date DATE DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_desc TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_62E314502C2AC5D3 (translatable_id), UNIQUE INDEX videos_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faq_translation ADD CONSTRAINT FK_50A668562C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES faq (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE videos_translation ADD CONSTRAINT FK_62E314502C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES videos (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faq_translation DROP FOREIGN KEY FK_50A668562C2AC5D3');
        $this->addSql('ALTER TABLE videos_translation DROP FOREIGN KEY FK_62E314502C2AC5D3');
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE faq_translation');
        $this->addSql('DROP TABLE videos');
        $this->addSql('DROP TABLE videos_translation');
    }
}
