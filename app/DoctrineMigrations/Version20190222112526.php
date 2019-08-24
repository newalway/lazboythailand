<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190222112526 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE is_new is_new TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE sku CHANGE default_option default_option TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE customer_order_item_option ADD customer_order_item_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer_order_item_option ADD CONSTRAINT FK_D3DCF7E480708B16 FOREIGN KEY (customer_order_item_id) REFERENCES customer_order_item (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D3DCF7E480708B16 ON customer_order_item_option (customer_order_item_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_order_item_option DROP FOREIGN KEY FK_D3DCF7E480708B16');
        $this->addSql('DROP INDEX IDX_D3DCF7E480708B16 ON customer_order_item_option');
        $this->addSql('ALTER TABLE customer_order_item_option DROP customer_order_item_id');
        $this->addSql('ALTER TABLE product CHANGE is_new is_new TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE sku CHANGE default_option default_option TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
