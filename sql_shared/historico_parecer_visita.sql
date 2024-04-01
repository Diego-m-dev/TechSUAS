-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 22, 2023 at 05:41 PM
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
-- Table structure for table `historico_parecer_visita`
--

DROP TABLE IF EXISTS `historico_parecer_visita`;
CREATE TABLE IF NOT EXISTS `historico_parecer_visita` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_parecer` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `cod_familiar` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `restante` text COLLATE utf8mb4_general_ci NOT NULL,
  `data_atual` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historico_parecer_visita`
--

INSERT INTO `historico_parecer_visita` (`id`, `numero_parecer`, `cod_familiar`, `nome`, `restante`, `data_atual`) VALUES
(1, '1', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(2, '2', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(3, '3', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(4, '4', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(5, '5', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(6, '6', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(7, '7', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(8, '8', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(9, '9', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(10, '10', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(11, '11', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(12, '11', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(13, '13', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(14, '14', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(15, '15', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(16, '15', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(17, '17', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(18, '18', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(19, '19', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(20, '20', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(21, '20', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(22, '22', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(23, '22', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(24, '22', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(25, '22', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(26, '22', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(27, '22', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(28, '22', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(29, '22', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(30, '30', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(31, '31', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '13, 11, 2023'),
(32, '32', '4532765390', 'CARLOS ALBERTO VILELA DE MORAIS', 'Foi realizado no dia 07 de novembro de 2023, no endereço RUA SANTA TRES, 66 - CENTRO, SEM REFERÊNCIA declarado por CARLOS ALBERTO VILELA DE MORAIS, CPF: 074.679.664-15,  filho de  ERACLIDES VILELA DE MORAIS, mas  o  família não foi localizada. Em busca ativa obteve a seguinte informação O ENDEREÇO FORNECIDO NÃO FOI SUFICIENTE PARA LOCALIZAR, NÃO FOI INFORMADO UM BAIRRO VALIDO.', '14, 11, 2023');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
