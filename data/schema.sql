CREATE DATABASE ngcaf_petition CHARACTER SET utf8 COLLATE utf8_general_ci;
USE ngcaf_petition;

DROP TABLE IF EXISTS `signatories`;
CREATE TABLE `signatories` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `signature_id` varchar(255) COLLATE utf8_unicode_ci,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `email` varchar(255) COLLATE utf8_unicode_ci,
  `phone` varchar(255) COLLATE utf8_unicode_ci,
  `zip` varchar(10) COLLATE utf8_unicode_ci,
  `created` timestamp,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;