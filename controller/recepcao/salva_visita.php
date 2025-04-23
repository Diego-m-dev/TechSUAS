<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('salvo' => false); // Inicialmente definido como não encontrado

if (isset($_POST['codfam'], $_POST['endereco'], $_POST['nome_'], $_POST['obs'])) {
    // 🔹 **Sanitização e ajustes dos valores recebidos**
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']); // Apenas números no CPF
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

    // $ajustando_cod = ltrim($cpf_limpo, '0'); // Remover zeros à esquerda

    $nome_pessoa = $_POST['nome_'];
    $cpf_valido = $_POST['codfam'];
    $endereco = $_POST['endereco'];
    $status = 'registrado';
    $parecer_rec = $_POST['obs'];
    $op_recepcao = $_SESSION['nome_usuario'];

    try {

        // Inserção dos dados na tabela `peixe`**
        $stmt = $pdo->prepare("INSERT INTO visitas_feitas (nome, cpf, status, endereco, recepcao, parecer_rec) 
                               VALUES (:nome, :cpf, :status, :endereco, :recepcao, :parecer_rec)");

        $stmt->bindParam(':nome', $nome_pessoa);
        $stmt->bindParam(':cpf', $cpf_valido);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':recepcao', $op_recepcao);
        $stmt->bindParam(':parecer_rec', $parecer_rec);

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