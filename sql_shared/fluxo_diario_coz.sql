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
-- Table structure for table `fluxo_diario_coz`
--

DROP TABLE IF EXISTS `fluxo_diario_coz`;
CREATE TABLE IF NOT EXISTS `fluxo_diario_coz` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nis_benef` varchar(11) NOT NULL,
  `num_doc` varchar(10) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dt_nasc` varchar(10) NOT NULL,
  `nome_mae` varchar(100) NOT NULL,
  `cpf_benef` varchar(14) NOT NULL,
  `data_de_entrega` date NOT NULL,
  `encaminhado_cras` varchar(70) NOT NULL,
  `qtd_pessoa` int NOT NULL,
  `qtd_marmita` int NOT NULL,
  `marm_entregue` int NOT NULL,
  `limiter` int NOT NULL,
  `entregue` varchar(4) NOT NULL,
  `prioridade` int NOT NULL,
  `data_limite` varchar(10) NOT NULL,
  `entregue_por` varchar(70) NOT NULL,
  `nome_operador` varchar(70) NOT NULL,
  `data_registro` varchar(20) NOT NULL,
  `id_beneficiario` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fluxo_diario_coz_beneficiario` (`id_beneficiario`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `fluxo_diario_coz`
--

INSERT INTO `fluxo_diario_coz` (`id`, `nis_benef`, `num_doc`, `nome`, `dt_nasc`, `nome_mae`, `cpf_benef`, `data_de_entrega`, `encaminhado_cras`, `qtd_pessoa`, `qtd_marmita`, `marm_entregue`, `limiter`, `entregue`, `prioridade`, `data_limite`, `entregue_por`, `nome_operador`, `data_registro`, `id_beneficiario`) VALUES
(2, '16120688227', '2/2024', 'DULCE MARIA SILVA DOS PIRES', '', '', '155.576.634-01', '0000-00-00', 'SUPORTE', 2, 20, 0, 0, 'não', 3, '2024-02-10', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(3, '16593789942', '3/2024', 'SAMILLE DE OLIVEIRA GUIMARAES', '', '', '130.298.314-85', '0000-00-00', 'SUPORTE', 5, 20, 0, 3, 'não', 3, '2024-02-05', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(5, '16186693415', '5/2024', 'IVONETE BERNARDO DA SILVA', '', '', '011.051.064-03', '0000-00-00', 'SUPORTE', 1, 20, 0, 0, 'não', 3, '2024-02-05', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(6, '22821769554', '6/2024', 'QUITERIA MARIA DE LIMA', '', '', '112.612.224-66', '0000-00-00', 'SUPORTE', 6, 20, 0, 0, 'não', 3, '2024-02-20', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(7, '23753939826', '7/2024', 'MARIA KAROLINA DE LIMA MARTINS', '', '', '107.467.854-02', '0000-00-00', 'SUPORTE', 3, 20, 0, 0, 'não', 3, '2024-02-10', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(8, '15805569500', '8/2024', 'JUCILEIDE CAVALCANTE', '', '', '129.633.534-80', '0000-00-00', 'SUPORTE', 6, 20, 0, 0, 'não', 3, '2024-02-21', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(10, '13103458451', '10/2024', 'EDSON LUIS DA SILVA', '', '', '054.868.794-31', '0000-00-00', 'SUPORTE', 1, 20, 0, 0, 'não', 3, '2024-03-01', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(11, '21324861373', '11/2024', 'NADIEL DE SOUZA SILVA', '', '', '909.379.614-34', '0000-00-00', 'SUPORTE', 1, 21, 0, 0, 'não', 3, '2024-05-02', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(13, '16573340958', '13/2024', 'PATRICIA MELO DOS SANTOS', '', '', '133.012.274-73', '0000-00-00', 'SUPORTE', 4, 21, 0, 0, 'não', 3, '2024-02-22', '', 'AGENTE TECNICO', '02/02/2024', NULL),
(14, '16536888260', '12/2024', 'ROSILENE LEITE DE MORAES', '', '', '047.556.024-83', '0000-00-00', 'SUPORTE', 2, 21, 0, 1, 'não', 3, '2024-02-10', '', 'AGENTE TECNICO', '02/02/2024', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fluxo_diario_coz`
--
ALTER TABLE `fluxo_diario_coz`
  ADD CONSTRAINT `fk_fluxo_diario_coz_beneficiario` FOREIGN KEY (`id_beneficiario`) REFERENCES `historico_mensal` (`id_beneficiario`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
