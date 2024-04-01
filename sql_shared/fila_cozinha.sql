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
-- Table structure for table `fila_cozinha`
--

DROP TABLE IF EXISTS `fila_cozinha`;
CREATE TABLE IF NOT EXISTS `fila_cozinha` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nis_benef` varchar(11) NOT NULL,
  `num_doc` varchar(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dt_nasc` varchar(10) NOT NULL,
  `nome_mae` varchar(100) NOT NULL,
  `cpf_benef` varchar(14) NOT NULL,
  `data_de_entrega` varchar(10) NOT NULL,
  `encaminhado_cras` varchar(70) NOT NULL,
  `qtd_pessoa` int NOT NULL,
  `qtd_marmita` int NOT NULL,
  `marm_entregue` int NOT NULL,
  `limiter` varchar(1) NOT NULL,
  `entregue` varchar(4) NOT NULL,
  `prioridade` int NOT NULL,
  `nome_operador` varchar(70) NOT NULL,
  `data_registro` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
