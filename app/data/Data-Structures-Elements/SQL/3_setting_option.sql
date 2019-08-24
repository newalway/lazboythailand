INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`)
VALUES
	(1, 'contact_mail_address', 'support@zap-interactive.com', 'Recipients', 'text', 'Contact Us', 'email', NULL, '2017-11-20 11:35:20'),
	(2, 'contact_mail_name', 'LA-Z-BOY', 'Sender name', 'text', 'Contact Us', 'email', NULL, '2017-11-20 11:35:20'),
	(3, 'order_mail_address', 'num@zap-interactive.com', 'Recipients', 'text', 'Order', 'email', NULL, '2017-11-20 11:35:20'),
	(4, 'order_mail_name', 'LA-Z-BOY', 'Sender name', 'text', 'Order', 'email', NULL, '2017-11-20 11:35:20');

INSERT INTO `setting_option` (`id`,`option_name`,`option_value`,`option_title`,`option_type`,`group_type`,`cat_type`, `updated_at`, `created_at`) VALUES (7,'low_stock_report_status','true','Enable low stock notification','boolean','Low Stock Notification','email', NULL, '2017-11-20 11:35:20');
INSERT INTO `setting_option` (`id`,`option_name`,`option_value`,`option_title`,`option_type`,`group_type`,`cat_type`, `updated_at`, `created_at`) VALUES (8,'low_stock_report_min_qty','10','Low stock quantity','text','Low Stock Notification','email', NULL, '2017-11-20 11:35:20');
INSERT INTO `setting_option` (`id`,`option_name`,`option_value`,`option_title`,`option_type`,`group_type`,`cat_type`, `updated_at`, `created_at`) VALUES (9,'low_stock_report_mail_address','support@zap-interactive.com','Recipients','text','Low Stock Notification','email', NULL, '2017-11-20 11:35:20');
INSERT INTO `setting_option` (`id`,`option_name`,`option_value`,`option_title`,`option_type`,`group_type`,`cat_type`, `updated_at`, `created_at`) VALUES (10,'low_stock_report_mail_name','LA-Z-BOY','Sender name','text','Low Stock Notification','email', NULL, '2017-11-20 11:35:20');

INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`)
VALUES
	(11, 'website_site_name', 'La-Z-Boy Thailand', 'Site Name', 'text', 'Meta Tags', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(12, 'website_keyword', NULL, 'Keyword', 'textarea', 'Meta Tags', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(13, 'website_description', NULL, 'Description', 'textarea', 'Meta Tags', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(14, 'follow_us_facebook', NULL, 'Facebook', 'text', 'Follow Us', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(15, 'follow_us_twitter', NULL, 'Twitter', 'text', 'Follow Us', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(16, 'follow_us_line', NULL, 'Line', 'text', 'Follow Us', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(17, 'follow_us_instagram', NULL, 'Instagram', 'text', 'Follow Us', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(18, 'follow_us_youtube', NULL, 'Youtube', 'text', 'Follow Us', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58');

INSERT INTO `setting_option` (`id`,`option_name`,`option_value`,`option_title`,`option_type`,`group_type`,`cat_type`, `updated_at`, `created_at`)
VALUES
	(19,'review_mail_address','new.it.th@zap-global.com','Recipients','text','Review','email', NULL, '2019-05-10 11:35:20'),
	(20,'review_mail_name','LA-Z-BOY','Sender name','text','Review','email', NULL, '2019-05-10 11:35:20');


INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`)
VALUES
	(100, 'website_footer_about_globiz_venture_th', 'ผู้ผลิตเก้าอี้และชุดโซฟาปรับเอน เลซีบอย LA-Z-BOY โดยมีบริษัท โกลบิซ เวนเจอร์จำกัดเป็นผู้จัดจำหน่ายในประเทศไทย', 'About Globiz Venture - TH', 'ckeditor', 'Footer', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(101, 'website_footer_about_globiz_venture_en', 'ผู้ผลิตเก้าอี้และชุดโซฟาปรับเอน เลซีบอย LA-Z-BOY โดยมีบริษัท โกลบิซ เวนเจอร์จำกัดเป็นผู้จัดจำหน่ายในประเทศไทย', 'About Globiz Venture - EN', 'ckeditor', 'Footer', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58');


INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`)
VALUES
	(50, 'delivery_information_th', '<p><strong>ระยะเวลาจัดส่ง</strong><br/>หลังชำระเงิน</p><table border="0" cellpadding="1" cellspacing="1" style="width:500px"><tbody><tr style="background:#ccc"><td>สถานที่จัดส่ง</td><td>สินค้าพร้อมส่ง</td><td>สั่งจอง</td></tr><tr><td>กรุงเทพฯ ปริมณฑล</td><td>10 วัน</td><td>35 วัน</td></tr><tr><td>ต่างจังหวัด*</td><td>20 วัน</td><td>45 วัน</td></tr></tbody></table><p>ฟรีค่าจัดส่ง<br/>*นอกเขตอำเภอเมือง ชำระค่าขนส่งเพิ่ม 500.- บาท</p>', 'Delivery Information - TH', 'ckeditor', 'Delivery Information', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(51, 'delivery_information_en', '<p><strong>Delivery Time</strong><br/>After payment</p><table border="0" cellpadding="1" cellspacing="1" style="width:500px"><tbody><tr style="background:#ccc"><td>Location</td><td>In Sto</td><td>Pre-ord</td></tr><tr><td>BKK &amp; Metro.</td><td>10 Days</td><td>35 Days</td></tr><tr><td>Up-country*</td><td>20 Days</td><td>45 Days</td></tr></tbody></table><p>Free shipping<br/>*Out of town, add 500.- Baht for shipping</p>', 'Delivery Information - EN', 'ckeditor', 'Delivery Information', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58');

INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`)
VALUES
	(52, 'warranty_condition_th', '<p><strong>เงื่อนไขการรับประกัน</strong><br />รับประกัน 10 ปี: ระบบกลไก<br />รับประกัน 5 ปี: โครงสร้่างไม้<br />รับประกัน 2 ปี: หนัง / ฟองน้ำ<br />รับประกัน 1 ปี: ผ้าและอุปกรณ์ไฟฟ้า</p>', 'Warranty Conditions - TH', 'ckeditor', 'Warranty Conditions', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(53, 'warranty_condition_en', '<p><strong>Warranty Conditions : (where applicable)</strong><br />10-Year Warranty: Recliner mechanism<br />5-Year Warranty: Frame<br />2-Year Warranty: Leather / Foam<br />1-Year Warranty: Fabric &amp; Electrical components</p>', 'Warranty Conditions - EN', 'ckeditor', 'Warranty Conditions', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58');

INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`)
VALUES
	(54, 'replacement_condition_th', '<p><strong>เงื่อนไขการเปลี่ยนสินค้า</strong><br />ภายใต้เงื่อนไขการรับประกัน กรณีที่เกิดปัญหาด้านคุณภาพของสินค้าใหม่ไม่เกิน 3 วัน</p><p>รายละเอียดเพิ่มเติม: 081-938-0118, 02-661-4941</p>', 'Replacement Conditions - TH', 'ckeditor', 'Replacement Conditions', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58'),
	(55, 'replacement_condition_en', '<p><strong>Replacement Conditions</strong><br />New product can only be replaced within 3 days if there is any quality problem, under product warranty conditions.</p><p>More details: 081-938-0118, 02-661-4941</p>', 'Replacement Conditions - EN', 'ckeditor', 'Replacement Conditions', 'website', '2019-03-26 10:16:58', '2019-03-26 10:16:58');

INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`, `param`)
VALUES
	(200, 'fos_registration_welcome_email_subject_th', 'ยินดีด้วย {first_name}, บัญชีของคุณถูกยืนยันแล้ว', 'Subject - TH', 'text', 'Registration Welcome Email Template', 'email', '2019-06-13 17:05:25', '2019-04-02 13:33:10', NULL),
	(201, 'fos_registration_welcome_email_message_th', '<p>สวัสดี {first_name}!<br />\r\n<br />\r\nด้วยความนับถือ,<br />\r\nLa-Z-Boy of Thailand</p>\r\n', 'Message - TH', 'textarea', 'Registration Welcome Email Template', 'email', '2019-06-13 17:06:44', '2019-04-02 13:33:10', 'a:3:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";}'),
	(210, 'fos_registration_welcome_email_subject_en', 'Congrats {first_name}, your account is now activated.', 'Subject -  EN', 'text', 'Registration Welcome Email Template', 'email', '2019-06-13 17:05:25', '2019-04-02 13:33:10', NULL),
	(211, 'fos_registration_welcome_email_message_en', '<p>Hello {first_name}!<br />\r\n<br />\r\nBest Regards,<br />\r\nLa-Z-Boy of Thailand</p>\r\n', 'Message -  EN', 'textarea', 'Registration Welcome Email Template', 'email', '2019-06-13 17:06:44', '2019-04-02 13:33:10', 'a:3:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";}');


--- update 13/08/2019 ---
INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`, `param`)
VALUES
(309, 'website_our_galleries_th', '<p>Just when you thought we couldn&rsquo;t possible make you any more comfortable&hellip;<br />\r\nAt our gallery, we want to make people to have a comfortable shopping experience for La-Z-Boy furniture as they are living with it.</p>\r\n', 'OUR GALLERIES - TH', 'ckeditor', 'OUR GALLERIES (Index Page)', 'website', '2019-08-13 07:10:10', '2019-03-26 10:16:58', NULL),
(310, 'website_our_galleries_en', '<p>Just when you thought we couldn&rsquo;t possible make you any more comfortable&hellip;<br />\r\nAt our gallery, we want to make people to have a comfortable shopping experience for La-Z-Boy furniture as they are living with it.</p>\r\n', 'OUR GALLERIES - EN', 'ckeditor', 'OUR GALLERIES (Index Page)', 'website', '2019-08-13 07:10:10', '2019-03-26 10:16:58', NULL),
(311, 'website_our_galleries_image', '/uploads/userfiles/images/home/galleries.jpg', 'OUR GALLERIES - Image', 'hidden', 'OUR GALLERIES (Index Page)', 'website', '2019-08-13 07:06:11', '2019-03-26 10:16:58', NULL),
(312, 'website_shop_locators_th', '<p>We have network of approximately 340 La-Z-Boy Furniture Galleries stores and over 560 Comfort Studio locations, of which the Company owns approximately 120 of the La-Z-Boy Furniture Galleries stores.</p>\r\n', 'SHOP LOCATORS - TH', 'ckeditor', 'SHOP LOCATORS (Index Page)', 'website', '2019-08-13 06:33:53', '2019-03-26 10:16:58', NULL),
(313, 'website_shop_locators_en', '<p>We have network of approximately 340 La-Z-Boy Furniture Galleries stores and over 560 Comfort Studio locations, of which the Company owns approximately 120 of the La-Z-Boy Furniture Galleries stores.</p>\r\n', 'SHOP LOCATORS - EN', 'ckeditor', 'SHOP LOCATORS (Index Page)', 'website', '2019-08-13 06:33:53', '2019-03-26 10:16:58', NULL),
(314, 'website_shop_locators_image', '/uploads/userfiles/images/home/shop-locator.jpg', 'SHOP LOCATORS - Image', 'hidden', 'SHOP LOCATORS (Index Page)', 'website', '2019-08-13 07:07:09', '2019-03-26 10:16:58', NULL);
