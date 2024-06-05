-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.34 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping database structure for waterbills
CREATE DATABASE IF NOT EXISTS `waterbills` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `waterbills`;

-- Dumping structure for table waterbills.bill_tariff
CREATE TABLE IF NOT EXISTS `bill_tariff` (
  `id` int NOT NULL AUTO_INCREMENT,
  `upfrom` date DEFAULT NULL,
  `tilfor` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table waterbills.bill_tariff: ~2 rows (approximately)
INSERT INTO `bill_tariff` (`id`, `upfrom`, `tilfor`) VALUES
	(1, '2022-01-01', '2024-05-31'),
	(2, '2024-06-01', NULL);

-- Dumping structure for table waterbills.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) COLLATE utf8mb3_bin NOT NULL,
  `name` varchar(30) COLLATE utf8mb3_bin DEFAULT NULL,
  `address` varchar(50) COLLATE utf8mb3_bin NOT NULL,
  `email` varchar(30) COLLATE utf8mb3_bin NOT NULL,
  `waterbill` int NOT NULL,
  `password` varchar(20) COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table waterbills.customer: ~4 rows (approximately)
INSERT INTO `customer` (`id`, `username`, `name`, `address`, `email`, `waterbill`, `password`) VALUES
	(1, '123', 'Imesh Perera', '56, Dibbadda Road, Thalpitiya North, Wadduwa', 'imeshdilshan1020@gmail.com', 1234, '123456'),
	(2, 'imesh2', 'Imesh Perera', '56, Dibbadda Road, Thalpitiya North, Wadduwa', 'imeshdilshan1020@gmail.com', 1100, '123456');

-- Dumping structure for table waterbills.months
CREATE TABLE IF NOT EXISTS `months` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8mb3_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table waterbills.months: ~12 rows (approximately)
INSERT INTO `months` (`id`, `name`) VALUES
	(1, 'January'),
	(2, 'February'),
	(3, 'March'),
	(4, 'April'),
	(5, 'May'),
	(6, 'June'),
	(7, 'July'),
	(8, 'August'),
	(9, 'September'),
	(10, 'October'),
	(11, 'November'),
	(12, 'December');

-- Dumping structure for table waterbills.years
CREATE TABLE IF NOT EXISTS `years` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(5) COLLATE utf8mb3_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table waterbills.years: ~2 rows (approximately)
INSERT INTO `years` (`id`, `name`) VALUES
	(1, '2022'),
	(2, '2023'),
	(3, '2024');

-- Dumping structure for table waterbills.water_bill_units
CREATE TABLE IF NOT EXISTS `water_bill_units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tariff_id` int DEFAULT NULL,
  `minvalue` int DEFAULT NULL,
  `maxvalue` int DEFAULT NULL,
  `energycharge` double DEFAULT NULL,
  `fixcharge` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tariff_id` (`tariff_id`),
  CONSTRAINT `FK1_tariff` FOREIGN KEY (`tariff_id`) REFERENCES `bill_tariff` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table waterbills.water_bill_units: ~8 rows (approximately)
INSERT INTO `water_bill_units` (`id`, `tariff_id`, `minvalue`, `maxvalue`, `energycharge`, `fixcharge`) VALUES
	(1, 1, 1, 60, 25, 0),
	(2, 1, 61, 90, 30, 400),
	(3, 1, 91, 120, 50, 1000),
	(4, 1, 121, 180, 50, 1500),
	(5, 1, 181, NULL, 75, 2000),
	(6, 2, 1, 60, 60, 0),
	(7, 2, 61, 90, 80, 1000),
	(8, 2, 91, NULL, 100, 3000);

-- Dumping structure for table waterbills.bill
CREATE TABLE IF NOT EXISTS `bill` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `month_id` int DEFAULT NULL,
  `units` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `year_id` (`year_id`),
  KEY `month_id` (`month_id`),
  CONSTRAINT `FK1_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `FK2_year` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`),
  CONSTRAINT `FK3_month` FOREIGN KEY (`month_id`) REFERENCES `months` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- Dumping data for table waterbills.bill: ~5 rows (approximately)
INSERT INTO `bill` (`id`, `customer_id`, `year_id`, `month_id`, `units`, `total`) VALUES
	(1, 2, 1, 1, 100, 1),
	(2, 2, 1, 2, 50, 1),
	(3, 2, 1, 3, 75, 1),
	(4, 2, 3, 1, 145, 7847),
	(5, 2, 3, 2, 84, 3091.6);


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
