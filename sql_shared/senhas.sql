-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 20, 2024 at 04:09 PM
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
-- Table structure for table `senhas`
--

DROP TABLE IF EXISTS `senhas`;
CREATE TABLE IF NOT EXISTS `senhas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ordem_chegada` int NOT NULL,
  `senha` varchar(10) NOT NULL,
  `cpf_atendido` varchar(14) NOT NULL,
  `nome_atendido` varchar(70) NOT NULL,
  `tipo_atendimento` varchar(4) NOT NULL,
  `tipo_prioridade` varchar(30) NOT NULL,
  `situacao_senha` int NOT NULL,
  `atendente` varchar(70) NOT NULL,
  `data_hora_registro` datetime NOT NULL,
  `data_hora_atendido` datetime NOT NULL,
  `setor_atendido` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `senhas`
--

INSERT INTO `senhas` (`id`, `ordem_chegada`, `senha`, `cpf_atendido`, `nome_atendido`, `tipo_atendimento`, `tipo_prioridade`, `situacao_senha`, `atendente`, `data_hora_registro`, `data_hora_atendido`, `setor_atendido`) VALUES
(1, 1, 'CADA', '121.642.354-79', 'JANAINA ALVES DA SILVA', 'CAD', 'A', 0, '', '2024-01-17 18:07:25', '0000-00-00 00:00:00', ''),
(2, 1, 'CADS', '155.576.634-01', 'DULCE MARIA SILVA DOS PIRES', 'CAD', 'S', 0, '', '2024-01-17 18:08:05', '0000-00-00 00:00:00', ''),
(3, 1, 'CADB', '130.298.314-85', 'SAMILLE DE OLIVEIRA GUIMARAES', 'CAD', 'B', 0, '', '2024-01-17 18:16:11', '0000-00-00 00:00:00', ''),
(4, 2, 'CADB', '766.008.584-00', 'GERALDO GOMES DA SILVA', 'CAD', 'B', 0, '', '2024-01-17 18:16:45', '0000-00-00 00:00:00', ''),
(5, 3, 'CADB', '011.051.064-03', 'IVONETE BERNARDO DA SILVA', 'CAD', 'B', 0, '', '2024-01-17 18:26:32', '0000-00-00 00:00:00', ''),
(6, 1, 'PBFM', '112.612.224-66', 'QUITERIA MARIA DE LIMA', 'PBF', 'M', 0, '', '2024-01-17 18:26:58', '0000-00-00 00:00:00', ''),
(7, 4, 'CADB', '107.467.854-02', 'MARIA KAROLINA DE LIMA MARTINS', 'CAD', 'B', 0, '', '2024-01-17 18:27:37', '0000-00-00 00:00:00', ''),
(8, 2, 'CADS', '129.633.534-80', 'JUCILEIDE CAVALCANTE', 'CAD', 'S', 0, '', '2024-01-17 18:28:48', '0000-00-00 00:00:00', ''),
(9, 5, 'CADB', '075.381.094-80', 'MONICA DE JESUS', 'CAD', 'B', 0, '', '2024-01-17 18:29:17', '0000-00-00 00:00:00', ''),
(10, 3, 'CADS', '054.868.794-31', 'EDSON LUIS DA SILVA', 'CAD', 'S', 0, '', '2024-01-17 18:30:10', '0000-00-00 00:00:00', ''),
(11, 6, 'CADB', '133.012.274-73', 'PATRICIA MELO DOS SANTOS', 'CAD', 'B', 0, '', '2024-01-17 18:31:16', '0000-00-00 00:00:00', ''),
(12, 1, 'PBFB', '138.345.424-82', 'CRISTINA ALVES DE AZEVEDO', 'PBF', 'B', 0, '', '2024-01-17 18:32:17', '0000-00-00 00:00:00', ''),
(13, 7, 'CADB', '138.345.424-82', 'CRISTINA ALVES DE AZEVEDO', 'CAD', 'B', 0, '', '2024-01-17 18:33:49', '0000-00-00 00:00:00', ''),
(14, 4, 'CADS', '047.556.024-83', 'ROSILENE LEITE DE MORAES', 'CAD', 'S', 0, '', '2024-01-17 18:35:43', '0000-00-00 00:00:00', ''),
(15, 8, 'CADB', '909.379.614-34', 'NADIEL DE SOUZA SILVA', 'CAD', 'B', 0, '', '2024-01-17 18:38:15', '0000-00-00 00:00:00', ''),
(16, 5, 'CADS', '012.106.854-42', 'EVANIA SOUZA DA SILVA', 'CAD', 'S', 0, '', '2024-01-17 18:39:25', '0000-00-00 00:00:00', ''),
(17, 9, 'CADB', '071.140.764-95', 'LUCIENE SANTOS DE LIMA', 'CAD', 'B', 0, '', '2024-01-17 19:01:33', '0000-00-00 00:00:00', ''),
(18, 1, 'PBFS', '113.718.684-41', 'RUZAREIA MELO DOS SANTOS', 'PBF', 'S', 0, '', '2024-01-17 19:02:58', '0000-00-00 00:00:00', ''),
(19, 1, 'CONCB', '123.586.314-00', 'TAISE NASCIMENTO DE SOUZA', 'CONC', 'B', 0, '', '2024-01-17 19:18:29', '0000-00-00 00:00:00', ''),
(20, 1, 'AMIB', '159.375.944-44', 'EVELIN DE OLIVEIRA ZEFERINO BEZERRA', 'AMI', 'B', 0, '', '2024-01-17 19:19:47', '0000-00-00 00:00:00', ''),
(21, 1, 'RFBS', '117.932.834-51', 'JAQUELINE BEZERRA FERREIRA', 'RFB', 'S', 0, '', '2024-01-17 19:20:24', '0000-00-00 00:00:00', ''),
(22, 2, 'PBFM', '075.344.514-00', 'GLEYSE DARLY LEITE DA SILVA', 'PBF', 'M', 0, '', '2024-01-17 19:23:55', '0000-00-00 00:00:00', ''),
(23, 1, 'CADM', '718.059.154-87', 'CICERO REIS DA SILVA', 'CAD', 'M', 0, '', '2024-01-17 19:30:32', '0000-00-00 00:00:00', ''),
(24, 2, 'CADM', '506.800.804-49', 'BENEDITO RODRIGUES DE LIMA', 'CAD', 'M', 0, '', '2024-01-17 19:30:54', '0000-00-00 00:00:00', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
