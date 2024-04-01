-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 28-Jan-2024 às 01:37
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `test`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_senhas`
--

DROP TABLE IF EXISTS `tipos_senhas`;
CREATE TABLE IF NOT EXISTS `tipos_senhas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nomeSetor` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipos_atendimentos` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `tipos_senhas`
--

INSERT INTO `tipos_senhas` (`id`, `nomeSetor`, `tipos_atendimentos`) VALUES
(1, 'CADUNICO', 'NORMAL'),
(2, 'CADUNICO', 'PRIORIDADE'),
(3, 'CADUNICO', 'ESPECIAL'),
(4, 'CADUNICO', 'ZONA'),
(9, 'IDENTIDADE', 'NORMAL'),
(10, 'IDENTIDADE', 'PRIORIDADE'),
(11, 'CPF', 'NORMAL'),
(12, 'CPF', 'PRIORIDADE'),
(13, 'CPF', 'ESPECIAL'),
(14, 'URUBUDOPIX', 'prioridade'),
(15, 'URUBUDOPIX', 'especial'),
(16, 'URUBUDOPIX', 'zona rural');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
