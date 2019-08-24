-- Development
INSERT INTO `banner_ads` (`id`, `banner_name`, `banner_value`, `banner_url`, `banner_group`, `image`, `image_size`, `image_mobile`, `image_mobile_size`, `updated_at`, `created_at`, `position`)
VALUES
	(1, 'banner_ads_home_1', 'Homepage Top Ad #1', 'homepage', 'home_top_ad', NULL, '450x272', NULL, '450x272', '2019-05-31 15:59:39', '2019-04-29 00:00:00', 1),
	(2, 'banner_ads_home_2', 'Homepage Top Ad #2', 'homepage', 'home_top_ad', NULL, '450x272', NULL, '450x272', '2019-05-31 15:59:51', '2019-04-29 00:00:00', 2),
	(3, 'banner_ads_home_3', 'Homepage Top Ad #3', 'homepage', 'home_top_ad', NULL, '450x272', NULL, '450x272', '2019-05-31 16:00:07', '2019-04-29 00:00:00', 3),
	(4, 'banner_ads_home_4', 'Homepage Top Ad #4', 'homepage', 'home_top_ad', NULL, '450x272', NULL, '450x272', '2019-05-31 16:00:46', '2019-04-29 00:00:00', 4),
	(12, 'home_middle_ad', 'Homepage Middle Ad', 'homepage', 'home_middle_ad', NULL, '1820x515', NULL, '600x600', '2019-05-31 16:09:21', '2019-04-29 00:00:00', 5),
	(5, 'product_top_ad', 'Product Top Ad', 'product', 'product_top_ad', NULL, '1350x550', NULL, '600x600', '2019-05-31 14:33:10', '2019-04-29 00:00:00', 6),
	(13, 'shop_online_top_ad', 'Shop Online Top Ad', 'product_shop_online', 'shop_online_top_ad', NULL, '1350x550', NULL, '600x600', '2019-05-31 14:52:03', '2019-04-29 00:00:00', 6),
	(6, 'product_left_side_ad_1', 'Product Left Side Ad #1', 'product', 'product_left_side_ad', NULL, '573x914', NULL, '573x914', '2019-05-31 15:29:28', '2019-04-29 00:00:00', 7),
	(7, 'product_left_side_ad_2', 'Product Left Side Ad #2', 'product', 'product_left_side_ad', NULL, '573x914', NULL, '573x914', '2019-05-31 15:49:16', '2019-04-29 00:00:00', 8),
	(8, 'feature_top_ad', 'Feature Top Ad', 'features', 'feature_top_ad', NULL, '1350x550', NULL, '600x600', '2019-05-31 18:09:57', '2019-04-29 00:00:00', 9),
	(9, 'news_top_ad', 'News Top Ad', 'news', 'news_top_ad', NULL, '1350x550', NULL, '600x600', '2019-05-31 18:28:35', '2019-04-29 00:00:00', 10),
	(10, 'inspiration_top_ad', 'Inspiration Top Ad', 'inspiration', 'inspiration_top_ad', NULL, '1350x550', NULL, '600x600', '2019-05-31 18:36:35', '2019-04-29 00:00:00', 11),
	(11, 'gallery_top_ad', 'Gallery Top Ad', 'gallery', 'gallery_top_ad', NULL, '1350x550', NULL, '600x600', '2019-05-31 19:32:04', '2019-04-29 00:00:00', 12);




-- Production
INSERT INTO `banner_ads` (`id`, `banner_name`, `banner_value`, `banner_url`, `banner_group`, `image`, `image_size`, `image_mobile`, `image_mobile_size`, `updated_at`, `created_at`, `position`)
VALUES
	(1, 'banner_ads_home_1', 'Homepage Top Ad #1', 'homepage', 'home_top_ad', '/uploads/userfiles/images/banner-ads/home-ad1.jpg', '450x272', NULL, '450x272', '2019-05-31 15:59:39', '2019-04-29 00:00:00', 1),
	(2, 'banner_ads_home_2', 'Homepage Top Ad #2', 'homepage', 'home_top_ad', '/uploads/userfiles/images/banner-ads/home-ad2.jpg', '450x272', NULL, '450x272', '2019-05-31 15:59:51', '2019-04-29 00:00:00', 2),
	(3, 'banner_ads_home_3', 'Homepage Top Ad #3', 'homepage', 'home_top_ad', '/uploads/userfiles/images/banner-ads/home-ad3.jpg', '450x272', NULL, '450x272', '2019-05-31 16:00:07', '2019-04-29 00:00:00', 3),
	(4, 'banner_ads_home_4', 'Homepage Top Ad #4', 'homepage', 'home_top_ad', '/uploads/userfiles/images/banner-ads/home-ad3.jpg', '450x272', NULL, '450x272', '2019-05-31 16:00:46', '2019-04-29 00:00:00', 4),
	(12, 'home_middle_ad', 'Homepage Middle Ad', 'homepage', 'home_middle_ad', '/uploads/userfiles/images/banner-ads/LZB-Homepage-1709x483.jpg', '1820x515', NULL, '600x600', '2019-05-31 16:09:21', '2019-04-29 00:00:00', 5),
	(5, 'product_top_ad', 'Product Top Ad', 'product', 'product_top_ad', NULL, '1350x550', NULL, '600x600', '2019-05-31 14:33:10', '2019-04-29 00:00:00', 6),
	(13, 'shop_online_top_ad', 'Shop Online Top Ad', 'product_shop_online', 'shop_online_top_ad', NULL, '1350x550', NULL, '600x600', '2019-05-31 14:52:03', '2019-04-29 00:00:00', 6),
	(6, 'product_left_side_ad_1', 'Product Left Side Ad #1', 'product', 'product_left_side_ad', NULL, '573x914', NULL, '573x914', '2019-05-31 15:29:28', '2019-04-29 00:00:00', 7),
	(7, 'product_left_side_ad_2', 'Product Left Side Ad #2', 'product', 'product_left_side_ad', NULL, '573x914', NULL, '573x914', '2019-05-31 15:49:16', '2019-04-29 00:00:00', 8),
	(8, 'feature_top_ad', 'Feature Top Ad', 'features', 'feature_top_ad', '/uploads/userfiles/images/banner-ads/LZB-features-1350x550.png', '1350x550', NULL, '600x600', '2019-05-31 18:09:57', '2019-04-29 00:00:00', 9),
	(9, 'news_top_ad', 'News Top Ad', 'news', 'news_top_ad', '/uploads/userfiles/images/banner-ads/LZB-News-1350x550.jpg', '1350x550', NULL, '600x600', '2019-05-31 18:28:35', '2019-04-29 00:00:00', 10),
	(10, 'inspiration_top_ad', 'Inspiration Top Ad', 'inspiration', 'inspiration_top_ad', '/uploads/userfiles/images/banner-ads/LZB-Inspirations-1350x550.jpg', '1350x550', NULL, '600x600', '2019-05-31 18:36:35', '2019-04-29 00:00:00', 11),
	(11, 'gallery_top_ad', 'Gallery Top Ad', 'gallery', 'gallery_top_ad', '/uploads/userfiles/images/banner-ads/LZB-Gallery-1350x550.png', '1350x550', NULL, '600x600', '2019-05-31 19:32:04', '2019-04-29 00:00:00', 12);

INSERT INTO `banner_ads_translation` (`id`, `translatable_id`, `website`, `locale`)
VALUES
	(1, 1, 'http://178.128.87.236/product/', 'th'),
	(2, 1, 'http://178.128.87.236/en/product/', 'en');


---- 07/06/2019 chnage banner home ads to slider 3 columns fix ----
UPDATE banner_ads SET
image_size = '573x432',
image_mobile_size = '573x432' WHERE banner_ads.id = 1;

UPDATE banner_ads SET
image_size = '573x432',
image_mobile_size = '573x432' WHERE banner_ads.id = 2;

UPDATE banner_ads SET
image_size = '573x432',
image_mobile_size = '573x432' WHERE banner_ads.id = 3;

DELETE FROM `banner_ads` WHERE banner_ads.id = 4
