<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';


date_default_timezone_set('America/Sao_Paulo');

// Verifique se o formulário foi submetido via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Obtenha os dados do formulário
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $cod = $_POST['cod'];
    $tipo = $_POST['tipo'];
    $nis = $_POST['nis'];
    $status = 'pendente'; // Valor padrão para a coluna status

    // Prepare a consulta SQL para inserção
    $sql = "INSERT INTO solicita (cpf, nome, cod_fam, tipo, nis, status) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Vincule as variáveis aos parâmetros da consulta
        $stmt->bind_param("ssssss", $cpf, $nome, $cod, $tipo, $nis, $status);

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
