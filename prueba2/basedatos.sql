-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.36 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for aveonline
DROP DATABASE IF EXISTS `aveonline`;
CREATE DATABASE IF NOT EXISTS `aveonline` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `aveonline`;

-- Dumping structure for table aveonline.producto
DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `referencia` varchar(15) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `observacion` varchar(200) NOT NULL,
  `precio` decimal(20,2) NOT NULL DEFAULT '0.00',
  `impuesto` decimal(4,2) NOT NULL DEFAULT '0.00',
  `cantidad` int(4) NOT NULL DEFAULT '0',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `imagen` varchar(100) NOT NULL,
  PRIMARY KEY (`referencia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table aveonline.producto: 1 rows
DELETE FROM `producto`;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` (`referencia`, `nombre`, `observacion`, `precio`, `impuesto`, `cantidad`, `estado`, `imagen`) VALUES
	('DEMO', 'DEMO', 'DEMO', 1.00, 1.00, 1, 'activo', 'DEMO.jpg'),
	('a', 'FUNCIONA', 'lineth', 1.00, 1.00, 1, 'activo', 'a.jpg'),
	('aaa', 'aaa', 'aaa', 0.00, 0.00, 0, 'activo', 'aaa');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
