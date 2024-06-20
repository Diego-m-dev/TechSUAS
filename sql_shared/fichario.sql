-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2024 at 12:16 PM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `fichario`
--

DROP TABLE IF EXISTS `fichario`;
CREATE TABLE IF NOT EXISTS `fichario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codfam` varchar(11) NOT NULL,
  `arm_gav_pas` varchar(13) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `operador` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_german2_ci;

--
-- Dumping data for table `fichario`
--

INSERT INTO `fichario` (`id`, `codfam`, `arm_gav_pas`, `created_at`, `operador`) VALUES
(1, '06522518112', '24 - 04 - 69', '2024-06-11 18:45:30', 'LUCIA FLAVIA BRITO'),
(2, '01850665265', '24 - 04 - 35', '2024-06-11 18:46:52', 'LUCIA FLAVIA BRITO'),
(3, '06543537191', '24 - 04 - 90', '2024-06-11 19:03:52', 'LUCIA FLAVIA BRITO'),
(4, '06541850852', '24 - 04 - 43', '2024-06-11 19:07:34', 'LUCIA FLAVIA BRITO'),
(5, '06527941900', '24 - 04 - 88', '2024-06-11 19:08:24', 'LUCIA FLAVIA BRITO'),
(6, '06529572260', '24 - 04 - 86', '2024-06-11 19:09:29', 'LUCIA FLAVIA BRITO'),
(7, '06543436751', '24 - 04 - 89', '2024-06-11 19:10:22', 'LUCIA FLAVIA BRITO'),
(8, '06543653930', '24 - 04 - 82', '2024-06-11 19:11:29', 'LUCIA FLAVIA BRITO'),
(9, '06529127100', '24 - 04 - 81', '2024-06-11 19:12:36', 'LUCIA FLAVIA BRITO'),
(10, '03114727379', '24 - 04 - 79', '2024-06-11 19:13:21', 'LUCIA FLAVIA BRITO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
