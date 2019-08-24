<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190308075044 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD variant_type VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE variant_option ADD product_category_id INT DEFAULT NULL, ADD basic_price NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE variant_option ADD CONSTRAINT FK_4FDCA766BE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id) ON DELETE RESTRICT');
        $this->addSql('CREATE INDEX IDX_4FDCA766BE6903FD ON variant_option (product_category_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP variant_type');
        $this->addSql('ALTER TABLE variant_option DROP FOREIGN KEY FK_4FDCA766BE6903FD');
        $this->addSql('DROP INDEX IDX_4FDCA766BE6903FD ON variant_option');
        $this->addSql('ALTER TABLE variant_option DROP product_category_id, DROP basic_price');
    }
}
