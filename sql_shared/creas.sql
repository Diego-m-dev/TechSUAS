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
-- Table structure for table `creas`
--

DROP TABLE IF EXISTS `creas`;
CREATE TABLE IF NOT EXISTS `creas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cpf` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `cod_familiar_fam` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `data_nasc` date DEFAULT NULL,
  `nome_social` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sexo` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `outro_sex` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cod_familia_indigena_fam` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom_povo_indigena_fam` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cod_indigena_reside_fam` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom_reserva_indigena_fam` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ind_familia_quilombola_fam` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom_comunidade_quilombola_fam` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nome_mae` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nome_pai` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nac_pessoa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uf_pessoa` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nat_pessoa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tel_pessoa` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_pessoa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pcd` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `rg` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complemento_rg` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_exp_rg` date DEFAULT NULL,
  `sigla_rg` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado_rg` varchar(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nis` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `num_titulo` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zone_titulo` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `area_titulo` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profissao` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `renda_per` decimal(10,2) DEFAULT NULL,
  `bairro` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logradouro` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `referencia` text COLLATE utf8mb4_general_ci,
  `qtd_pessoa` int DEFAULT NULL,
  `parentesco` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `cor_raca` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `sit_rua` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `setor` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dtcadastro` date DEFAULT NULL,
  `acesso_aliment` varchar(3) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `acompanhamento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `creas`
--

INSERT INTO `creas` (`id`, `cpf`, `cod_familiar_fam`, `nome`, `data_nasc`, `nome_social`, `sexo`, `outro_sex`, `cod_familia_indigena_fam`, `nom_povo_indigena_fam`, `cod_indigena_reside_fam`, `nom_reserva_indigena_fam`, `ind_familia_quilombola_fam`, `nom_comunidade_quilombola_fam`, `nome_mae`, `nome_pai`, `nac_pessoa`, `uf_pessoa`, `nat_pessoa`, `tel_pessoa`, `email_pessoa`, `pcd`, `rg`, `complemento_rg`, `data_exp_rg`, `sigla_rg`, `estado_rg`, `nis`, `num_titulo`, `zone_titulo`, `area_titulo`, `profissao`, `renda_per`, `bairro`, `logradouro`, `numero`, `referencia`, `qtd_pessoa`, `parentesco`, `cor_raca`, `sit_rua`, `setor`, `dtcadastro`, `acesso_aliment`, `acompanhamento`) VALUES
(17, '067.026.184-09', '03818730725', 'CLEONICE JUSTINO DA SILVA', '1975-05-26', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'LEONOR AVELINA DE BARROS', 'JOSE JUSTINO DA SILVA', 'BRASIL', 'PE', 'CAPOEIRAS', '0000000000', '', '', '00000000000006741856', '', '0000-00-00', '', '', '20911237172', '0071987500892', '0052', '', 'OUTRO', '0.00', 'IRAQUE', 'RUA  CINCO', '80', 'O CRAS ANTONIO MATIAS FICA EM FRENTE', 2, 'RESPONSAVEL FAMILIAR', 'BRANCO', '2', NULL, NULL, NULL, NULL),
(18, '705.559.694-79', '03691649548', 'MARCIA CORREIA SOUZA', '1986-03-10', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'LINDINALVA CORREIA SOUZA', '', 'BRASIL', 'PE', 'RIO LARGO', '0000000000', '', '', '00000000000009730967', '', '0000-00-00', '', '', '23635903155', '0089195790850', '0106', '', 'OUTRO', '0.00', 'IRAQUE', 'RUA  QUATRO', '297', 'PROXIMO AO BAR DE BIU', 3, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(19, '117.138.034-88', '04435672804', 'JULIANA MARIA DA SILVA', '1996-08-18', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'MARIA DAS DORES DA SILVA', '', 'BRASIL', 'PE', 'BELO JARDIM', '0000000000', '', '', '', '', '0000-00-00', '', '', '16249289543', '0088091920892', '0052', '', 'OUTRO', '5.00', 'DELMARIO BRAGA', 'RUA  SEIS', '14', 'PERTO DA QUITADA', 7, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(20, '895.068.714-34', '05801919660', 'JANAINA HERMES DE MELO', '1975-11-20', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'JACILDA BRAGA DE MELO', 'ROVESTO HERMES DE MELO', 'BRASIL', 'PE', 'RECIFE', '0000000000', '', 'TRANSTORNO/DOENCA MENTAL', '00000000000004775108', '', '0000-00-00', '', '', '23864006763', '', '', '', 'OUTRO', '325.00', 'CENTRO', 'TRAVESSA  JOAO VALENCA', '212', 'DUAS RUAS APOS A DE CAIO E CASA DE ESQUINA', 4, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(21, '072.720.444-03', '02239261242', 'ROSANGELA DA LUZ MELO', '1972-08-19', 'NEGUINHA', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'SEVERINA DA LUZ MELO', 'ROBERTO XAVIER DE MELO', 'BRASIL', 'PE', 'RECIFE', '0000000000', '', '', '00000000000009162386', '', '0000-00-00', '', '', '16573618069', '0073043940809', '0052', '', 'OUTRO', '0.00', 'PE 180', 'RUA  DA PEDRA', '30', 'PROXIMO A PONTE', 3, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(22, '720.293.184-26', '06686770230', 'NADJA DA SILVA', '2001-04-08', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'SHEILA DA SILVA', '', 'BRASIL', 'PE', 'SAO BENTO DO UNA', '0000000000', '', '', '00000000000011646164', '', '0000-00-00', '', '', '16644914919', '', '', '', 'OUTRO', '0.00', 'SANTO AFONSO II', 'RUA  ONZE', '254', 'PROXIMO A CRECHE', 3, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(23, '039.738.884-50', '00608545880', 'JOSELI VIEIRA DE AZEVEDO', '1981-12-30', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'SEVERINA DE AZEVEDO', 'JOSE VIEIRA DE MORAIS', 'BRASIL', 'PE', 'GRAVATA', '0995201559', '', '', '00000000000006443340', '', '0000-00-00', '', '', '16249241419', '0059009370833', '0052', '', 'OUTRO', '0.00', 'QUEIMADA GRANDE', 'SITIO  BAIXA', '0', 'FICA ENTRE O SITIO BASILIO E O PIMENTEL PROXIMO A ESCOLA ANA MARIA OU A IGREJA SAO FRANCISCO PROXIMO A CASA DA SUA MAE SEVERINA', 7, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(24, '068.085.244-16', '03138652301', 'GLEICIANE DA SILVA', '1987-02-10', 'GLEICE', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'JOSEFA MORENA DA SILVA', 'MANOEL FRANCISCO DA SILVA', 'BRASIL', 'PE', 'BELO JARDIM', '0094937266', '', '', '00000000000007524964', '', '0000-00-00', '', '', '16186540082', '0071769260892', '0052', '', 'OUTRO', '264.00', 'IRAQUE', 'RUA  CINCO', '87', 'AO LADO DO CRAS ANTONIO MATIAS', 6, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(25, '716.546.664-91', '00996827617', 'MARIA JOSE EZEQUIEL', '1967-02-08', 'DELZINHA', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'ADELAIDE JOANA EZEQUIEL', '', 'BRASIL', 'PE', 'SAO BENTO DO UNA', '(81) 9 9474-5681', '', '', '00000000000006739079', '', '0000-00-00', '', '', '16361690246', '0016432980833', '0052', '', 'OUTRO', '11.00', 'IRAQUE', 'RUA  CINCO', '13', 'EM FRENTE AO CRAS MAE DE MACAXEIRA', 2, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(26, '963.116.574-49', '02229299794', 'EDILEUZA PETRONILA DA CONCEICAO', '1968-07-18', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'QUITERIA PETRONILA DA CONCEICAO', '', 'BRASIL', 'PE', 'SAO JOSE DA LAJE', '0000000000', '', '', '00000000000006159187', '', '0000-00-00', '', '', '21230330900', '0061360360884', '0052', '', 'OUTRO', '0.00', 'IRAQUE', 'RUA  QUATRO', '60', 'PROXIMO A CASA DE ROSANGELA', 3, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL),
(27, '073.274.224-20', '01823059104', 'LUCILENE SANTOS DA SILVA', '1981-03-08', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'MARIA JOSE SANTOS DA SILVA', 'JOSE DA SILVA SANTOS', 'BRASIL', 'PE', 'SAO BENTO DO UNA', '0000000000', '', '', '00000000000007772449', '', '0000-00-00', '', '', '16479724551', '0071186150884', '0052', '', 'OUTRO', '217.00', 'IRAQUE', 'RUA  TRES', '197', 'PROXIMO AO BAR DE BRANCO VIZINHA A CASA DE SUELANE RF CONHECIDA POR GALEGA', 6, 'RESPONSAVEL FAMILIAR', 'BRANCO', '2', NULL, NULL, NULL, NULL),
(28, '011.630.904-09', '03955148009', 'WILMA KATIA LEITE DA SILVA TENORIO', '1980-03-08', '', 'FEMININO', NULL, '2', NULL, '2', NULL, '2', NULL, 'CICERA MARIA DA SILVA', 'MANOEL LEITE DA SILVA', 'BRASIL', 'PE', 'SAO BENTO DO UNA', '0994817242', '', '', '00000000000532289043', '', '0000-00-00', '', '', '16567095149', '0054371430809', '0230', '', 'OUTRO', '0.00', 'DELMARIO BRAGA', 'RUA  CINCO', '311', 'EM FRENTE A CAIXA DAGUA PROXIMO A ESCOLA ESTER SIQUEIRA RF CONHECIDO POR MANEZINHO', 7, 'CONJUGUE OU COMPANHEIRO', 'PARDO', '2', NULL, NULL, NULL, NULL),
(29, '333.722.094-00', '06151497660', 'JOSE LUIZ LOPES DA SILVA', '1961-05-09', '', 'MASCULINO', NULL, '2', NULL, '2', NULL, '2', NULL, 'MARIA DAS DORES SILVA', 'ARLINDO LOPES DA SILVA', 'BRASIL', 'PE', 'SAO BENTO DO UNA', '0000000000', '', '', '00000000000006207872', '', '0000-00-00', '', '', '12302081171', '0016376670868', '0052', '', 'OUTRO', '1320.00', 'ZONA RURAL', 'SITIO  AGRA', '0', 'PROXIMO A SIVUCA', 1, 'RESPONSAVEL FAMILIAR', 'PARDO', '2', NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
