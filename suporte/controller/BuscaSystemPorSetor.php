<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';

header('Content-Type: application/json');


if (isset($_POST['idSetor'])) {
    $idSetor = $_POST['idSetor'];

    // Prepare a consulta SQL para buscar os sistemas
    $stmt = $conn_1->prepare("SELECT id, nome FROM sistemas WHERE setores_id = ?");
    $stmt->bind_param('i', $idSetor); 
    $stmt->execute();

    $result = $stmt->get_result();
    $sistemas = [];

    while ($row = $result->fetch_assoc()) {
        $sistemas[] = $row;
    }
    if (count($sistemas) > 0) {
        echo json_encode($sistemas);
    } else {
        echo json_encode(['error' => 'Nenhum sistema encontrado para o setor selecionado.']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID do setor não informado.']);
}

$conn_1->close();
?>
