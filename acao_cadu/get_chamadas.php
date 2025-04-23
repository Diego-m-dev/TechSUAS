<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/acao_cadu/config/conexao.php';

header('Content-Type: application/json');

$sql = "SELECT senha, programa, tipo, chamada_em 
        FROM atendimentos_acao_cadu a
        LEFT JOIN tbl_tudo t ON t.num_cpf_pessoa = a.cpf
        WHERE chamada_em IS NOT NULL 
        ORDER BY chamada_em DESC 
        LIMIT 8";

$result = $conn->query($sql);
$dados = [];

while ($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

echo json_encode($dados);
$conn->close();
?>
