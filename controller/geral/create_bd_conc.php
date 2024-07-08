<?php

$sql_create = [
  "CREATE TABLE `beneficiario` (
    `id` int(11) NOT NULL,
    `beneficiario` varchar(100) NOT NULL,
    `naturalidade` varchar(100) NOT NULL,
    `nome_mae_benef` varchar(100) NOT NULL,
    `renda_media` int(11) NOT NULL,
    `endereco_resp` varchar(255) NOT NULL,
    `cpf_beneficio` varchar(14) NOT NULL,
    `te_beneficio` varchar(14) NOT NULL,
    `rg_beneficio` varchar(24) NOT NULL,
    `parentesco` varchar(24) NOT NULL,
    `operador` varchar(100) NOT NULL,
    `data_registro` varchar(16) NOT NULL
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;",

  "CREATE TABLE `concessao_historico` (
  `id_hist` int(11) NOT NULL,
  `id_concessao` int(11) DEFAULT NULL,
  `num_form` int(11) DEFAULT NULL,
  `ano_form` varchar(4) DEFAULT NULL,
  `nome_resp` varchar(255) NOT NULL,
  `cpf_resp` varchar(14) NOT NULL,
  `nome_benef` varchar(255) DEFAULT NULL,
  `nis_benef` varchar(12) DEFAULT NULL,
  `cpf_benef` varchar(14) NOT NULL,
  `rg_benef` varchar(25) NOT NULL,
  `tit_benef` varchar(14) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `renda_media` int(11) DEFAULT NULL,
  `parecer` mediumtext DEFAULT NULL,
  `descricao` varchar(4) DEFAULT NULL,
  `nome_item` varchar(100) DEFAULT NULL,
  `qtd_item` varchar(10) DEFAULT NULL,
  `valor_uni` decimal(7,2) DEFAULT NULL,
  `valor_total` decimal(10,2) DEFAULT NULL,
  `data_registro` varchar(16) DEFAULT NULL,
  `mes_pag` varchar(10) DEFAULT NULL,
  `parentesco` varchar(30) NOT NULL,
  `operador` varchar(255) DEFAULT NULL,
  `pg_data` date DEFAULT NULL,
  `situacao_concessao` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;",

"CREATE TABLE `concessao_itens` (
  `id_itens_conc` int(11) NOT NULL,
  `cod_item` varchar(16) DEFAULT NULL,
  `caracteristica` varchar(100) DEFAULT NULL,
  `nome_item` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

"CREATE TABLE `concessao_tbl` (
  `id_concessao` int(11) NOT NULL,
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
  `data_cadastro` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

"ALTER TABLE `beneficiario`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `concessao_historico`
  ADD PRIMARY KEY (`id_hist`),
  ADD KEY `id_concessao` (`id_concessao`);",

"ALTER TABLE `concessao_itens`
  ADD PRIMARY KEY (`id_itens_conc`);",

"ALTER TABLE `concessao_tbl`
  ADD PRIMARY KEY (`id_concessao`);"
];