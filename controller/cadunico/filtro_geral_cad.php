<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

// Aumentar o tempo de execução para 300 segundos (5 minutos)
set_time_limit(300);

$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 100; // Ajuste o limite de resultados por página
$offset = ($pagina - 1) * $limite;

$filtros = "";

// Manter a conexão ativa
if (!$conn->ping()) {
  $conn->close();
  $conn = new mysqli($host, $username, $password, $dbname);
}

// Verifica se os filtros foram passados
if (isset($_GET['idade_min']) && $_GET['idade_min'] != '') {
    $idade_min = (int)$_GET['idade_min'];
    $filtros .= " AND TIMESTAMPDIFF(YEAR, t.dta_nasc_pessoa, CURDATE()) >= $idade_min";
}

if (isset($_GET['idade_max']) && $_GET['idade_max'] != '') {
    $idade_max = (int)$_GET['idade_max'];
    $filtros .= " AND TIMESTAMPDIFF(YEAR, t.dta_nasc_pessoa, CURDATE()) <= $idade_max";
}

if (isset($_GET['sexo']) && $_GET['sexo'] != '') {
    $sexo = (int)$_GET['sexo'];
    $filtros .= " AND t.cod_sexo_pessoa = $sexo";
}

if (isset($_GET['status_atualizacao']) && $_GET['status_atualizacao'] != '') {
    $status = $_GET['status_atualizacao'];
    $filtros .= " AND (CASE WHEN t.qtde_meses_desat_cat = 0 THEN 'ATUALIZADA' ELSE 'DESATUALIZADO' END) = '$status'";
}

// Consulta SQL para contar o total de registros (sem limites e offsets)
$count_sql = "SELECT COUNT(*) as total_registros
              FROM tbl_tudo t
              LEFT JOIN fichario f ON t.cod_familiar_fam = f.codfam
              WHERE 1=1 $filtros";

$result_count = $conn->query($count_sql);
$total_registros = $result_count->fetch_assoc()['total_registros'];

// Consulta SQL ajustada com paginação e filtros
$solicitacao_sql = "SELECT
  t.cod_familiar_fam,
  t.nom_pessoa,
  t.num_nis_pessoa_atual,
  DATE_FORMAT(t.dta_nasc_pessoa, '%d/%m/%Y') AS dta_nasc_pessoa,
  TIMESTAMPDIFF(YEAR, t.dta_nasc_pessoa, CURDATE()) AS idade,
  CONCAT('R$ ', t.vlr_renda_total_fam, ',00') AS vlr_renda_total_fam, 
  CONCAT(t.nom_tip_logradouro_fam, ' ', t.nom_titulo_logradouro_fam, ' ', t.nom_logradouro_fam, ', ', t.num_logradouro_fam, ' - ', t.nom_localidade_fam, ' ', t.txt_referencia_local_fam) AS endereco,
  CASE
    WHEN t.qtde_meses_desat_cat = 0 THEN 'ATUALIZADA'
    ELSE 'DESATUALIZADO'
  END AS status_atualizacao,
  t.nom_escola_memb,
  CASE
    WHEN t.cod_deficiencia_memb = 1 THEN 'SIM'
    ELSE 'NÃO'
  END AS cod_deficiencia_memb,
  CASE
    WHEN t.cod_sexo_pessoa = 1 THEN 'HOMEM'
    ELSE 'MULHER'
  END AS cod_sexo_pessoa,
  CASE
    WHEN t.cod_parentesco_rf_pessoa = 1 THEN 'RESPONSAVEL FAMILIAR'
    WHEN t.cod_parentesco_rf_pessoa = 2 THEN 'CONJUGE OU COMPANHEIRO'
    WHEN t.cod_parentesco_rf_pessoa = 3 THEN 'FILHO(A)'
    WHEN t.cod_parentesco_rf_pessoa = 4 THEN 'ENTEADO(A)'
    WHEN t.cod_parentesco_rf_pessoa = 5 THEN 'NETO(A) OU BISNETO(A)'
    WHEN t.cod_parentesco_rf_pessoa = 6 THEN 'PAI OU MÃE'
    WHEN t.cod_parentesco_rf_pessoa = 7 THEN 'SOGRO(A)'
    WHEN t.cod_parentesco_rf_pessoa = 8 THEN 'IRMÃO OU IRMÃ'
    WHEN t.cod_parentesco_rf_pessoa = 9 THEN 'GENRO OU NORA'
    WHEN t.cod_parentesco_rf_pessoa = 10 THEN 'OUTROS PARENTES'
    WHEN t.cod_parentesco_rf_pessoa = 11 THEN 'NÃO PARENTE'
    ELSE 'FAMÍLIA SEM RESPONSÁVEL FAMILIAR (consulte o V7)'
  END AS parentesco,
  CONCAT('(',t.num_ddd_contato_1_fam, ')', ' ', t.num_tel_contato_1_fam),
  t.num_cpf_pessoa,
  YEAR(t.dat_atual_fam),
  t.vlr_renda_media_fam,
  MONTH(t.dat_atual_fam),
  f.arm_gav_pas AS localizacao_arquivo

  FROM tbl_tudo t
  LEFT JOIN fichario f ON t.cod_familiar_fam = f.codfam
  WHERE 1=1 $filtros
  LIMIT $limite OFFSET $offset";

// Executar a consulta de dados paginados
$result = $conn->query($solicitacao_sql);
$dados = $result->fetch_all(MYSQLI_ASSOC);

// Calcular o total de páginas
$total_paginas = ceil($total_registros / $limite);

// Enviar os dados e informações de paginação como JSON
header('Content-Type: application/json');
echo json_encode([
    'dados' => $dados,
    'pagina_atual' => $pagina,
    'total_paginas' => $total_paginas,
    'total_registros' => $total_registros,
    'limite' => $limite
]);
?>
