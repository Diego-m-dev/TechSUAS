<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Consulta SQL para selecionar apenas registros com status "pendente"
$sql = "SELECT * FROM solicita WHERE status = 'pendente'";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // Loop através dos resultados e armazena cada registro em um array
    while ($row = $result->fetch_assoc()) {
        $tipo = '';
        if ($row['tipo'] == 1) {
            $tipo = "NIS";
        } elseif ($row['tipo'] == 2) {
            $tipo = "ENTREVISTA";
        } elseif ($row['tipo'] == 3) {
            $tipo = "DECLARAÇÃO CAD";
        }
        
        $data[] = [
            'cpf' => $row['cpf'],
            'nome' => $row['nome'],
            'cod_fam' => $row['cod_fam'],
            'nis' => $row['nis'],
            'tipo' => $tipo,
            'status' => $row['status'],
            'id' => $row['id']
        ];
    }
} 

// Fecha a conexão com o banco de dados
$conn->close();

// Retorna os dados como JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
