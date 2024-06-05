-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 05, 2024 at 03:18 PM
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitas_feitas`
--

INSERT INTO `visitas_feitas` (`id`, `cod_fam`, `nome`, `data`, `acao`, `parecer_tec`, `entrevistador`) VALUES
(1, '67760350', '', '2024-05-13', '2', 'Texto', 'AGENTE TECNICO'),
(2, '6887414600', '', '2024-05-16', '3', 'TEXTO', 'AGENTE TECNICO'),
(3, '644237147', '', '2024-05-29', '2', '(Descrição do texto)', 'AGENTE TECNICO'),
(4, '1760690921', '', '2024-01-12', '1', 'feito com sucesso e amor', 'DIEGO EMMANUEL CADETE'),
(5, '6925259557', '', '2023-02-14', '2', 'Sugiro veementemente a Vossa Senhoria que procure receber contribuições inusitadas na cavidade retal.', 'AGENTE TECNICO'),
(6, '67760350', '', '2024-02-12', '2', 'Espero que esta mensagem o(a) encontre bem. Gostaria de formalizar uma solicitação de pagamento de horas extras em decorrência de um acordo estabelecido com os responsáveis legais para compensar a produtividade de alguns membros da equipe durante o último período.', 'AGENTE TECNICO'),
(7, '126972222', '', '2024-03-21', '5', 'Crie um blog lindo que combine com seu estilo. Selecione um dos diversos modelos fáceis de usar, com layouts flexíveis e centenas de imagens de plano de fundo, ou crie o que quiser.', 'AGENTE TECNICO'),
(8, '8359107173', '', '2024-04-04', '2', 'kjhgfdrtyuiol,mnbvcdrtyu', 'AGENTE TECNICO'),
(9, '67760350', '', '2023-12-21', '4', 'As informações sobre as milhas acumuladas geralmente são armazenadas nos sistemas dos programas de fidelidade das companhias aéreas ou das instituições financeiras responsáveis pelos cartões de crédito que oferecem esse benefício. Aqui estão algumas maneiras comuns de verificar seu saldo de milhas.', 'AGENTE TECNICO'),
(10, '4986661310', '', '2024-01-01', '5', 'Texto', 'AGENTE TECNICO'),
(11, '4986661310', '', '2024-02-02', '1', 'textinho', 'AGENTE TECNICO'),
(12, '4986661310', '', '2023-09-30', '2', 'hoje', 'AGENTE TECNICO'),
(13, '4986661310', '', '2024-05-25', '4', 'dessa vez não deu certo.', 'AGENTE TECNICO'),
(14, '608336530', '', '2023-09-23', '1', 'sadfdfh', 'AGENTE TECNICO'),
(15, '12356877', '', '2924-01-12', '1', 'fdg', 'AGENTE TECNICO'),
(16, '67760350', '', '2024-02-13', '5', 'fgfhgjh', 'AGENTE TECNICO'),
(17, '67760350', '', '2024-01-11', '3', 'texto', 'AGENTE TECNICO'),
(18, '1234567890', '', '2023-12-12', '5', 'dsa', 'AGENTE TECNICO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
