<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php'; 
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Verifique se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pegue os dados do POST
    $codFamiliar = isset($_POST['cod_fam']) ? $_POST['cod_fam'] : null;
    $dataAtualizacao = isset($_POST['data_entrevista']) ? $_POST['data_entrevista'] : null;
    $nomeResponsavel = isset($_POST['nome_pess']) ? $_POST['nome_pess'] : null;
    $status = "ATIVO";
    // Valide os dados
    if (empty($codFamiliar) || empty($dataAtualizacao) || empty($nomeResponsavel)) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
        exit();
    }

    // Prepare e execute a query de inserção
    $stmt = $conn->prepare("INSERT INTO status_familia (cod_familiar, status, data_atualizacao,  nome_pess) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('ssss', $codFamiliar,  $status, $dataAtualizacao, $nomeResponsavel);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Registro incluído com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao incluir o registro.']);
        }

        // Feche a declaração
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta.']);
    }

    // Feche a conexão
    $conn->close();
} else {
    // Se não for um POST, retorne um erro
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
?>
