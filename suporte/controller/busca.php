<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
if ($_SESSION['setor'] != "SUPORTE") {
  echo "VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR AQUI!";
  exit();
}

if (isset($_POST['cod_ibge_2']) && empty($_POST['cpf'])) {
  $resposta['encontrado'] = true;
  $cod_ibge = $_POST['cod_ibge_2'];
  $stmt_munic = $pdo->prepare("SELECT municipio FROM municipios WHERE cod_ibge = :cod_ibge");
  $stmt_munic->execute(array(':cod_ibge' => $cod_ibge));

  if ($stmt_munic->rowCount() != 0) {
    $dados = $stmt_munic->fetch(PDO::FETCH_ASSOC);
    $resposta['municipio'] = $dados['municipio'];
  }
  echo json_encode($resposta);
} elseif (empty($_POST['cod_ibge_2']) && isset($_POST['cpf'])) {
  $resposta['encontrado'] = true;
  $cpf_coord = $_POST['cpf'];
  $stmt_munic = $pdo->prepare("SELECT responsavel FROM setores WHERE cpf_coord = :cpf_coord");
  $stmt_munic->execute(array(':cpf_coord' => $cpf_coord));

  if ($stmt_munic->rowCount() != 0) {
    $dados = $stmt_munic->fetch(PDO::FETCH_ASSOC);
    $resposta['municipio'] = $dados['responsavel'];
  }
  echo json_encode($resposta);
} else {
  http_response_code(400);
  echo json_encode(array('error' => 'Parâmetro "codfam" não recebido.'));
}
?>
