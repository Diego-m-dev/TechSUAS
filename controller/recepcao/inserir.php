<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

date_default_timezone_set('America/Sao_Paulo');

// Obtenha o timestamp atual no fuso horário correto
$timestamp_corrigido = date("Y-m-d H:i:s");

// Verifique se o formulário foi submetido via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Obtenha os dados do formulário
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $cod = $_POST['cod'];
    $tipo = $_POST['tipo'];
    $nis = $_POST['nis'];
    $status = 'PENDENTE'; // Valor padrão para a coluna status

    // Prepare a consulta SQL para inserção
    $sql = "INSERT INTO solicita (cpf, nome, cod_fam, tipo, nis, status, data_solicitacao, modify_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Vincule as variáveis aos parâmetros da consulta
        $stmt->bind_param("ssssssss", $cpf, $nome, $cod, $tipo, $nis, $status, $timestamp_corrigido, $timestamp_corrigido);

        // Execute a consulta
        if ($stmt->execute()) {
            // Responda ao cliente que o registro foi inserido com sucesso
            echo "success";
        } else {
            // Responda ao cliente que houve um erro na inserção
            echo "error";
        }

        // Feche a declaração
        $stmt->close();
    } else {
        // Responda ao cliente que houve um erro na preparação da consulta
        echo "error";
    }

    // Feche a conexão com o banco de dados
    $conn->close();
} else {
    // Caso não seja uma requisição AJAX, retorne um erro ou redirecione
    echo "error";
}
?>
