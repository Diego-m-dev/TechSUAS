<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');

$response = array('recebido' => false);


try {
  $data5yearsago = new DateTime();
  $data5yearsago->modify('-5 years');
  $data5yearsagoFormatada = $data5yearsago->format('Y-m-d');
    $stmt_up_5 = $pdo->prepare("SELECT * FROM cadastro_forms WHERE data_entrevista < :data5yearsago");
    $stmt_up_5->bindValue(":data5yearsago", $data5yearsagoFormatada);
    $stmt_up_5->execute();

    if ($stmt_up_5->rowCount() > 0) {
        $response['recebido'] = true;
        while ($row = $stmt_up_5->fetch(PDO::FETCH_ASSOC)) {
            $response['arquivos'][] = $row;
        }

        echo json_encode($response);
    } else {
            $response['msg'] = 'O correu um erro ao buscar os dados';
            echo json_encode($response);
    }
} catch (\Throwable $e) {
    echo json_encode(['msg' => "Erro: " . $e->getMessage()]);
}
