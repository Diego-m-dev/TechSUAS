<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

// Função para executar consulta SQL e retornar os resultados
function executeQuery($conn, $query)
{
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
  DATE_FORMAT(dta_nasc_pessoa, '%d/%m/%Y') AS dta_nasc_pessoa,
  TIMESTAMPDIFF(YEAR, dta_nasc_pessoa, CURDATE()) AS idade,
  CONCAT('R$ ', vlr_renda_total_fam, ',00') AS vlr_renda_total_fam, 
  CONCAT(nom_tip_logradouro_fam, ' ', nom_titulo_logradouro_fam, ' ', nom_logradouro_fam, ', ', num_logradouro_fam, ' - ', nom_localidade_fam, ' ', txt_referencia_local_fam) AS endereco,
  CASE
    WHEN qtde_meses_desat_cat = 0 THEN 'ATUALIZADA'
    ELSE 'DESATUALIZADO'
  END AS status_atualizacao,
  nom_escola_memb,
  CASE
    WHEN cod_deficiencia_memb = 1 THEN 'SIM'
    ELSE 'NÃO'
  END AS cod_deficiencia_memb,
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
  CONCAT('(',num_ddd_contato_1_fam, ')', ' ', num_tel_contato_1_fam),
  num_cpf_pessoa,
  YEAR(dat_atual_fam),
  vlr_renda_media_fam,
  MONTH(dat_atual_fam)
  ";

$orderby = "ORDER BY cod_familiar_fam ASC, cod_parentesco_rf_pessoa ASC, dta_nasc_pessoa DESC";

// Consulta SQL para indígenas
$query_tudo = "$solicitacao_sql
  FROM tbl_tudo
  $orderby";

// Executar consultas e armazenar resultados
$query_tudo = executeQuery($conn, $query_tudo);

// Combinar resultados (se necessário)
$dados = array_merge($query_tudo);

header('Content-Type: application/json');
echo json_encode($dados);
