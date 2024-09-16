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
$solicitacao_sql = "SELECT arm, gav, pas
    FROM ficharios
    ORDER BY arm, gav, pas";

// Executar consulta
$dados_unipessoal = executeQuery($conn, $solicitacao_sql);

// Configurar o cabeçalho como JSON
header('Content-Type: application/json');

// Retornar os dados como JSON
echo json_encode($dados_unipessoal);

// Fechar a conexão com o banco de dados
$conn->close();
?>
