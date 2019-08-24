<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190419031343 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE promotions_showrooms (promotion_id INT NOT NULL, showroom_id INT NOT NULL, INDEX IDX_79C72BE7139DF194 (promotion_id), INDEX IDX_79C72BE72243B88B (showroom_id), PRIMARY KEY(promotion_id, showroom_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, fos_user_id INT NOT NULL, rating SMALLINT NOT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, reviewer_name VARCHAR(255) NOT NULL, reviewer_email VARCHAR(255) NOT NULL, ip_address VARCHAR(45) NOT NULL, user_session VARCHAR(128) NOT NULL, status SMALLINT UNSIGNED DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_rating (id INT AUTO_INCREMENT NOT NULL, fos_user_id INT NOT NULL, review_id SMALLINT NOT NULL, helpful SMALLINT NOT NULL, unhelpful SMALLINT NOT NULL, ip_address VARCHAR(45) NOT NULL, user_session VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_setting (id INT AUTO_INCREMENT NOT NULL, status SMALLINT UNSIGNED DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promotions_showrooms ADD CONSTRAINT FK_79C72BE7139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotions_showrooms ADD CONSTRAINT FK_79C72BE72243B88B FOREIGN KEY (showroom_id) REFERENCES showroom (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE promotions_showrooms');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE review_rating');
        $this->addSql('DROP TABLE review_setting');
    }
}
