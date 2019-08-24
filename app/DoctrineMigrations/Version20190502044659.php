<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190502044659 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD dim_body_depth NUMERIC(10, 2) DEFAULT NULL, ADD dim_body_height NUMERIC(10, 2) DEFAULT NULL, ADD dim_body_width NUMERIC(10, 2) DEFAULT NULL, ADD dim_seat_depth NUMERIC(10, 2) DEFAULT NULL, ADD dim_seat_height NUMERIC(10, 2) DEFAULT NULL, ADD dim_seat_width NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_translation ADD resources TEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP dim_body_depth, DROP dim_body_height, DROP dim_body_width, DROP dim_seat_depth, DROP dim_seat_height, DROP dim_seat_width');
        $this->addSql('ALTER TABLE product_translation DROP resources');
    }
}
