-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 22, 2023 at 05:42 PM
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
-- Table structure for table `visitas_feitas`
--

DROP TABLE IF EXISTS `visitas_feitas`;
CREATE TABLE IF NOT EXISTS `visitas_feitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod_fam` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `acao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `parecer_tec` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitas_feitas`
--

INSERT INTO `visitas_feitas` (`id`, `cod_fam`, `nome`, `data`, `acao`, `parecer_tec`) VALUES
(1, '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', '2023-11-07', '2', 'O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.'),
(3, '123234345', 'maria', '2023-10-21', '3', 'nõ sei'),
(4, '34452332', 'joana', '2023-10-22', '2', 'saberia'),
(5, '212212212', 'sorocaba', '2023-10-21', '4', 'não poderia\r\n'),
(6, '212212212', 'dasmo', '2023-10-21', '4', 'não poderia dale'),
(7, '67760350', 'JOSEFA ADENILDA DE CARVALHO', '2022-11-21', '3', 'Passa mal.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
