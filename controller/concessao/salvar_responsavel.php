<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');

try {

  $dados = json_decode(file_get_contents("php://input"), true);

    if (!isset($dados['cpf'])) {
      echo json_encode(["success" => false, "error" => "CPF não informado."]);
      exit;
    }

  $cpf_resp = $conn->real_escape_string($dados['cpf']);
  $cpf_resp_limp = preg_replace('/\D/', '', $dados['cpf']);
  $ajustando_cod = str_pad($cpf_resp_limp, 11, '0', STR_PAD_LEFT);

  $nis_pessoa = preg_replace('/\D/', '', $dados['nis_pessoa']);
  $tit_ele = preg_replace('/\D/', '', $dados['te_pessoa']);


  $rg_pessoa = ltrim($dados['rg_pessoa'], '0');
  $nome_pessoa = $dados['nome_pessoa'];
  $dt_nasc = $dados['dt_nasc'];
  $naturalidade_pessoa = $dados['naturalidade_pessoa'];
  $nome_mae_pessoa = $dados['nome_mae_pessoa'];
  $endereco = $dados['endereco'];
  $telefone = $dados['contato'];
  $renda = $dados['renda'];
  $quant_mes = $dados['quant_mes'];
  $operador = $_SESSION['nome_usuario'];

      // Verifica se o CPF já existe no banco
      $verifica_usuario = $conn->prepare("SELECT cpf FROM dados_pessoal_concessao WHERE cpf = ?");
      $verifica_usuario->bind_param("s", $ajustando_cod);
      $verifica_usuario->execute();
      $verifica_usuario->store_result();

      if ($verifica_usuario->num_rows > 0) {
        echo json_encode(["success" => false, "error" => "Este CPF já está cadastrado."]);
        exit;
    }

    $stmt_resp = $conn->prepare("INSERT INTO dados_pessoal_concessao 
    (nome, data_nasc, cpf, nome_mae, renda_mensal, naturalidade, contato, te, rg, nis, endereco, quant_mes, operador) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt_resp === false) {
          echo json_encode(["success" => false, "error" => "Erro na preparação da SQL."]);
          exit;
        }

    $stmt_resp->bind_param("sssssssssssss", $nome_pessoa, $dt_nasc, $ajustando_cod, $nome_mae_pessoa, $renda, $naturalidade_pessoa, $telefone, $tit_ele, $rg_pessoa, $nis_pessoa, $endereco, $quant_mes, $operador);
    $stmt_resp->execute();

    if ($stmt_resp->affected_rows > 0) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "error" => "Erro ao inserir os dados."]);
    }

    $stmt_resp->close();
    $conn->close();

} catch (Exception $e) {
  echo json_encode(["success" => false, "error" => "Erro inesperado: " . $e->getMessage()]);
}
?>