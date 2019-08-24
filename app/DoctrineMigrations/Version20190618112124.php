<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190618112124 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customer_payment_omise (id INT AUTO_INCREMENT NOT NULL, customer_order_id INT DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, token_id VARCHAR(255) DEFAULT NULL, currency VARCHAR(255) DEFAULT NULL, authorized SMALLINT DEFAULT NULL, paid SMALLINT DEFAULT NULL, card_id VARCHAR(255) DEFAULT NULL, card_country VARCHAR(255) DEFAULT NULL, card_bank VARCHAR(255) DEFAULT NULL, card_last_digits VARCHAR(255) DEFAULT NULL, card_brand VARCHAR(255) DEFAULT NULL, card_expiration_month VARCHAR(255) DEFAULT NULL, card_expiration_year VARCHAR(255) DEFAULT NULL, card_name VARCHAR(255) DEFAULT NULL, failure_code VARCHAR(255) DEFAULT NULL, failure_message VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_59EC31A3A15A2E17 (customer_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_payment_omise ADD CONSTRAINT FK_59EC31A3A15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE customer_payment_omise');
    }
}
