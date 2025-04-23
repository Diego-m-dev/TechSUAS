<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/acao_cadu/config/conexao.php';

header('Content-Type: application/json');

$dados = json_decode(file_get_contents("php://input"), true);

if (!isset($dados['id'], $dados['guiche'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
    exit;
}

$id = $dados['id'];
$programa = $dados['guiche'];
$status_ = 'aguardando';

try {
    $conn->begin_transaction();

    $stmt = $conn->prepare("UPDATE atendimentos_acao_cadu SET guiche = ?, status_atendimento = ?, chamada_em = NOW() WHERE id = ?");

    if (!$stmt) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Erro ao preparar a UPDATE: ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param("ssi", $programa, $status_, $id);
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