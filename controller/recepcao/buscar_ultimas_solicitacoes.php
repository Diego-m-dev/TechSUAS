<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Defina o fuso horário correto
date_default_timezone_set('America/Sao_Paulo');

// Obtenha a data de hoje no formato 'Y-m-d'
$data_hoje = date('Y-m-d');

// Consulta SQL para selecionar registros com status 'feito' modificados hoje
$sql = "SELECT * FROM solicita 
        WHERE status = 'feito' 
        AND DATE(modify_date) = ? 
        ORDER BY modify_date DESC 
        LIMIT 5";

if ($stmt = $conn->prepare($sql)) {
    // Vincule o parâmetro da data de hoje
    $stmt->bind_param("s", $data_hoje);

    // Execute a consulta
    $stmt->execute();

    // Obtenha o resultado
    $result = $stmt->get_result();

    $registros = [];

    // Verifica se há registros retornados
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tipo = '';
            if ($row['tipo'] == 1) {
                $tipo = "NIS";
            } elseif ($row['tipo'] == 3) {
                $tipo = "ENTREVISTA";
            } elseif ($row['tipo'] == 2) {
                $tipo = "DECLARAÇÃO CAD";
            }

            $registros[] = [
                'cpf' => htmlspecialchars($row['cpf']),
                'nome' => htmlspecialchars($row['nome']),
                'cod_fam' => htmlspecialchars($row['cod_fam']),
                'nis' => htmlspecialchars($row['nis']),
                'tipo' => htmlspecialchars($tipo),
                'status' => htmlspecialchars($row['status']),
                'id' => htmlspecialchars($row['id'])
            ];
        }
    }

    // Retorne a resposta em JSON
    echo json_encode($registros);

    // Feche a declaração
    $stmt->close();
} else {
    echo json_encode(['error' => 'Erro na consulta.']);
}

// Feche a conexão com o banco de dados
$conn->close();
?>
