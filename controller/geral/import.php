<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='website icon' type='png' href='/TechSUAS/img/geral/logo.png'>
    <title>Importar CSV</title>
</head>
<?php

ini_set('memory_limit', '8192M');
ini_set('max_execution_time', 300);

if (isset($_POST['csv_tbl']) && isset($_FILES['arquivoCSV'])) {
    $csv_tbl = $_POST['csv_tbl'];
    $arquivo = $_FILES['arquivoCSV'];

    $linhas_importadas = 0;
    $linhas_n_importadas = 0;
    $linha_nao_importada = "";
    $tamanho_do_lote = 1000;

    if ($csv_tbl == 'tudo') {

        //limpa os dados da tabela antes de repor os novos dados
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $limpTabela = "tbl_tudo";
        $sqli = "TRUNCATE TABLE $limpTabela";
        $pdo->exec($sqli);

        if ($arquivo['type'] == 'text/csv') {
            $dados = fopen($arquivo['tmp_name'], "r");
            // Ignorar cabeçalho
            fgetcsv($dados);

            while ($linha = fgetcsv($dados, 1000, ";")) {

                $query = "INSERT INTO tbl_tudo (cd_ibge,
                                                cod_familiar_fam,
                                                dat_cadastramento_fam,
                                                dat_atual_fam,
                                                cod_est_cadastral_fam,
                                                cod_forma_coleta_fam,
                                                dta_entrevista_fam,
                                                nom_localidade_fam,
                                                nom_tip_logradouro_fam,
                                                nom_titulo_logradouro_fam,
                                                nom_logradouro_fam,
                                                num_logradouro_fam,
                                                des_complemento_fam,
                                                des_complemento_adic_fam,
                                                num_cep_logradouro_fam,
                                                cod_unidade_territorial_fam,
                                                nom_unidade_territorial_fam,
                                                txt_referencia_local_fam,
                                                nom_entrevistador_fam,
                                                num_cpf_entrevistador_fam,
                                                vlr_renda_media_fam,
                                                fx_rfpc,
                                                vlr_renda_total_fam,
                                                marc_pbf,
                                                qtde_meses_desat_cat,
                                                cod_local_domic_fam,
                                                cod_especie_domic_fam,
                                                qtd_comodos_domic_fam,
                                                qtd_comodos_dormitorio_fam,
                                                cod_material_piso_fam,
                                                cod_material_domic_fam,
                                                cod_agua_canalizada_fam,
                                                cod_abaste_agua_domic_fam,
                                                cod_banheiro_domic_fam,
                                                cod_escoa_sanitario_domic_fam,
                                                cod_destino_lixo_domic_fam,
                                                cod_iluminacao_domic_fam,
                                                cod_calcamento_domic_fam,
                                                cod_familia_indigena_fam,
                                                cod_povo_indigena_fam,
                                                nom_povo_indigena_fam,
                                                cod_indigena_reside_fam,
                                                cod_reserva_indigena_fam,
                                                nom_reserva_indigena_fam,
                                                ind_familia_quilombola_fam,
                                                cod_comunidade_quilombola_fam,
                                                nom_comunidade_quilombola_fam,
                                                qtd_pessoas_domic_fam,
                                                qtd_familias_domic_fam,
                                                qtd_pessoa_inter_0_17_anos_fam,
                                                qtd_pessoa_inter_18_64_anos_fam,
                                                qtd_pessoa_inter_65_anos_fam,
                                                val_desp_energia_fam,
                                                val_desp_agua_esgoto_fam,
                                                val_desp_gas_fam,
                                                val_desp_alimentacao_fam,
                                                val_desp_transpor_fam,
                                                val_desp_aluguel_fam,
                                                val_desp_medicamentos_fam,
                                                nom_estab_assist_saude_fam,
                                                cod_eas_fam,
                                                nom_centro_assist_fam,
                                                cod_centro_assist_fam,
                                                num_ddd_contato_1_fam,
                                                num_tel_contato_1_fam,
                                                ic_tipo_contato_1_fam,
                                                ic_envo_sms_contato_1_fam,
                                                num_tel_contato_2_fam,
                                                num_ddd_contato_2_fam,
                                                ic_tipo_contato_2_fam,
                                                ic_envo_sms_contato_2_fam,
                                                cod_cta_energ_unid_consum_fam,
                                                ind_parc_mds_fam,
                                                ref_cad,
                                                ref_pbf,
                                                cod_familiar_fam_,
                                                cod_est_cadastral_memb,
                                                ind_trabalho_infantil_pessoa,
                                                nom_pessoa,
                                                num_nis_pessoa_atual,
                                                nom_apelido_pessoa,
                                                cod_sexo_pessoa,
                                                dta_nasc_pessoa,
                                                cod_parentesco_rf_pessoa,
                                                cod_raca_cor_pessoa,
                                                nom_completo_mae_pessoa,
                                                nom_completo_pai_pessoa,
                                                cod_local_nascimento_pessoa,
                                                sig_uf_munic_nasc_pessoa,
                                                nom_ibge_munic_nasc_pessoa,
                                                cod_ibge_munic_nasc_pessoa,
                                                nom_pais_origem_pessoa,
                                                cod_pais_origem_pessoa,
                                                cod_certidao_registrada_pessoa,
                                                fx_idade,
                                                marc_pbf_,
                                                cod_certidao_civil_pessoa,
                                                cod_livro_termo_certid_pessoa,
                                                cod_folha_termo_certid_pessoa,
                                                cod_termo_matricula_certid_pessoa,
                                                nom_munic_certid_pessoa,
                                                cod_ibge_munic_certid_pessoa,
                                                cod_cartorio_certid_pessoa,
                                                num_cpf_pessoa,
                                                num_identidade_pessoa,
                                                cod_complemento_pessoa,
                                                dta_emissao_ident_pessoa,
                                                sig_uf_ident_pessoa,
                                                sig_orgao_emissor_pessoa,
                                                num_cart_trab_prev_soc_pessoa,
                                                num_serie_trab_prev_soc_pessoa,
                                                dta_emissao_cart_trab_pessoa,
                                                sig_uf_cart_trab_pessoa,
                                                num_titulo_eleitor_pessoa,
                                                num_zona_tit_eleitor_pessoa,
                                                num_secao_tit_eleitor_pessoa,
                                                cod_deficiencia_memb,
                                                ind_def_cegueira_memb,
                                                ind_def_baixa_visao_memb,
                                                ind_def_surdez_profunda_memb,
                                                ind_def_surdez_leve_memb,
                                                ind_def_fisica_memb,
                                                ind_def_mental_memb,
                                                ind_def_sindrome_down_memb,
                                                ind_def_transtorno_mental_memb,
                                                ind_ajuda_nao_memb,
                                                ind_ajuda_familia_memb,
                                                ind_ajuda_especializado_memb,
                                                ind_ajuda_vizinho_memb,
                                                ind_ajuda_instituicao_memb,
                                                ind_ajuda_outra_memb,
                                                cod_sabe_ler_escrever_memb,
                                                ind_frequenta_escola_memb,
                                                nom_escola_memb,
                                                cod_escola_local_memb,
                                                sig_uf_escola_memb,
                                                nom_munic_escola_memb,
                                                cod_ibge_munic_escola_memb,
                                                cod_censo_inep_memb,
                                                cod_curso_frequenta_memb,
                                                cod_ano_serie_frequenta_memb,
                                                cod_curso_frequentou_pessoa_memb,
                                                cod_ano_serie_frequentou_memb,
                                                cod_concluiu_frequentou_memb,
                                                grau_instrucao,
                                                cod_trabalhou_memb,
                                                cod_afastado_trab_memb,
                                                cod_agricultura_trab_memb,
                                                cod_principal_trab_memb,
                                                cod_trabalho_12_meses_memb,
                                                qtd_meses_12_meses_memb,
                                                fx_renda_individual_805,
                                                fx_renda_individual_808,
                                                fx_renda_individual_809_1,
                                                fx_renda_individual_809_2,
                                                fx_renda_individual_809_3,
                                                fx_renda_individual_809_4,
                                                fx_renda_individual_809_5,
                                                marc_sit_rua,
                                                ind_dormir_rua_memb,
                                                qtd_dormir_freq_rua_memb,
                                                ind_dormir_albergue_memb,
                                                qtd_dormir_freq_albergue_memb,
                                                ind_dormir_dom_part_memb,
                                                qtd_dormir_freq_dom_part_memb,
                                                ind_outro_memb,
                                                qtd_freq_outro_memb,
                                                cod_tempo_rua_memb,
                                                ind_motivo_perda_memb,
                                                ind_motivo_ameaca_memb,
                                                ind_motivo_probs_fam_memb,
                                                ind_motivo_alcool_memb,
                                                ind_motivo_desemprego_memb,
                                                ind_motivo_trabalho_memb,
                                                ind_motivo_saude_memb,
                                                ind_motivo_pref_memb,
                                                ind_motivo_outro_memb,
                                                ind_motivo_nao_sabe_memb,
                                                ind_motivo_nao_resp_memb,
                                                cod_tempo_cidade_memb,
                                                cod_vive_fam_rua_memb,
                                                cod_contato_parente_memb,
                                                ind_ativ_com_escola_memb,
                                                ind_ativ_com_coop_memb,
                                                ind_ativ_com_mov_soc_memb,
                                                ind_ativ_com_nao_sabe_memb,
                                                ind_ativ_com_nao_resp_memb,
                                                ind_atend_cras_memb,
                                                ind_atend_creas_memb,
                                                ind_atend_centro_ref_rua_memb,
                                                ind_atend_inst_gov_memb,
                                                ind_atend_inst_nao_gov_memb,
                                                ind_atend_hospital_geral_memb,
                                                cod_cart_assinada_memb,
                                                ind_dinh_const_memb,
                                                ind_dinh_flanelhinha_memb,
                                                ind_dinh_carregador_memb,
                                                ind_dinh_catador_memb,
                                                ind_dinh_servs_gerais_memb,
                                                ind_dinh_pede_memb,
                                                ind_dinh_vendas_memb,
                                                ind_dinh_outro_memb,
                                                ind_dinh_nao_resp_memb,
                                                ind_atend_nenhum_memb,
                                                ref_cad_,
                                                ref_pbf_
                                                        )
                VALUES (
                :cd_ibge,
                :cod_familiar_fam,
                :dat_cadastramento_fam,
                :dat_atual_fam,
                :cod_est_cadastral_fam,
                :cod_forma_coleta_fam,
                :dta_entrevista_fam,
                :nom_localidade_fam,
                :nom_tip_logradouro_fam,
                :nom_titulo_logradouro_fam,
                :nom_logradouro_fam,
                :num_logradouro_fam,
                :des_complemento_fam,
                :des_complemento_adic_fam,
                :num_cep_logradouro_fam,
                :cod_unidade_territorial_fam,
                :nom_unidade_territorial_fam,
                :txt_referencia_local_fam,
                :nom_entrevistador_fam,
                :num_cpf_entrevistador_fam,
                :vlr_renda_media_fam,
                :fx_rfpc,
                :vlr_renda_total_fam,
                :marc_pbf,
                :qtde_meses_desat_cat,
                :cod_local_domic_fam,
                :cod_especie_domic_fam,
                :qtd_comodos_domic_fam,
                :qtd_comodos_dormitorio_fam,
                :cod_material_piso_fam,
                :cod_material_domic_fam,
                :cod_agua_canalizada_fam,
                :cod_abaste_agua_domic_fam,
                :cod_banheiro_domic_fam,
                :cod_escoa_sanitario_domic_fam,
                :cod_destino_lixo_domic_fam,
                :cod_iluminacao_domic_fam,
                :cod_calcamento_domic_fam,
                :cod_familia_indigena_fam,
                :cod_povo_indigena_fam,
                :nom_povo_indigena_fam,
                :cod_indigena_reside_fam,
                :cod_reserva_indigena_fam,
                :nom_reserva_indigena_fam,
                :ind_familia_quilombola_fam,
                :cod_comunidade_quilombola_fam,
                :nom_comunidade_quilombola_fam,
                :qtd_pessoas_domic_fam,
                :qtd_familias_domic_fam,
                :qtd_pessoa_inter_0_17_anos_fam,
                :qtd_pessoa_inter_18_64_anos_fam,
                :qtd_pessoa_inter_65_anos_fam,
                :val_desp_energia_fam,
                :val_desp_agua_esgoto_fam,
                :val_desp_gas_fam,
                :val_desp_alimentacao_fam,
                :val_desp_transpor_fam,
                :val_desp_aluguel_fam,
                :val_desp_medicamentos_fam,
                :nom_estab_assist_saude_fam,
                :cod_eas_fam,
                :nom_centro_assist_fam,
                :cod_centro_assist_fam,
                :num_ddd_contato_1_fam,
                :num_tel_contato_1_fam,
                :ic_tipo_contato_1_fam,
                :ic_envo_sms_contato_1_fam,
                :num_tel_contato_2_fam,
                :num_ddd_contato_2_fam,
                :ic_tipo_contato_2_fam,
                :ic_envo_sms_contato_2_fam,
                :cod_cta_energ_unid_consum_fam,
                :ind_parc_mds_fam,
                :ref_cad,
                :ref_pbf,
                :cod_familiar_fam_,
                :cod_est_cadastral_memb,
                :ind_trabalho_infantil_pessoa,
                :nom_pessoa,
                :num_nis_pessoa_atual,
                :nom_apelido_pessoa,
                :cod_sexo_pessoa,
                :dta_nasc_pessoa,
                :cod_parentesco_rf_pessoa,
                :cod_raca_cor_pessoa,
                :nom_completo_mae_pessoa,
                :nom_completo_pai_pessoa,
                :cod_local_nascimento_pessoa,
                :sig_uf_munic_nasc_pessoa,
                :nom_ibge_munic_nasc_pessoa,
                :cod_ibge_munic_nasc_pessoa,
                :nom_pais_origem_pessoa,
                :cod_pais_origem_pessoa,
                :cod_certidao_registrada_pessoa,
                :fx_idade,
                :marc_pbf_,
                :cod_certidao_civil_pessoa,
                :cod_livro_termo_certid_pessoa,
                :cod_folha_termo_certid_pessoa,
                :cod_termo_matricula_certid_pessoa,
                :nom_munic_certid_pessoa,
                :cod_ibge_munic_certid_pessoa,
                :cod_cartorio_certid_pessoa,
                :num_cpf_pessoa,
                :num_identidade_pessoa,
                :cod_complemento_pessoa,
                :dta_emissao_ident_pessoa,
                :sig_uf_ident_pessoa,
                :sig_orgao_emissor_pessoa,
                :num_cart_trab_prev_soc_pessoa,
                :num_serie_trab_prev_soc_pessoa,
                :dta_emissao_cart_trab_pessoa,
                :sig_uf_cart_trab_pessoa,
                :num_titulo_eleitor_pessoa,
                :num_zona_tit_eleitor_pessoa,
                :num_secao_tit_eleitor_pessoa,
                :cod_deficiencia_memb,
                :ind_def_cegueira_memb,
                :ind_def_baixa_visao_memb,
                :ind_def_surdez_profunda_memb,
                :ind_def_surdez_leve_memb,
                :ind_def_fisica_memb,
                :ind_def_mental_memb,
                :ind_def_sindrome_down_memb,
                :ind_def_transtorno_mental_memb,
                :ind_ajuda_nao_memb,
                :ind_ajuda_familia_memb,
                :ind_ajuda_especializado_memb,
                :ind_ajuda_vizinho_memb,
                :ind_ajuda_instituicao_memb,
                :ind_ajuda_outra_memb,
                :cod_sabe_ler_escrever_memb,
                :ind_frequenta_escola_memb,
                :nom_escola_memb,
                :cod_escola_local_memb,
                :sig_uf_escola_memb,
                :nom_munic_escola_memb,
                :cod_ibge_munic_escola_memb,
                :cod_censo_inep_memb,
                :cod_curso_frequenta_memb,
                :cod_ano_serie_frequenta_memb,
                :cod_curso_frequentou_pessoa_memb,
                :cod_ano_serie_frequentou_memb,
                :cod_concluiu_frequentou_memb,
                :grau_instrucao,
                :cod_trabalhou_memb,
                :cod_afastado_trab_memb,
                :cod_agricultura_trab_memb,
                :cod_principal_trab_memb,
                :cod_trabalho_12_meses_memb,
                :qtd_meses_12_meses_memb,
                :fx_renda_individual_805,
                :fx_renda_individual_808,
                :fx_renda_individual_809_1,
                :fx_renda_individual_809_2,
                :fx_renda_individual_809_3,
                :fx_renda_individual_809_4,
                :fx_renda_individual_809_5,
                :marc_sit_rua,
                :ind_dormir_rua_memb,
                :qtd_dormir_freq_rua_memb,
                :ind_dormir_albergue_memb,
                :qtd_dormir_freq_albergue_memb,
                :ind_dormir_dom_part_memb,
                :qtd_dormir_freq_dom_part_memb,
                :ind_outro_memb,
                :qtd_freq_outro_memb,
                :cod_tempo_rua_memb,
                :ind_motivo_perda_memb,
                :ind_motivo_ameaca_memb,
                :ind_motivo_probs_fam_memb,
                :ind_motivo_alcool_memb,
                :ind_motivo_desemprego_memb,
                :ind_motivo_trabalho_memb,
                :ind_motivo_saude_memb,
                :ind_motivo_pref_memb,
                :ind_motivo_outro_memb,
                :ind_motivo_nao_sabe_memb,
                :ind_motivo_nao_resp_memb,
                :cod_tempo_cidade_memb,
                :cod_vive_fam_rua_memb,
                :cod_contato_parente_memb,
                :ind_ativ_com_escola_memb,
                :ind_ativ_com_coop_memb,
                :ind_ativ_com_mov_soc_memb,
                :ind_ativ_com_nao_sabe_memb,
                :ind_ativ_com_nao_resp_memb,
                :ind_atend_cras_memb,
                :ind_atend_creas_memb,
                :ind_atend_centro_ref_rua_memb,
                :ind_atend_inst_gov_memb,
                :ind_atend_inst_nao_gov_memb,
                :ind_atend_hospital_geral_memb,
                :cod_cart_assinada_memb,
                :ind_dinh_const_memb,
                :ind_dinh_flanelhinha_memb,
                :ind_dinh_carregador_memb,
                :ind_dinh_catador_memb,
                :ind_dinh_servs_gerais_memb,
                :ind_dinh_pede_memb,
                :ind_dinh_vendas_memb,
                :ind_dinh_outro_memb,
                :ind_dinh_nao_resp_memb,
                :ind_atend_nenhum_memb,
                :ref_cad_,
                :ref_pbf_
                        )";

                $import_data = $pdo->prepare($query);
                $import_data->bindValue(':cd_ibge', ($linha[0] ?? "NULL"));
                $import_data->bindValue(':cod_familiar_fam', ($linha[1] ?? "NULL"));
                $import_data->bindValue(':dat_cadastramento_fam', ($linha[2] ?? "NULL"));
                $import_data->bindValue(':dat_atual_fam', ($linha[3] ?? "NULL"));
                $import_data->bindValue(':cod_est_cadastral_fam', ($linha[4] ?? "NULL"));
                $import_data->bindValue(':cod_forma_coleta_fam', ($linha[5] ?? "NULL"));
                $import_data->bindValue(':dta_entrevista_fam', ($linha[6] ?? "NULL"));
                $import_data->bindValue(':nom_localidade_fam', ($linha[7] ?? "NULL"));
                $import_data->bindValue(':nom_tip_logradouro_fam', ($linha[8] ?? "NULL"));
                $import_data->bindValue(':nom_titulo_logradouro_fam', ($linha[9] ?? "NULL"));
                $import_data->bindValue(':nom_logradouro_fam', ($linha[10] ?? "NULL"));
                $import_data->bindValue(':num_logradouro_fam', ($linha[11] ?? "NULL"));
                $import_data->bindValue(':des_complemento_fam', ($linha[12] ?? "NULL"));
                $import_data->bindValue(':des_complemento_adic_fam', ($linha[13] ?? "NULL"));
                $import_data->bindValue(':num_cep_logradouro_fam', ($linha[14] ?? "NULL"));
                $import_data->bindValue(':cod_unidade_territorial_fam', ($linha[15] ?? "NULL"));
                $import_data->bindValue(':nom_unidade_territorial_fam', ($linha[16] ?? "NULL"));
                $import_data->bindValue(':txt_referencia_local_fam', ($linha[17] ?? "NULL"));
                $import_data->bindValue(':nom_entrevistador_fam', ($linha[18] ?? "NULL"));
                $import_data->bindValue(':num_cpf_entrevistador_fam', ($linha[19] ?? "NULL"));
                $import_data->bindValue(':vlr_renda_media_fam', ($linha[20] ?? "NULL"));
                $import_data->bindValue(':fx_rfpc', ($linha[21] ?? "NULL"));
                $import_data->bindValue(':vlr_renda_total_fam', ($linha[22] ?? "NULL"));
                $import_data->bindValue(':marc_pbf', ($linha[23] ?? "NULL"));
                $import_data->bindValue(':qtde_meses_desat_cat', ($linha[24] ?? "NULL"));
                $import_data->bindValue(':cod_local_domic_fam', ($linha[25] ?? "NULL"));
                $import_data->bindValue(':cod_especie_domic_fam', ($linha[26] ?? "NULL"));
                $import_data->bindValue(':qtd_comodos_domic_fam', ($linha[27] ?? "NULL"));
                $import_data->bindValue(':qtd_comodos_dormitorio_fam', ($linha[28] ?? "NULL"));
                $import_data->bindValue(':cod_material_piso_fam', ($linha[29] ?? "NULL"));
                $import_data->bindValue(':cod_material_domic_fam', ($linha[30] ?? "NULL"));
                $import_data->bindValue(':cod_agua_canalizada_fam', ($linha[31] ?? "NULL"));
                $import_data->bindValue(':cod_abaste_agua_domic_fam', ($linha[32] ?? "NULL"));
                $import_data->bindValue(':cod_banheiro_domic_fam', ($linha[33] ?? "NULL"));
                $import_data->bindValue(':cod_escoa_sanitario_domic_fam', ($linha[34] ?? "NULL"));
                $import_data->bindValue(':cod_destino_lixo_domic_fam', ($linha[35] ?? "NULL"));
                $import_data->bindValue(':cod_iluminacao_domic_fam', ($linha[36] ?? "NULL"));
                $import_data->bindValue(':cod_calcamento_domic_fam', ($linha[37] ?? "NULL"));
                $import_data->bindValue(':cod_familia_indigena_fam', ($linha[38] ?? "NULL"));
                $import_data->bindValue(':cod_povo_indigena_fam', ($linha[39] ?? "NULL"));
                $import_data->bindValue(':nom_povo_indigena_fam', ($linha[40] ?? "NULL"));
                $import_data->bindValue(':cod_indigena_reside_fam', ($linha[41] ?? "NULL"));
                $import_data->bindValue(':cod_reserva_indigena_fam', ($linha[42] ?? "NULL"));
                $import_data->bindValue(':nom_reserva_indigena_fam', ($linha[43] ?? "NULL"));
                $import_data->bindValue(':ind_familia_quilombola_fam', ($linha[44] ?? "NULL"));
                $import_data->bindValue(':cod_comunidade_quilombola_fam', ($linha[45] ?? "NULL"));
                $import_data->bindValue(':nom_comunidade_quilombola_fam', ($linha[46] ?? "NULL"));
                $import_data->bindValue(':qtd_pessoas_domic_fam', ($linha[47] ?? "NULL"));
                $import_data->bindValue(':qtd_familias_domic_fam', ($linha[48] ?? "NULL"));
                $import_data->bindValue(':qtd_pessoa_inter_0_17_anos_fam', ($linha[49] ?? "NULL"));
                $import_data->bindValue(':qtd_pessoa_inter_18_64_anos_fam', ($linha[50] ?? "NULL"));
                $import_data->bindValue(':qtd_pessoa_inter_65_anos_fam', ($linha[51] ?? "NULL"));
                $import_data->bindValue(':val_desp_energia_fam', ($linha[52] ?? "NULL"));
                $import_data->bindValue(':val_desp_agua_esgoto_fam', ($linha[53] ?? "NULL"));
                $import_data->bindValue(':val_desp_gas_fam', ($linha[54] ?? "NULL"));
                $import_data->bindValue(':val_desp_alimentacao_fam', ($linha[55] ?? "NULL"));
                $import_data->bindValue(':val_desp_transpor_fam', ($linha[56] ?? "NULL"));
                $import_data->bindValue(':val_desp_aluguel_fam', ($linha[57] ?? "NULL"));
                $import_data->bindValue(':val_desp_medicamentos_fam', ($linha[58] ?? "NULL"));
                $import_data->bindValue(':nom_estab_assist_saude_fam', ($linha[59] ?? "NULL"));
                $import_data->bindValue(':cod_eas_fam', ($linha[60] ?? "NULL"));
                $import_data->bindValue(':nom_centro_assist_fam', ($linha[61] ?? "NULL"));
                $import_data->bindValue(':cod_centro_assist_fam', ($linha[62] ?? "NULL"));
                $import_data->bindValue(':num_ddd_contato_1_fam', ($linha[63] ?? "NULL"));
                $import_data->bindValue(':num_tel_contato_1_fam', ($linha[64] ?? "NULL"));
                $import_data->bindValue(':ic_tipo_contato_1_fam', ($linha[65] ?? "NULL"));
                $import_data->bindValue(':ic_envo_sms_contato_1_fam', ($linha[66] ?? "NULL"));
                $import_data->bindValue(':num_tel_contato_2_fam', ($linha[67] ?? "NULL"));
                $import_data->bindValue(':num_ddd_contato_2_fam', ($linha[68] ?? "NULL"));
                $import_data->bindValue(':ic_tipo_contato_2_fam', ($linha[69] ?? "NULL"));
                $import_data->bindValue(':ic_envo_sms_contato_2_fam', ($linha[70] ?? "NULL"));
                $import_data->bindValue(':cod_cta_energ_unid_consum_fam', ($linha[71] ?? "NULL"));
                $import_data->bindValue(':ind_parc_mds_fam', ($linha[72] ?? "NULL"));
                $import_data->bindValue(':ref_cad', ($linha[73] ?? "NULL"));
                $import_data->bindValue(':ref_pbf', ($linha[74] ?? "NULL"));
                $import_data->bindValue(':cod_familiar_fam_', ($linha[75] ?? "NULL"));
                $import_data->bindValue(':cod_est_cadastral_memb', ($linha[76] ?? "NULL"));
                $import_data->bindValue(':ind_trabalho_infantil_pessoa', ($linha[77] ?? "NULL"));
                $import_data->bindValue(':nom_pessoa', ($linha[78] ?? "NULL"));
                $import_data->bindValue(':num_nis_pessoa_atual', ($linha[79] ?? "NULL"));
                $import_data->bindValue(':nom_apelido_pessoa', ($linha[80] ?? "NULL"));
                $import_data->bindValue(':cod_sexo_pessoa', ($linha[81] ?? "NULL"));
                $import_data->bindValue(':dta_nasc_pessoa', ($linha[82] ?? "NULL"));
                $import_data->bindValue(':cod_parentesco_rf_pessoa', ($linha[83] ?? "NULL"));
                $import_data->bindValue(':cod_raca_cor_pessoa', ($linha[84] ?? "NULL"));
                $import_data->bindValue(':nom_completo_mae_pessoa', ($linha[85] ?? "NULL"));
                $import_data->bindValue(':nom_completo_pai_pessoa', ($linha[86] ?? "NULL"));
                $import_data->bindValue(':cod_local_nascimento_pessoa', ($linha[87] ?? "NULL"));
                $import_data->bindValue(':sig_uf_munic_nasc_pessoa', ($linha[88] ?? "NULL"));
                $import_data->bindValue(':nom_ibge_munic_nasc_pessoa', ($linha[89] ?? "NULL"));
                $import_data->bindValue(':cod_ibge_munic_nasc_pessoa', ($linha[90] ?? "NULL"));
                $import_data->bindValue(':nom_pais_origem_pessoa', ($linha[91] ?? "NULL"));
                $import_data->bindValue(':cod_pais_origem_pessoa', ($linha[92] ?? "NULL"));
                $import_data->bindValue(':cod_certidao_registrada_pessoa', ($linha[93] ?? "NULL"));
                $import_data->bindValue(':fx_idade', ($linha[94] ?? "NULL"));
                $import_data->bindValue(':marc_pbf_', ($linha[95] ?? "NULL"));
                $import_data->bindValue(':cod_certidao_civil_pessoa', ($linha[96] ?? "NULL"));
                $import_data->bindValue(':cod_livro_termo_certid_pessoa', ($linha[97] ?? "NULL"));
                $import_data->bindValue(':cod_folha_termo_certid_pessoa', ($linha[98] ?? "NULL"));
                $import_data->bindValue(':cod_termo_matricula_certid_pessoa', ($linha[99] ?? "NULL"));
                $import_data->bindValue(':nom_munic_certid_pessoa', ($linha[100] ?? "NULL"));
                $import_data->bindValue(':cod_ibge_munic_certid_pessoa', ($linha[101] ?? "NULL"));
                $import_data->bindValue(':cod_cartorio_certid_pessoa', ($linha[102] ?? "NULL"));
                $import_data->bindValue(':num_cpf_pessoa', ($linha[103] ?? "NULL"));
                $import_data->bindValue(':num_identidade_pessoa', ($linha[104] ?? "NULL"));
                $import_data->bindValue(':cod_complemento_pessoa', ($linha[105] ?? "NULL"));
                $import_data->bindValue(':dta_emissao_ident_pessoa', ($linha[106] ?? "NULL"));
                $import_data->bindValue(':sig_uf_ident_pessoa', ($linha[107] ?? "NULL"));
                $import_data->bindValue(':sig_orgao_emissor_pessoa', ($linha[108] ?? "NULL"));
                $import_data->bindValue(':num_cart_trab_prev_soc_pessoa', ($linha[109] ?? "NULL"));
                $import_data->bindValue(':num_serie_trab_prev_soc_pessoa', ($linha[110] ?? "NULL"));
                $import_data->bindValue(':dta_emissao_cart_trab_pessoa', ($linha[111] ?? "NULL"));
                $import_data->bindValue(':sig_uf_cart_trab_pessoa', ($linha[112] ?? "NULL"));
                $import_data->bindValue(':num_titulo_eleitor_pessoa', ($linha[113] ?? "NULL"));
                $import_data->bindValue(':num_zona_tit_eleitor_pessoa', ($linha[114] ?? "NULL"));
                $import_data->bindValue(':num_secao_tit_eleitor_pessoa', ($linha[115] ?? "NULL"));
                $import_data->bindValue(':cod_deficiencia_memb', ($linha[116] ?? "NULL"));
                $import_data->bindValue(':ind_def_cegueira_memb', ($linha[117] ?? "NULL"));
                $import_data->bindValue(':ind_def_baixa_visao_memb', ($linha[118] ?? "NULL"));
                $import_data->bindValue(':ind_def_surdez_profunda_memb', ($linha[119] ?? "NULL"));
                $import_data->bindValue(':ind_def_surdez_leve_memb', ($linha[120] ?? "NULL"));
                $import_data->bindValue(':ind_def_fisica_memb', ($linha[121] ?? "NULL"));
                $import_data->bindValue(':ind_def_mental_memb', ($linha[122] ?? "NULL"));
                $import_data->bindValue(':ind_def_sindrome_down_memb', ($linha[123] ?? "NULL"));
                $import_data->bindValue(':ind_def_transtorno_mental_memb', ($linha[124] ?? "NULL"));
                $import_data->bindValue(':ind_ajuda_nao_memb', ($linha[125] ?? "NULL"));
                $import_data->bindValue(':ind_ajuda_familia_memb', ($linha[126] ?? "NULL"));
                $import_data->bindValue(':ind_ajuda_especializado_memb', ($linha[127] ?? "NULL"));
                $import_data->bindValue(':ind_ajuda_vizinho_memb', ($linha[128] ?? "NULL"));
                $import_data->bindValue(':ind_ajuda_instituicao_memb', ($linha[129] ?? "NULL"));
                $import_data->bindValue(':ind_ajuda_outra_memb', ($linha[130] ?? "NULL"));
                $import_data->bindValue(':cod_sabe_ler_escrever_memb', ($linha[131] ?? "NULL"));
                $import_data->bindValue(':ind_frequenta_escola_memb', ($linha[132] ?? "NULL"));
                $import_data->bindValue(':nom_escola_memb', ($linha[133] ?? "NULL"));
                $import_data->bindValue(':cod_escola_local_memb', ($linha[134] ?? "NULL"));
                $import_data->bindValue(':sig_uf_escola_memb', ($linha[135] ?? "NULL"));
                $import_data->bindValue(':nom_munic_escola_memb', ($linha[136] ?? "NULL"));
                $import_data->bindValue(':cod_ibge_munic_escola_memb', ($linha[137] ?? "NULL"));
                $import_data->bindValue(':cod_censo_inep_memb', ($linha[138] ?? "NULL"));
                $import_data->bindValue(':cod_curso_frequenta_memb', ($linha[139] ?? "NULL"));
                $import_data->bindValue(':cod_ano_serie_frequenta_memb', ($linha[140] ?? "NULL"));
                $import_data->bindValue(':cod_curso_frequentou_pessoa_memb', ($linha[141] ?? "NULL"));
                $import_data->bindValue(':cod_ano_serie_frequentou_memb', ($linha[142] ?? "NULL"));
                $import_data->bindValue(':cod_concluiu_frequentou_memb', ($linha[143] ?? "NULL"));
                $import_data->bindValue(':grau_instrucao', ($linha[144] ?? "NULL"));
                $import_data->bindValue(':cod_trabalhou_memb', ($linha[145] ?? "NULL"));
                $import_data->bindValue(':cod_afastado_trab_memb', ($linha[146] ?? "NULL"));
                $import_data->bindValue(':cod_agricultura_trab_memb', ($linha[147] ?? "NULL"));
                $import_data->bindValue(':cod_principal_trab_memb', ($linha[148] ?? "NULL"));
                $import_data->bindValue(':cod_trabalho_12_meses_memb', ($linha[149] ?? "NULL"));
                $import_data->bindValue(':qtd_meses_12_meses_memb', ($linha[150] ?? "NULL"));
                $import_data->bindValue(':fx_renda_individual_805', ($linha[151] ?? "NULL"));
                $import_data->bindValue(':fx_renda_individual_808', ($linha[152] ?? "NULL"));
                $import_data->bindValue(':fx_renda_individual_809_1', ($linha[153] ?? "NULL"));
                $import_data->bindValue(':fx_renda_individual_809_2', ($linha[154] ?? "NULL"));
                $import_data->bindValue(':fx_renda_individual_809_3', ($linha[155] ?? "NULL"));
                $import_data->bindValue(':fx_renda_individual_809_4', ($linha[156] ?? "NULL"));
                $import_data->bindValue(':fx_renda_individual_809_5', ($linha[157] ?? "NULL"));
                $import_data->bindValue(':marc_sit_rua', ($linha[158] ?? "NULL"));
                $import_data->bindValue(':ind_dormir_rua_memb', ($linha[159] ?? "NULL"));
                $import_data->bindValue(':qtd_dormir_freq_rua_memb', ($linha[160] ?? "NULL"));
                $import_data->bindValue(':ind_dormir_albergue_memb', ($linha[161] ?? "NULL"));
                $import_data->bindValue(':qtd_dormir_freq_albergue_memb', ($linha[162] ?? "NULL"));
                $import_data->bindValue(':ind_dormir_dom_part_memb', ($linha[163] ?? "NULL"));
                $import_data->bindValue(':qtd_dormir_freq_dom_part_memb', ($linha[164] ?? "NULL"));
                $import_data->bindValue(':ind_outro_memb', ($linha[165] ?? "NULL"));
                $import_data->bindValue(':qtd_freq_outro_memb', ($linha[166] ?? "NULL"));
                $import_data->bindValue(':cod_tempo_rua_memb', ($linha[167] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_perda_memb', ($linha[168] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_ameaca_memb', ($linha[169] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_probs_fam_memb', ($linha[170] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_alcool_memb', ($linha[171] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_desemprego_memb', ($linha[172] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_trabalho_memb', ($linha[173] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_saude_memb', ($linha[174] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_pref_memb', ($linha[175] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_outro_memb', ($linha[176] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_nao_sabe_memb', ($linha[177] ?? "NULL"));
                $import_data->bindValue(':ind_motivo_nao_resp_memb', ($linha[178] ?? "NULL"));
                $import_data->bindValue(':cod_tempo_cidade_memb', ($linha[179] ?? "NULL"));
                $import_data->bindValue(':cod_vive_fam_rua_memb', ($linha[180] ?? "NULL"));
                $import_data->bindValue(':cod_contato_parente_memb', ($linha[181] ?? "NULL"));
                $import_data->bindValue(':ind_ativ_com_escola_memb', ($linha[182] ?? "NULL"));
                $import_data->bindValue(':ind_ativ_com_coop_memb', ($linha[183] ?? "NULL"));
                $import_data->bindValue(':ind_ativ_com_mov_soc_memb', ($linha[184] ?? "NULL"));
                $import_data->bindValue(':ind_ativ_com_nao_sabe_memb', ($linha[185] ?? "NULL"));
                $import_data->bindValue(':ind_ativ_com_nao_resp_memb', ($linha[186] ?? "NULL"));
                $import_data->bindValue(':ind_atend_cras_memb', ($linha[187] ?? "NULL"));
                $import_data->bindValue(':ind_atend_creas_memb', ($linha[188] ?? "NULL"));
                $import_data->bindValue(':ind_atend_centro_ref_rua_memb', ($linha[189] ?? "NULL"));
                $import_data->bindValue(':ind_atend_inst_gov_memb', ($linha[190] ?? "NULL"));
                $import_data->bindValue(':ind_atend_inst_nao_gov_memb', ($linha[191] ?? "NULL"));
                $import_data->bindValue(':ind_atend_hospital_geral_memb', ($linha[192] ?? "NULL"));
                $import_data->bindValue(':cod_cart_assinada_memb', ($linha[193] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_const_memb', ($linha[194] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_flanelhinha_memb', ($linha[195] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_carregador_memb', ($linha[196] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_catador_memb', ($linha[197] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_servs_gerais_memb', ($linha[198] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_pede_memb', ($linha[199] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_vendas_memb', ($linha[200] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_outro_memb', ($linha[201] ?? "NULL"));
                $import_data->bindValue(':ind_dinh_nao_resp_memb', ($linha[202] ?? "NULL"));
                $import_data->bindValue(':ind_atend_nenhum_memb', ($linha[203] ?? "NULL"));
                $import_data->bindValue(':ref_cad_', ($linha[204] ?? "NULL"));
                $import_data->bindValue(':ref_pbf_', ($linha[205] ?? "NULL"));

                $import_data->execute();

                if ($import_data->rowCount()) {
                    $linhas_importadas++;
                } else {
                    $linhas_n_importadas++;
                    $linha_nao_importada = $linhas_n_importadas . ", " . ($linha[0] ?? "NULL");
                }
            }
            echo "$linhas_importadas linha(s) importadas, $linhas_n_importadas linha(s) não importada(s). ";
            ?>
        <script>

        </script>
<?php

        } else {
            echo "Apenas arquivos CSV.";
        }
    } elseif ($csv_tbl == 'folha') {

        //limpa os dados da tabela antes de repor os novos dados
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $limpTabela = "folha_pag";
        $sqli = "DELETE FROM $limpTabela";
        $pdo->exec($sqli);

        if ($arquivo['type'] == 'text/csv') {
            $dados = fopen($arquivo['tmp_name'], "r");
            // Ignorar cabeçalho
            fgetcsv($dados);

            while ($linha = fgetcsv($dados, 1000, ";")) {

                $query = "INSERT INTO folha_pag (prog,
            ref_folha,
            uf,
            ibge,
            cod_familiar,
            rf_cpf,
            rf_nis,
            rf_nome,
            tipo_pgto_previsto,
            pacto,
            compet_parcela,
            tp_benef,
            vlrbenef,
            vlrtotal,
            sitbeneficio,
            sitbeneficiario,
            sitfam,
            inicio_vig_benef,
            fim_vig_benef,
            marca_rf,
            quilombola,
            trab_escrv,
            indigena,
            catador_recic,
            trabalho_inf,
            renda_per_capita,
            renda_com_pbf,
            qtd_pessoas,
            dt_atu_cadastral,
            endereco,
            bairro,
            cep,
            telefone1,
            telefone2) VALUES (:prog,
                        :ref_folha,
                        :uf,
                        :ibge,
                        :cod_familiar,
                        :rf_cpf,
                        :rf_nis,
                        :rf_nome,
                        :tipo_pgto_previsto,
                        :pacto,
                        :compet_parcela,
                        :tp_benef,
                        :vlrbenef,
                        :vlrtotal,
                        :sitbeneficio,
                        :sitbeneficiario,
                        :sitfam,
                        :inicio_vig_benef,
                        :fim_vig_benef,
                        :marca_rf,
                        :quilombola,
                        :trab_escrv,
                        :indigena,
                        :catador_recic,
                        :trabalho_inf,
                        :renda_per_capita,
                        :renda_com_pbf,
                        :qtd_pessoas,
                        :dt_atu_cadastral,
                        :endereco,
                        :bairro,
                        :cep,
                        :telefone1,
                        :telefone2)";

                $import_data = $pdo->prepare($query);
                $import_data->bindValue(':prog', ($linha[0] ?? "NULL"));
                $import_data->bindValue(':ref_folha', ($linha[1] ?? "NULL"));
                $import_data->bindValue(':uf', ($linha[2] ?? "NULL"));
                $import_data->bindValue(':ibge', ($linha[3] ?? "NULL"));
                $import_data->bindValue(':cod_familiar', ($linha[4] ?? "NULL"));
                $import_data->bindValue(':rf_cpf', ($linha[5] ?? "NULL"));
                $import_data->bindValue(':rf_nis', ($linha[6] ?? "NULL"));
                $import_data->bindValue(':rf_nome', ($linha[7] ?? "NULL"));
                $import_data->bindValue(':tipo_pgto_previsto', ($linha[8] ?? "NULL"));
                $import_data->bindValue(':pacto', ($linha[9] ?? "NULL"));
                $import_data->bindValue(':compet_parcela', ($linha[10] ?? "NULL"));
                $import_data->bindValue(':tp_benef', ($linha[11] ?? "NULL"));
                $import_data->bindValue(':vlrbenef', ($linha[12] ?? "NULL"));
                $import_data->bindValue(':vlrtotal', ($linha[13] ?? "NULL"));
                $import_data->bindValue(':sitbeneficio', ($linha[14] ?? "NULL"));
                $import_data->bindValue(':sitbeneficiario', ($linha[15] ?? "NULL"));
                $import_data->bindValue(':sitfam', ($linha[16] ?? "NULL"));
                $import_data->bindValue(':inicio_vig_benef', ($linha[17] ?? "NULL"));
                $import_data->bindValue(':fim_vig_benef', ($linha[18] ?? "NULL"));
                $import_data->bindValue(':marca_rf', ($linha[19] ?? "NULL"));
                $import_data->bindValue(':quilombola', ($linha[20] ?? "NULL"));
                $import_data->bindValue(':trab_escrv', ($linha[21] ?? "NULL"));
                $import_data->bindValue(':indigena', ($linha[22] ?? "NULL"));
                $import_data->bindValue(':catador_recic', ($linha[23] ?? "NULL"));
                $import_data->bindValue(':trabalho_inf', ($linha[24] ?? "NULL"));
                $import_data->bindValue(':renda_per_capita', ($linha[25] ?? "NULL"));
                $import_data->bindValue(':renda_com_pbf', ($linha[26] ?? "NULL"));
                $import_data->bindValue(':qtd_pessoas', ($linha[27] ?? "NULL"));
                $import_data->bindValue(':dt_atu_cadastral', ($linha[28] ?? "NULL"));
                $import_data->bindValue(':endereco', ($linha[29] ?? "NULL"));
                $import_data->bindValue(':bairro', ($linha[30] ?? "NULL"));
                $import_data->bindValue(':cep', ($linha[31] ?? "NULL"));
                $import_data->bindValue(':telefone1', ($linha[32] ?? "NULL"));
                $import_data->bindValue(':telefone2', ($linha[33] ?? "NULL"));
                $import_data->execute();

                if ($import_data->rowCount()) {
                    $linhas_importadas++;
                } else {
                    $linhas_n_importadas++;
                    $linha_nao_importada = $linhas_n_importadas . ", " . ($linha[0] ?? "NULL");
                }
            }
            echo "$linhas_importadas linha(s) importadas, $linhas_n_importadas linha(s) não importada(s). ";
        } else {
            echo "Apenas arquivos CSV.";
        }
    }
} else {
    echo "Erro: Campo 'csv_tbl' ou arquivo CSV não foram enviados.";
}