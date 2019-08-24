<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190510033200 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_order_item_option ADD option_id INT NOT NULL, ADD option_image VARCHAR(255) DEFAULT NULL, ADD option_price NUMERIC(10, 2) NOT NULL, ADD option_category_id INT DEFAULT NULL, ADD option_category_title VARCHAR(255) DEFAULT NULL, ADD option_category_image VARCHAR(255) DEFAULT NULL, DROP product_option_id, DROP category_title, DROP short_description, DROP image, DROP price, CHANGE title option_title VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_order_item_option ADD product_option_id INT UNSIGNED DEFAULT NULL, ADD category_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD short_description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD image VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD price NUMERIC(10, 2) DEFAULT \'0.00\', DROP option_id, DROP option_image, DROP option_price, DROP option_category_id, DROP option_category_title, DROP option_category_image, CHANGE option_title title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
