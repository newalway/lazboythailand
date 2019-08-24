INSERT INTO `authentication` (`id`, `name`, `value`, `title`, `input_type`, `group_type`, `updated_at`, `created_at`)
VALUES
	(1, 'google_maps_api_key', 'AIzaSyBHkPz5loN8xTTFRWES6TzFfhvguT33aCU', 'Google Maps API key', 'text', 'Google APIs', '2017-12-28 18:00:00', '2017-12-28 18:00:00'),
	(2, 'geolocation_api_key', 'AIzaSyBHkPz5loN8xTTFRWES6TzFfhvguT33aCU', 'Geolocation API key', 'text', 'Google APIs', '2017-12-28 18:00:00', '2017-12-28 18:00:00'),
	(3, 'directions_api_key', 'AIzaSyBHkPz5loN8xTTFRWES6TzFfhvguT33aCU', 'Directions API key', 'text', 'Google APIs', '2017-12-28 18:00:00', '2017-12-28 18:00:00');

INSERT INTO `authentication` (`id`, `name`, `value`, `title`, `input_type`, `group_type`, `updated_at`, `created_at`)
VALUES
	(20, 'omise_public_key', 'pkey_test_5g2tkwblwpkrm2le7c0', 'Public key', 'text', 'Omise', '2017-12-28 18:00:00', '2017-12-28 18:00:00'),
	(21, 'omise_secret_key', 'skey_test_5g2tkwbm81p9hmvp63h', 'Secret key', 'password', 'Omise', '2017-12-28 18:00:00', '2017-12-28 18:00:00'),
	(22, 'omise_3ds', 'true', '3D Secure', 'boolean', 'Omise', '2017-12-28 18:00:00', '2017-12-28 18:00:00');


INSERT INTO `authentication` (`id`, `name`, `value`, `title`, `input_type`, `group_type`, `updated_at`, `created_at`)
VALUES
	(23, 'omise_livemode', 'false', 'Live Mode', 'boolean', 'Omise', '2019-06-17 12:06:00', '2019-06-17 12:06:00');


INSERT INTO `authentication` (`id`, `name`, `value`, `title`, `input_type`, `group_type`, `updated_at`, `created_at`)
VALUES
	(30, 'preorder', 'true', 'Customer can buy product which is no stock as Pre-order', 'boolean', 'Pre-order', '2019-08-06 09:05:00', '2019-08-06 09:05:00');


INSERT INTO `authentication` (`id`, `name`, `value`, `title`, `input_type`, `group_type`, `updated_at`, `created_at`)
VALUES
	(31, 'order_status_email', 'true', 'Change order status e-mail automatically is sent to customer', 'boolean', 'Change order status e-mail', '2019-08-06 09:05:00', '2019-08-06 09:05:00');
