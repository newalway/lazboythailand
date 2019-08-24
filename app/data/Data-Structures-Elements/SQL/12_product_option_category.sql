INSERT INTO `product_option_category` (`id`, `image`, `position`, `updated_at`, `created_at`, `status`)
VALUES
	(1, '/uploads/userfiles/images/product_options/legrest_stnd.jpg', 1, '2019-02-27 09:59:55', '2019-02-25 11:36:43', 1),
	(2, '/uploads/userfiles/images/product_options/handleoptions_stnd.jpg', 2, '2019-02-27 09:59:55', '2019-02-25 11:54:18', 1),
	(3, '/uploads/userfiles/images/product_options/finish_options_stnd.jpg', 3, '2019-02-27 09:59:55', '2019-02-25 12:04:05', 1),
	(4, '/uploads/userfiles/images/product_options/baseoptions_stnd.jpg', 4, '2019-02-27 09:59:55', '2019-02-25 12:04:37', 1),
	(5, '/uploads/userfiles/images/product_options/cushion_options.jpg', 5, '2019-04-22 16:16:33', '2019-02-25 12:05:03', 1);

INSERT INTO `product_option_category_translation` (`id`, `translatable_id`, `title`, `short_desc`, `locale`)
VALUES
	(1, 1, 'Leg Rest', 'Standard Leg Rest', 'th'),
	(2, 1, 'Leg Rest', 'Standard Leg Rest', 'en'),
	(3, 2, 'Handle Options', 'Standard Handle', 'th'),
	(4, 2, 'Handle Options', 'Standard Handle', 'en'),
	(5, 3, 'Finish Options', 'Standard Finish', 'th'),
	(6, 3, 'Finish Options', 'Standard Finish', 'en'),
	(7, 4, 'Base Options', 'None', 'th'),
	(8, 4, 'Base Options', 'None', 'en'),
	(9, 5, 'Cushion Options', 'Standard Cushion', 'th'),
	(10, 5, 'Cushion Options', 'Standard Cushion', 'en');
