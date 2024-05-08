-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 08, 2024 at 05:50 PM
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
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `apelido` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nivel` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `setor` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `funcao` int NOT NULL,
  `dt_nasc` date NOT NULL,
  `telefone` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `cargo` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `id_cargo` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `acesso` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_registro` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `apelido`, `usuario`, `senha`, `nivel`, `cpf`, `setor`, `funcao`, `dt_nasc`, `telefone`, `email`, `cargo`, `id_cargo`, `acesso`, `data_registro`) VALUES
(1, 'AGENTE TECNICO', 'SUPORTE', 'adm.suporte', '$2y$10$sMB2LGrmnoGCns8zURF2IO6TFk72iEw3a6pxolF9fArPffKLiqzl.', 'suport', '', 'SUPORTE', 1, '0000-00-00', '', 'tech-suas@gmail.com', 'TECNICO DO SISTEMA', '', '', '2023-12-10 16:24:02'),
(2, 'AGENTE TECNICO', 'ADMINISTRADOR', 'usuario.adm', '$2y$10$JlCvlnag6de7NzZzvYXJlOuJ9zpD9g25Bz2wW/8hcKf0QlyBHUn3K', 'admin', '', 'SUPORTE', 2, '0000-00-00', '', 'tech-suas@gmail.com', 'TECNICO DO SISTEMA', '', '', '2023-12-10 23:49:00'),
(3, 'USUARIO TESTE COMUM', 'USER COMUM', 'usuario.comum', '$2y$10$6bbttlhPT9r.WE72.F852.MSnkC0tuBMsDT0Zn7mOWT837bVSf0Q.', 'usuario', '', 'SUPORTE', 3, '0000-00-00', '', 'tech-suas@gmail.com', 'COMUM', '', '', '2023-12-11 11:10:51'),
(6, 'NAELI SILVA DE OLIVEIRA', 'NAELI', 'naeli.oliveira', '$2y$10$XnytkyKefusTAWYOPkp76eSlMlKyefnTpqfQQgJrbc9WfDxzts5ma', 'admin', '097.750.464-67', 'CREAS - GILDO SOARES', 1, '1990-11-11', '(81) 9 9231-0992', 'oliveiranaeli@hotmail.com', 'COORDENADORA O CREAS GILDO SOARES', '109320', '', '2023-12-19 19:24:39'),
(7, 'MARIA ELAINE TEIXEIRA BELO', 'ELAINE', 'maria.belo', '$2y$10$yjRvCPMdJycywn9VlWsZBuBmLPB/xIvdWgdXWpivNgMncv/osSnsG', 'admin', '044.981.524-25', 'CRAS - SANTO AFONSO', 1, '1984-04-17', '(81) 9 9186-8303', 'elaine.17sbu@gmail.com', 'COORDEADORA DO CRAS SANTO AFONSO', '107989', '', '2023-12-19 19:39:18'),
(8, 'MARLENE DA SILVA ARAUJO', 'MARLENE', 'marlene.araujo/', '$2y$10$D92JkaLuFU3ic9yx0JC0qOzGXU4gJPA9h5QucaAM9o7Iq9lnGjSLK', 'admin', '049.141.274-66', 'CRAS - ANTONIO MATIAS', 1, '1983-11-08', '(81) 9 7333-1729', 'marlenesbu@yahoo.com.br', 'COORDENAÇÃO', '04914127466', '', '2023-12-19 19:41:23'),
(9, 'RAYNAN PAES DA COSTA', 'RAYNAN', 'raynan.costa', '$2y$10$jan7OEhnYPCD3wJvdS35C.poCCh6oZyflru26TFocCmYNQTuT00Kq', 'usuario', '061.067.114-61', 'CREAS - GILDO SOARES', 2, '1987-06-26', '(81) 9 9641-3815', 'raynanpaesdacosta@gmail.com', 'COORDENADOR CRAS ANTONIO MATIAS', '12421', '', '2023-12-20 11:37:01'),
(10, 'OSNAR JOHN SANTOS DA SILVA', 'OSNAR JOHN', 'osnar.silva', '$2y$10$j2/Vgcm2HI4Sn22lVX2rZ.XGnAOQ20oLbHZyiStJPGjPVZP50or6O', 'usuario', '439.331.708-42', 'CRAS - SANTO AFONSO', 2, '1995-03-04', '(81) 9 9809-2511', 'osnarjohn@hotmail.com', 'PSICÓLOGO', '109012', '', '2023-12-20 12:09:14'),
(11, 'DIEGO EMMANUEL CADETE', 'DIEGO', 'diego.cadete', '$2y$10$sMB2LGrmnoGCns8zURF2IO6TFk72iEw3a6pxolF9fArPffKLiqzl.', 'admin', '092.349.874-54', 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL', 1, '1990-07-02', '(81) 9 9414-5401', 'emmanuelcadete@outlook.com', 'COORDENAÇÃO', 'Mat.: 109302', '', '2023-12-20 13:03:22'),
(12, 'MARLENE DA SILVA LINS', 'MARLENE', 'marlene.lins', '$2y$10$aFBAzzwsTs1XCgrx2SXCAOCkl4ESs5V5UEittPJhSYwmaNjd7SmPK', 'admin', '866.173.544-00', 'COZINHA COMUNITARIA - MARIA NEUMA DA SILVA', 1, '1966-04-01', '(71) 9 8258-9259', 'marlenelinssbu@hotmail.com', 'COORD. COZINHA COMUNITARIA', '94337', '', '2023-12-20 16:46:04'),
(13, 'GLEIDSON ALVES DA SILVA', 'GLEIDSON', 'gleidson.silva', '$2y$10$9mZDC2xrAg5UJIlpCR4WEO7DQeRW88UvUFuHVyatlbR.dvu1eSDVG', 'usuario', '012.093.054-45', 'CRAS - ANTONIO MATIAS', 2, '1983-06-06', '(81) 9 9221-7334', 'psigleidsonsilva@gmail.com', 'PSICÓLOGO', '02/24268', '', '2023-12-20 17:28:23'),
(14, 'THAÍS RAFAELA FERREIRA DE SOUZA', 'THAIS SOUZA', 'thais.souza', '$2y$10$IIP0CBJbRUxgNj1d4KAIJuGCG1w5y6SQ7AOlrNYJ4hsfXYTc8WTAW', 'usuario', '703.676.564-00', 'CRAS - ANTONIO MATIAS', 2, '1997-12-21', '(81) 9 9353-8802', 'thaisrfspsi@hotmail.com', 'PSICOLOGA', '0224485', '', '2023-12-27 13:50:35'),
(15, 'GEORGE HENRIQUE MORAES LEITE', 'GEORGE', 'george.leite', '$2y$10$gJUyynjM.81.jcp60lnJqubZ9J82qM9DiisntX/t55HixHr6E8Gdi', 'usuario', '704.523.994-75', 'CREAS - GILDO SOARES', 2, '1999-04-27', '(81) 9 9627-2644', 'psigeorgehenrique@gmail.com', 'PSICÓLOGO', '02/27729', '', '2023-12-27 13:51:07'),
(16, 'MARIZANE FERNNDO DA SIVA MACIEL', 'MARIZANE', 'marizane.maciel', '$2y$10$ak7sWq.tbui2QYIBzE/sk.G.yVKUWsH/a.VV15kkCs2pYLF72qAWK', 'usuario', '094.928.514-58', 'CRAS - SANTO AFONSO', 2, '1989-10-10', '(81) 9 7325-4120', 'marizane.fernando@gmail.com', 'ASSISTENTE SOCIAL', '108520', '', '2024-01-03 15:17:38'),
(17, 'CAMILLA MERCIA SILVA TEIXEIRA', 'CAMILLA', 'camilla.teixeira', '$2y$10$B2qc3ETfYPBMtGqRdKx/t.INKcuvQcMVBLxs4h8QE6UorAB488tlu', 'usuario', '102.379.664-33', 'NUTRICAO', 2, '1995-02-16', '(81) 9 9658-8869', 'camillamerciaaa@gmail.com', 'NUTRICIONISTA', '1234', '', '2024-01-05 14:18:43'),
(40, 'CARLA LETICIA CARNEIRO DO CARMO', 'LETICIA', 'carla.carmo', '$2y$10$eq5RJTCWhX82liB6106zNOXzGcGDRr1aeEHWxY8Wcb4DZ5XqLwTZW', 'usuario', '103.148.264-40', 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL', 0, '1994-09-25', '(81) 0 0000-0000', 'leticia_carneiiro@hotmail.com', 'ENTREVISTADOR', '0000', '', '2024-04-08 13:17:08'),
(18, 'MARIA EDUARDA DE FARIAS MORAES', 'DUDA', 'maria.moraes', '$2y$10$svX/M7cW4oTGfPcGZQkuVe8U/sjAcJzqlh37rbWxm4uiI/qGKEm7W', 'usuario', '124.907.214-02', 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL', 2, '1999-12-06', '(81) 9 9535-1954', 'cadunico.eduarda@gmail.com', 'TEC IGD', '512526262', '', '2024-02-15 11:44:08'),
(19, 'GABRIELLA STEFANY CINTRA DORNELAS', 'GABY', 'gabriella.dornelas', '$2y$10$oEMlX1g4MCFUuNuWDEvLweBNB6rtq6Cpza9SdJAPyLrcKPThwIZHi', 'usuario', '139.584.064-40', 'CRIANÇA FELIZ', 3, '2001-06-06', '(81) 9 8947-9035', 'gaabycintra06@gmail.com', 'PCF', '13958406440', '', '2024-02-26 11:40:24'),
(21, 'LUIZ HENRIQUE MORAES MANSO', 'HENRIQUE MANSO', 'luiz.manso', '$2y$10$sMB2LGrmnoGCns8zURF2IO6TFk72iEw3a6pxolF9fArPffKLiqzl.', 'usuario', '117.616.664-60', 'ADMINISTRATIVO E CONCESSÃO', 0, '1995-08-05', '(81) 9 9991-0992', 'henriquemanso1@hotmail.com', 'ADMINISTRATIVO', '11761666460', '', '2024-02-26 11:58:39'),
(22, 'ELIENE XAVIER MUNIZ', 'ELIENE', 'eliene.muniz', '$2y$10$OxlzQoYWoSppRmFwIwPHT.gMiCxXHytACvPawUmkl1Kqf6P3cqnMK', 'usuario', '493.779.734-49', 'CRAS - SANTO AFONSO', 0, '1965-02-04', '(81) 9 9431-2450', 'lienexmuniz@hotmail.com', 'RECEPCIONISTA', '95687', '', '2024-02-26 12:13:59'),
(23, 'ELIDA MARINA MACIEL ALMEIDA DE SOUZA', 'ELIDA', 'elida.souza', '$2y$10$G9M4kuRQt0./GSeG5ObNRexOidgLG.zMjFH.fh2XyZdwpd/hnWkpK', 'usuario', '115.040.934-70', 'CRAS - ANTONIO MATIAS', 0, '1997-05-26', '(81) 9 8935-1131', 'elidamarinapsi@gmail.com', 'COORDENAÇÃO', '11504093470', '', '2024-02-26 12:16:44'),
(26, 'CLÉDIA MARIA CAVALCANTE CORDEIO', 'CLÉDIA', 'cledia.cavalcante', '$2y$10$TfYHTAqnvQBtI93opqiVeObXN2dOi9op3vM9uBrnYMhMuH3oF.7fq', 'usuario', '391.391.404-82', 'CRAS - ANTONIO MATIAS', 0, '1963-08-23', '(81) 9 9986-1319', 'cordeirocledia95@gmail.com', 'AUX. ADMINISTRATIVO', '90969', '', '2024-02-26 14:25:57'),
(25, 'AURICELIA GALVAO DOS SANTOS', 'CELIA GALVAO', 'auricelia.santos', '$2y$10$OIoMP7Fnu7UM4O345CiC6u1JB79RvhlTzOmNN5A08.kQr2.QVQC32', 'usuario', '272.420.304-63', 'CRAS - ANTONIO MATIAS', 0, '1962-10-01', '(81) 9 9377-3717', 'agsgalvao@gmail.com', 'RECEPCIONISTA', '107997', '', '2024-02-26 13:04:51'),
(27, 'DRIELY SANTOS DE BRITO FERREIRA', 'DRIELY', 'driely.ferreira', '$2y$10$WC5Uk1Th76ZbI4Mr/POWGOVHkLOXNI2hCxLo5Go/ALidTgWgAdc9G', 'usuario', '135.914.704-73', 'CRIANÇA FELIZ', 0, '2001-08-24', '(81) 9 8994-5706', 'drielyds16@gmail.com', 'PCF', '13591470473', '', '2024-02-27 11:04:02'),
(28, 'MARIA CLARA SILVA DE PONTES', 'MARIA CLARA', 'maria.pontes', '$2y$10$s3pWn2XMcRmTAfgH.oqohOCt9L8OkFeIMB5dgoqhC0If076m/NdWq', 'usuario', '147.792.884-79', 'CRIANÇA FELIZ', 0, '2002-11-26', '(81) 9 9927-4673', 'mariaclarasbu@hotmail.com', 'PCF', '14779288479', '', '2024-02-28 11:13:29'),
(29, 'GABRIELA LOPES DE ARAUJO ', 'GABI', 'gabriela.araujo', '$2y$10$YUaRkw9lI9hMJF9Ho20E/.ZE5NbWM.xR4XId4mhUmy5fm4E/SY33G', 'usuario', '139.941.254-05', 'CRIANÇA FELIZ', 0, '2002-07-20', '(81) 9 7326-6354', 'gabrielalopesa02@gmail.com', 'PCF', '13994125405', '', '2024-02-28 11:16:41'),
(30, 'AMANDA LETICIA MATIAS DA SILVA', 'AMANDA', 'amanda.silva', '$2y$10$Kia7NVO0WInyZLn2b0Y9xejbjPwA48TQmVhaydMUA2vki.GG88Ts6', 'usuario', '126.814.764-88', 'CRIANÇA FELIZ', 0, '1999-07-26', '(81) 9 9222-1613', 'amandaleticia130@outlook.com', 'PCF', '12681476488', '', '2024-02-28 11:19:18'),
(31, 'MICHELLE AGNES GOMES CAVALCANTE', 'AGNES', 'michelle.cavalcante', '$2y$10$Kw2r09kVRCWjIg777d/GhuGZrLKWDNqtNRbzMhG6j2k.y6enTXZ9u', 'usuario', '025.586.504-08', 'CONCESSÃO', 0, '1978-07-08', '(81) 9 9506-0437', 'michelleagnesgc@gmail.com', 'CONCESSÃO', '02558650408', '', '2024-02-28 11:50:00'),
(32, 'MARIA EDUARDA DE MACEDO VALENÇA ', 'DUDA', 'maria.valenca', '$2y$10$a4Wlr5ojv5uguRN8heGpmOphBittOLm3jUL9uw6.b5JpMfDqalWlq', 'usuario', '101.882.114-70', 'CRAS - ANTONIO MATIAS', 0, '1992-06-06', '(81) 9 9221-9896', 'dudamacedo92@gmail.com', 'TÉCINICO(A) SOCIAL ', '10188211470', '', '2024-02-28 15:32:30'),
(33, 'MARIA RAFAELLA DE MELO COSTA ALVES', 'RAFAELLA', 'maria.alves', '$2y$10$GDWSLvig/4wkzT5gsp21c.U5tsk6VQWwlyUQXG20zPC6dGZ0b1Phe', 'usuario', '714.181.244-00', 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL', 0, '2002-01-10', '(81) 9 9398-1112', 'cadunico.rafaellamelo@gmail.co', 'TECNICA DO IGD', '714.181.244-00', '', '2024-03-07 11:34:33'),
(34, 'MARIA WILLIANE SILVA MONTEIRO SANTOS', 'WILLY ❤', 'maria.santos', '$2y$10$axSz0ZXwXkrRa4rQHuXu7u/pdM1nePg5lGKuXqTtTXhvvX0ClZUgW', 'usuario', '104.839.974-55', 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL', 0, '1995-01-25', '(81) 9 8935-2333', 'willianesobrancelhas@gmai.com', 'TECNICO DO IGD', '10483997455', '', '2024-03-07 12:18:25'),
(35, 'NAILDA MIRELY ALMEIDA MORAES DA SILVA', 'MIRELY', 'nailda.silva', '$2y$10$iQTWwwLNjChzyCtzjuByee/lCa3ioIhmPi/rsPQFdpF3Gfik1kU9C', 'usuario', '090.676.854-37', 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL', 0, '1990-03-15', '(81) 9 9202-9149', 'moraesmirely@gmail.com', 'ENTREVISTADORA', '09067685437', '', '2024-03-07 13:09:38'),
(36, 'THAMIRES DA SILVA TAVARES', 'THAMIRES TAVARES', 'thamires.tavares', '$2y$10$GzgqAVQ9/cMOn5m4xS0.Q.k/d1LfvsIcA5V0Yb0bpm/DrdbjZlK2K', 'usuario', '120.328.864-64', 'CRIANÇA FELIZ', 0, '1997-11-10', '(81) 9 8103-6198', 'thamirestavares111@gmail.com', 'ADMINISTRAÇÃO', '12032886464', '', '2024-03-11 18:52:12'),
(37, 'ROSANA SILVA DOS SANTOS ', 'ROSANA SILVA ', 'rosana.santos', '$2y$10$QNy0Aj5L/xVtRbGQfVBmWODrGkM0cwOsIpoGm6NQaUBnRtd/Q82i2', 'usuario', '137.600.554-94', 'CRIANÇA FELIZ', 0, '2000-09-05', '(81) 9 9656-3126', 'rosanaagroetre@gmail.com', 'ADMINISTRATIVO ', 'Administrativo ', '', '2024-03-12 12:07:18'),
(38, 'EVERTON DOS SANTOS GUIMARAES', 'EVERTON', 'everton.guimaraes', '$2y$10$yD8hdywhUtpwIOJ2Fuqsze9RpIXaW1xKWDfOowRGAaXMa9LZz/4OC', 'usuario', '163.492.804-07', 'CREAS - GILDO SOARES', 0, '1999-03-31', '(81) 9 9398-3390', 'evertonalves9015@gmail.com', 'SCFV', '16349280407', '', '2024-03-13 11:35:02'),
(39, 'HAMILTON SERGIO DE ASSIS FILHO', 'SERGIO', 'hamilton.filho', '$2y$10$sMB2LGrmnoGCns8zURF2IO6TFk72iEw3a6pxolF9fArPffKLiqzl.', 'usuario', '112.780.244-50', 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL', 0, '2001-08-13', '(81) 9 8958-6118', 'hamilton-saf3@hotmail.com', 'TECNICO IGD', 'TECNICO IGD', '', '2024-03-15 13:53:59');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
