<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

$cpf_R_limp = preg_replace('/\D/', '', $_POST['cpf_R']);
$cpf_RLimpo = str_pad($cpf_R_limp, 11, '0', STR_PAD_LEFT);

$cpf_B_limp = preg_replace('/\D/', '', $_POST['cpf_B']);
$cpf_BLimpo = str_pad($cpf_B_limp, 11, '0', STR_PAD_LEFT);


$stmt = $pdo->prepare("SELECT quant_mes, quant_conc_bene FROM dados_pessoal_concessao WHERE cpf = ?");
$stmt->execute([$cpf_RLimpo]);
$linitacao = $stmt->fetch(PDO::FETCH_ASSOC);

if ($linitacao['quant_conc_bene'] >= $linitacao['quant_mes']) {
  echo json_encode(['encontrado' => false, 'mensagem' => 'Excedeu o limite de concessões']);
  exit;
}

$data_atual = date('Y');
$situation = "EM PROCESSO";

$stmt = $pdo->prepare("SELECT COUNT(*) AS total_reg FROM concessao WHERE ano_formulario = ?");
$stmt->execute([$data_atual]);
$numeracao = $stmt->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['cpf_B']) || isset($_POST['cpf_R'])) {

  $itens_conc = $conn->real_escape_string($_POST['itens_conc']);
  $parentesco = $conn->real_escape_string($_POST['parentesco']);
  $multiQ_U = $conn->real_escape_string($_POST['multiQ_U']);
  $valorUni = $conn->real_escape_string($_POST['valorUni']);
  $quant = $conn->real_escape_string($_POST['quant']);
  $mes_pg = $conn->real_escape_string($_POST['mes_pg']);


    $cpf_B_limp = preg_replace('/\D/', '', $_POST['cpf_B']);
    $cpf_BLimpo = str_pad($cpf_B_limp, 11, '0', STR_PAD_LEFT);

      $pdo->beginTransaction();

      try {
        // buscar ID pessoa
        $stmt = $pdo->prepare("SELECT id FROM dados_pessoal_concessao WHERE cpf = ?");
        $stmt->execute([$cpf_RLimpo]);
        $dados_pessoa_id = $stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT id FROM dados_pessoal_concessao WHERE cpf = ?");
        $stmt->execute([$cpf_BLimpo]);
        $dados_pessoa_id_b = $stmt->fetchColumn();

        if (!$dados_pessoa_id || !$dados_pessoa_id_b) {
          echo json_encode(['error' => 'Erro: O beneficiário ou responsável não está cadastrado']);
          exit;
        }


        $n_parecer = $numeracao['total_reg'] + 1;

        //insere dados na tbl concessao
        $stmt = $pdo->prepare("INSERT INTO concessao (beneficiario_id, responsavel_id, num_formulario, ano_formulario, parentesco, situacao, mes_pg, item, quantidade, valor_uni, valor_total, contagem, operador) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)");
        $stmt->execute([$dados_pessoa_id_b, $dados_pessoa_id, $n_parecer, $data_atual, $parentesco, $situation, $mes_pg, $itens_conc, $quant, $valorUni, $multiQ_U, $_SESSION['nome_usuario']]);

        $stmt = $pdo->prepare("SELECT COUNT(*) AS total_conc FROM concessao WHERE responsavel_id  = ?");
        $stmt->execute([$dados_pessoa_id]);
        $total_conc_r = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_r = $total_conc_r['total_conc'];

        $stmt = $pdo->prepare("SELECT COUNT(*) AS total_conc FROM concessao WHERE beneficiario_id = ?");
        $stmt->execute([$dados_pessoa_id_b]);
        $total_conc_b = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_b = $total_conc_b['total_conc'];


        $stmt = $pdo->prepare("UPDATE dados_pessoal_concessao SET quant_conc_resp = ? WHERE id = ?");
        $stmt->execute([$total_r, $dados_pessoa_id]);

        $stmt = $pdo->prepare("UPDATE dados_pessoal_concessao SET quant_conc_bene = ? WHERE id = ?");
        $stmt->execute([$total_b, $dados_pessoa_id_b]);


        $pdo->commit();
        echo json_encode(['encontrado' => true]);

      } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(array('error' => 'Erro: ' . $e->getMessage()));
      }


} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "POST" não recebido.'));
}

$conn->close();