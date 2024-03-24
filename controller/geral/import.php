<?php

echo "<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='website icon' type='png' href='/TechSUAS/img/geral/logo.png'>
    <title>Importar CSV</title>
</head>";

$csv_tbl = $_POST['csv_tbl'];
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

ini_set('memory_limit', '8192M');
ini_set('max_execution_time', 300);
$arquivo = $_FILES['arquivoCSV'];

$linhas_importadas = 0;
$linhas_n_importadas = 0;
$linha_nao_importada = "";
$tamanho_do_lote = 1000;

if ($csv_tbl == 'tudo') {

    //limpa os dados da tabela antes de repor os novos dados
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $limpTabela = "tbl_tudo";
    $sqli = "DELETE FROM $limpTabela";
    $pdo->exec($sqli);

    if ($arquivo['type'] == 'text/csv') {
        $dados = fopen($arquivo['tmp_name'], "r");
        // Ignorar cabeçalho
        fgetcsv($dados);

        while ($linha = fgetcsv($dados, 1000, ";")) {

            $query = "INSERT INTO tbl_tudo (cod_familiar_fam,
            dat_cadastramento_fam,
            dat_atual_fam,
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
            nom_unidade_territorial_fam,
            txt_referencia_local_fam,
            nom_entrevistador_fam,
            num_cpf_entrevistador_fam,
            vlr_renda_media_fam,
            vlr_renda_total_fam,
            marc_pbf,
            qtde_meses_desat_cat,
            cod_local_domic_fam,
            nom_povo_indigena_fam,
            cod_indigena_reside_fam,
            nom_reserva_indigena_fam,
            ind_familia_quilombola_fam,
            nom_comunidade_quilombola_fam,
            qtd_pessoas_domic_fam,
            qtd_familias_domic_fam,
            nom_estab_assist_saude_fam,
            nom_centro_assist_fam,
            num_ddd_contato_1_fam,
            num_tel_contato_1_fam,
            num_tel_contato_2_fam,
            num_ddd_contato_2_fam,
            ind_parc_mds_fam,
            ref_cad,
            ref_pbf,
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
            nom_ibge_munic_nasc_pessoa,
            nom_pais_origem_pessoa,
            fx_idade,
            num_cpf_pessoa,
            num_identidade_pessoa,
            num_cart_trab_prev_soc_pessoa,
            num_serie_trab_prev_soc_pessoa,
            num_titulo_eleitor_pessoa,
            num_zona_tit_eleitor_pessoa,
            num_secao_tit_eleitor_pessoa,
            cod_deficiencia_memb,
            cod_sabe_ler_escrever_memb,
            ind_frequenta_escola_memb,
            marc_sit_rua) VALUES (:cod_familiar_fam,
:dat_cadastramento_fam,
:dat_atual_fam,
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
:nom_unidade_territorial_fam,
:txt_referencia_local_fam,
:nom_entrevistador_fam,
:num_cpf_entrevistador_fam,
:vlr_renda_media_fam,
:vlr_renda_total_fam,
:marc_pbf,
:qtde_meses_desat_cat,
:cod_local_domic_fam,
:nom_povo_indigena_fam,
:cod_indigena_reside_fam,
:nom_reserva_indigena_fam,
:ind_familia_quilombola_fam,
:nom_comunidade_quilombola_fam,
:qtd_pessoas_domic_fam,
:qtd_familias_domic_fam,
:nom_estab_assist_saude_fam,
:nom_centro_assist_fam,
:num_ddd_contato_1_fam,
:num_tel_contato_1_fam,
:num_tel_contato_2_fam,
:num_ddd_contato_2_fam,
:ind_parc_mds_fam,
:ref_cad,
:ref_pbf,
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
:nom_ibge_munic_nasc_pessoa,
:nom_pais_origem_pessoa,
:fx_idade,
:num_cpf_pessoa,
:num_identidade_pessoa,
:num_cart_trab_prev_soc_pessoa,
:num_serie_trab_prev_soc_pessoa,
:num_titulo_eleitor_pessoa,
:num_zona_tit_eleitor_pessoa,
:num_secao_tit_eleitor_pessoa,
:cod_deficiencia_memb,
:cod_sabe_ler_escrever_memb,
:ind_frequenta_escola_memb,
:marc_sit_rua)";

            $import_data = $pdo->prepare($query);
            $import_data->bindValue(':cod_familiar_fam', ($linha[1] ?? "NULL"));
            $import_data->bindValue(':dat_cadastramento_fam', ($linha[2] ?? "NULL"));
            $import_data->bindValue(':dat_atual_fam', ($linha[3] ?? "NULL"));
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
            $import_data->bindValue(':nom_unidade_territorial_fam', ($linha[16] ?? "NULL"));
            $import_data->bindValue(':txt_referencia_local_fam', ($linha[17] ?? "NULL"));
            $import_data->bindValue(':nom_entrevistador_fam', ($linha[18] ?? "NULL"));
            $import_data->bindValue(':num_cpf_entrevistador_fam', ($linha[19] ?? "NULL"));
            $import_data->bindValue(':vlr_renda_media_fam', ($linha[20] ?? "NULL"));
            $import_data->bindValue(':vlr_renda_total_fam', ($linha[22] ?? "NULL"));
            $import_data->bindValue(':marc_pbf', ($linha[23] ?? "NULL"));
            $import_data->bindValue(':qtde_meses_desat_cat', ($linha[24] ?? "NULL"));
            $import_data->bindValue(':cod_local_domic_fam', ($linha[25] ?? "NULL"));
            $import_data->bindValue(':nom_povo_indigena_fam', ($linha[40] ?? "NULL"));
            $import_data->bindValue(':cod_indigena_reside_fam', ($linha[41] ?? "NULL"));
            $import_data->bindValue(':nom_reserva_indigena_fam', ($linha[43] ?? "NULL"));
            $import_data->bindValue(':ind_familia_quilombola_fam', ($linha[44] ?? "NULL"));
            $import_data->bindValue(':nom_comunidade_quilombola_fam', ($linha[46] ?? "NULL"));
            $import_data->bindValue(':qtd_pessoas_domic_fam', ($linha[47] ?? "NULL"));
            $import_data->bindValue(':qtd_familias_domic_fam', ($linha[48] ?? "NULL"));
            $import_data->bindValue(':nom_estab_assist_saude_fam', ($linha[59] ?? "NULL"));
            $import_data->bindValue(':nom_centro_assist_fam', ($linha[61] ?? "NULL"));
            $import_data->bindValue(':num_ddd_contato_1_fam', ($linha[63] ?? "NULL"));
            $import_data->bindValue(':num_tel_contato_1_fam', ($linha[64] ?? "NULL"));
            $import_data->bindValue(':num_tel_contato_2_fam', ($linha[67] ?? "NULL"));
            $import_data->bindValue(':num_ddd_contato_2_fam', ($linha[68] ?? "NULL"));
            $import_data->bindValue(':ind_parc_mds_fam', ($linha[72] ?? "NULL"));
            $import_data->bindValue(':ref_cad', ($linha[73] ?? "NULL"));
            $import_data->bindValue(':ref_pbf', ($linha[74] ?? "NULL"));
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
            $import_data->bindValue(':nom_ibge_munic_nasc_pessoa', ($linha[89] ?? "NULL"));
            $import_data->bindValue(':nom_pais_origem_pessoa', ($linha[91] ?? "NULL"));
            $import_data->bindValue(':fx_idade', ($linha[94] ?? "NULL"));
            $import_data->bindValue(':num_cpf_pessoa', ($linha[103] ?? "NULL"));
            $import_data->bindValue(':num_identidade_pessoa', ($linha[104] ?? "NULL"));
            $import_data->bindValue(':num_cart_trab_prev_soc_pessoa', ($linha[109] ?? "NULL"));
            $import_data->bindValue(':num_serie_trab_prev_soc_pessoa', ($linha[110] ?? "NULL"));
            $import_data->bindValue(':num_titulo_eleitor_pessoa', ($linha[113] ?? "NULL"));
            $import_data->bindValue(':num_zona_tit_eleitor_pessoa', ($linha[114] ?? "NULL"));
            $import_data->bindValue(':num_secao_tit_eleitor_pessoa', ($linha[115] ?? "NULL"));
            $import_data->bindValue(':cod_deficiencia_memb', ($linha[116] ?? "NULL"));
            $import_data->bindValue(':cod_sabe_ler_escrever_memb', ($linha[131] ?? "NULL"));
            $import_data->bindValue(':ind_frequenta_escola_memb', ($linha[132] ?? "NULL"));
            $import_data->bindValue(':marc_sit_rua', ($linha[158] ?? "NULL"));
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
            setTimeout(function() {
                window.location.href = "/TechSUAS/views/geral/atualizar_tabela";
            }, 1500);
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
