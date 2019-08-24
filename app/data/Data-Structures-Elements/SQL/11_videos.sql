INSERT INTO `videos` (`id`, `embed`, `public_date`, `status`, `updated_at`, `created_at`, `position`) VALUES
(1, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Yv0lgbCPB8U\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2019-04-18', 1, '2019-04-19 09:29:12', '2019-04-18 18:03:34', 1),
(2, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/s9TlQon3NwE\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2019-04-19', 1, '2019-04-19 09:29:12', '2019-04-19 09:21:06', 2),
(3, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/eRaGIuJMMFs\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2019-04-19', 1, '2019-04-19 09:29:12', '2019-04-19 09:23:16', 3),
(4, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/cR4LdiN_kEI\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2019-04-19', 1, '2019-04-19 09:29:12', '2019-04-19 09:25:07', 4),
(5, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/kzcwMU7COr4\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2019-04-19', 1, '2019-04-19 09:29:12', '2019-04-19 09:26:59', 5),
(6, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/cKXOUAKEKLM\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', '2019-04-19', 1, '2019-04-19 09:29:12', '2019-04-19 09:27:41', 6);

INSERT INTO `videos_translation` (`id`, `translatable_id`, `title`, `short_desc`, `locale`) VALUES
(1, 1, 'Simple Operation of a LA-Z-BOY', 'Reclina-Rocker Chair Seat Tilt Rachet Mechanism', 'th'),
(2, 1, 'Simple Operation of a LA-Z-BOY', 'Reclina-Rocker Chair Seat Tilt Rachet Mechanism', 'en'),
(3, 2, 'How to Replace the Lift Handle', 'How to Replace the Lift Handle on LA-Z-BOY Recliner or Motion Sofa', 'th'),
(4, 2, 'How to Replace the Lift Handle', 'How to Replace the Lift Handle on LA-Z-BOY Recliner or Motion Sofa', 'en'),
(5, 3, 'How to Install and Remove the Recliner Back', 'How to Install and Remove the Recliner Back', 'th'),
(6, 3, 'How to Install and Remove the Recliner Back', 'How to Install and Remove the Recliner Back', 'en'),
(7, 4, 'Simple Operation of a LA-Z-BOY', 'Simple Operation of a LA-Z-BOY Reclinar-Rocker Chair Footrest', 'th'),
(8, 4, 'Simple Operation of a LA-Z-BOY', 'Simple Operation of a LA-Z-BOY Reclinar-Rocker Chair Footrest', 'en'),
(9, 5, 'Regular Maintenance of Your Recliner or Sofa', 'Regular Maintenance of Your LA-Z-BOY Recliner or Sofa', 'th'),
(10, 5, 'Regular Maintenance of Your Recliner or Sofa', 'Regular Maintenance of Your LA-Z-BOY Recliner or Sofa', 'en'),
(11, 6, 'Addressing the Footrest Noise Level', 'Addressing the Footrest Noise Level of a LA-Z-BOY Recliner or Motion Sofa', 'th'),
(12, 6, 'Addressing the Footrest Noise Level', 'Addressing the Footrest Noise Level of a LA-Z-BOY Recliner or Motion Sofa', 'en');
