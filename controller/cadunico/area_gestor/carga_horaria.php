<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

if (isset($_POST['cpf_servidor'])) {
    $cpf_servidor = $pdo_1->quote($_POST['cpf_servidor']);

    // Consulta única para obter dados da família e a data da entrevista do responsável familiar
    $stmt = $pdo_1->prepare("SELECT *
                            FROM operadores
                            WHERE cpf = :cpf_servidor");
    $stmt->execute(array(':cpf_servidor' => $cpf_servidor));

    if ($stmt->rowCount() > 0) {
      $dados_servidor = $stmt->fetch(PDO::FETCH_ASSOC);
        $response['encontrado'] = true;
        $response['dados_servidor'] = $dados_servidor['nome'];
        $response['nis_servidor'] = $dados_servidor['nis_func'];

        

    } else {
        $response['dados_servidor'] = "NENHUMA SERVIDOR ENCONTRADO!";
    }

    // Retorna a resposta JSON com base no valor de 'encontrado'
    if ($response['encontrado']) {
        echo json_encode($response);
    } else {

        echo json_encode(array('encontrado' => false, 'error' => 'Nenhum resultado encontrado.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "codfam" não recebido.'));
}
