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
    return $result->fetch_all(MYSQLI_ASSOC);
}

// SQL para buscar os dados
$solicitacao_sql = "SELECT
    CASE
        WHEN in_inconsistencia_uni = 1 THEN 'PUBLICO 1'
        WHEN in_inconsistencia_uni = 2 THEN 'PUBLICO 2'
        WHEN in_inconsistencia_uni = 3 THEN 'PUBLICO 3'
        WHEN in_inconsistencia_uni = 4 THEN 'PUBLICO 4'
        WHEN in_inconsistencia_uni = 5 THEN 'PUBLICO 5'
        WHEN in_inconsistencia_uni = 6 THEN 'PUBLICO 6'
        WHEN in_inconsistencia_uni = 7 THEN 'PUBLICO 7'
        WHEN in_inconsistencia_uni = 8 THEN 'PUBLICO 8'
        WHEN in_inconsistencia_uni = 9 THEN 'PUBLICO 9'
        WHEN in_inconsistencia_uni = 10 THEN 'PUBLICO 10'
        WHEN in_inconsistencia_uni = 11 THEN 'PUBLICO 11'
        WHEN in_inconsistencia_uni = 12 THEN 'PUBLICO 12'
        WHEN in_inconsistencia_uni = 13 THEN 'PUBLICO 13'
        WHEN in_inconsistencia_uni = 14 THEN 'PUBLICO 14'
        WHEN in_inconsistencia_uni = 15 THEN 'PUBLICO 15'
        WHEN in_inconsistencia_uni = 16 THEN 'PUBLICO 16'
        ELSE ''
    END AS inc_unip,
    COUNT(in_inconsistencia_uni) AS quantidade,
    in_inconsistencia_uni
    FROM unipessoal
    GROUP BY in_inconsistencia_uni
    ORDER BY in_inconsistencia_uni";

// Executar consulta
$dados_unipessoal = executeQuery($conn, $solicitacao_sql);

// Configurar o cabeçalho como JSON
header('Content-Type: application/json');

// Retornar os dados como JSON
echo json_encode($dados_unipessoal);
?>
