-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 10, 2024 at 10:22 PM
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
-- Table structure for table `beneficiario`
--

DROP TABLE IF EXISTS `beneficiario`;
CREATE TABLE IF NOT EXISTS `beneficiario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `beneficiario` varchar(100) NOT NULL,
  `naturalidade` varchar(100) NOT NULL,
  `nome_mae_benef` varchar(100) NOT NULL,
  `renda_media` int NOT NULL,
  `endereco_resp` varchar(255) NOT NULL,
  `cpf_beneficio` varchar(14) NOT NULL,
  `te_beneficio` varchar(14) NOT NULL,
  `rg_beneficio` varchar(24) NOT NULL,
  `parentesco` varchar(24) NOT NULL,
  `operador` varchar(100) NOT NULL,
  `data_registro` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `beneficiario`
--

INSERT INTO `beneficiario` (`id`, `beneficiario`, `naturalidade`, `nome_mae_benef`, `renda_media`, `endereco_resp`, `cpf_beneficio`, `te_beneficio`, `rg_beneficio`, `parentesco`, `operador`, `data_registro`) VALUES
(1, 'DIEGO EMMANUEL CADETE', 'BELO JARDIM', 'MARIA JOSEANE DA CONCECAO', 21, 'RUA MIRAMBAR, 90 - NUIMOLHARDI', '092.349.874-54', '1111-1111-1111', '8436184', '', 'SUPORTE TECNICO', '08/03/2024 23:26'),
(2, 'PEDRINHO', 'ZAMAL', 'VILMA', 34, 'SOROCABA', '134.087.114-96', '2222-2222-2222', '2122122', '', 'SUPORTE TECNICO', '08/03/2024 23:52');

-- --------------------------------------------------------

--
-- Table structure for table `concessao_historico`
--

DROP TABLE IF EXISTS `concessao_historico`;
CREATE TABLE IF NOT EXISTS `concessao_historico` (
  `id_hist` int NOT NULL AUTO_INCREMENT,
  `id_concessao` int DEFAULT NULL,
  `num_form` int DEFAULT NULL,
  `ano_form` varchar(4) DEFAULT NULL,
  `cpf_resp` varchar(14) NOT NULL,
  `nome_benef` varchar(255) DEFAULT NULL,
  `nis_benef` varchar(12) DEFAULT NULL,
  `cpf_benef` varchar(14) NOT NULL,
  `rg_benef` varchar(25) NOT NULL,
  `tit_benef` varchar(14) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `renda_media` int DEFAULT NULL,
  `parecer` mediumtext,
  `descricao` varchar(4) DEFAULT NULL,
  `nome_item` varchar(100) DEFAULT NULL,
  `qtd_item` varchar(10) DEFAULT NULL,
  `valor_uni` varchar(7) DEFAULT NULL,
  `valor_total` varchar(10) DEFAULT NULL,
  `data_registro` varchar(16) DEFAULT NULL,
  `mes_pag` varchar(10) DEFAULT NULL,
  `parentesco` varchar(30) NOT NULL,
  `operador` varchar(255) DEFAULT NULL,
  `pg_data` date DEFAULT NULL,
  `situacao_concessao` varchar(20) NOT NULL,
  PRIMARY KEY (`id_hist`),
  KEY `id_concessao` (`id_concessao`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `concessao_historico`
--

INSERT INTO `concessao_historico` (`id_hist`, `id_concessao`, `num_form`, `ano_form`, `cpf_resp`, `nome_benef`, `nis_benef`, `cpf_benef`, `rg_benef`, `tit_benef`, `endereco`, `renda_media`, `parecer`, `descricao`, `nome_item`, `qtd_item`, `valor_uni`, `valor_total`, `data_registro`, `mes_pag`, `parentesco`, `operador`, `pg_data`, `situacao_concessao`) VALUES
(1, 3, 1, '2024', '', 'JANAINA ALVES DA SILVA', '16186794823', '121.642.354-79', '9.804.950', '0796-9119-0868', 'RUA  TRES, 177 - IRAQUE, PROXIMO AO BAR DE BRANCO RF CONHECIDA POR JANE', 0, NULL, NULL, 'MEDICAMENTO', '2', '89,90', '179,80', '08/03/2024 22:28', 'Feveiro', 'ENTEADO(A)', 'SUPORTE TECNICO', NULL, 'EM PROCESSO'),
(2, 3, 2, '2024', '', 'DIEGO EMMANUEL CADETE', NULL, '092.349.874-54', '', '', 'RUA MIRAMBAR, 90 - NUIMOLHARDI', 21, NULL, NULL, 'MEDICAMENTO', '3', '45,90', '137,70', '08/03/2024 23:26', 'Fevereiro', 'UNIPESSOAL', 'SUPORTE TECNICO', '0000-00-00', 'EM PROCESSO'),
(3, 3, 3, '2024', '', 'PEDRINHO', NULL, '134.087.114-96', '2122122', '2222-2222-2222', 'SOROCABA', 34, NULL, NULL, 'MEDICAMENTO', '2', '230,00', '460,00', '08/03/2024 23:52', 'Fevereiro', 'UNIPESSOAL', 'SUPORTE TECNICO', '0000-00-00', 'EM PROCESSO');

-- --------------------------------------------------------

--
-- Table structure for table `concessao_itens`
--

DROP TABLE IF EXISTS `concessao_itens`;
CREATE TABLE IF NOT EXISTS `concessao_itens` (
  `id_itens_conc` int NOT NULL AUTO_INCREMENT,
  `cod_item` varchar(16) DEFAULT NULL,
  `caracteristica` varchar(100) DEFAULT NULL,
  `nome_item` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_itens_conc`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `concessao_itens`
--

INSERT INTO `concessao_itens` (`id_itens_conc`, `cod_item`, `caracteristica`, `nome_item`) VALUES
(1, '1', 'MEDICAMENTO', 'MEDICAMENTO'),
(2, '12', 'ALUGUEL', 'ALUGUEL');

-- --------------------------------------------------------

--
-- Table structure for table `concessao_tbl`
--

DROP TABLE IF EXISTS `concessao_tbl`;
CREATE TABLE IF NOT EXISTS `concessao_tbl` (
  `id_concessao` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `naturalidade` varchar(100) DEFAULT NULL,
  `nome_mae` varchar(100) DEFAULT NULL,
  `contato` varchar(16) DEFAULT NULL,
  `cpf_pessoa` varchar(14) DEFAULT NULL,
  `rg_pessoa` varchar(14) DEFAULT NULL,
  `tit_eleitor_pessoa` varchar(14) DEFAULT NULL,
  `nis_pessoa` varchar(12) DEFAULT NULL,
  `renda_media` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `operador` varchar(255) DEFAULT NULL,
  `data_cadastro` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_concessao`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `concessao_tbl`
--

INSERT INTO `concessao_tbl` (`id_concessao`, `nome`, `naturalidade`, `nome_mae`, `contato`, `cpf_pessoa`, `rg_pessoa`, `tit_eleitor_pessoa`, `nis_pessoa`, `renda_media`, `endereco`, `operador`, `data_cadastro`) VALUES
(1, 'VALTER MATHEUS DE LIMA ARAUJO', 'VITORIA DE SANTO ANTAO', 'PALOMA DE LIMA ARAUJO', '(81) 9.9308-4976', '078.158.234-24', '9.315.783', '', '16598717184', '1.256,00', 'RUA  18 DE COPACABANA, 25 - CENTRO, PROXIMO A NELSON SAPATEIRO', 'AGENTE TECNICO', '25/02/2024 16:38'),
(2, 'DIEGO MOREIRA DE ANDRADE', 'SAO BENTO DO UNA', 'MARIA DO SOCORRO MOREIRA DE ANDRADE', '(87) 9.9171-8722', '134.087.114-96', '10.440.447', '0954-9253-0841', '21230775449', '220,00', 'LOTEAMENTO  SETE IRMAOS, 52 - CENTRO, AO LADO DA CASA DE PAULO DA QUITANDA', 'AGENTE TECNICO', '25/02/2024 16:40'),
(3, 'DIEGO EMMANUEL CADETE', 'BELO  JARDIM', 'MARIA JOSEANE DA CONCEICAO', '(81) 9.9414-5401', '092.349.874-54', '8.436.184', '', '', '100.000,00', 'TRAV. JOAQUIM NABUCO, 11 - CENTRO', 'AGENTE TECNICO', '25/02/2024 16:59'),
(4, 'MICHELLE AGNES GOMES CAVALCANTE', 'GARANHUNS', 'MARIA DE FATIMA GOMES CAVALCANTE', '(81) 9.9506-0437', '025.586.504-08', '5.516.982', '0496-0273-0809', '17055985615', '1.304,00', 'RUA SAO PAULO, 31 - VILA ADELMA, PROXIMO A ACADEMIA DE MIMI OU CASARAO', 'AGENTE TECNICO', '26/02/2024 08:09'),
(5, 'JANAINA ALVES DA SILVA', 'BELO JARDIM', 'ANA ALVES DA SILVA', '(81) 9.8979-1616', '121.642.354-79', '9.804.950', '0796-9119-0868', '16186794823', '0,00', 'RUA  TRES, 177 - IRAQUE, PROXIMO AO BAR DE BRANCO RF CONHECIDA POR JANE', 'AGENTE TECNICO', '28/02/2024 08:36'),
(6, 'LISONETE SOARES DE ARAUJO COSTA', 'SAO BENTO DO UNA', 'EVANGELINA SOARES DE ARAUJO COSTA', '(81) 9.9522-7527', '018.914.434-37', '3.132.505', '0163-5261-0809', '13185104454', '0,00', 'RUA  DA ALEGRIA, 310 - CENTRO, PROXIMO AO BAR DE WILSON', 'AGENTE TECNICO', '01/03/2024 10:59'),
(8, 'SHEENA BARBARA BRAGA DO NASCIMENTO CADETE', 'RECIFE', 'MARIA DO SOCORRO BRAGA DO NASCIMENTO', '(81) 9.8988-4895', '095.865.024-14', '', '1111-1111-1111', '', '23.000,00', 'BEM ALI PERTO DACULA', '', '04/03/2024 00:13'),
(9, 'JOSILENE SOUSA MARTINS', 'SAO BENTO DO UNA', 'AMELIA MARQUES DE SOUZA', '(00) 9.0000-0000', '658.119.764-53', '4.366.888', '0163-9365-0817', '16187301669', '440,00', 'RUA  CAPISTRANO DE ABREU, 78 - SETE IRMAOS, VIZINHA DE MARIA DO CARMO', '', '05/03/2024 10:03'),
(10, 'VALDETE AMORIM DA SILVA', 'SAO BENTO DO UNA', 'MARIA JOSEFA DE AMORIM', '(81) 9.9296-5067', '046.256.484-32', '6.725.772', '0420-4259-0833', '16598712700', '260,00', 'RUA  TRES, 123 - SANTO AFONSO, PROXIMO A IGREJA', '', '05/03/2024 14:47'),
(11, 'SUELI DE SOUZA DUARTE', 'CAPOEIRAS', 'JOSEFA CORDEIRO DE SOUZA', '(81) 9.9191-8334', '862.019.214-00', '4.477.866', '0362-0834-0850', '16537134022', '990,00', 'RUA  ONZE, 95 - JOSE DO PATROCINIO MOTA, VIZINHA A CASA DE ZEZE QUE CONSERTA MOVEIS', '', '05/03/2024 16:47'),
(12, 'SUELLEN CORDEIRO DA SILVA', 'SAO BENTO DO UNA', 'CREMILDA CORDEIRO DA SILVA', '(81) 9.9254-0510', '157.755.784-06', NULL, '', '16655973512', '0,00', 'SITIO  CANTINHO, 0 - ZONA RURAL, PROXIMO A CASA DE ADAEL E DE VALDERI PROXIMO A JURUBEBA MARIDO DA RF CONHECIDO POR MERO', 'SUPORTE TECNICO', '07/03/2024 12:53');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `concessao_historico`
--
ALTER TABLE `concessao_historico`
  ADD CONSTRAINT `concessao_historico_ibfk_1` FOREIGN KEY (`id_concessao`) REFERENCES `concessao_tbl` (`id_concessao`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
