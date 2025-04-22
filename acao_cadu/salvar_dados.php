<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/acao_cadu/config/conexao.php';

header('Content-Type: application/json');

$dados = json_decode(file_get_contents("php://input"), true);

if (!isset($dados['cpf'], $dados['programa'], $dados['tipo'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
    exit;
}

$cpf = $dados['cpf'];
$programa = $dados['programa'];
$tipo = $dados['tipo'];

// Determina prefixo
if ($programa === 'CADUNICO') {
    $prefixo = ($tipo === 'PRIORIDADE') ? 'CP' : 'CC';
} else {
    $prefixo = ($tipo === 'PRIORIDADE') ? 'BP' : 'BC';
}

$likePrefixo = $prefixo . '%';
// Gera próxima senha com base nas existentes
try {
    $conn->begin_transaction();

    $query = $conn->prepare("SELECT senha FROM atendimentos_acao_cadu WHERE senha LIKE ? ORDER BY id DESC LIMIT 1");

    if (!$query) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Erro na preparação da query: ' . $conn->error
        ]);
        exit;
    }

    $query->bind_param("s", $likePrefixo);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $ultimaSenha = $resultado->fetch_assoc()['senha'];
        $numeroAtual = intval(substr($ultimaSenha, 2));
        $proximaSenha = $prefixo . str_pad($numeroAtual + 1, 3, "0", STR_PAD_LEFT);
    } else {
        $proximaSenha = $prefixo . "001";
    }



    $query->close();

    $stmt = $conn->prepare("INSERT INTO atendimentos_acao_cadu (cpf, programa, tipo, senha) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Erro ao preparar INSERT: ' . $conn->error
        ]);
        exit;
    }

    

    $stmt->bind_param("ssss", $cpf, $programa, $tipo, $proximaSenha);
    $stmt->execute();
    $stmt->close();

    $conn->commit();

    echo json_encode([
        'status' => 'sucesso',
        'mensagem' => 'Atendimento salvo com sucesso',
        'senha' => $proximaSenha
    ]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao salvar: ' . $e->getMessage()]);
}
$conn->close();