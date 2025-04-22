<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('salvo' => false); // Inicialmente definido como não encontrado

if (isset($_POST['cpf'], $_POST['obs'])) {
    // 🔹 **Sanitização e ajustes dos valores recebidos**
    //$codfamiliar = $conn->real_escape_string($_POST['cpf']);
    //$cpf_limpo = preg_replace('/\D/', '', $_POST['cpf']);
    // $ajustando_cod = ltrim($cpf_limpo, '0'); // Remover zeros à esquerda

    $cpf = $_POST['cpf'];
    $obs = $_POST['obs'];

    // Assumindo que existe uma sessão com o operador logado
    // $parentesco = 'Desconhecido';  Defina se houver um parâmetro correspondente

    try {

        $stmt = $pdo->prepare("INSERT INTO encaminhados_peixe (cpf_enc, obs_cla) 
                               VALUES (:cpf, :obs)");

        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':obs', $obs);
        // $stmt->bindParam(':parentesco', $parentesco);

        if ($stmt->execute()) {
            $response['salvo'] = true;
            $response['msg'] = 'Registro inserido com sucesso!';
        } else {
            $response['erro'] = 'Falha ao inserir os dados.';
        }

    } catch (PDOException $e) {
        $response['erro'] = 'Erro no banco de dados: ' . $e->getMessage();
    }
    
} else {
    http_response_code(400);
    $response['erro'] = 'Parâmetros obrigatórios não recebidos.';
}

echo json_encode($response);

// 🔹 **Fechando conexão corretamente**
$pdo_1 = null;
$pdo = null;