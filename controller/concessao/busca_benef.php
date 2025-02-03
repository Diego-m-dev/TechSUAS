<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');

$response = ['encontrado' => false];

if (!isset($_POST['nis_resp'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Parâmetro "nis_resp" não recebido.']);
    exit;
} else {

$nis_resp = $conn->real_escape_string($_POST['nis_resp']);
$nis_resp_limp = preg_replace('/\D/', '', $nis_resp);
$ajustando_cod = str_pad($nis_resp_limp, 11, '0', STR_PAD_LEFT);

// Primeiro, busca em `responsavel_concessao`
$stmt_resp = "SELECT nome, DATE_FORMAT(data_nasc, '%d/%m/%Y') AS data_nasc, nome_mae, quant_mes, quant_conc_bene FROM dados_pessoal_concessao WHERE cpf = $ajustando_cod";
$stmt_resp_query = $conn->query($stmt_resp) or die("ERRO ao consultar !" . $conn->error);

  if ($stmt_resp_query->num_rows > 0) {
    $dados_stmt_resp = $stmt_resp_query->fetch_assoc();


    echo json_encode([
      "encontrado" => true,
      "dados_benef" => [
          "nome" => $dados_stmt_resp["nome"],
          "data_nasc" => $dados_stmt_resp["data_nasc"],
          "nome_mae" => $dados_stmt_resp["nome_mae"],
          "limite" => $dados_stmt_resp['quant_mes'],
          "feitos" => $dados_stmt_resp['quant_conc_bene']
      ]
  ]);

  } else {

      $stmt_tbl = "SELECT 
      nom_pessoa, DATE_FORMAT(dta_nasc_pessoa, '%d/%m/%Y') AS data_nasc, 
      dta_nasc_pessoa, num_cpf_pessoa, vlr_renda_total_fam, 
      nom_ibge_munic_nasc_pessoa,  
      CONCAT('(', num_ddd_contato_1_fam, ') ', num_tel_contato_1_fam) AS contato, 
      CONCAT(nom_tip_logradouro_fam, ' ', nom_titulo_logradouro_fam, ' ', nom_logradouro_fam, ', ', num_logradouro_fam, ' - ', nom_localidade_fam, ' ', txt_referencia_local_fam) AS endereco, 
      num_titulo_eleitor_pessoa, num_identidade_pessoa, num_nis_pessoa_atual, nom_completo_mae_pessoa 
      FROM tbl_tudo WHERE num_cpf_pessoa = $ajustando_cod";
      $stmt_tbl_query = $conn->query($stmt_tbl) or die("ERRO ao consultar !" . $conn->error);

        if ($stmt_tbl_query->num_rows > 0) {
  
          $dados_stmt_tbl = $stmt_tbl_query->fetch_assoc();
  
          echo json_encode([
            "encontrado" => true,
            "dados_benef" => [
                "nome" => $dados_stmt_tbl["nom_pessoa"],
                "data_nasc" => $dados_stmt_tbl["data_nasc"],
                "nome_mae" => $dados_stmt_tbl["nom_completo_mae_pessoa"],
                "salvo" => "Dados salvos com sucesso!"
            ]
        ]);

            // 🔹 Insere os dados na `responsavel_concessao`
    $stmt_insert = $conn->prepare("INSERT INTO dados_pessoal_concessao 
    (nome, data_nasc, cpf, nome_mae, renda_mensal, naturalidade, contato, te, rg, nis, endereco, quant_mes, operador) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)");

    if ($stmt_insert === false) {
        echo json_encode(["success" => false, "error" => "Erro na preparação da SQL."]);
        exit;
    }

    $op_auto = "Dados extraídos do V7";
    $stmt_insert->bind_param("ssssssssssss",
        $dados_stmt_tbl["nom_pessoa"],
        $dados_stmt_tbl["dta_nasc_pessoa"],
        $ajustando_cod,
        $dados_stmt_tbl["nom_completo_mae_pessoa"],
        $dados_stmt_tbl["vlr_renda_total_fam"],
        $dados_stmt_tbl["nom_ibge_munic_nasc_pessoa"],
        $dados_stmt_tbl["contato"],
        $dados_stmt_tbl["num_titulo_eleitor_pessoa"],
        $dados_stmt_tbl["num_identidade_pessoa"],
        $dados_stmt_tbl["num_nis_pessoa_atual"],
        $dados_stmt_tbl["endereco"],
        $op_auto
    );

    if (!$stmt_insert->execute()) {
      echo json_encode(["success" => false, "error" => "Erro ao inserir os dados: " . $stmt_insert->error]);
    }

        } else {
              // Se não encontrar em nenhuma tabela, retorna erro
              echo json_encode(["success" => false, "error" => "CPF não cadastrado."]);
        }
    
  }

}

