<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/models/cadunico/submit_model.php';

header('Content-Type: application/json');

$response = array('salvo' => false);

if (!isset($_POST['idzinho'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
    exit;
}

$idzinho = $_POST['idzinho'];

try {
    $stmt = $pdo->prepare("UPDATE cadastro_forms SET certo = :certo WHERE id = :id");

    // Vamos definir o valor de certo como 1 (verdadeiro)
    $certo = 1;

    $stmt->bindParam(':certo', $certo, PDO::PARAM_INT);
    $stmt->bindParam(':id', $idzinho, PDO::PARAM_INT); // ou PARAM_STR dependendo do tipo de dado no banco

    if ($stmt->execute()) {
        $response['salvo'] = true;
    } else {
        $response['msg'] = 'Ocorreu um erro ao atualizar os dados.';
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => "Erro: " . $e->getMessage()]);
}

// Fechando conexão
$pdo = null;