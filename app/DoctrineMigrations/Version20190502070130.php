<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190502070130 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE review_rating DROP FOREIGN KEY FK_52FF61E23E2E969B');
        $this->addSql('ALTER TABLE review_rating ADD CONSTRAINT FK_52FF61E23E2E969B FOREIGN KEY (review_id) REFERENCES review (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE review_rating DROP FOREIGN KEY FK_52FF61E23E2E969B');
        $this->addSql('ALTER TABLE review_rating ADD CONSTRAINT FK_52FF61E23E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
    }
}
