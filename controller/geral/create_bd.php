<?php
$sql_create = [

// Table structure for table `averenda`

"CREATE TABLE `averenda` (
  `id` int(11) NOT NULL,
  `co_ibge` varchar(255) NOT NULL,
  `no_munic` varchar(255) NOT NULL,
  `in_processo` varchar(255) DEFAULT NULL,
  `in_grupo` varchar(255) DEFAULT NULL,
  `dt_referencia` date DEFAULT NULL,
  `in_inconsistencia` int(11) DEFAULT NULL,
  `co_familiar_fam` varchar(255) NOT NULL,
  `no_pessoa_rf` varchar(255) DEFAULT NULL,
  `nu_nis_pessoa_rf` varchar(11) DEFAULT NULL,
  `nu_cpf_pessoa_rf` varchar(11) DEFAULT NULL,
  `dt_atualizacao_fam` date DEFAULT NULL,
  `vl_renda_media_fam` decimal(10,2) DEFAULT NULL,
  `no_localidade_fam` varchar(255) DEFAULT NULL,
  `no_tip_logradouro_fam` varchar(255) DEFAULT NULL,
  `no_tit_logradouro_fam` varchar(255) DEFAULT NULL,
  `no_logradouro_fam` varchar(255) DEFAULT NULL,
  `nu_logradouro_fam` varchar(20) DEFAULT NULL,
  `ds_complemento_fam` varchar(255) DEFAULT NULL,
  `ds_complemento_adic_fam` varchar(255) DEFAULT NULL,
  `nu_cep_logradouro_fam` varchar(8) DEFAULT NULL,
  `co_utl_fam` int(11) DEFAULT NULL,
  `no_utl_fam` varchar(255) DEFAULT NULL,
  `ds_referencia_local_fam` text DEFAULT NULL,
  `co_local_domic_fam` int(11) DEFAULT NULL,
  `nu_ddd_contato_1` varchar(2) DEFAULT NULL,
  `nu_tel_contato_1` varchar(9) DEFAULT NULL,
  `nu_ddd_contato_2` varchar(2) DEFAULT NULL,
  `nu_tel_contato_2` varchar(9) DEFAULT NULL,
  `ds_email_fam` varchar(255) DEFAULT NULL,
  `no_pessoa_pi` varchar(255) DEFAULT NULL,
  `nu_nis_pessoa_pi` varchar(11) DEFAULT NULL,
  `nu_cpf_pessoa_pi` varchar(11) DEFAULT NULL,
  `flag_vinculo_rgps` tinyint(1) DEFAULT NULL,
  `flag_beneficio_inss` tinyint(1) DEFAULT NULL,
  `flag_seguro_desemprego` tinyint(1) DEFAULT NULL,
  `flag_sdpa` tinyint(1) DEFAULT NULL,
  `flag_siape` tinyint(1) DEFAULT NULL,
  `flag_estagiario_siape` tinyint(1) DEFAULT NULL,
  `flag_residente_siape` tinyint(1) DEFAULT NULL,
  `flag_rais` tinyint(1) DEFAULT NULL,
  `flag_serv_cnj` tinyint(1) DEFAULT NULL,
  `flag_defesa` tinyint(1) DEFAULT NULL,
  `flag_cgu` tinyint(1) DEFAULT NULL,
  `dt_limite_bloqpbf` date DEFAULT NULL,
  `dt_limite_cancela` date DEFAULT NULL,
  `dt_limite_exclusao` date DEFAULT NULL,
  `in_pbf` tinyint(1) DEFAULT NULL,
  `in_tsee` tinyint(1) DEFAULT NULL,
  `in_bpc_idoso` tinyint(1) DEFAULT NULL,
  `in_bpc_pcd` tinyint(1) DEFAULT NULL,
  `in_fam_transferida` tinyint(1) DEFAULT NULL,
  `in_situacao_pes` varchar(255) DEFAULT NULL,
  `in_situacao_fam` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

// Table structure for table `cadastro_forms`

"CREATE TABLE `cadastro_forms` (
  `id` int(11) NOT NULL,
  `cod_familiar_fam` varchar(50) NOT NULL,
  `data_entrevista` date NOT NULL,
  `tipo_documento` varchar(100) NOT NULL,
  `arquivo` longblob NOT NULL,
  `tamanho` int(11) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `tipo_mime` varchar(50) NOT NULL,
  `verificado` int(11) NOT NULL,
  `obs_familia` text NOT NULL,
  `sit_beneficio` varchar(100) NOT NULL,
  `operador` varchar(100) NOT NULL,
  `criacao` timestamp NULL DEFAULT current_timestamp(),
  `modificacao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;;",

// Table structure for table `fichario`

"CREATE TABLE `fichario` (
  `id` int(11) NOT NULL,
  `codfam` varchar(11) NOT NULL,
  `arm_gav_pas` varchar(13) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `operador` varchar(100) NOT NULL,
  `arm` int(2) NOT NULL,
  `gav` int(2) NOT NULL,
  `pas` int(3) NOT NULL,
  `print_id` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;;",

// Table structure for table `ficharios`

"CREATE TABLE `ficharios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arm` varchar(2) NOT NULL,
  `gav` varchar(2) NOT NULL,
  `pas` varchar(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_arm_gav_pas` (`arm`, `gav`, `pas`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",


// Table structure for table `folha_pag`

"CREATE TABLE `folha_pag` (
  `prog` varchar(4) NOT NULL,
  `ref_folha` varchar(6) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `ibge` varchar(7) NOT NULL,
  `cod_familiar` varchar(11) NOT NULL,
  `rf_cpf` varchar(14) NOT NULL,
  `rf_nis` varchar(11) NOT NULL,
  `rf_nome` varchar(255) NOT NULL,
  `tipo_pgto_previsto` varchar(1) NOT NULL,
  `pacto` varchar(1) NOT NULL,
  `compet_parcela` varchar(6) NOT NULL,
  `tp_benef` varchar(6) NOT NULL,
  `vlrbenef` float NOT NULL,
  `vlrtotal` float NOT NULL,
  `sitbeneficio` varchar(20) NOT NULL,
  `sitbeneficiario` varchar(20) NOT NULL,
  `sitfam` varchar(20) NOT NULL,
  `inicio_vig_benef` varchar(6) NOT NULL,
  `fim_vig_benef` varchar(6) NOT NULL,
  `marca_rf` varchar(2) NOT NULL,
  `quilombola` varchar(2) NOT NULL,
  `trab_escrv` varchar(2) NOT NULL,
  `indigena` varchar(2) NOT NULL,
  `catador_recic` varchar(2) NOT NULL,
  `trabalho_inf` varchar(2) NOT NULL,
  `renda_per_capita` float NOT NULL,
  `renda_com_pbf` float NOT NULL,
  `qtd_pessoas` varchar(2) NOT NULL,
  `dt_atu_cadastral` varchar(10) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `bairro` varchar(70) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `telefone1` varchar(12) NOT NULL,
  `telefone2` varchar(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

// Table structure for table `historico_parecer_visita`

"CREATE TABLE `historico_parecer_visita` (
  `id` int(11) NOT NULL,
  `id_visitas` int(11) NOT NULL,
  `numero_parecer` varchar(5) NOT NULL,
  `ano_parecer` varchar(4) NOT NULL,
  `codigo_familiar` varchar(50) NOT NULL,
  `data_entrevista` varchar(10) NOT NULL,
  `renda_per_capita` varchar(12) NOT NULL,
  `localidade` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `nome_logradouro` varchar(255) NOT NULL,
  `numero_logradouro` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `complemento_numero` varchar(10) NOT NULL,
  `complemento_adicional` varchar(15) NOT NULL,
  `cep` varchar(25) NOT NULL,
  `referencia_localizacao` text NOT NULL,
  `situacao` varchar(50) NOT NULL,
  `resumo_visita` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

// Table structure for table `membros_familia`

"CREATE TABLE `membros_familia` (
  `id` int(11) NOT NULL,
  `parecer_id` int(11) NOT NULL,
  `parentesco` varchar(50) NOT NULL,
  `nome_completo` varchar(100) NOT NULL,
  `nis` varchar(50) NOT NULL,
  `data_nascimento` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

// Table structure for table `solicita`

"CREATE TABLE `solicita` (
  `id` int(11) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cod_fam` varchar(20) NOT NULL,
  `status` varchar(55) NOT NULL,
  `tipo` int(10) NOT NULL,
  `nis` varchar(15) NOT NULL,
  `data_solicitacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",

// Table structure for table `tbl_tudo`

"CREATE TABLE `tbl_tudo` (
  `id` int(11) NOT NULL,
  `cd_ibge` bigint(20) DEFAULT NULL,
  `cod_familiar_fam` varchar(11) DEFAULT NULL,
  `dat_cadastramento_fam` varchar(10) DEFAULT NULL,
  `dat_atual_fam` varchar(10) DEFAULT NULL,
  `cod_est_cadastral_fam` decimal(1,0) DEFAULT NULL,
  `cod_forma_coleta_fam` decimal(1,0) DEFAULT NULL,
  `dta_entrevista_fam` varchar(10) DEFAULT NULL,
  `nom_localidade_fam` varchar(100) DEFAULT NULL,
  `nom_tip_logradouro_fam` varchar(40) DEFAULT NULL,
  `nom_titulo_logradouro_fam` varchar(40) DEFAULT NULL,
  `nom_logradouro_fam` varchar(70) DEFAULT NULL,
  `num_logradouro_fam` int(11) DEFAULT NULL,
  `des_complemento_fam` varchar(20) DEFAULT NULL,
  `des_complemento_adic_fam` varchar(20) DEFAULT NULL,
  `num_cep_logradouro_fam` varchar(8) DEFAULT NULL,
  `cod_unidade_territorial_fam` varchar(3) DEFAULT NULL,
  `nom_unidade_territorial_fam` varchar(40) DEFAULT NULL,
  `txt_referencia_local_fam` varchar(255) DEFAULT NULL,
  `nom_entrevistador_fam` varchar(70) DEFAULT NULL,
  `num_cpf_entrevistador_fam` varchar(11) DEFAULT NULL,
  `vlr_renda_media_fam` decimal(9,0) DEFAULT NULL,
  `fx_rfpc` varchar(2) DEFAULT NULL,
  `vlr_renda_total_fam` decimal(10,0) DEFAULT NULL,
  `marc_pbf` varchar(1) DEFAULT NULL,
  `qtde_meses_desat_cat` varchar(3) DEFAULT NULL,
  `cod_local_domic_fam` varchar(1) DEFAULT NULL,
  `cod_especie_domic_fam` decimal(1,0) DEFAULT NULL,
  `qtd_comodos_domic_fam` decimal(2,0) DEFAULT NULL,
  `qtd_comodos_dormitorio_fam` decimal(2,0) DEFAULT NULL,
  `cod_material_piso_fam` decimal(1,0) DEFAULT NULL,
  `cod_material_domic_fam` decimal(1,0) DEFAULT NULL,
  `cod_agua_canalizada_fam` decimal(1,0) DEFAULT NULL,
  `cod_abaste_agua_domic_fam` decimal(1,0) DEFAULT NULL,
  `cod_banheiro_domic_fam` decimal(1,0) DEFAULT NULL,
  `cod_escoa_sanitario_domic_fam` decimal(1,0) DEFAULT NULL,
  `cod_destino_lixo_domic_fam` decimal(1,0) DEFAULT NULL,
  `cod_iluminacao_domic_fam` decimal(1,0) DEFAULT NULL,
  `cod_calcamento_domic_fam` decimal(1,0) DEFAULT NULL,
  `cod_familia_indigena_fam` decimal(1,0) DEFAULT NULL,
  `cod_povo_indigena_fam` varchar(3) DEFAULT NULL,
  `nom_povo_indigena_fam` varchar(70) DEFAULT NULL,
  `cod_indigena_reside_fam` decimal(1,0) DEFAULT NULL,
  `cod_reserva_indigena_fam` varchar(6) DEFAULT NULL,
  `nom_reserva_indigena_fam` varchar(70) DEFAULT NULL,
  `ind_familia_quilombola_fam` decimal(1,0) DEFAULT NULL,
  `cod_comunidade_quilombola_fam` varchar(4) DEFAULT NULL,
  `nom_comunidade_quilombola_fam` varchar(120) DEFAULT NULL,
  `qtd_pessoas_domic_fam` decimal(2,0) DEFAULT NULL,
  `qtd_familias_domic_fam` decimal(2,0) DEFAULT NULL,
  `qtd_pessoa_inter_0_17_anos_fam` decimal(2,0) DEFAULT NULL,
  `qtd_pessoa_inter_18_64_anos_fam` decimal(2,0) DEFAULT NULL,
  `qtd_pessoa_inter_65_anos_fam` decimal(2,0) DEFAULT NULL,
  `val_desp_energia_fam` decimal(5,0) DEFAULT NULL,
  `val_desp_agua_esgoto_fam` decimal(5,0) DEFAULT NULL,
  `val_desp_gas_fam` decimal(5,0) DEFAULT NULL,
  `val_desp_alimentacao_fam` decimal(5,0) DEFAULT NULL,
  `val_desp_transpor_fam` decimal(5,0) DEFAULT NULL,
  `val_desp_aluguel_fam` decimal(5,0) DEFAULT NULL,
  `val_desp_medicamentos_fam` decimal(5,0) DEFAULT NULL,
  `nom_estab_assist_saude_fam` varchar(70) DEFAULT NULL,
  `cod_eas_fam` varchar(12) DEFAULT NULL,
  `nom_centro_assist_fam` varchar(70) DEFAULT NULL,
  `cod_centro_assist_fam` varchar(12) DEFAULT NULL,
  `num_ddd_contato_1_fam` varchar(10) DEFAULT NULL,
  `num_tel_contato_1_fam` varchar(10) DEFAULT NULL,
  `ic_tipo_contato_1_fam` varchar(10) DEFAULT NULL,
  `ic_envo_sms_contato_1_fam` varchar(10) DEFAULT NULL,
  `num_tel_contato_2_fam` varchar(10) DEFAULT NULL,
  `num_ddd_contato_2_fam` varchar(10) DEFAULT NULL,
  `ic_tipo_contato_2_fam` varchar(10) DEFAULT NULL,
  `ic_envo_sms_contato_2_fam` varchar(10) DEFAULT NULL,
  `cod_cta_energ_unid_consum_fam` varchar(20) DEFAULT NULL,
  `ind_parc_mds_fam` decimal(3,0) DEFAULT NULL,
  `ref_cad` decimal(8,0) DEFAULT NULL,
  `ref_pbf` decimal(8,0) DEFAULT NULL,
  `cod_familiar_fam_` varchar(11) DEFAULT NULL,
  `cod_est_cadastral_memb` decimal(1,0) DEFAULT NULL,
  `ind_trabalho_infantil_pessoa` decimal(1,0) DEFAULT NULL,
  `nom_pessoa` varchar(70) DEFAULT NULL,
  `num_nis_pessoa_atual` varchar(11) DEFAULT NULL,
  `nom_apelido_pessoa` varchar(40) DEFAULT NULL,
  `cod_sexo_pessoa` decimal(1,0) DEFAULT NULL,
  `dta_nasc_pessoa` varchar(10) DEFAULT NULL,
  `cod_parentesco_rf_pessoa` decimal(2,0) DEFAULT NULL,
  `cod_raca_cor_pessoa` decimal(1,0) DEFAULT NULL,
  `nom_completo_mae_pessoa` varchar(70) DEFAULT NULL,
  `nom_completo_pai_pessoa` varchar(70) DEFAULT NULL,
  `cod_local_nascimento_pessoa` decimal(1,0) DEFAULT NULL,
  `sig_uf_munic_nasc_pessoa` varchar(2) DEFAULT NULL,
  `nom_ibge_munic_nasc_pessoa` varchar(35) DEFAULT NULL,
  `cod_ibge_munic_nasc_pessoa` decimal(7,0) DEFAULT NULL,
  `nom_pais_origem_pessoa` varchar(40) DEFAULT NULL,
  `cod_pais_origem_pessoa` decimal(2,0) DEFAULT NULL,
  `cod_certidao_registrada_pessoa` decimal(1,0) DEFAULT NULL,
  `fx_idade` decimal(2,0) DEFAULT NULL,
  `marc_pbf_` varchar(1) DEFAULT NULL,
  `cod_certidao_civil_pessoa` decimal(1,0) DEFAULT NULL,
  `cod_livro_termo_certid_pessoa` varchar(8) DEFAULT NULL,
  `cod_folha_termo_certid_pessoa` varchar(4) DEFAULT NULL,
  `cod_termo_matricula_certid_pessoa` varchar(33) DEFAULT NULL,
  `nom_munic_certid_pessoa` varchar(35) DEFAULT NULL,
  `cod_ibge_munic_certid_pessoa` varchar(7) DEFAULT NULL,
  `cod_cartorio_certid_pessoa` varchar(15) DEFAULT NULL,
  `num_cpf_pessoa` varchar(11) DEFAULT NULL,
  `num_identidade_pessoa` varchar(20) DEFAULT NULL,
  `cod_complemento_pessoa` varchar(5) DEFAULT NULL,
  `dta_emissao_ident_pessoa` date DEFAULT NULL,
  `sig_uf_ident_pessoa` varchar(2) DEFAULT NULL,
  `sig_orgao_emissor_pessoa` varchar(8) DEFAULT NULL,
  `num_cart_trab_prev_soc_pessoa` varchar(7) DEFAULT NULL,
  `num_serie_trab_prev_soc_pessoa` varchar(5) DEFAULT NULL,
  `dta_emissao_cart_trab_pessoa` date DEFAULT NULL,
  `sig_uf_cart_trab_pessoa` varchar(2) DEFAULT NULL,
  `num_titulo_eleitor_pessoa` varchar(13) DEFAULT NULL,
  `num_zona_tit_eleitor_pessoa` varchar(4) DEFAULT NULL,
  `num_secao_tit_eleitor_pessoa` varchar(4) DEFAULT NULL,
  `cod_deficiencia_memb` decimal(1,0) DEFAULT NULL,
  `ind_def_cegueira_memb` decimal(1,0) DEFAULT NULL,
  `ind_def_baixa_visao_memb` decimal(1,0) DEFAULT NULL,
  `ind_def_surdez_profunda_memb` decimal(1,0) DEFAULT NULL,
  `ind_def_surdez_leve_memb` decimal(1,0) DEFAULT NULL,
  `ind_def_fisica_memb` decimal(1,0) DEFAULT NULL,
  `ind_def_mental_memb` decimal(1,0) DEFAULT NULL,
  `ind_def_sindrome_down_memb` decimal(1,0) DEFAULT NULL,
  `ind_def_transtorno_mental_memb` decimal(1,0) DEFAULT NULL,
  `ind_ajuda_nao_memb` decimal(1,0) DEFAULT NULL,
  `ind_ajuda_familia_memb` decimal(1,0) DEFAULT NULL,
  `ind_ajuda_especializado_memb` decimal(1,0) DEFAULT NULL,
  `ind_ajuda_vizinho_memb` decimal(1,0) DEFAULT NULL,
  `ind_ajuda_instituicao_memb` decimal(1,0) DEFAULT NULL,
  `ind_ajuda_outra_memb` decimal(1,0) DEFAULT NULL,
  `cod_sabe_ler_escrever_memb` decimal(1,0) DEFAULT NULL,
  `ind_frequenta_escola_memb` decimal(1,0) DEFAULT NULL,
  `nom_escola_memb` varchar(70) DEFAULT NULL,
  `cod_escola_local_memb` decimal(1,0) DEFAULT NULL,
  `sig_uf_escola_memb` varchar(2) DEFAULT NULL,
  `nom_munic_escola_memb` varchar(35) DEFAULT NULL,
  `cod_ibge_munic_escola_memb` decimal(7,0) DEFAULT NULL,
  `cod_censo_inep_memb` varchar(8) DEFAULT NULL,
  `cod_curso_frequenta_memb` decimal(2,0) DEFAULT NULL,
  `cod_ano_serie_frequenta_memb` decimal(2,0) DEFAULT NULL,
  `cod_curso_frequentou_pessoa_memb` decimal(2,0) DEFAULT NULL,
  `cod_ano_serie_frequentou_memb` decimal(2,0) DEFAULT NULL,
  `cod_concluiu_frequentou_memb` decimal(1,0) DEFAULT NULL,
  `grau_instrucao` decimal(1,0) DEFAULT NULL,
  `cod_trabalhou_memb` decimal(1,0) DEFAULT NULL,
  `cod_afastado_trab_memb` decimal(1,0) DEFAULT NULL,
  `cod_agricultura_trab_memb` decimal(1,0) DEFAULT NULL,
  `cod_principal_trab_memb` decimal(2,0) DEFAULT NULL,
  `cod_trabalho_12_meses_memb` decimal(1,0) DEFAULT NULL,
  `qtd_meses_12_meses_memb` decimal(2,0) DEFAULT NULL,
  `fx_renda_individual_805` decimal(5,0) DEFAULT NULL,
  `fx_renda_individual_808` decimal(5,0) DEFAULT NULL,
  `fx_renda_individual_809_1` decimal(5,0) DEFAULT NULL,
  `fx_renda_individual_809_2` decimal(5,0) DEFAULT NULL,
  `fx_renda_individual_809_3` decimal(5,0) DEFAULT NULL,
  `fx_renda_individual_809_4` decimal(5,0) DEFAULT NULL,
  `fx_renda_individual_809_5` decimal(5,0) DEFAULT NULL,
  `marc_sit_rua` decimal(1,0) DEFAULT NULL,
  `ind_dormir_rua_memb` decimal(1,0) DEFAULT NULL,
  `qtd_dormir_freq_rua_memb` decimal(1,0) DEFAULT NULL,
  `ind_dormir_albergue_memb` decimal(1,0) DEFAULT NULL,
  `qtd_dormir_freq_albergue_memb` decimal(1,0) DEFAULT NULL,
  `ind_dormir_dom_part_memb` decimal(1,0) DEFAULT NULL,
  `qtd_dormir_freq_dom_part_memb` decimal(1,0) DEFAULT NULL,
  `ind_outro_memb` decimal(1,0) DEFAULT NULL,
  `qtd_freq_outro_memb` decimal(1,0) DEFAULT NULL,
  `cod_tempo_rua_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_perda_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_ameaca_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_probs_fam_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_alcool_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_desemprego_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_trabalho_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_saude_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_pref_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_outro_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_nao_sabe_memb` decimal(1,0) DEFAULT NULL,
  `ind_motivo_nao_resp_memb` decimal(1,0) DEFAULT NULL,
  `cod_tempo_cidade_memb` decimal(1,0) DEFAULT NULL,
  `cod_vive_fam_rua_memb` decimal(1,0) DEFAULT NULL,
  `cod_contato_parente_memb` decimal(1,0) DEFAULT NULL,
  `ind_ativ_com_escola_memb` decimal(1,0) DEFAULT NULL,
  `ind_ativ_com_coop_memb` decimal(1,0) DEFAULT NULL,
  `ind_ativ_com_mov_soc_memb` decimal(1,0) DEFAULT NULL,
  `ind_ativ_com_nao_sabe_memb` decimal(1,0) DEFAULT NULL,
  `ind_ativ_com_nao_resp_memb` decimal(1,0) DEFAULT NULL,
  `ind_atend_cras_memb` decimal(1,0) DEFAULT NULL,
  `ind_atend_creas_memb` decimal(1,0) DEFAULT NULL,
  `ind_atend_centro_ref_rua_memb` decimal(1,0) DEFAULT NULL,
  `ind_atend_inst_gov_memb` decimal(1,0) DEFAULT NULL,
  `ind_atend_inst_nao_gov_memb` decimal(1,0) DEFAULT NULL,
  `ind_atend_hospital_geral_memb` decimal(1,0) DEFAULT NULL,
  `cod_cart_assinada_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_const_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_flanelhinha_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_carregador_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_catador_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_servs_gerais_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_pede_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_vendas_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_outro_memb` decimal(1,0) DEFAULT NULL,
  `ind_dinh_nao_resp_memb` decimal(1,0) DEFAULT NULL,
  `ind_atend_nenhum_memb` decimal(1,0) DEFAULT NULL,
  `ref_cad_` decimal(8,0) DEFAULT NULL,
  `ref_pbf_` decimal(8,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

// Table structure for table `unipessoal`

"CREATE TABLE `unipessoal` (
  `id` int(11) NOT NULL,
  `co_ibge` varchar(255) NOT NULL,
  `no_munic` varchar(255) NOT NULL,
  `in_processo` varchar(255) DEFAULT NULL,
  `in_grupo` varchar(255) DEFAULT NULL,
  `dt_referencia` varchar(10) DEFAULT NULL,
  `in_inconsistencia_uni` int(11) DEFAULT NULL,
  `co_familiar_fam` varchar(255) DEFAULT NULL,
  `no_pessoa_rf` varchar(255) DEFAULT NULL,
  `nu_nis_pessoa_rf` varchar(11) DEFAULT NULL,
  `nu_cpf_pessoa_rf` varchar(11) DEFAULT NULL,
  `dt_atualizacao_fam` varchar(10) DEFAULT NULL,
  `vl_renda_media_fam` decimal(10,2) DEFAULT NULL,
  `no_localidade_fam` varchar(255) DEFAULT NULL,
  `no_tip_logradouro_fam` varchar(255) DEFAULT NULL,
  `no_tit_logradouro_fam` varchar(255) DEFAULT NULL,
  `no_logradouro_fam` varchar(255) DEFAULT NULL,
  `nu_logradouro_fam` varchar(20) DEFAULT NULL,
  `ds_complemento_fam` varchar(255) DEFAULT NULL,
  `ds_complemento_adic_fam` varchar(255) DEFAULT NULL,
  `nu_cep_logradouro_fam` varchar(8) DEFAULT NULL,
  `co_utl_fam` int(11) DEFAULT NULL,
  `no_utl_fam` varchar(255) DEFAULT NULL,
  `ds_referencia_local_fam` text DEFAULT NULL,
  `co_local_domic_fam` int(11) DEFAULT NULL,
  `nu_ddd_contato_1` varchar(2) DEFAULT NULL,
  `nu_tel_contato_1` varchar(9) DEFAULT NULL,
  `nu_ddd_contato_2` varchar(2) DEFAULT NULL,
  `nu_tel_contato_2` varchar(9) DEFAULT NULL,
  `ds_email_fam` varchar(255) DEFAULT NULL,
  `dt_limite_bloqpbf` varchar(10) DEFAULT NULL,
  `dt_limite_cancela` varchar(10) DEFAULT NULL,
  `dt_limite_exclusao` varchar(10) DEFAULT NULL,
  `in_pbf` tinyint(1) DEFAULT NULL,
  `in_tsee` tinyint(1) DEFAULT NULL,
  `in_bpc_idoso` tinyint(1) DEFAULT NULL,
  `in_bpc_pcd` tinyint(1) DEFAULT NULL,
  `in_fam_transferida` tinyint(1) DEFAULT NULL,
  `in_situacao` varchar(255) DEFAULT NULL,
  `in_situacao_detalhe` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

// Table structure for table `visitas_feitas`

"CREATE TABLE `visitas_feitas` (
  `id` int(11) NOT NULL,
  `cod_fam` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL,
  `acao` varchar(255) NOT NULL,
  `parecer_tec` text NOT NULL,
  `entrevistador` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;",

"ALTER TABLE `averenda`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `cadastro_forms`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `fichario`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `historico_parecer_visita`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `membros_familia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parecer_id` (`parecer_id`);",

"ALTER TABLE `solicita`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `tbl_tudo`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `unipessoal`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `visitas_feitas`
  ADD PRIMARY KEY (`id`);",

"ALTER TABLE `averenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

"ALTER TABLE `cadastro_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

"ALTER TABLE `fichario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

"ALTER TABLE `historico_parecer_visita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

"ALTER TABLE `membros_familia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

"ALTER TABLE `solicita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

"ALTER TABLE `tbl_tudo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

"ALTER TABLE `unipessoal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

"ALTER TABLE `visitas_feitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",


// Table structure for table `status_familia`

  "CREATE TABLE status_familia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cod_familiar VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
    status VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
DELIMITER //

CREATE PROCEDURE atualizar_status_familia()
BEGIN
    -- Temporarily mark all families as inactive
    UPDATE status_familia
    SET status = 'inativo', data_atualizacao = NOW();

    -- Update families that are still active
    INSERT INTO status_familia (cod_familiar, status, data_atualizacao, nom_pess)
    SELECT cod_familiar_fam, 'ativo', dat_atual_fam, nom_pessoa
    FROM tbl_tudo
    WHERE cod_parentesco_rf_pessoa = 1
    ON DUPLICATE KEY UPDATE 
        status = VALUES(status), 
        data_atualizacao = VALUES(data_atualizacao);

END //
DELIMITER;

CREATE EVENT IF NOT EXISTS atualizar_status_familia_event
ON SCHEDULE EVERY 1 DAY
DO
CALL atualizar_status_familia();

SET GLOBAL event_scheduler = ON;

CALL atualizar_status_familia();",

"CREATE TABLE `descartes` (
  `id` int(11) NOT NULL,
  `codfam` varchar(11) NOT NULL,
  `data_entrevista` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `operador` varchar(100) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `descartes`
  ADD PRIMARY KEY (`id`);
  
  ALTER TABLE `descartes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;",

];