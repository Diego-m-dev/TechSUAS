<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

if ($_SESSION['setor'] != "SUPORTE") {
  echo "VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR AQUI!";
  exit();
}

// Inicia o buffer de saída
ob_start();

// Defina o cabeçalho para JSON
header('Content-Type: application/json');

$resposta = array('encontrado' => false);

if (isset($_POST['cod_ibge_2']) && empty($_POST['cpf'])) {
  $cod_ibge = $_POST['cod_ibge_2'];
  $stmt_munic = $pdo_1->prepare("SELECT municipio FROM municipios WHERE cod_ibge = :cod_ibge");
  $stmt_munic->execute(array(':cod_ibge' => $cod_ibge));

  if ($stmt_munic->rowCount() != 0) {
    $dados = $stmt_munic->fetch(PDO::FETCH_ASSOC);
    $resposta['encontrado'] = true;
    $resposta['municipio'] = $dados['municipio'];
  }
} elseif (empty($_POST['cod_ibge_2']) && isset($_POST['cpf'])) {
  $cpf_coord = $_POST['cpf'];
  $stmt_munic = $pdo_1->prepare("SELECT responsavel FROM setores WHERE cpf_coord = :cpf_coord");
  $stmt_munic->execute(array(':cpf_coord' => $cpf_coord));

  if ($stmt_munic->rowCount() != 0) {
    $dados = $stmt_munic->fetch(PDO::FETCH_ASSOC);
    $resposta['encontrado'] = true;
    $resposta['municipio'] = $dados['responsavel'];
  }
} else {
  http_response_code(400);
  $resposta['error'] = 'Parâmetro "codfam" não recebido.';
}

// Limpa o buffer de saída e envia a resposta JSON
ob_end_clean();
echo json_encode($resposta);
?>
