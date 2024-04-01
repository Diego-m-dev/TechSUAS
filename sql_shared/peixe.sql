-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 16, 2024 at 01:00 AM
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
-- Table structure for table `peixe`
--

DROP TABLE IF EXISTS `peixe`;
CREATE TABLE IF NOT EXISTS `peixe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod_fam` varchar(20) NOT NULL,
  `texto` text NOT NULL,
  `data_registro` date NOT NULL,
  `operador` varchar(255) NOT NULL,
  `local_entrega` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peixe`
--

INSERT INTO `peixe` (`id`, `cod_fam`, `texto`, `data_registro`, `operador`, `local_entrega`) VALUES
(1, '07311089140', '21230775449 texto dos comprovantes DIEGO MOREIRA DE ANDRADE', '0000-00-00', 'AGENTE TECNICO', 'ESTER SIQUEIRA'),
(2, '07272459379', '16598717184 texto dos comprovantes VALTER MATHEUS DE LIMA ARAUJO', '0000-00-00', 'AGENTE TECNICO', 'ODETE COSTA'),
(3, '05387346125', '16120688227 texto dos comprovantes DULCE MARIA SILVA DOS PIRES', '0000-00-00', 'AGENTE TECNICO', 'CRAS ANTONIO MATIAS');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
