<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

if (isset($_POST['cpf_resp'])) {
    $cpf_resp = $conn->real_escape_string($_POST['cpf_resp']);
    $cpf_resp_limp = preg_replace('/\D/', '', $_POST['cpf_resp']);
    $ajustando_cod = str_pad($cpf_resp_limp, 11, '0', STR_PAD_LEFT);

    $stmt = $conn->prepare("SELECT nome, DATE_FORMAT(data_nasc, '%d/%m/%Y') AS data_nasc, nome_mae FROM dados_pessoal_concessao WHERE cpf = ?");
    $stmt->bind_param("s", $ajustando_cod);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($dados_resp = $result->fetch_assoc()) {
        $response['encontrado'] = true;
        $response['dados_resp'] = [
          "nome" => $dados_resp["nome"],
          "data_nasc" => $dados_resp["data_nasc"],
          "nome_mae" => $dados_resp["nome_mae"]
        ];


    } else {
        $response['error'] = "CPF não cadastrado!";

    }

    $stmt->close();


} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "POST" não recebido.'));
}

echo json_encode($response);
$conn->close();