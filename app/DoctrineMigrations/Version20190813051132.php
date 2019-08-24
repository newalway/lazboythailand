<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190813051132 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inspiration_category DROP FOREIGN KEY FK_36C55515727ACA70');
        $this->addSql('ALTER TABLE inspiration_category DROP FOREIGN KEY FK_36C55515A977936C');
        $this->addSql('ALTER TABLE inspiration_category ADD CONSTRAINT FK_36C55515727ACA70 FOREIGN KEY (parent_id) REFERENCES inspiration_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inspiration_category ADD CONSTRAINT FK_36C55515A977936C FOREIGN KEY (tree_root) REFERENCES inspiration_category (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inspiration_category DROP FOREIGN KEY FK_36C55515A977936C');
        $this->addSql('ALTER TABLE inspiration_category DROP FOREIGN KEY FK_36C55515727ACA70');
        $this->addSql('ALTER TABLE inspiration_category ADD CONSTRAINT FK_36C55515A977936C FOREIGN KEY (tree_root) REFERENCES news_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inspiration_category ADD CONSTRAINT FK_36C55515727ACA70 FOREIGN KEY (parent_id) REFERENCES news_category (id) ON DELETE CASCADE');
    }
}
