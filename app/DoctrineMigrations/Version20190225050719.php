<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190225050719 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE features_products (features_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_7E043CF6CEC89005 (features_id), INDEX IDX_7E043CF64584665A (product_id), PRIMARY KEY(features_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inspirations_products (inspiration_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_499563E52B726C5F (inspiration_id), INDEX IDX_499563E54584665A (product_id), PRIMARY KEY(inspiration_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE features_products ADD CONSTRAINT FK_7E043CF6CEC89005 FOREIGN KEY (features_id) REFERENCES features (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE features_products ADD CONSTRAINT FK_7E043CF64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inspirations_products ADD CONSTRAINT FK_499563E52B726C5F FOREIGN KEY (inspiration_id) REFERENCES inspiration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inspirations_products ADD CONSTRAINT FK_499563E54584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE features DROP FOREIGN KEY FK_BFC0DC134584665A');
        $this->addSql('DROP INDEX IDX_BFC0DC134584665A ON features');
        $this->addSql('ALTER TABLE features DROP product_id');
        $this->addSql('ALTER TABLE inspiration DROP FOREIGN KEY FK_FDEC44404584665A');
        $this->addSql('DROP INDEX IDX_FDEC44404584665A ON inspiration');
        $this->addSql('ALTER TABLE inspiration DROP product_id');
        $this->addSql('ALTER TABLE news ADD embed MEDIUMTEXT DEFAULT NULL');
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

        $this->addSql('DROP TABLE features_products');
        $this->addSql('DROP TABLE inspirations_products');
        $this->addSql('ALTER TABLE features ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE features ADD CONSTRAINT FK_BFC0DC134584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_BFC0DC134584665A ON features (product_id)');
        $this->addSql('ALTER TABLE inspiration ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inspiration ADD CONSTRAINT FK_FDEC44404584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_FDEC44404584665A ON inspiration (product_id)');
        $this->addSql('ALTER TABLE news DROP embed');
        $this->addSql('ALTER TABLE product CHANGE is_new is_new TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE sku CHANGE default_option default_option TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
