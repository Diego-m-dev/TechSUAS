-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 04, 2024 at 07:10 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

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
-- Table structure for table `historico_mensal`
--

DROP TABLE IF EXISTS `historico_mensal`;
CREATE TABLE IF NOT EXISTS `historico_mensal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_beneficiario` int NOT NULL,
  `data` date NOT NULL,
  `entregue` varchar(4) NOT NULL,
  `quantidade_dia` int NOT NULL,
  `qtd_marmita_entregue` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_beneficiario` (`id_beneficiario`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `historico_mensal`
--

INSERT INTO `historico_mensal` (`id`, `id_beneficiario`, `data`, `entregue`, `quantidade_dia`, `qtd_marmita_entregue`) VALUES
(1, 5, '0000-00-00', '0', 0, 0),
(2, 7, '2024-02-04', 'SIM', 20, 0),
(3, 8, '2024-02-04', 'SIM', 20, 0),
(5, 10, '2024-02-04', 'SIM', 20, 0),
(6, 6, '2024-02-04', 'SIM', 20, 0),
(7, 2, '2024-02-04', 'SIM', 20, 0),
(8, 11, '2024-02-04', 'SIM', 21, 0),
(9, 5, '2024-02-04', 'SIM', 20, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historico_mensal`
--
ALTER TABLE `historico_mensal`
  ADD CONSTRAINT `historico_mensal_ibfk_1` FOREIGN KEY (`id_beneficiario`) REFERENCES `fluxo_diario_coz` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
