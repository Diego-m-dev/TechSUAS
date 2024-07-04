<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenha os dados do formulário
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $cod = $_POST['cod'];
    $status = 'pendente'; // Valor padrão para a coluna status

    // Prepare a consulta SQL para inserção
    $sql = "INSERT INTO solicita (cpf, nome, cod_fam, status) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Vincule as variáveis aos parâmetros da consulta
        $stmt->bind_param("ssss", $cpf, $nome, $cod, $status);

        // Execute a consulta
        if ($stmt->execute()) {
            echo "Registro inserido com sucesso.";
        } else {
            echo "Erro: " . $stmt->error;
        }

        // Feche a declaração
        $stmt->close();
    } else {
        echo "Erro: " . $conn->error;
    }

    // Feche a conexão com o banco de dados
    $conn->close();
}

