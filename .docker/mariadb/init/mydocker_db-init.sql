-- Utiliser une transaction évite de créer les tables si une erreur survient
-- et permet d'éviter les erreurs liées aux clés étrangères (la requête est lue d'abord puis exécutée)
START TRANSACTION;

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `mydocker_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `mydocker_db`;

CREATE TABLE IF NOT EXISTS `mydocker_table` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`value` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `table_test` (`id`, `value`) VALUES
(1,	'Machin truc')
;
COMMIT;