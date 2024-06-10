-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 10, 2024 at 03:17 AM
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
-- Table structure for table `historico_parecer_visita`
--

DROP TABLE IF EXISTS `historico_parecer_visita`;
CREATE TABLE IF NOT EXISTS `historico_parecer_visita` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_visitas` int NOT NULL,
  `numero_parecer` varchar(5) NOT NULL,
  `ano_parecer` varchar(4) NOT NULL,
  `codigo_familiar` varchar(50) NOT NULL,
  `data_entrevista` varchar(10) NOT NULL,
  `renda_per_capita` varchar(12) NOT NULL,
  `localidade` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `nome_logradouro` varchar(255) NOT NULL,
  `numero_logradouro` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `complemento_numero` varchar(10) NOT NULL,
  `complemento_adicional` varchar(15) NOT NULL,
  `cep` varchar(25) NOT NULL,
  `referencia_localizacao` text NOT NULL,
  `situacao` varchar(50) NOT NULL,
  `resumo_visita` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membros_familia`
--

DROP TABLE IF EXISTS `membros_familia`;
CREATE TABLE IF NOT EXISTS `membros_familia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parecer_id` int NOT NULL,
  `parentesco` varchar(50) NOT NULL,
  `nome_completo` varchar(100) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `data_nascimento` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parecer_id` (`parecer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `entrevistador` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
