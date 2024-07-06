<?php
// Inclui o arquivo de conexão com o banco de dados
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Verifica se os dados foram recebidos via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém o id do registro e o novo status enviado via POST
    $id = $_POST['id'];
    $novo_status = $_POST['novo_status'];

    // Atualiza o status no banco de dados
    $sql = "UPDATE solicita SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $novo_status, $id);

    if ($stmt->execute()) {
        // Retorna uma resposta de sucesso para o AJAX
        echo 'success';
    } else {
        // Retorna uma mensagem de erro em caso de falha na execução da query
        echo 'Erro ao atualizar o status.';
    }

    // Fecha a declaração e a conexão com o banco de dados
    $stmt->close();
    $conn->close();
} else {
    // Se o método de requisição não for POST, retorna um erro
    echo 'Método de requisição inválido.';
}
?>
