<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';
header('Content-Type: application/json');

if (isset($_POST['idSetor'])) {
    $idSetor = intval($_POST['idSetor']); // Obtém o ID do setor enviado pelo AJAX

    // Consulta para buscar os sistemas relacionados ao setor
    $query = $conn_1->prepare("SELECT id, nome_sistema FROM sistemas WHERE setores_id = ?");
    $query->bind_param('i', $idSetor); // Substitui o parâmetro pelo ID do setor
    $query->execute();
    $result = $query->get_result();

    $sistemas = [];
    while ($row = $result->fetch_assoc()) {
        $sistemas[] = $row; // Adiciona cada sistema encontrado ao array
    }

    // Retorna os sistemas encontrados como JSON
    echo json_encode($sistemas);
} else {
    echo json_encode([]); // Retorna um array vazio se o ID do setor não foi enviado
}


$conn_1->close();
?>
