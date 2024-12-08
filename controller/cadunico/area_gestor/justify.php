<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_POST['nis_entrevistador'] == '') {
  $response = false;
} else {
  $dataAusencia = $_POST['dataAusencia'];
  $nis_entrevistador = $_POST['nis_entrevistador'];
  $justificativa = $_POST['justificativa'];

  $stmt_salva = $conn->prepare("INSERT INTO carga_justify(nis, data_just, justify) VALUE (?, ?, ?)");

      // Verifica se a preparação foi bem-sucedida
      if ($stmt_salva === false) {
        die('Erro na preparação SQL: ' . $conn->error);
      }

  $stmt_salva->bind_param('sss', $nis_entrevistador, $dataAusencia, $justificativa);

  if ($stmt_salva->execute()) {
    $response = true;
  } 
}

echo json_encode([
  'salvo' => $response
]);