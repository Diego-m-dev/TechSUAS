<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/acao_cadu/config/conexao.php';

header('Content-Type: application/json');

$dados = json_decode(file_get_contents("php://input"), true);

$acao = $dados['acao'];
$id = $dados['id'];

if ($dados['acao'] == "PRESENTE") {
    $status_ = 'atendido';
} else {
    $status_ = 'ausente';
}

try {
    $conn->begin_transaction();

    $stmt = $conn->prepare("UPDATE atendimentos_acao_cadu SET status_atendimento = ? WHERE id = ?");

    if (!$stmt) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Erro ao preparar a UPDATE: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param("si", $status_, $id);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    echo json_encode([
        'status' => 'sucesso',
        'mensagem' => 'Salvo com sucesso'
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao salvar: ' . $e->getMessage()]);
}
$conn->close();