INSERT INTO `news_category` (`id`, `tree_root`, `parent_id`, `lft`, `lvl`, `rgt`, `slug`) VALUES
(1, 1, NULL, 1, 0, 21, 'news'),
(2, 1, 1, 2, 1, 3, 'csr'),
(3, 1, 1, 4, 1, 5, 'new-products'),
(4, 1, 1, 6, 1, 7, 'new-location'),
(5, 1, 1, 8, 1, 9, 'internal'),
(6, 1, 1, 10, 1, 11, 'view-tv-commercial'),
(7, 1, 1, 12, 1, 19, 'view-la-z-boy-vtr'),
(8, 1, 7, 13, 2, 14, 'dhanakorn-kasetrsuwan-secrets-of-victory'),
(9, 1, 7, 15, 2, 16, 'la-z-boy-powerrecline-xr'),
(10, 1, 7, 17, 2, 18, 'la-z-boy-fanday')
;


INSERT INTO `news_category_translation` (`id`, `translatable_id`, `title`, `locale`) VALUES
(1, 1, 'PR/NEWS', 'en'),
(2, 1, 'ข่าวสารและวีดีโอ', 'th'),
(3, 2, 'CSR', 'en'),
(4, 2, 'กิจกรรมเพื่อสังคม', 'th'),
(5, 3, 'New Products', 'en'),
(6, 3, 'ผลิตภัณฑ์ใหม่', 'th'),
(7, 4, 'New Location', 'en'),
(8, 4, 'ร้านค้าใหม่', 'th'),
(9, 5, 'Internal', 'en'),
(10, 5, 'ข่าวสารภายใน', 'th'),
(11, 6, 'View TV Commercial', 'en'),
(12, 6, 'View TV Commercial', 'th'),
(13, 7, 'View La-Z-Boy VTR', 'en'),
(14, 7, 'View La-Z-Boy VTR', 'th'),
(15, 8, 'Dhanakorn Kasetrsuwan @Secrets of Victory', 'en'),
(16, 8, 'Dhanakorn Kasetrsuwan @Secrets of Victory', 'th'),
(17, 9, 'LA-Z-BOY PowerRecline XR+', 'en'),
(18, 9, 'LA-Z-BOY PowerRecline XR+', 'th'),
(19, 10, 'LA-Z-BOY FanDay', 'en'),
(20, 10, 'เล-ซี-บอย แฟนเดย์', 'th');
