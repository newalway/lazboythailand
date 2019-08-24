<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190523050225 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_style_number (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, position INT UNSIGNED DEFAULT 0 NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD product_style_number_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADAEB7F015 FOREIGN KEY (product_style_number_id) REFERENCES product_style_number (id) ON DELETE RESTRICT');
        $this->addSql('CREATE INDEX IDX_D34A04ADAEB7F015 ON product (product_style_number_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADAEB7F015');
        $this->addSql('DROP TABLE product_style_number');
        $this->addSql('DROP INDEX IDX_D34A04ADAEB7F015 ON product');
        $this->addSql('ALTER TABLE product DROP product_style_number_id');
    }
}
