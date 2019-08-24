<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190813041910 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE inspiration_category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_B43B60A62C2AC5D3 (translatable_id), INDEX search_idx (title), UNIQUE INDEX inspiration_category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inspiration_category (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_36C55515A977936C (tree_root), INDEX IDX_36C55515727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inspiration_category_translation ADD CONSTRAINT FK_B43B60A62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES inspiration_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inspiration_category ADD CONSTRAINT FK_36C55515A977936C FOREIGN KEY (tree_root) REFERENCES news_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inspiration_category ADD CONSTRAINT FK_36C55515727ACA70 FOREIGN KEY (parent_id) REFERENCES news_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inspiration ADD inspiration_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inspiration ADD CONSTRAINT FK_FDEC4440506E3BB3 FOREIGN KEY (inspiration_category_id) REFERENCES inspiration_category (id) ON DELETE RESTRICT');
        $this->addSql('CREATE INDEX IDX_FDEC4440506E3BB3 ON inspiration (inspiration_category_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inspiration_category_translation DROP FOREIGN KEY FK_B43B60A62C2AC5D3');
        $this->addSql('ALTER TABLE inspiration DROP FOREIGN KEY FK_FDEC4440506E3BB3');
        $this->addSql('DROP TABLE inspiration_category_translation');
        $this->addSql('DROP TABLE inspiration_category');
        $this->addSql('DROP INDEX IDX_FDEC4440506E3BB3 ON inspiration');
        $this->addSql('ALTER TABLE inspiration DROP inspiration_category_id');
    }
}
