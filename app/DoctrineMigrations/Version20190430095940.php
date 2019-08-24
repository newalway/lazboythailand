<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190430095940 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE review CHANGE product_id product_id INT DEFAULT NULL, CHANGE fos_user_id fos_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68C20A0FB FOREIGN KEY (fos_user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_794381C64584665A ON review (product_id)');
        $this->addSql('CREATE INDEX IDX_794381C68C20A0FB ON review (fos_user_id)');
        $this->addSql('ALTER TABLE review_rating CHANGE fos_user_id fos_user_id INT DEFAULT NULL, CHANGE review_id review_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review_rating ADD CONSTRAINT FK_52FF61E28C20A0FB FOREIGN KEY (fos_user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE review_rating ADD CONSTRAINT FK_52FF61E23E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
        $this->addSql('CREATE INDEX IDX_52FF61E28C20A0FB ON review_rating (fos_user_id)');
        $this->addSql('CREATE INDEX IDX_52FF61E23E2E969B ON review_rating (review_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C64584665A');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C68C20A0FB');
        $this->addSql('DROP INDEX IDX_794381C64584665A ON review');
        $this->addSql('DROP INDEX IDX_794381C68C20A0FB ON review');
        $this->addSql('ALTER TABLE review CHANGE product_id product_id INT NOT NULL, CHANGE fos_user_id fos_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE review_rating DROP FOREIGN KEY FK_52FF61E28C20A0FB');
        $this->addSql('ALTER TABLE review_rating DROP FOREIGN KEY FK_52FF61E23E2E969B');
        $this->addSql('DROP INDEX IDX_52FF61E28C20A0FB ON review_rating');
        $this->addSql('DROP INDEX IDX_52FF61E23E2E969B ON review_rating');
        $this->addSql('ALTER TABLE review_rating CHANGE fos_user_id fos_user_id INT NOT NULL, CHANGE review_id review_id SMALLINT NOT NULL');
    }
}
