<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

if (isset($_POST['cpf_resp'])) {
  $cpefinho = preg_replace('/\D/', '', $_POST['cpf_resp']);
  $limiter = $_POST['limiter'];

  $pdo->beginTransaction();

  try {


    $stmt = $pdo->prepare("UPDATE dados_pessoal_concessao SET quant_mes = ? WHERE cpf = ?");
    $stmt->execute([$limiter, $cpefinho]);

    $pdo->commit();
    echo json_encode(["encontrado" => true]);

  } catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(array('error' => 'Erro: ' . $e->getMessage()));
  }
} else {
  http_response_code(400);
  echo json_encode(array('error' => 'Parâmetro "POST" não recebido.'));
}
?>