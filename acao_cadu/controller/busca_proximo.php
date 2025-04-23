<?php
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

$solicitacao_sql = "SELECT a.id, a.programa, a.tipo, a.senha, a.guiche, a.status_atendimento, chamada_em, a.created_at, t.nom_pessoa, t.cod_familiar_fam";

//$where = "";
// Consulta SQL para indígenas
$query_tudo = "$solicitacao_sql
        FROM atendimentos_acao_cadu a
        LEFT JOIN tbl_tudo t ON a.cpf = t.num_cpf_pessoa
        WHERE a.status_atendimento = 'aguardando' AND DATE(a.created_at) = CURDATE()
        ORDER BY created_at DESC
 ";

// Executar consultas e armazenar resultados
$dados = executeQuery($conn, $query_tudo); // Variável correta para dados

header('Content-Type: application/json');
echo json_encode($dados);

$conn->close();