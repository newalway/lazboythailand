INSERT INTO `product_category` (`id`, `tree_root`, `parent_id`, `lft`, `lvl`, `rgt`, `slug`, `category_code`, `pattern_image`, `pattern_image_small`, `pattern_image_medium`, `pattern_image_large`, `is_only_gallery`)
VALUES
	(1, 1, NULL, 1, 0, 110, 'products', NULL, NULL, NULL, NULL, NULL, 0),
	(2, 1, 1, 2, 1, 23, 'recliners', NULL, NULL, NULL, NULL, NULL, 0),
	(3, 1, 1, 24, 1, 35, 'loveseat', NULL, NULL, NULL, NULL, NULL, 0),
	(4, 1, 1, 36, 1, 55, 'sofa', NULL, NULL, NULL, NULL, NULL, 0),
	(5, 1, 1, 56, 1, 71, 'home-theater', NULL, NULL, NULL, NULL, NULL, 0),
	(6, 1, 1, 72, 1, 77, 'armchairs-ottomans', NULL, NULL, NULL, NULL, NULL, 0),
	(7, 1, 1, 78, 1, 83, 'sectionals', NULL, NULL, NULL, NULL, NULL, 0),
	(8, 1, 1, 84, 1, 101, 'collections', NULL, NULL, NULL, NULL, NULL, 0),
	(9, 1, 1, 102, 1, 109, 'home-accents', NULL, NULL, NULL, NULL, NULL, 0),
	(10, 1, 2, 3, 2, 12, 'recliners', NULL, NULL, NULL, NULL, NULL, 0),
	(11, 1, 2, 13, 2, 22, 'power-recliners', NULL, NULL, NULL, NULL, NULL, 0),
	(12, 1, 3, 25, 2, 30, 'love-seat', NULL, NULL, NULL, NULL, NULL, 0),
	(13, 1, 3, 31, 2, 34, 'power-loveseat', NULL, NULL, NULL, NULL, NULL, 0),
	(14, 1, 4, 37, 2, 46, 'sofa', NULL, NULL, NULL, NULL, NULL, 0),
	(15, 1, 4, 47, 2, 54, 'power-sofa', NULL, NULL, NULL, NULL, NULL, 0),
	(16, 1, 5, 57, 2, 64, 'home-theater', NULL, NULL, NULL, NULL, NULL, 0),
	(17, 1, 5, 65, 2, 70, 'power-theater', NULL, NULL, NULL, NULL, NULL, 0),
	(18, 1, 6, 73, 2, 74, 'armchairs-23t', NULL, NULL, NULL, NULL, NULL, 0),
	(19, 1, 6, 75, 2, 76, 'ottomans-24t', NULL, NULL, NULL, NULL, NULL, 0),
	(20, 1, 7, 79, 2, 80, 'reclining-sectionals', NULL, NULL, NULL, NULL, NULL, 0),
	(21, 1, 7, 81, 2, 82, 'stationary-sectionals', NULL, NULL, NULL, NULL, NULL, 0),
	(22, 1, 8, 85, 2, 92, 'shop-by', NULL, NULL, NULL, NULL, NULL, 0),
	(23, 1, 8, 93, 2, 100, 'collections', NULL, NULL, NULL, NULL, NULL, 0),
	(24, 1, 9, 103, 2, 104, 'lamps', NULL, NULL, NULL, NULL, NULL, 0),
	(25, 1, 10, 4, 3, 5, 'rocking-recliner-10t', NULL, NULL, NULL, NULL, NULL, 0),
	(26, 1, 10, 6, 3, 7, 'wall-recliner-16t', NULL, NULL, NULL, NULL, NULL, 0),
	(27, 1, 10, 8, 3, 9, 'high-leg-29t', NULL, NULL, NULL, NULL, NULL, 0),
	(28, 1, 10, 10, 3, 11, 'nordic-recliner', NULL, NULL, NULL, NULL, NULL, 0),
	(29, 1, 11, 14, 3, 15, 'power-rocking-recliner-1pt', NULL, NULL, NULL, NULL, NULL, 0),
	(30, 1, 11, 16, 3, 17, 'power-wall-recliner-16p', NULL, NULL, NULL, NULL, NULL, 0),
	(31, 1, 11, 18, 3, 19, 'power-rocking-recliner-w-head-rest-and-lumbar-1ht', NULL, NULL, NULL, NULL, NULL, 0),
	(32, 1, 11, 20, 3, 21, 'power-lift-recliner-tpl-tbr', NULL, NULL, NULL, NULL, NULL, 0),
	(33, 1, 12, 26, 3, 27, 'reclining-loveseat-t32', NULL, NULL, NULL, NULL, NULL, 0),
	(34, 1, 12, 28, 3, 29, 'stationary-loveseat-63t', NULL, NULL, NULL, NULL, NULL, 0),
	(35, 1, 13, 32, 3, 33, 'power-reclining-loveseat-p32', NULL, NULL, NULL, NULL, NULL, 0),
	(36, 1, 14, 38, 3, 39, 'reclining-sofa-t33', NULL, NULL, NULL, NULL, NULL, 0),
	(37, 1, 14, 40, 3, 41, 'reclining-sofa-with-dropdown-table-t35', NULL, NULL, NULL, NULL, NULL, 0),
	(38, 1, 14, 42, 3, 43, 'stationary-sofa-61t', NULL, NULL, NULL, NULL, NULL, 0),
	(39, 1, 14, 44, 3, 45, 'sleep-sofa-t55-t51', NULL, NULL, NULL, NULL, NULL, 0),
	(40, 1, 15, 48, 3, 49, 'power-reclining-sofa-p33', NULL, NULL, NULL, NULL, NULL, 0),
	(41, 1, 15, 50, 3, 51, 'power-reclining-sofa-with-dropdown-table-p35', NULL, NULL, NULL, NULL, NULL, 0),
	(42, 1, 15, 52, 3, 53, 'duo-product', NULL, NULL, NULL, NULL, NULL, 0),
	(43, 1, 16, 58, 3, 59, 'reclining-loveseat-home-theater-t39', NULL, NULL, NULL, NULL, NULL, 0),
	(44, 1, 16, 60, 3, 61, 'rocking-reclining-loveseat-home-theater-04t', NULL, NULL, NULL, NULL, NULL, 0),
	(45, 1, 16, 62, 3, 63, 'home-theater-sectionals', NULL, NULL, NULL, NULL, NULL, 0),
	(46, 1, 17, 66, 3, 67, 'power-reclining-loveseat-home-theater-p39', NULL, NULL, NULL, NULL, NULL, 0),
	(47, 1, 17, 68, 3, 69, 'power-rocking-reclining-loveseat-home-theater-4pt', NULL, NULL, NULL, NULL, NULL, 0),
	(48, 1, 22, 86, 3, 87, 'new', NULL, NULL, NULL, NULL, NULL, 0),
	(49, 1, 22, 88, 3, 89, 'best-sellers', NULL, NULL, NULL, NULL, NULL, 0),
	(50, 1, 22, 90, 3, 91, 'sale', NULL, NULL, NULL, NULL, NULL, 0),
	(51, 1, 23, 94, 3, 95, 'urban-attitudes', NULL, NULL, NULL, NULL, NULL, 0),
	(52, 1, 23, 96, 3, 97, 'minimal', NULL, NULL, NULL, NULL, NULL, 0),
	(53, 1, 23, 98, 3, 99, 'signature', NULL, NULL, NULL, NULL, NULL, 0),
	(54, 1, 9, 105, 2, 106, 'tables', NULL, NULL, NULL, NULL, NULL, 0),
	(55, 1, 9, 107, 2, 108, 'pillows', NULL, NULL, NULL, NULL, NULL, 0);

INSERT INTO `product_category_translation` (`id`, `translatable_id`, `title`, `locale`, `description`)
VALUES
	(1, 1, 'Products', 'en', NULL),
	(2, 1, 'สินค้า', 'th', NULL),
	(3, 2, 'Recliners', 'en', NULL),
	(4, 2, 'Recliners', 'th', NULL),
	(5, 3, 'Loveseat', 'en', NULL),
	(6, 3, 'Loveseat', 'th', NULL),
	(7, 4, 'Sofa', 'en', NULL),
	(8, 4, 'Sofa', 'th', NULL),
	(9, 5, 'Home Theater', 'en', NULL),
	(10, 5, 'Home Theater', 'th', NULL),
	(11, 6, 'Armchairs & Ottomans', 'en', NULL),
	(12, 6, 'Armchairs & Ottomans', 'th', NULL),
	(13, 7, 'Sectionals', 'en', NULL),
	(14, 7, 'Sectionals', 'th', NULL),
	(15, 8, 'Collections', 'en', NULL),
	(16, 8, 'Collections', 'th', NULL),
	(17, 9, 'Home Accents', 'en', NULL),
	(18, 9, 'Home Accents', 'th', NULL),
	(19, 10, 'Recliners', 'en', NULL),
	(20, 10, 'Recliners', 'th', NULL),
	(21, 11, 'Power Recliners', 'en', NULL),
	(22, 11, 'Power Recliners', 'th', NULL),
	(23, 12, 'Love seat', 'en', NULL),
	(24, 12, 'Love seat', 'th', NULL),
	(25, 13, 'Power Loveseat', 'en', NULL),
	(26, 13, 'Power Loveseat', 'th', NULL),
	(27, 14, 'Sofa', 'en', NULL),
	(28, 14, 'Sofa', 'th', NULL),
	(29, 15, 'Power Sofa', 'en', NULL),
	(30, 15, 'Power Sofa', 'th', NULL),
	(31, 16, 'Home Theater', 'en', NULL),
	(32, 16, 'Home Theater', 'th', NULL),
	(33, 17, 'Power Theater', 'en', NULL),
	(34, 17, 'Power Theater', 'th', NULL),
	(35, 18, 'Armchairs (23T)', 'en', NULL),
	(36, 18, 'Armchairs (23T)', 'th', NULL),
	(37, 19, 'Ottomans (24T)', 'en', NULL),
	(38, 19, 'Ottomans (24T)', 'th', NULL),
	(39, 20, 'Reclining Sectionals', 'en', NULL),
	(40, 20, 'Reclining Sectionals', 'th', NULL),
	(41, 21, 'Stationary Sectionals', 'en', NULL),
	(42, 21, 'Stationary Sectionals', 'th', NULL),
	(43, 22, 'Shop By', 'en', NULL),
	(44, 22, 'Shop By', 'th', NULL),
	(45, 23, 'Collections', 'en', NULL),
	(46, 23, 'Collections', 'th', NULL),
	(47, 24, 'Lamps', 'en', NULL),
	(48, 24, 'Lamps', 'th', NULL),
	(49, 25, 'Rocking Recliner (10T)', 'en', NULL),
	(50, 25, 'Rocking Recliner (10T)', 'th', NULL),
	(51, 26, 'Wall Recliner ( 16T)', 'en', NULL),
	(52, 26, 'Wall Recliner ( 16T)', 'th', NULL),
	(53, 27, 'High leg (29T)', 'en', NULL),
	(54, 27, 'High leg (29T)', 'th', NULL),
	(55, 28, 'Nordic Recliner', 'en', NULL),
	(56, 28, 'Nordic Recliner', 'th', NULL),
	(57, 29, 'Power Rocking Recliner (1PT)', 'en', NULL),
	(58, 29, 'Power Rocking Recliner (1PT)', 'th', NULL),
	(59, 30, 'Power Wall Recliner (16P)', 'en', NULL),
	(60, 30, 'Power Wall Recliner (16P)', 'th', NULL),
	(61, 31, 'Power rocking recliner w/ Head Rest and Lumbar (1HT)', 'en', NULL),
	(62, 31, 'Power rocking recliner w/ Head Rest and Lumbar (1HT)', 'th', NULL),
	(63, 32, 'Power Lift Recliner (TPL/TBR)', 'en', NULL),
	(64, 32, 'Power Lift Recliner (TPL/TBR)', 'th', NULL),
	(65, 33, 'Reclining Loveseat (T32)', 'en', NULL),
	(66, 33, 'Reclining Loveseat (T32)', 'th', NULL),
	(67, 34, 'Stationary Loveseat ( 63T)', 'en', NULL),
	(68, 34, 'Stationary Loveseat ( 63T)', 'th', NULL),
	(69, 35, 'Power Reclining Loveseat (P32)', 'en', NULL),
	(70, 35, 'Power Reclining Loveseat (P32)', 'th', NULL),
	(71, 36, 'Reclining Sofa (T33)', 'en', NULL),
	(72, 36, 'Reclining Sofa (T33)', 'th', NULL),
	(73, 37, 'Reclining Sofa with dropdown Table (T35)', 'en', NULL),
	(74, 37, 'Reclining Sofa with dropdown Table (T35)', 'th', NULL),
	(75, 38, 'Stationary Sofa (61T)', 'en', NULL),
	(76, 38, 'Stationary Sofa (61T)', 'th', NULL),
	(77, 39, 'Sleep sofa (T55/T51)', 'en', NULL),
	(78, 39, 'Sleep sofa (T55/T51)', 'th', NULL),
	(79, 40, 'Power Reclining Sofa (P33)', 'en', NULL),
	(80, 40, 'Power Reclining Sofa (P33)', 'th', NULL),
	(81, 41, 'Power reclining Sofa with dropdown table (P35)', 'en', NULL),
	(82, 41, 'Power reclining Sofa with dropdown table (P35)', 'th', NULL),
	(83, 42, 'Duo product', 'en', NULL),
	(84, 42, 'Duo product', 'th', NULL),
	(85, 43, 'Reclining loveseat Home Theater (T39)', 'en', NULL),
	(86, 43, 'Reclining loveseat Home Theater (T39)', 'th', NULL),
	(87, 44, 'Rocking Reclining Loveseat Home Theater (04T)', 'en', NULL),
	(88, 44, 'Rocking Reclining Loveseat Home Theater (04T)', 'th', NULL),
	(89, 45, 'Home Theater Sectionals', 'en', NULL),
	(90, 45, 'Home Theater Sectionals', 'th', NULL),
	(91, 46, 'Power Reclining Loveseat Home Theater (P39)', 'en', NULL),
	(92, 46, 'Power Reclining Loveseat Home Theater (P39)', 'th', NULL),
	(93, 47, 'Power Rocking Reclining Loveseat Home Theater (4PT)', 'en', NULL),
	(94, 47, 'Power Rocking Reclining Loveseat Home Theater (4PT)', 'th', NULL),
	(95, 48, 'New', 'en', NULL),
	(96, 48, 'New', 'th', NULL),
	(97, 49, 'Best sellers', 'en', NULL),
	(98, 49, 'Best sellers', 'th', NULL),
	(99, 50, 'Sale', 'en', NULL),
	(100, 50, 'Sale', 'th', NULL),
	(101, 51, 'Urban attitudes', 'en', NULL),
	(102, 51, 'Urban attitudes', 'th', NULL),
	(103, 52, 'Minimal', 'en', NULL),
	(104, 52, 'Minimal', 'th', NULL),
	(105, 53, 'Signature', 'en', NULL),
	(106, 53, 'Signature', 'th', NULL),
	(107, 54, 'Tables', 'en', NULL),
	(108, 54, 'Tables', 'th', NULL),
	(109, 55, 'Pillows', 'en', NULL),
	(110, 55, 'Pillows', 'th', NULL);






INSERT INTO `product_category` (`id`, `tree_root`, `parent_id`, `lft`, `lvl`, `rgt`, `slug`, `category_code`, `pattern_image`, `pattern_image_small`, `pattern_image_medium`, `pattern_image_large`, `is_only_gallery`)
VALUES
	(56, 56, NULL, 1, 0, 142, 'variant', NULL, NULL, NULL, NULL, NULL, 0),
	(57, 56, 56, 2, 1, 45, 'full-leather', NULL, NULL, NULL, NULL, NULL, 0),
	(58, 56, 56, 46, 1, 75, 'half-leather', NULL, NULL, NULL, NULL, NULL, 0),
	(59, 56, 56, 76, 1, 141, 'fabric-iclean', NULL, NULL, NULL, NULL, NULL, 0),
	(60, 56, 57, 3, 2, 6, 'gl', 'GL', NULL, NULL, NULL, NULL, 0),
	(61, 56, 57, 17, 2, 34, 'xl-daver-color', 'XL', NULL, NULL, NULL, NULL, 0),
	(62, 56, 57, 7, 2, 16, 'fl', 'FL', NULL, NULL, NULL, NULL, 0),
	(63, 56, 58, 47, 2, 74, 'em', 'EM', NULL, NULL, NULL, NULL, 0),
	(64, 56, 59, 77, 2, 84, 'c-i-flannigan', 'C', NULL, NULL, NULL, NULL, 0),
	(65, 56, 59, 85, 2, 90, 'c-i-aldrich', 'C', NULL, NULL, NULL, NULL, 0),
	(66, 56, 60, 4, 3, 5, 'vino', '827709', '/uploads/userfiles/images/cover/gl/gl_vino.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/gl/gl_vino.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/gl/gl_vino.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/gl/gl_vino.jpg', 0),
	(67, 56, 62, 8, 3, 9, 'tan', '515340', '/uploads/userfiles/images/cover/fl/fl_tan.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fl/fl_tan.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fl/fl_tan.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fl/fl_tan.jpg', 0),
	(68, 56, 62, 10, 3, 11, 'cognac', '515374', '/uploads/userfiles/images/cover/fl/fl_cognac.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fl/fl_cognac.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fl/fl_cognac.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fl/fl_cognac.jpg', 0),
	(69, 56, 62, 12, 3, 13, 'maple', '515376', '/uploads/userfiles/images/cover/fl/fl_maple.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fl/fl_maple.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fl/fl_maple.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fl/fl_maple.jpg', 0),
	(70, 56, 62, 14, 3, 15, 'chocolate', '515377', '/uploads/userfiles/images/cover/fl/fl_chocolate.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fl/fl_chocolate.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fl/fl_chocolate.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fl/fl_chocolate.jpg', 0),
	(71, 56, 61, 18, 3, 19, 'sunset', '528715', '/uploads/userfiles/images/cover/xl_daver/xl_sunset.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl_daver/xl_sunset.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl_daver/xl_sunset.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl_daver/xl_sunset.jpg', 0),
	(72, 56, 61, 20, 3, 21, 'deep-sage', '528715', '/uploads/userfiles/images/cover/xl_daver/xl_deep_sage.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl_daver/xl_deep_sage.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl_daver/xl_deep_sage.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl_daver/xl_deep_sage.jpg', 0),
	(73, 56, 61, 22, 3, 23, 'sunbrust', '528745', '/uploads/userfiles/images/cover/xl_daver/xl_sunburst.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl_daver/xl_sunburst.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl_daver/xl_sunburst.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl_daver/xl_sunburst.jpg', 0),
	(74, 56, 61, 24, 3, 25, 'sea-glass', '528780', '/uploads/userfiles/images/cover/xl_daver/xl_sea_glass.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl_daver/xl_sea_glass.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl_daver/xl_sea_glass.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl_daver/xl_sea_glass.jpg', 0),
	(75, 56, 61, 26, 3, 27, 'pewter', '528756', '/uploads/userfiles/images/cover/xl_daver/xl_pewter.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl_daver/xl_pewter.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl_daver/xl_pewter.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl_daver/xl_pewter.jpg', 1),
	(76, 56, 61, 28, 3, 29, 'lead-grey', '528754', '/uploads/userfiles/images/cover/xl_daver/xl_lead_grey.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl_daver/xl_lead_grey.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl_daver/xl_lead_grey.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl_daver/xl_lead_grey.jpg', 1),
	(77, 56, 61, 30, 3, 31, 'jet-black', '528750', '/uploads/userfiles/images/cover/xl_daver/xl_jet_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl_daver/xl_jet_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl_daver/xl_jet_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl_daver/xl_jet_black.jpg', 1),
	(78, 56, 61, 32, 3, 33, 'sienna', '528776', '/uploads/userfiles/images/cover/xl_daver/xl_sienna.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl_daver/xl_sienna.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl_daver/xl_sienna.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl_daver/xl_sienna.jpg', 1),
	(79, 56, 63, 48, 3, 49, 'cloud', '714832', '/uploads/userfiles/images/cover/em/em_cloud.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_cloud.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_cloud.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_cloud.jpg', 0),
	(80, 56, 63, 50, 3, 51, 'mushroom', '714838', '/uploads/userfiles/images/cover/em/em_mushroom.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_mushroom.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_mushroom.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_mushroom.jpg', 0),
	(81, 56, 63, 52, 3, 53, 'black', '714850', '/uploads/userfiles/images/cover/em/em_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_black.jpg', 0),
	(82, 56, 63, 54, 3, 55, 'pebble', '714857', '/uploads/userfiles/images/cover/em/em_pebble.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_pebble.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_pebble.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_pebble.jpg', 0),
	(83, 56, 63, 56, 3, 57, 'chestnut', '714874', '/uploads/userfiles/images/cover/em/em_chestnut.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_chestnut.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_chestnut.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_chestnut.jpg', 0),
	(84, 56, 63, 58, 3, 59, 'mocca', '714877', '/uploads/userfiles/images/cover/em/em_mocca.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_mocca.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_mocca.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_mocca.jpg', 0),
	(85, 56, 63, 60, 3, 61, 'claret', '714889', '/uploads/userfiles/images/cover/em/em_claret.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_claret.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_claret.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_claret.jpg', 0),
	(86, 56, 63, 62, 3, 63, 'wine', '714808', '/uploads/userfiles/images/cover/em/em_wine.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_wine.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_wine.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_wine.jpg', 0),
	(87, 56, 63, 64, 3, 65, 'dast', '714830', '/uploads/userfiles/images/cover/em/em_dash.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_dash.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_dash.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_dash.jpg', 0),
	(88, 56, 63, 66, 3, 67, 'stone', '714834', '/uploads/userfiles/images/cover/em/em_stone.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_stone.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_stone.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_stone.jpg', 0),
	(89, 56, 63, 68, 3, 69, 'smoke', '714855', '/uploads/userfiles/images/cover/em/em_smoke.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_smoke.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_smoke.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_smoke.jpg', 0),
	(90, 56, 63, 70, 3, 71, 'fango', '714872', '/uploads/userfiles/images/cover/em/em_fango.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_fango.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_fango.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_fango.jpg', 0),
	(91, 56, 63, 72, 3, 73, 'deep', '714886', '/uploads/userfiles/images/cover/em/em_deep.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/em/em_deep.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/em/em_deep.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/em/em_deep.jpg', 0),
	(92, 56, 59, 91, 2, 98, 'c-i-sun-dance', 'C', NULL, NULL, NULL, NULL, 0),
	(93, 56, 59, 99, 2, 106, 'd-i-buzz', 'D', NULL, NULL, NULL, NULL, 0),
	(94, 56, 59, 107, 2, 116, 'd-i-densmore', 'D', NULL, NULL, NULL, NULL, 0),
	(95, 56, 59, 117, 2, 124, 'd-i-polo-club', 'D', NULL, NULL, NULL, NULL, 0),
	(96, 56, 59, 125, 2, 132, 'd-i-alexa', 'D', NULL, NULL, NULL, NULL, 0),
	(97, 56, 59, 133, 2, 140, 'c-i-prescott', 'C', NULL, NULL, NULL, NULL, 0),
	(98, 56, 64, 78, 3, 79, 'slate', '142654', '/uploads/userfiles/images/cover/fabric_iflannigan/mf_slate.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_iflannigan/mf_slate.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_iflannigan/mf_slate.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_iflannigan/mf_slate.jpg', 0),
	(99, 56, 64, 80, 3, 81, 'fudge', '142678', '/uploads/userfiles/images/cover/fabric_iflannigan/mf_fudge.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_iflannigan/mf_fudge.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_iflannigan/mf_fudge.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_iflannigan/mf_fudge.jpg', 0),
	(100, 56, 64, 82, 3, 83, 'midnight', '142687', '/uploads/userfiles/images/cover/fabric_iflannigan/mf_midnight.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_iflannigan/mf_midnight.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_iflannigan/mf_midnight.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_iflannigan/mf_midnight.jpg', 0),
	(101, 56, 65, 86, 3, 87, 'lead', '142957', '/uploads/userfiles/images/cover/fabric_ialdrich/mf_lead.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_ialdrich/mf_lead.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_ialdrich/mf_lead.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_ialdrich/mf_lead.jpg', 0),
	(102, 56, 65, 88, 3, 89, 'barley', '142974', '/uploads/userfiles/images/cover/fabric_ialdrich/mf_barley.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_ialdrich/mf_barley.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_ialdrich/mf_barley.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_ialdrich/mf_barley.jpg', 0),
	(103, 56, 92, 92, 3, 93, 'vermilion', '143008', '/uploads/userfiles/images/cover/fabric_isun_dance/mf_vermillion.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_isun_dance/mf_vermillion.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_isun_dance/mf_vermillion.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_isun_dance/mf_vermillion.jpg', 0),
	(104, 56, 92, 94, 3, 95, 'silt', '143075', '/uploads/userfiles/images/cover/fabric_isun_dance/mf_silt.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_isun_dance/mf_silt.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_isun_dance/mf_silt.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_isun_dance/mf_silt.jpg', 0),
	(105, 56, 92, 96, 3, 97, 'sable', '143078', '/uploads/userfiles/images/cover/fabric_isun_dance/mf_sable.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_isun_dance/mf_sable.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_isun_dance/mf_sable.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_isun_dance/mf_sable.jpg', 0),
	(106, 56, 93, 100, 3, 101, 'crimson', '144006', '/uploads/userfiles/images/cover/fabric_ibuzz/mf_crimson.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_ibuzz/mf_crimson.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_ibuzz/mf_crimson.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_ibuzz/mf_crimson.jpg', 0),
	(107, 56, 93, 102, 3, 103, 'truffle', '144057', '/uploads/userfiles/images/cover/fabric_ibuzz/mf_truffle.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_ibuzz/mf_truffle.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_ibuzz/mf_truffle.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_ibuzz/mf_truffle.jpg', 0),
	(108, 56, 93, 104, 3, 105, 'twilight', '144073', '/uploads/userfiles/images/cover/fabric_ibuzz/mf_twilight.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/fabric_ibuzz/mf_twilight.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/fabric_ibuzz/mf_twilight.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/fabric_ibuzz/mf_twilight.jpg', 0),
	(109, 56, 94, 108, 3, 109, 'vermilion', NULL, NULL, NULL, NULL, NULL, 0),
	(110, 56, 94, 110, 3, 111, 'quartz', NULL, NULL, NULL, NULL, NULL, 0),
	(111, 56, 94, 112, 3, 113, 'chocolate', NULL, NULL, NULL, NULL, NULL, 0),
	(112, 56, 94, 114, 3, 115, 'nautical', NULL, NULL, NULL, NULL, NULL, 0),
	(113, 56, 95, 118, 3, 119, 'teak', NULL, NULL, NULL, NULL, NULL, 1),
	(114, 56, 95, 120, 3, 121, 'toast', NULL, NULL, NULL, NULL, NULL, 1),
	(115, 56, 95, 122, 3, 123, 'kohl', NULL, NULL, NULL, NULL, NULL, 1),
	(116, 56, 96, 126, 3, 127, 'fiesta', NULL, NULL, NULL, NULL, NULL, 1),
	(117, 56, 96, 128, 3, 129, 'whisper', NULL, NULL, NULL, NULL, NULL, 1),
	(118, 56, 96, 130, 3, 131, 'seaspray', NULL, NULL, NULL, NULL, NULL, 1),
	(119, 56, 97, 134, 3, 135, 'scarlet', NULL, NULL, NULL, NULL, NULL, 1),
	(120, 56, 97, 136, 3, 137, 'graphite', NULL, NULL, NULL, NULL, NULL, 1),
	(121, 56, 97, 138, 3, 139, 'navy', '', NULL, NULL, NULL, NULL, 1),
	(131, 56, 57, 35, 2, 44, 'xl', 'XL', NULL, NULL, NULL, NULL, 0),
	(132, 56, 131, 36, 3, 37, 'red', '889103', '/uploads/userfiles/images/cover/xl/xl_red.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl/xl_red.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl/xl_red.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl/xl_red.jpg', 0),
	(133, 56, 131, 38, 3, 39, 'merlot', '889109', '/uploads/userfiles/images/cover/xl/xl_merlot.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl/xl_merlot.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl/xl_merlot.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl/xl_merlot.jpg', 0),
	(134, 56, 131, 40, 3, 41, 'earth', '889136', '/uploads/userfiles/images/cover/xl/xl_earth.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl/xl_earth.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl/xl_earth.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl/xl_earth.jpg', 0),
	(135, 56, 131, 42, 3, 43, 'black', '889150', '/uploads/userfiles/images/cover/xl/xl_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_small/uploads/userfiles/images/cover/xl/xl_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_medium/uploads/userfiles/images/cover/xl/xl_black.jpg', '//lazboythailand.secure.dev/uploads/cache/img_product_cat_large/uploads/userfiles/images/cover/xl/xl_black.jpg', 0);

INSERT INTO `product_category_translation` (`id`, `translatable_id`, `title`, `locale`, `description`)
VALUES
	(111, 56, 'Variant', 'en', NULL),
	(112, 56, 'Variant', 'th', NULL),
	(113, 57, 'หนัง', 'th', NULL),
	(114, 57, 'Full Leather', 'en', NULL),
	(115, 58, 'Half Leather', 'th', NULL),
	(116, 58, 'Half Leather', 'en', NULL),
	(117, 59, 'Fabric (iClean)', 'th', NULL),
	(118, 59, 'Fabric (iClean)', 'en', NULL),
	(119, 60, 'GL', 'th', NULL),
	(120, 60, 'GL', 'en', NULL),
	(121, 61, 'XL - Daver Color', 'th', NULL),
	(122, 61, 'XL - Daver Color', 'en', NULL),
	(123, 62, 'FL', 'th', NULL),
	(124, 62, 'FL', 'en', NULL),
	(125, 63, 'EM', 'th', NULL),
	(126, 63, 'EM', 'en', NULL),
	(127, 64, 'C (I-Flannigan)', 'th', NULL),
	(128, 64, 'C (I-Flannigan)', 'en', NULL),
	(129, 65, 'C (I-Aldrich)', 'th', NULL),
	(130, 65, 'C (I-Aldrich)', 'en', NULL),
	(131, 66, 'Vino', 'th', NULL),
	(132, 66, 'Vino', 'en', NULL),
	(133, 67, 'Tan', 'th', NULL),
	(134, 67, 'Tan', 'en', NULL),
	(135, 68, 'Cognac', 'th', NULL),
	(136, 68, 'Cognac', 'en', NULL),
	(137, 69, 'Maple', 'th', NULL),
	(138, 69, 'Maple', 'en', NULL),
	(139, 70, 'Chocolate', 'th', NULL),
	(140, 70, 'Chocolate', 'en', NULL),
	(141, 71, 'Sunset', 'th', NULL),
	(142, 71, 'Sunset', 'en', NULL),
	(143, 72, 'Deep sage', 'th', NULL),
	(144, 72, 'Deep sage', 'en', NULL),
	(145, 73, 'Sunbrust', 'th', NULL),
	(146, 73, 'Sunbrust', 'en', NULL),
	(147, 74, 'Sea Glass', 'th', NULL),
	(148, 74, 'Sea Glass', 'en', NULL),
	(149, 75, 'Pewter', 'th', NULL),
	(150, 75, 'Pewter', 'en', NULL),
	(151, 76, 'Lead grey', 'th', NULL),
	(152, 76, 'Lead grey', 'en', NULL),
	(153, 77, 'Jet Black', 'th', NULL),
	(154, 77, 'Jet Black', 'en', NULL),
	(155, 78, 'Sienna', 'th', NULL),
	(156, 78, 'Sienna', 'en', NULL),
	(157, 79, 'Cloud', 'th', NULL),
	(158, 79, 'Cloud', 'en', NULL),
	(159, 80, 'Mushroom', 'th', NULL),
	(160, 80, 'Mushroom', 'en', NULL),
	(161, 81, 'Black', 'th', NULL),
	(162, 81, 'Black', 'en', NULL),
	(163, 82, 'Pebble', 'th', NULL),
	(164, 82, 'Pebble', 'en', NULL),
	(165, 83, 'Chestnut', 'th', NULL),
	(166, 83, 'Chestnut', 'en', NULL),
	(167, 84, 'Mocca', 'th', NULL),
	(168, 84, 'Mocca', 'en', NULL),
	(169, 85, 'Claret', 'th', NULL),
	(170, 85, 'Claret', 'en', NULL),
	(171, 86, 'Wine', 'th', NULL),
	(172, 86, 'Wine', 'en', NULL),
	(173, 87, 'Dast', 'th', NULL),
	(174, 87, 'Dast', 'en', NULL),
	(175, 88, 'Stone', 'th', NULL),
	(176, 88, 'Stone', 'en', NULL),
	(177, 89, 'Smoke', 'th', NULL),
	(178, 89, 'Smoke', 'en', NULL),
	(179, 90, 'Fango', 'th', NULL),
	(180, 90, 'Fango', 'en', NULL),
	(181, 91, 'Deep', 'th', NULL),
	(182, 91, 'Deep', 'en', NULL),
	(183, 92, 'C (I-Sun Dance)', 'th', NULL),
	(184, 92, 'C (I-Sun Dance)', 'en', NULL),
	(185, 93, 'D (I-Buzz)', 'th', NULL),
	(186, 93, 'D (I-Buzz)', 'en', NULL),
	(187, 94, 'D (I-Densmore)', 'th', NULL),
	(188, 94, 'D (I-Densmore)', 'en', NULL),
	(189, 95, 'D (I-Polo Club)', 'th', NULL),
	(190, 95, 'D (I-Polo Club)', 'en', NULL),
	(191, 96, 'D (I-Alexa)', 'th', NULL),
	(192, 96, 'D (I-Alexa)', 'en', NULL),
	(193, 97, 'C (I-Prescott)', 'th', NULL),
	(194, 97, 'C (I-Prescott)', 'en', NULL),
	(195, 98, 'Slate', 'th', NULL),
	(196, 98, 'Slate', 'en', NULL),
	(197, 99, 'Fudge', 'th', NULL),
	(198, 99, 'Fudge', 'en', NULL),
	(199, 100, 'Midnight', 'th', NULL),
	(200, 100, 'Midnight', 'en', NULL),
	(201, 101, 'Lead', 'th', NULL),
	(202, 101, 'Lead', 'en', NULL),
	(203, 102, 'Barley', 'th', NULL),
	(204, 102, 'Barley', 'en', NULL),
	(205, 103, 'Vermilion', 'th', NULL),
	(206, 103, 'Vermilion', 'en', NULL),
	(207, 104, 'Silt', 'th', NULL),
	(208, 104, 'Silt', 'en', NULL),
	(209, 105, 'Sable', 'th', NULL),
	(210, 105, 'Sable', 'en', NULL),
	(211, 106, 'Crimson', 'th', NULL),
	(212, 106, 'Crimson', 'en', NULL),
	(213, 107, 'Truffle', 'th', NULL),
	(214, 107, 'Truffle', 'en', NULL),
	(215, 108, 'Twilight', 'th', NULL),
	(216, 108, 'Twilight', 'en', NULL),
	(217, 109, 'Vermilion', 'th', NULL),
	(218, 109, 'Vermilion', 'en', NULL),
	(219, 110, 'Quartz', 'th', NULL),
	(220, 110, 'Quartz', 'en', NULL),
	(221, 111, 'Chocolate', 'th', NULL),
	(222, 111, 'Chocolate', 'en', NULL),
	(223, 112, 'Nautical', 'th', NULL),
	(224, 112, 'Nautical', 'en', NULL),
	(225, 113, 'Teak', 'th', NULL),
	(226, 113, 'Teak', 'en', NULL),
	(227, 114, 'Toast', 'th', NULL),
	(228, 114, 'Toast', 'en', NULL),
	(229, 115, 'Kohl', 'th', NULL),
	(230, 115, 'Kohl', 'en', NULL),
	(231, 116, 'Fiesta', 'th', NULL),
	(232, 116, 'Fiesta', 'en', NULL),
	(233, 117, 'Whisper', 'th', NULL),
	(234, 117, 'Whisper', 'en', NULL),
	(235, 118, 'Seaspray', 'th', NULL),
	(236, 118, 'Seaspray', 'en', NULL),
	(237, 119, 'Scarlet', 'th', NULL),
	(238, 119, 'Scarlet', 'en', NULL),
	(239, 120, 'Graphite', 'th', NULL),
	(240, 120, 'Graphite', 'en', NULL),
	(241, 121, 'Navy', 'th', NULL),
	(242, 121, 'Navy', 'en', NULL),
	(261, 131, 'XL', 'th', NULL),
	(262, 131, 'XL', 'en', NULL),
	(263, 132, 'Red', 'th', NULL),
	(264, 132, 'Red', 'en', NULL),
	(265, 133, 'Merlot', 'th', NULL),
	(266, 133, 'Merlot', 'en', NULL),
	(267, 134, 'Earth', 'th', NULL),
	(268, 134, 'Earth', 'en', NULL),
	(269, 135, 'Black', 'th', NULL),
	(270, 135, 'Black', 'en', NULL);