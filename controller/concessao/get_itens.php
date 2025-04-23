<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');

// Consulta para buscar os itens da tabela
$sql = "SELECT caracteristica FROM concessao_itens"; // Substitua pelo nome correto da tabela
$result = $conn->query($sql);

$itens = [];

while ($row = $result->fetch_assoc()) {
    $itens[] = $row['caracteristica'];
}

echo json_encode($itens);
$conn->close();
