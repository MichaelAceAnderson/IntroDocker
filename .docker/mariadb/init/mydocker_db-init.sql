-- The use of a transaction is recommended to avoid data corruption
-- and helps avoid errors related to foreign keys (the query is read first and then executed)
START TRANSACTION;

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `introdocker_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `introdocker_db`;

CREATE TABLE IF NOT EXISTS `introdocker_table` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`value` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `table_test` (`id`, `value`) VALUES
(1,	'Thingamajig')
;
COMMIT;