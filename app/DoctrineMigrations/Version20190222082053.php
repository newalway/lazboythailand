<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190222082053 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE features (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, product_id INT DEFAULT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, image VARCHAR(255) DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, INDEX IDX_BFC0DC13A977936C (tree_root), INDEX IDX_BFC0DC13727ACA70 (parent_id), INDEX IDX_BFC0DC134584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE features_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_desc TEXT DEFAULT NULL, description MEDIUMTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_7B75B30C2C2AC5D3 (translatable_id), UNIQUE INDEX features_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inspiration (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, INDEX IDX_FDEC44404584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inspiration_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_desc TEXT DEFAULT NULL, description MEDIUMTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_F641E33E2C2AC5D3 (translatable_id), UNIQUE INDEX inspiration_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, news_category_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, public_date DATE DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, INDEX IDX_1DD399503B732BAD (news_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_category (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_4F72BA90A977936C (tree_root), INDEX IDX_4F72BA90727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_C8B8CAF92C2AC5D3 (translatable_id), INDEX search_idx (title), UNIQUE INDEX news_category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_image (id INT AUTO_INCREMENT NOT NULL, news_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, INDEX IDX_BF828301B5A459A0 (news_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_desc TEXT DEFAULT NULL, description MEDIUMTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_9D5CF3202C2AC5D3 (translatable_id), UNIQUE INDEX news_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE features ADD CONSTRAINT FK_BFC0DC13A977936C FOREIGN KEY (tree_root) REFERENCES features (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE features ADD CONSTRAINT FK_BFC0DC13727ACA70 FOREIGN KEY (parent_id) REFERENCES features (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE features ADD CONSTRAINT FK_BFC0DC134584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE features_translation ADD CONSTRAINT FK_7B75B30C2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES features (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inspiration ADD CONSTRAINT FK_FDEC44404584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE inspiration_translation ADD CONSTRAINT FK_F641E33E2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES inspiration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD399503B732BAD FOREIGN KEY (news_category_id) REFERENCES news_category (id)');
        $this->addSql('ALTER TABLE news_category ADD CONSTRAINT FK_4F72BA90A977936C FOREIGN KEY (tree_root) REFERENCES news_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_category ADD CONSTRAINT FK_4F72BA90727ACA70 FOREIGN KEY (parent_id) REFERENCES news_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_category_translation ADD CONSTRAINT FK_C8B8CAF92C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES news_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_image ADD CONSTRAINT FK_BF828301B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE news_translation ADD CONSTRAINT FK_9D5CF3202C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product CHANGE is_new is_new TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE sku CHANGE default_option default_option TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE features DROP FOREIGN KEY FK_BFC0DC13A977936C');
        $this->addSql('ALTER TABLE features DROP FOREIGN KEY FK_BFC0DC13727ACA70');
        $this->addSql('ALTER TABLE features_translation DROP FOREIGN KEY FK_7B75B30C2C2AC5D3');
        $this->addSql('ALTER TABLE inspiration_translation DROP FOREIGN KEY FK_F641E33E2C2AC5D3');
        $this->addSql('ALTER TABLE news_image DROP FOREIGN KEY FK_BF828301B5A459A0');
        $this->addSql('ALTER TABLE news_translation DROP FOREIGN KEY FK_9D5CF3202C2AC5D3');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD399503B732BAD');
        $this->addSql('ALTER TABLE news_category DROP FOREIGN KEY FK_4F72BA90A977936C');
        $this->addSql('ALTER TABLE news_category DROP FOREIGN KEY FK_4F72BA90727ACA70');
        $this->addSql('ALTER TABLE news_category_translation DROP FOREIGN KEY FK_C8B8CAF92C2AC5D3');
        $this->addSql('DROP TABLE features');
        $this->addSql('DROP TABLE features_translation');
        $this->addSql('DROP TABLE inspiration');
        $this->addSql('DROP TABLE inspiration_translation');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_category');
        $this->addSql('DROP TABLE news_category_translation');
        $this->addSql('DROP TABLE news_image');
        $this->addSql('DROP TABLE news_translation');
        $this->addSql('ALTER TABLE product CHANGE is_new is_new TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE sku CHANGE default_option default_option TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
