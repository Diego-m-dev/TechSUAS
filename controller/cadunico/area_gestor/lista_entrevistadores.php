<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Função para executar consulta SQL e retornar os resultados
function executeQuery($conn, $query)
{
    $result = $conn->query($query);
    if (!$result) {
        die("ERRO na consulta: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC); // Alterado para ASSOCIATIVE array
}

$solicitacao_sql = "SELECT
  COUNT(*) AS soma_entrev_cad, nom_entrevistador_fam
";

$orderby = "GROUP BY nom_entrevistador_fam 
    ORDER BY nom_entrevistador_fam ASC";

// Consulta SQL para indígenas
$query_tudo = "$solicitacao_sql
    FROM tbl_tudo
    WHERE cod_parentesco_rf_pessoa = 1
  $orderby";

// Executar consultas e armazenar resultados
$dados = executeQuery($conn, $query_tudo); // Variável correta para dados

header('Content-Type: application/json');
echo json_encode($dados);

$conn->close();