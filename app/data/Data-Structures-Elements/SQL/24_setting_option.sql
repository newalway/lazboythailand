INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`, `param`)
VALUES
(300, 'contact_phone', 				'02-3760118', 				'Phone', 	'text', 'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL),
(301, 'contact_fax', 				'02-3760119', 				'Fax', 		'text', 'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL),
(302, 'contact_email', 				'info@globizventure.com', 	'Email', 	'text', 'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL),
(303, 'contact_address_th', 		'2991/12 ถนนลาดพร้าว 101/3 แขวงคลองจั่น เขตบางกะปิ กทม. 10240',		'Address - TH',			'text',	'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL),
(304, 'contact_address_en', 		'2991/12 Ladprao 101/3 Road Klongjan, Bangkapi, Bangkok 10240',	'Address - EN',			'text',	'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL),
(305, 'contact_business_hours_th', 	'จ-ศ: 08:30 น. - 17:30 น.', 		'Business Hours - TH',	'text',	'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL),
(306, 'contact_business_hours_en', 	'Mn-Fr: 08:30 AM - 05:30 PM', 		'Business Hours - EN',	'text',	'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL),
(307, 'contact_map_latitude',		'13.775074', 	'Map Latitude',		'text', 'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL),
(308, 'contact_map_longitude',		'100.631832', 	'Map Longitude',	'text', 'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL);


INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`, `param`)
VALUES
	(220, 'order_status_paid_subject_th', 'Thanks for your payment', 'Subject - TH', 'text', 'Order Status Paid', 'email', '2019-08-07 17:41:58', '2019-08-06 09:05:00', NULL),
	(221, 'order_status_paid_message_th', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>Thank you for shopping with Lazboy. Please see below for the payment status in your order.</p>\r\n', 'Message - TH', 'textarea', 'Order Status Paid', 'email', '2019-08-07 17:41:58', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),
	(222, 'order_status_paid_subject_en', 'Thanks for your payment', 'Subject - EN', 'text', 'Order Status Paid', 'email', '2019-08-07 17:41:58', '2019-08-06 09:05:00', NULL),
	(223, 'order_status_paid_message_en', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>Thank you for shopping with Lazboy. Please see below for the payment status in your order.</p>\r\n', 'Message - EN', 'textarea', 'Order Status Paid', 'email', '2019-08-07 17:41:58', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),

	(224, 'order_status_shipped_subject_th', 'We\'ve just shipped your order', 'Subject - TH', 'text', 'Order Status Shipped', 'email', '2019-08-07 17:41:58', '2019-08-06 09:05:00', NULL),
	(225, 'order_status_shipped_message_th', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>The package with your order ID {order_number} has just left our warehouse and is on its way to you.</p>\r\n', 'Message - TH', 'textarea', 'Order Status Shipped', 'email', '2019-08-08 15:03:15', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),
	(226, 'order_status_shipped_subject_en', 'We\'ve just shipped your order', 'Subject - EN', 'text', 'Order Status Shipped', 'email', '2019-08-07 17:41:58', '2019-08-06 09:05:00', NULL),
	(227, 'order_status_shipped_message_en', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>The package with your order ID {order_number} has just left our warehouse and is on its way to you.</p>\r\n', 'Message - EN', 'textarea', 'Order Status Shipped', 'email', '2019-08-08 15:03:15', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),

	(228, 'order_status_delivered_subject_th', 'Shipment delivered', 'Subject - TH', 'text', 'Order Status Delivered', 'email', '2019-08-08 15:41:33', '2019-08-06 09:05:00', NULL),
	(229, 'order_status_delivered_message_th', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>Your order&nbsp;ID {order_number} has been delivered</p>\r\n', 'Message - TH', 'textarea', 'Order Status Delivered', 'email', '2019-08-08 17:25:04', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),
	(230, 'order_status_delivered_subject_en', 'Shipment delivered', 'Subject - EN', 'text', 'Order Status Delivered', 'email', '2019-08-08 15:41:33', '2019-08-06 09:05:00', NULL),
	(231, 'order_status_delivered_message_en', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>Your order&nbsp;ID {order_number} has been delivered</p>\r\n', 'Message - EN', 'textarea', 'Order Status Delivered', 'email', '2019-08-08 17:25:04', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),

	(232, 'order_status_cancelled_subject_th', 'Your order has been cancelled', 'Subject - TH', 'text', 'Order Status Cancelled', 'email', '2019-08-08 17:04:15', '2019-08-06 09:05:00', NULL),
	(233, 'order_status_cancelled_message_th', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>Your order&nbsp;ID {order_number} has been cancelled</p>\r\n', 'Message - TH', 'textarea', 'Order Status Cancelled', 'email', '2019-08-08 17:25:04', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),
	(234, 'order_status_cancelled_subject_en', 'Your order has been cancelled', 'Subject - EN', 'text', 'Order Status Cancelled', 'email', '2019-08-08 17:04:15', '2019-08-06 09:05:00', NULL),
	(235, 'order_status_cancelled_message_en', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>Your order&nbsp;ID {order_number} has been cancelled</p>\r\n', 'Message - EN', 'textarea', 'Order Status Cancelled', 'email', '2019-08-08 17:25:04', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),

	(236, 'order_status_refunded_subject_th', 'Your order has been refunded', 'Subject - TH', 'text', 'Order Status Refunded', 'email', '2019-08-08 17:24:31', '2019-08-06 09:05:00', NULL),
	(237, 'order_status_refunded_message_th', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>Your order&nbsp;ID {order_number} has been refunded</p>\r\n', 'Message - TH', 'textarea', 'Order Status Refunded', 'email', '2019-08-08 17:25:04', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}'),
	(238, 'order_status_refunded_subject_en', 'Your order has been refunded', 'Subject - EN', 'text', 'Order Status Refunded', 'email', '2019-08-08 17:24:31', '2019-08-06 09:05:00', NULL),
	(239, 'order_status_refunded_message_en', '<p>Hello {first_name} {last_name},</p>\r\n\r\n<p>Your order&nbsp;ID {order_number} has been refunded</p>\r\n', 'Message - EN', 'textarea', 'Order Status Refunded', 'email', '2019-08-08 17:25:04', '2019-08-06 09:05:00', 'a:4:{i:0;s:7:\"{email}\";i:1;s:12:\"{first_name}\";i:2;s:11:\"{last_name}\";i:3;s:14:\"{order_number}\";}');

INSERT INTO `setting_option` (`id`, `option_name`, `option_value`, `option_title`, `option_type`, `group_type`, `cat_type`, `updated_at`, `created_at`, `param`)
VALUES
(299, 'contact_icon_phone', 				'02-3760118', 				'Phone Icon Number', 	'text', 'Contacts', 'website', '2019-06-28 17:05:25', '2019-06-28 17:05:25', NULL);
