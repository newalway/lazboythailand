<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190424034553 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD is_sale TINYINT(1) DEFAULT \'0\' NOT NULL, ADD is_top_seller TINYINT(1) DEFAULT \'0\' NOT NULL, DROP new_status, DROP sale_status, DROP top_seller_status');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD new_status SMALLINT UNSIGNED DEFAULT 0 NOT NULL, ADD sale_status SMALLINT UNSIGNED DEFAULT 0 NOT NULL, ADD top_seller_status SMALLINT UNSIGNED DEFAULT 0 NOT NULL, DROP is_sale, DROP is_top_seller');
    }
}
