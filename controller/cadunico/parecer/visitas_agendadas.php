<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');

$response = array('recebido' => false);


try {

    $sql = "SELECT id, nome, endereco, parecer_rec, DATE_FORMAT(created_at, '%d/%m/%Y') AS dat FROM visitas_feitas WHERE status = 'registrado'";
		$stmt = $pdo->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
	    $response['recebido'] = true;
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
