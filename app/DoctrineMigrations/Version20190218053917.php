<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190218053917 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customer_payment_epayment (id INT AUTO_INCREMENT NOT NULL, customer_order_id INT DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, status VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, transaction_id VARCHAR(255) DEFAULT NULL, decision VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, reason_code VARCHAR(255) DEFAULT NULL, reference_number VARCHAR(255) DEFAULT NULL, card_number VARCHAR(255) DEFAULT NULL, card_expiry_date VARCHAR(255) DEFAULT NULL, card_issuer VARCHAR(255) DEFAULT NULL, card_scheme VARCHAR(255) DEFAULT NULL, card_country VARCHAR(45) DEFAULT NULL, auth_amount NUMERIC(10, 2) DEFAULT NULL, currency VARCHAR(45) DEFAULT NULL, auth_time DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5D0A3AB1A15A2E17 (customer_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_carrier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tracking_url TEXT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_desc TEXT DEFAULT NULL, description TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_A5073BB2C2AC5D3 (translatable_id), UNIQUE INDEX portfolio_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE showroom_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_14E674C32C2AC5D3 (translatable_id), INDEX search_idx (title), UNIQUE INDEX showroom_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C74F21955F37A13B (token), INDEX IDX_C74F219519EB6921 (client_id), INDEX IDX_C74F2195A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_order_delivery (id INT AUTO_INCREMENT NOT NULL, customer_order_id INT DEFAULT NULL, address_type SMALLINT UNSIGNED DEFAULT 1 NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, district VARCHAR(255) DEFAULT NULL, amphure VARCHAR(255) DEFAULT NULL, province VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, postcode VARCHAR(45) DEFAULT NULL, tax_payer_id VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, head_office VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, place_id VARCHAR(255) DEFAULT NULL, INDEX IDX_4F143A6BA15A2E17 (customer_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE authentication (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value TEXT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, input_type VARCHAR(255) DEFAULT NULL, group_type VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX authentication_l_1 (name), INDEX authentication_l_2 (group_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, discount_code VARCHAR(255) NOT NULL, discount_type SMALLINT NOT NULL, discount_value INT NOT NULL, applies_to SMALLINT NOT NULL, only_applies_once_item_per_product TINYINT(1) NOT NULL, minimum_requirement SMALLINT NOT NULL, minimum_requirement_amount_value INT DEFAULT NULL, minimum_requirement_quantity_value INT DEFAULT NULL, usage_limit_discount_total TINYINT(1) NOT NULL, usage_limit_discount_total_value INT DEFAULT NULL, usage_limit_discount_one_per_customer TINYINT(1) NOT NULL, start_date DATETIME NOT NULL, is_end_date TINYINT(1) NOT NULL, end_date DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, sku VARCHAR(255) DEFAULT NULL, price NUMERIC(10, 2) DEFAULT \'0\', image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, status SMALLINT UNSIGNED DEFAULT 1 NOT NULL, publish_date DATETIME NOT NULL, position INT UNSIGNED DEFAULT 0 NOT NULL, compare_at_price NUMERIC(10, 2) DEFAULT \'0\', inventory_policy_status SMALLINT DEFAULT 0 NOT NULL, inventory_quantity INT DEFAULT NULL, grams NUMERIC(10, 2) DEFAULT \'0\', weight NUMERIC(10, 2) DEFAULT \'0\', weight_unit VARCHAR(45) DEFAULT NULL, image_small VARCHAR(255) DEFAULT NULL, image_medium VARCHAR(255) DEFAULT NULL, image_large VARCHAR(255) DEFAULT NULL, user_weight VARCHAR(255) DEFAULT NULL, is_new TINYINT(1) DEFAULT \'0\' NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_categories (product_id INT NOT NULL, product_category_id INT NOT NULL, INDEX IDX_E8ACBE764584665A (product_id), INDEX IDX_E8ACBE76BE6903FD (product_category_id), PRIMARY KEY(product_id, product_category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_hashtags (product_id INT NOT NULL, hashtag_id INT NOT NULL, INDEX IDX_34E03B5C4584665A (product_id), INDEX IDX_34E03B5CFB34EF56 (hashtag_id), PRIMARY KEY(product_id, hashtag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_showrooms (product_id INT NOT NULL, showroom_id INT NOT NULL, INDEX IDX_AF0E5F684584665A (product_id), INDEX IDX_AF0E5F682243B88B (showroom_id), PRIMARY KEY(product_id, showroom_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_discounts (product_id INT NOT NULL, discount_id INT NOT NULL, INDEX IDX_AE2AE19E4584665A (product_id), INDEX IDX_AE2AE19E4C7C611F (discount_id), PRIMARY KEY(product_id, discount_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products_promotions (product_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_3844C82A4584665A (product_id), INDEX IDX_3844C82A139DF194 (promotion_id), PRIMARY KEY(product_id, promotion_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, image_mobile VARCHAR(255) DEFAULT NULL, public_date DATE DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE showroom (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, place_id VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, fax VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, position SMALLINT NOT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_code (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, iso_code VARCHAR(5) NOT NULL, dial_code VARCHAR(45) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, position SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, position SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount_setting (id INT AUTO_INCREMENT NOT NULL, status SMALLINT UNSIGNED DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sku (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, price NUMERIC(10, 2) DEFAULT NULL, status SMALLINT UNSIGNED DEFAULT 1 NOT NULL, compare_at_price NUMERIC(10, 2) DEFAULT NULL, inventory_policy_status SMALLINT UNSIGNED DEFAULT 0 NOT NULL, inventory_quantity INT DEFAULT NULL, grams NUMERIC(10, 2) DEFAULT NULL, weight NUMERIC(10, 2) DEFAULT NULL, weight_unit VARCHAR(45) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, default_option TINYINT(1) DEFAULT \'0\' NOT NULL, image_small VARCHAR(255) DEFAULT NULL, image_medium VARCHAR(255) DEFAULT NULL, image_large VARCHAR(255) DEFAULT NULL, INDEX IDX_F9038C44584665A (product_id), INDEX search_idx (sku), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, short_desc TEXT DEFAULT NULL, description TEXT DEFAULT NULL, filepath VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) DEFAULT NULL, filesize NUMERIC(10, 1) DEFAULT NULL, download_count INT NOT NULL, start_date DATE DEFAULT NULL, is_end_date TINYINT(1) NOT NULL, end_date DATE DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_order (id INT AUTO_INCREMENT NOT NULL, fos_user_id INT DEFAULT NULL, order_number VARCHAR(45) NOT NULL, order_date DATETIME NOT NULL, ship_date DATE DEFAULT NULL, item_count INT DEFAULT NULL, shipping_cost NUMERIC(10, 2) DEFAULT NULL, sub_total NUMERIC(10, 2) DEFAULT NULL, discount_code VARCHAR(255) DEFAULT NULL, discount_amount NUMERIC(10, 2) DEFAULT NULL, total_price NUMERIC(10, 2) DEFAULT NULL, payment_option VARCHAR(255) NOT NULL, payment_option_title VARCHAR(255) NOT NULL, paid SMALLINT UNSIGNED DEFAULT 0 NOT NULL, fulfilled SMALLINT UNSIGNED DEFAULT 0 NOT NULL, cancelled SMALLINT UNSIGNED DEFAULT 0 NOT NULL, refunded SMALLINT UNSIGNED DEFAULT 0 NOT NULL, deleted SMALLINT UNSIGNED DEFAULT 0 NOT NULL, note TEXT DEFAULT NULL, is_read SMALLINT UNSIGNED DEFAULT 0 NOT NULL, direction_distance INT DEFAULT NULL, direction_distance_text VARCHAR(255) DEFAULT NULL, direction_origin_showroom_id INT DEFAULT NULL, direction_origin_lat_lng VARCHAR(255) DEFAULT NULL, direction_origin_showroom_name VARCHAR(255) DEFAULT NULL, direction_destination_delivery_address_id INT DEFAULT NULL, direction_destination_lat_lng VARCHAR(255) DEFAULT NULL, shipping_cost_by_distance NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_3B1CE6A38C20A0FB (fos_user_id), INDEX customer_order_order_number_1 (order_number), INDEX customer_order_order_paid_1 (paid), INDEX customer_order_order_fulfilled_1 (fulfilled), INDEX customer_order_order_cancelled_1 (cancelled), INDEX customer_order_order_refunded_1 (refunded), INDEX customer_order_order_deleted_1 (deleted), INDEX customer_order_order_payment_option_1 (payment_option), INDEX customer_order_order_is_read_1 (is_read), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_orders_discounts (customer_order_id INT NOT NULL, discount_id INT NOT NULL, INDEX IDX_9E3611FCA15A2E17 (customer_order_id), INDEX IDX_9E3611FC4C7C611F (discount_id), PRIMARY KEY(customer_order_id, discount_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(45) DEFAULT NULL, birth_date DATE DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, oauth SMALLINT NOT NULL, facebook_id VARCHAR(255) DEFAULT NULL, facebook_access_token VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, google_access_token VARCHAR(255) DEFAULT NULL, service_name VARCHAR(255) DEFAULT NULL, service_email VARCHAR(255) DEFAULT NULL, is_set_password SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE access_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B6A2DD685F37A13B (token), INDEX IDX_B6A2DD6819EB6921 (client_id), INDEX IDX_B6A2DD68A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_F143BFAD4584665A (product_id), INDEX search_idx (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, website TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_841ECF1C2C2AC5D3 (translatable_id), INDEX search_idx (title), UNIQUE INDEX banner_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE layout_shop (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, status SMALLINT NOT NULL, position SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, publish_date DATE DEFAULT NULL, content_position VARCHAR(1) DEFAULT NULL, button_position VARCHAR(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, telephone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, message TEXT DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_image (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, INDEX IDX_35D24797DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE holiday (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, holiday_date DATE NOT NULL, status SMALLINT DEFAULT 1 NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE our_client (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion_download_counter (id INT AUTO_INCREMENT NOT NULL, promotion_id INT DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, browser_name VARCHAR(255) DEFAULT NULL, platform VARCHAR(255) DEFAULT NULL, browser VARCHAR(255) DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, country_code VARCHAR(255) DEFAULT NULL, country_name VARCHAR(255) DEFAULT NULL, city_name VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, location_latitude VARCHAR(255) DEFAULT NULL, location_longitude VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_8225F94D139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sku_value (id INT AUTO_INCREMENT NOT NULL, variant_id INT DEFAULT NULL, variant_option_id INT DEFAULT NULL, sku_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_3A7BBDD43B69A9AF (variant_id), INDEX IDX_3A7BBDD44438C63C (variant_option_id), INDEX IDX_3A7BBDD41777D41C (sku_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_service (id INT AUTO_INCREMENT NOT NULL, request_title VARCHAR(255) NOT NULL, product_title VARCHAR(255) NOT NULL, product_model VARCHAR(255) DEFAULT NULL, product_serial_number VARCHAR(255) DEFAULT NULL, product_warranty_number VARCHAR(255) DEFAULT NULL, product_text_type VARCHAR(255) DEFAULT NULL, request_detail VARCHAR(255) NOT NULL, first_name VARCHAR(45) DEFAULT NULL, last_name VARCHAR(45) DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, email VARCHAR(45) DEFAULT NULL, address VARCHAR(45) DEFAULT NULL, district VARCHAR(255) DEFAULT NULL, sub_district VARCHAR(255) DEFAULT NULL, province VARCHAR(45) DEFAULT NULL, postcode VARCHAR(45) DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_desc TEXT DEFAULT NULL, description TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_1846DB702C2AC5D3 (translatable_id), INDEX search_idx (title), UNIQUE INDEX product_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, status SMALLINT NOT NULL, public_date DATE DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auth_code (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri LONGTEXT NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5933D02C5F37A13B (token), INDEX IDX_5933D02C19EB6921 (client_id), INDEX IDX_5933D02CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_gateway (id INT AUTO_INCREMENT NOT NULL, gateway LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_1DAAB4872C2AC5D3 (translatable_id), INDEX search_idx (title), UNIQUE INDEX product_category_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, short_desc TEXT DEFAULT NULL, description TEXT DEFAULT NULL, public_date DATE DEFAULT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_order_item (id INT AUTO_INCREMENT NOT NULL, customer_order_id INT DEFAULT NULL, product_id INT DEFAULT NULL, sku_id INT DEFAULT NULL, product_title VARCHAR(255) NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, compare_at_price NUMERIC(10, 2) DEFAULT NULL, discount NUMERIC(10, 2) DEFAULT NULL, quantity INT DEFAULT NULL, amount NUMERIC(10, 2) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, inventory_policy_status SMALLINT UNSIGNED DEFAULT 0 NOT NULL, sku_title LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', sku_value VARCHAR(255) DEFAULT NULL, INDEX IDX_AF231B8BA15A2E17 (customer_order_id), INDEX IDX_AF231B8B4584665A (product_id), INDEX IDX_AF231B8B1777D41C (sku_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE layout_shop_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, content TEXT DEFAULT NULL, link_title VARCHAR(255) DEFAULT NULL, link_url VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_63592E382C2AC5D3 (translatable_id), UNIQUE INDEX layout_shop_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant_option (id INT AUTO_INCREMENT NOT NULL, variant_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_4FDCA7663B69A9AF (variant_id), INDEX search_idx (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_option (id INT AUTO_INCREMENT NOT NULL, option_name VARCHAR(255) NOT NULL, option_value LONGTEXT DEFAULT NULL, option_title VARCHAR(255) DEFAULT NULL, option_type VARCHAR(255) DEFAULT NULL, group_type VARCHAR(255) DEFAULT NULL, cat_type VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX setting_option_l_1 (cat_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscriber (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolio_image (id INT AUTO_INCREMENT NOT NULL, portfolio_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, position SMALLINT NOT NULL, INDEX IDX_98652E1AB96B5643 (portfolio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_method (id INT AUTO_INCREMENT NOT NULL, place_order_time TIME DEFAULT NULL, before_set_date VARCHAR(45) DEFAULT NULL, after_set_date VARCHAR(45) DEFAULT NULL, non_delivery_date LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tracking_number (id INT AUTO_INCREMENT NOT NULL, customer_order_id INT DEFAULT NULL, shipping_carrier_id INT DEFAULT NULL, order_number VARCHAR(255) NOT NULL, tracking_number VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_3E1C9C18A15A2E17 (customer_order_id), INDEX IDX_3E1C9C18992497C9 (shipping_carrier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_payment_bank_transfer (id INT AUTO_INCREMENT NOT NULL, customer_order_id INT DEFAULT NULL, bank_account_id INT DEFAULT NULL, order_number VARCHAR(45) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, attach_file VARCHAR(255) DEFAULT NULL, date_transfer DATE DEFAULT NULL, time_transfer TIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_DA1C2826A15A2E17 (customer_order_id), INDEX IDX_DA1C282612CB990C (bank_account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipping_rate (id INT AUTO_INCREMENT NOT NULL, rate_type VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, minimum_range INT NOT NULL, maximum_range INT NOT NULL, rate_amount INT NOT NULL, variable_cost INT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hashtag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX search_idx (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank_account (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, account_number VARCHAR(45) NOT NULL, account_name VARCHAR(255) NOT NULL, branch VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, sort SMALLINT NOT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_address (id INT AUTO_INCREMENT NOT NULL, fos_user_id INT DEFAULT NULL, country_code_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, district VARCHAR(255) DEFAULT NULL, amphure VARCHAR(255) DEFAULT NULL, province VARCHAR(255) DEFAULT NULL, postcode VARCHAR(45) DEFAULT NULL, tax_payer_id VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, head_office VARCHAR(255) DEFAULT NULL, default_shipping TINYINT(1) DEFAULT \'0\' NOT NULL, default_tax TINYINT(1) DEFAULT \'0\' NOT NULL, position INT DEFAULT 0 NOT NULL, deleted INT DEFAULT 0 NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, place_id VARCHAR(255) DEFAULT NULL, INDEX IDX_750D05F8C20A0FB (fos_user_id), INDEX IDX_750D05FEE96A67A (country_code_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content MEDIUMTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_7D0CA9D12C2AC5D3 (translatable_id), UNIQUE INDEX pages_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE our_client_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_596C26052C2AC5D3 (translatable_id), INDEX search_idx (title), UNIQUE INDEX our_client_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, tree_root INT DEFAULT NULL, parent_id INT DEFAULT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_CDFC7356A977936C (tree_root), INDEX IDX_CDFC7356727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, random_id VARCHAR(255) NOT NULL, redirect_uris LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', secret VARCHAR(255) NOT NULL, allowed_grant_types LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status SMALLINT NOT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_payment_epayment ADD CONSTRAINT FK_5D0A3AB1A15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portfolio_translation ADD CONSTRAINT FK_A5073BB2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES portfolio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE showroom_translation ADD CONSTRAINT FK_14E674C32C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES showroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE refresh_token ADD CONSTRAINT FK_C74F219519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE refresh_token ADD CONSTRAINT FK_C74F2195A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE customer_order_delivery ADD CONSTRAINT FK_4F143A6BA15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_categories ADD CONSTRAINT FK_E8ACBE764584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_categories ADD CONSTRAINT FK_E8ACBE76BE6903FD FOREIGN KEY (product_category_id) REFERENCES product_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_hashtags ADD CONSTRAINT FK_34E03B5C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_hashtags ADD CONSTRAINT FK_34E03B5CFB34EF56 FOREIGN KEY (hashtag_id) REFERENCES hashtag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_showrooms ADD CONSTRAINT FK_AF0E5F684584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_showrooms ADD CONSTRAINT FK_AF0E5F682243B88B FOREIGN KEY (showroom_id) REFERENCES showroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_discounts ADD CONSTRAINT FK_AE2AE19E4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_discounts ADD CONSTRAINT FK_AE2AE19E4C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_promotions ADD CONSTRAINT FK_3844C82A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_promotions ADD CONSTRAINT FK_3844C82A139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sku ADD CONSTRAINT FK_F9038C44584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_order ADD CONSTRAINT FK_3B1CE6A38C20A0FB FOREIGN KEY (fos_user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_orders_discounts ADD CONSTRAINT FK_9E3611FCA15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_orders_discounts ADD CONSTRAINT FK_9E3611FC4C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD6819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD68A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE banner_translation ADD CONSTRAINT FK_841ECF1C2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES banner (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_image ADD CONSTRAINT FK_35D24797DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_download_counter ADD CONSTRAINT FK_8225F94D139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sku_value ADD CONSTRAINT FK_3A7BBDD43B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sku_value ADD CONSTRAINT FK_3A7BBDD44438C63C FOREIGN KEY (variant_option_id) REFERENCES variant_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sku_value ADD CONSTRAINT FK_3A7BBDD41777D41C FOREIGN KEY (sku_id) REFERENCES sku (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB702C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02C19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02CA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE product_category_translation ADD CONSTRAINT FK_1DAAB4872C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES product_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_order_item ADD CONSTRAINT FK_AF231B8BA15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_order_item ADD CONSTRAINT FK_AF231B8B4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE customer_order_item ADD CONSTRAINT FK_AF231B8B1777D41C FOREIGN KEY (sku_id) REFERENCES sku (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE layout_shop_translation ADD CONSTRAINT FK_63592E382C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES layout_shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant_option ADD CONSTRAINT FK_4FDCA7663B69A9AF FOREIGN KEY (variant_id) REFERENCES variant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portfolio_image ADD CONSTRAINT FK_98652E1AB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tracking_number ADD CONSTRAINT FK_3E1C9C18A15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tracking_number ADD CONSTRAINT FK_3E1C9C18992497C9 FOREIGN KEY (shipping_carrier_id) REFERENCES shipping_carrier (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE customer_payment_bank_transfer ADD CONSTRAINT FK_DA1C2826A15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_payment_bank_transfer ADD CONSTRAINT FK_DA1C282612CB990C FOREIGN KEY (bank_account_id) REFERENCES bank_account (id)');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05F8C20A0FB FOREIGN KEY (fos_user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05FEE96A67A FOREIGN KEY (country_code_id) REFERENCES country_code (id)');
        $this->addSql('ALTER TABLE pages_translation ADD CONSTRAINT FK_7D0CA9D12C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES pages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE our_client_translation ADD CONSTRAINT FK_596C26052C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES our_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356A977936C FOREIGN KEY (tree_root) REFERENCES product_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356727ACA70 FOREIGN KEY (parent_id) REFERENCES product_category (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tracking_number DROP FOREIGN KEY FK_3E1C9C18992497C9');
        $this->addSql('ALTER TABLE products_discounts DROP FOREIGN KEY FK_AE2AE19E4C7C611F');
        $this->addSql('ALTER TABLE customer_orders_discounts DROP FOREIGN KEY FK_9E3611FC4C7C611F');
        $this->addSql('ALTER TABLE products_categories DROP FOREIGN KEY FK_E8ACBE764584665A');
        $this->addSql('ALTER TABLE products_hashtags DROP FOREIGN KEY FK_34E03B5C4584665A');
        $this->addSql('ALTER TABLE products_showrooms DROP FOREIGN KEY FK_AF0E5F684584665A');
        $this->addSql('ALTER TABLE products_discounts DROP FOREIGN KEY FK_AE2AE19E4584665A');
        $this->addSql('ALTER TABLE products_promotions DROP FOREIGN KEY FK_3844C82A4584665A');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE sku DROP FOREIGN KEY FK_F9038C44584665A');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD4584665A');
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB702C2AC5D3');
        $this->addSql('ALTER TABLE customer_order_item DROP FOREIGN KEY FK_AF231B8B4584665A');
        $this->addSql('ALTER TABLE banner_translation DROP FOREIGN KEY FK_841ECF1C2C2AC5D3');
        $this->addSql('ALTER TABLE showroom_translation DROP FOREIGN KEY FK_14E674C32C2AC5D3');
        $this->addSql('ALTER TABLE products_showrooms DROP FOREIGN KEY FK_AF0E5F682243B88B');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05FEE96A67A');
        $this->addSql('ALTER TABLE sku_value DROP FOREIGN KEY FK_3A7BBDD41777D41C');
        $this->addSql('ALTER TABLE customer_order_item DROP FOREIGN KEY FK_AF231B8B1777D41C');
        $this->addSql('ALTER TABLE products_promotions DROP FOREIGN KEY FK_3844C82A139DF194');
        $this->addSql('ALTER TABLE promotion_download_counter DROP FOREIGN KEY FK_8225F94D139DF194');
        $this->addSql('ALTER TABLE customer_payment_epayment DROP FOREIGN KEY FK_5D0A3AB1A15A2E17');
        $this->addSql('ALTER TABLE customer_order_delivery DROP FOREIGN KEY FK_4F143A6BA15A2E17');
        $this->addSql('ALTER TABLE customer_orders_discounts DROP FOREIGN KEY FK_9E3611FCA15A2E17');
        $this->addSql('ALTER TABLE customer_order_item DROP FOREIGN KEY FK_AF231B8BA15A2E17');
        $this->addSql('ALTER TABLE tracking_number DROP FOREIGN KEY FK_3E1C9C18A15A2E17');
        $this->addSql('ALTER TABLE customer_payment_bank_transfer DROP FOREIGN KEY FK_DA1C2826A15A2E17');
        $this->addSql('ALTER TABLE refresh_token DROP FOREIGN KEY FK_C74F2195A76ED395');
        $this->addSql('ALTER TABLE customer_order DROP FOREIGN KEY FK_3B1CE6A38C20A0FB');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD68A76ED395');
        $this->addSql('ALTER TABLE auth_code DROP FOREIGN KEY FK_5933D02CA76ED395');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05F8C20A0FB');
        $this->addSql('ALTER TABLE sku_value DROP FOREIGN KEY FK_3A7BBDD43B69A9AF');
        $this->addSql('ALTER TABLE variant_option DROP FOREIGN KEY FK_4FDCA7663B69A9AF');
        $this->addSql('ALTER TABLE layout_shop_translation DROP FOREIGN KEY FK_63592E382C2AC5D3');
        $this->addSql('ALTER TABLE our_client_translation DROP FOREIGN KEY FK_596C26052C2AC5D3');
        $this->addSql('ALTER TABLE portfolio_translation DROP FOREIGN KEY FK_A5073BB2C2AC5D3');
        $this->addSql('ALTER TABLE portfolio_image DROP FOREIGN KEY FK_98652E1AB96B5643');
        $this->addSql('ALTER TABLE blog_image DROP FOREIGN KEY FK_35D24797DAE07E97');
        $this->addSql('ALTER TABLE sku_value DROP FOREIGN KEY FK_3A7BBDD44438C63C');
        $this->addSql('ALTER TABLE products_hashtags DROP FOREIGN KEY FK_34E03B5CFB34EF56');
        $this->addSql('ALTER TABLE customer_payment_bank_transfer DROP FOREIGN KEY FK_DA1C282612CB990C');
        $this->addSql('ALTER TABLE products_categories DROP FOREIGN KEY FK_E8ACBE76BE6903FD');
        $this->addSql('ALTER TABLE product_category_translation DROP FOREIGN KEY FK_1DAAB4872C2AC5D3');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356A977936C');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356727ACA70');
        $this->addSql('ALTER TABLE refresh_token DROP FOREIGN KEY FK_C74F219519EB6921');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD6819EB6921');
        $this->addSql('ALTER TABLE auth_code DROP FOREIGN KEY FK_5933D02C19EB6921');
        $this->addSql('ALTER TABLE pages_translation DROP FOREIGN KEY FK_7D0CA9D12C2AC5D3');
        $this->addSql('DROP TABLE customer_payment_epayment');
        $this->addSql('DROP TABLE shipping_carrier');
        $this->addSql('DROP TABLE portfolio_translation');
        $this->addSql('DROP TABLE showroom_translation');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('DROP TABLE customer_order_delivery');
        $this->addSql('DROP TABLE authentication');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE products_categories');
        $this->addSql('DROP TABLE products_hashtags');
        $this->addSql('DROP TABLE products_showrooms');
        $this->addSql('DROP TABLE products_discounts');
        $this->addSql('DROP TABLE products_promotions');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE showroom');
        $this->addSql('DROP TABLE country_code');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE discount_setting');
        $this->addSql('DROP TABLE sku');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE customer_order');
        $this->addSql('DROP TABLE customer_orders_discounts');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('DROP TABLE variant');
        $this->addSql('DROP TABLE banner_translation');
        $this->addSql('DROP TABLE layout_shop');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE blog_image');
        $this->addSql('DROP TABLE holiday');
        $this->addSql('DROP TABLE our_client');
        $this->addSql('DROP TABLE promotion_download_counter');
        $this->addSql('DROP TABLE sku_value');
        $this->addSql('DROP TABLE request_service');
        $this->addSql('DROP TABLE product_translation');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE auth_code');
        $this->addSql('DROP TABLE payment_gateway');
        $this->addSql('DROP TABLE product_category_translation');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE customer_order_item');
        $this->addSql('DROP TABLE layout_shop_translation');
        $this->addSql('DROP TABLE variant_option');
        $this->addSql('DROP TABLE setting_option');
        $this->addSql('DROP TABLE subscriber');
        $this->addSql('DROP TABLE portfolio_image');
        $this->addSql('DROP TABLE delivery_method');
        $this->addSql('DROP TABLE tracking_number');
        $this->addSql('DROP TABLE customer_payment_bank_transfer');
        $this->addSql('DROP TABLE shipping_rate');
        $this->addSql('DROP TABLE hashtag');
        $this->addSql('DROP TABLE bank_account');
        $this->addSql('DROP TABLE delivery_address');
        $this->addSql('DROP TABLE pages_translation');
        $this->addSql('DROP TABLE our_client_translation');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE pages');
    }
}
