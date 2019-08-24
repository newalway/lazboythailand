INSERT INTO `product_option` (`id`, `price`, `image`, `status`, `position`, `updated_at`, `created_at`, `product_option_category_id`, `default_option`)
VALUES
	(1, NULL, '/uploads/userfiles/images/product_options/leg_rest/legrest_stnd.jpg', 1, 0, '2019-04-22 17:11:25', '2019-04-22 16:24:45', 1, 1),
	(2, NULL, '/uploads/userfiles/images/product_options/handle_options/handle_options_stnd.jpg', 1, 1, '2019-04-22 16:33:42', '2019-04-22 16:31:00', 2, 1),
	(3, 1880.00, '/uploads/userfiles/images/product_options/handle_options/icon_es.jpg', 1, 2, '2019-04-22 16:43:21', '2019-04-22 16:31:42', 2, 0),
	(4, 1880.00, '/uploads/userfiles/images/product_options/handle_options/icon_archandle.jpg', 1, 3, '2019-04-22 16:43:35', '2019-04-22 16:32:24', 2, 0),
	(5, 3500.00, '/uploads/userfiles/images/product_options/handle_options/icon_archandle-1.jpg', 1, 4, '2019-04-22 16:43:58', '2019-04-22 16:32:45', 2, 0),
	(6, 3500.00, '/uploads/userfiles/images/product_options/handle_options/icon_le.jpg', 1, 5, '2019-04-22 16:44:11', '2019-04-22 16:33:05', 2, 0),
	(7, 1880.00, '/uploads/userfiles/images/product_options/handle_options/icon_ls.jpg', 1, 6, '2019-04-22 16:44:30', '2019-04-22 16:33:21', 2, 0),
	(8, NULL, '/uploads/userfiles/images/product_options/finish_options/standard_finish.jpg', 1, 1, '2019-04-22 17:10:54', '2019-04-22 16:35:14', 3, 1),
	(9, NULL, '/uploads/userfiles/images/product_options/finish_options/icon_fn.jpg', 1, 2, '2019-04-22 17:10:54', '2019-04-22 16:35:59', 3, 0),
	(10, NULL, '/uploads/userfiles/images/product_options/base_options/baseoptions_stnd.jpg', 1, 1, '2019-04-22 17:10:24', '2019-04-22 16:36:47', 4, 1),
	(11, 4500.00, '/uploads/userfiles/images/product_options/base_options/icon_swivelbase.jpg', 1, 2, '2019-04-22 17:10:24', '2019-04-22 16:37:08', 4, 0),
	(12, NULL, '/uploads/userfiles/images/product_options/cushion_options/cushionoptions_Stnd.jpg', 1, 1, '2019-04-22 17:10:13', '2019-04-22 16:37:50', 5, 1),
	(13, 4500.00, '/uploads/userfiles/images/product_options/cushion_options/icon_memoryFoam_new.jpg', 1, 2, '2019-04-22 17:10:13', '2019-04-22 16:38:12', 5, 0);


INSERT INTO `product_option_translation` (`id`, `translatable_id`, `title`, `short_desc`, `locale`)
VALUES
	(1, 1, 'Standard Leg Rest', NULL, 'th'),
	(2, 1, 'Standard Leg Rest', NULL, 'en'),
	(3, 2, 'Standard Handle', NULL, 'th'),
	(4, 2, 'Standard Handle', NULL, 'en'),
	(5, 3, 'Elongated Handle', NULL, 'th'),
	(6, 3, 'Elongated Handle', NULL, 'en'),
	(7, 4, 'Arc Handle', NULL, 'th'),
	(8, 4, 'Arc Handle', NULL, 'en'),
	(9, 5, 'Arc Left Side Handle', NULL, 'th'),
	(10, 5, 'Arc Left Side Handle', NULL, 'en'),
	(11, 6, 'Left Elongated Handle', NULL, 'th'),
	(12, 6, 'Left Elongated Handle', NULL, 'en'),
	(13, 7, 'Left Side Handle', NULL, 'th'),
	(14, 7, 'Left Side Handle', NULL, 'en'),
	(15, 8, 'Standard Finish', 'Brown Mahogany', 'th'),
	(16, 8, 'Standard Finish', 'Brown Mahogany', 'en'),
	(17, 9, 'Optional Finishes', NULL, 'th'),
	(18, 9, 'Optional Finishes', NULL, 'en'),
	(19, 10, 'None', NULL, 'th'),
	(20, 10, 'None', NULL, 'en'),
	(21, 11, 'Swivel Base Ordered With Recliner', NULL, 'th'),
	(22, 11, 'Swivel Base Ordered With Recliner', NULL, 'en'),
	(23, 12, 'Standard Cushion', NULL, 'th'),
	(24, 12, 'Standard Cushion', NULL, 'en'),
	(25, 13, 'AirForm', NULL, 'th'),
	(26, 13, 'AirForm', NULL, 'en');