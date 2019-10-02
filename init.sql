-- Adminer 4.7.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE TABLE `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team1_id` int(11) NOT NULL,
  `team2_id` int(11) NOT NULL,
  `league_id` int(11) NOT NULL,
  `sport_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_232B318CE72BCFA4` (`team1_id`),
  KEY `IDX_232B318CF59E604A` (`team2_id`),
  KEY `IDX_232B318C58AFC4DE` (`league_id`),
  KEY `IDX_232B318CAC78BCF8` (`sport_id`),
  CONSTRAINT `FK_232B318C58AFC4DE` FOREIGN KEY (`league_id`) REFERENCES `league` (`id`),
  CONSTRAINT `FK_232B318CAC78BCF8` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`),
  CONSTRAINT `FK_232B318CE72BCFA4` FOREIGN KEY (`team1_id`) REFERENCES `team` (`id`),
  CONSTRAINT `FK_232B318CF59E604A` FOREIGN KEY (`team2_id`) REFERENCES `team` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `game_buffer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `sport` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `league` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4C6F5D3AE48FD905` (`game_id`),
  CONSTRAINT `FK_4C6F5D3AE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `league` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_id` int(11) NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ru` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3EB4C318AC78BCF8` (`sport_id`),
  FULLTEXT KEY `full_name_idx` (`name_en`,`name_ru`),
  CONSTRAINT `FK_3EB4C318AC78BCF8` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `sport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ru` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `full_name_idx` (`name_en`,`name_ru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sport_id` int(11) NOT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ru` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C4E0A61FAC78BCF8` (`sport_id`),
  FULLTEXT KEY `full_name_idx` (`name_en`,`name_ru`),
  CONSTRAINT `FK_C4E0A61FAC78BCF8` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2019-10-02 15:13:49