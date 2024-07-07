<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

// Função para executar consulta SQL e retornar os resultados
function executeQuery($conn, $query) {
    $result = $conn->query($query);
    if (!$result) {
        die("ERRO na consulta: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_NUM);
}

$solicitacao_sql = "SELECT 
  cod_familiar_fam, 
  nom_pessoa, 
  num_nis_pessoa_atual, 
  dat_atual_fam, 
  dta_entrevista_fam, 
  CONCAT('R$ ', vlr_renda_total_fam, ',00') AS vlr_renda_total_fam, 
  CONCAT(nom_tip_logradouro_fam, ' ', nom_titulo_logradouro_fam, ' ', nom_logradouro_fam, ', ', num_logradouro_fam, ' - ', nom_localidade_fam, ' ', txt_referencia_local_fam) AS endereco, 
  CASE 
    WHEN qtde_meses_desat_cat = 0 THEN 'ATUALIZADA' 
    ELSE 'DESATUALIZADO' 
  END AS status_atualizacao,
  CASE
    WHEN cod_familia_indigena_fam = 1 THEN 'INDÍGENA'
    WHEN ind_familia_quilombola_fam = 1 THEN 'QUILOMBOLA'
    ELSE ''
  END AS grupo_familia,
  CASE
    WHEN ind_parc_mds_fam = 101 THEN 'FAMILIA CIGANA'
    WHEN ind_parc_mds_fam = 201 THEN 'FAMILIA EXTRATIVISTA'
    WHEN ind_parc_mds_fam = 202 THEN 'FAMILIA DE PESCADORES  ARTESANAIS'
    WHEN ind_parc_mds_fam = 203 THEN 'FAMILIA PERTENCENTE A COMUNIDADE DE TERREIRO'
    WHEN ind_parc_mds_fam = 204 THEN 'FAMILIA RIBEIRINHA'
    WHEN ind_parc_mds_fam = 205 THEN 'FAMILIA AGRICULTORES FAMILIARES'
    WHEN ind_parc_mds_fam = 301 THEN 'FAMILIA ASSENTADA DA REFORMA AGRARIA'
    WHEN ind_parc_mds_fam = 302 THEN 'FAMILIA BENEFICIARIA DO PROGRAMA NACIONAL DO CREDITO FUNDIARIO'
    WHEN ind_parc_mds_fam = 303 THEN 'FAMILIA ACAMPADA'
    WHEN ind_parc_mds_fam = 304 THEN 'FAMILIA ATINGIDA POR EMPREENDIMENTOS DE INFRAESTRUTURA'
    WHEN ind_parc_mds_fam = 305 THEN 'FAMILIA DE PRESO DO SISTEMA CARCERARIO'
    WHEN ind_parc_mds_fam = 306 THEN 'FAMILIA CATADORES DE MATERIAL RECICLAVEL'
    ELSE ''
  END AS outros_grupos,
  CASE
    WHEN cod_sexo_pessoa = 1 THEN 'HOMEM'
    ELSE 'MULHER'
  END AS cod_sexo_pessoa,
  CASE
    WHEN cod_parentesco_rf_pessoa = 1 THEN 'RESPONSAVEL FAMILIAR'
    WHEN cod_parentesco_rf_pessoa = 2 THEN 'CONJUGE OU COMPANHEIRO'
    WHEN cod_parentesco_rf_pessoa = 3 THEN 'FILHO(A)'
    WHEN cod_parentesco_rf_pessoa = 4 THEN 'ENTEADO(A)'
    WHEN cod_parentesco_rf_pessoa = 5 THEN 'NETO(A) OU BISNETO(A)'
    WHEN cod_parentesco_rf_pessoa = 6 THEN 'PAI OU MÃE'
    WHEN cod_parentesco_rf_pessoa = 7 THEN 'SOGRO(A)'
    WHEN cod_parentesco_rf_pessoa = 8 THEN 'IRMÃO OU IRMÃ'
    WHEN cod_parentesco_rf_pessoa = 9 THEN 'GENRO OU NORA'
    WHEN cod_parentesco_rf_pessoa = 10 THEN 'OUTROS PARENTES'
    WHEN cod_parentesco_rf_pessoa = 11 THEN 'NÃO PARENTE'
    ELSE 'FAMÍLIA SEM RESPONSÁVEL FAMILIAR (consulte o V7)'
  END AS parentesco,
  CONCAT('(',num_ddd_contato_1_fam, ')', ' ', num_tel_contato_1_fam)
";

$orderby = "ORDER BY cod_familiar_fam ASC, cod_parentesco_rf_pessoa ASC, dta_nasc_pessoa DESC";

// Consulta SQL para indígenas
$query_indio = "$solicitacao_sql
    FROM tbl_tudo
    WHERE cod_familia_indigena_fam = 1
    $orderby";

// Consulta SQL para quilombolas
$query_quilombo = "$solicitacao_sql
    FROM tbl_tudo
    WHERE ind_familia_quilombola_fam = 1
    $orderby";

//Consulta de outros GPTEs
$query_outros_gpte = "$solicitacao_sql
    FROM tbl_tudo
    WHERE ind_parc_mds_fam != 0
    $orderby";


// Executar consultas e armazenar resultados
$dados_indio = executeQuery($conn, $query_indio);
$dados_quilombo = executeQuery($conn, $query_quilombo);
$dados_outros_gpte = executeQuery($conn, $query_outros_gpte);

// Combinar resultados (se necessário)
$dados = array_merge($dados_indio, $dados_quilombo, $dados_outros_gpte);

header('Content-Type: application/json');
echo json_encode($dados);
?>