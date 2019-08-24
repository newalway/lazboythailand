<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190502075751 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE dim_body_depth dim_body_depth NUMERIC(10, 2) DEFAULT NULL, CHANGE dim_body_height dim_body_height NUMERIC(10, 2) DEFAULT NULL, CHANGE dim_body_width dim_body_width NUMERIC(10, 2) DEFAULT NULL, CHANGE dim_seat_depth dim_seat_depth NUMERIC(10, 2) DEFAULT NULL, CHANGE dim_seat_height dim_seat_height NUMERIC(10, 2) DEFAULT NULL, CHANGE dim_seat_width dim_seat_width NUMERIC(10, 2) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE dim_body_depth dim_body_depth NUMERIC(10, 2) DEFAULT \'0.00\', CHANGE dim_body_height dim_body_height NUMERIC(10, 2) DEFAULT \'0.00\', CHANGE dim_body_width dim_body_width NUMERIC(10, 2) DEFAULT \'0.00\', CHANGE dim_seat_depth dim_seat_depth NUMERIC(10, 2) DEFAULT \'0.00\', CHANGE dim_seat_height dim_seat_height NUMERIC(10, 2) DEFAULT \'0.00\', CHANGE dim_seat_width dim_seat_width NUMERIC(10, 2) DEFAULT \'0.00\'');
    }
}
