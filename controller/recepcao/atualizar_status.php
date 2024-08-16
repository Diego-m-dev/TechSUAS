<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

date_default_timezone_set('America/Sao_Paulo');
$timestamp_corrigido = date("Y-m-d H:i:s");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && isset($_POST['novo_status'])) {
        $id = intval($_POST['id']);
        $novo_status = $_POST['novo_status'];

        if (!empty($novo_status) && $id > 0) {
            $sql = "UPDATE solicita SET status = ?, modify_date = ? WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('ssi', $novo_status, $timestamp_corrigido, $id);

                if ($stmt->execute()) {
                    echo 'success';
                } else {
                    echo 'Erro ao atualizar o status: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                echo 'Erro ao preparar a consulta: ' . $conn->error;
            }
        } else {
            echo 'Dados inválidos.';
        }
    } else {
        echo 'Dados não recebidos.';
    }
    $conn->close();
} else {
    echo 'Método de requisição inválido.';
}
?>
