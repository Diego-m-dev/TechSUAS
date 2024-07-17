<?php
// Inclui o arquivo de conexão com o banco de dados
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Define o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Verifica se os dados foram recebidos via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']); 
    $novo_status = $_POST['novo_status'];

    if (!empty($novo_status) && is_int($id)) {
        $sql = "UPDATE solicita SET status = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('si', $novo_status, $id);

            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'Erro ao atualizar o status.';
            }
            $stmt->close();
        } else {
            echo 'Erro ao preparar a consulta.';
        }
    } else {
        echo 'Dados inválidos.';
    }
    $conn->close();
} else {
    echo 'Método de requisição inválido.';
}
?>
