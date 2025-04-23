<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('salvo' => false); // Inicialmente definido como não encontrado

if (isset($_POST['lc_cadastro']) && isset($_SESSION['cpf'])) {

    $lc = $_POST['lc_cadastro'] === "X" ? 'X' : $_POST['lc_cadastro'];
    $cpf_operador = $_SESSION['cpf'];

    try {
        // Atualização na tabela `operadores`**
        $stmt = $pdo_1->prepare("UPDATE operadores SET local_cadastro = :lc_cadastro WHERE cpf = :cpf");
        $stmt->bindParam(':lc_cadastro', $lc, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $cpf_operador, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['lc_cad'] = $lc;
            $response['salvo'] = true;
            $response['msg'] = 'Registro atualizado com sucesso!';
        } else {
            $response['msg'] = 'Falha ao atualizar os dados.';
        }

    } catch (PDOException $e) {
        $response['erro'] = 'Erro no banco de dados: ' . $e->getMessage();
    }

}  else {
    http_response_code(400);
    $response['erro'] = 'Parâmetros obrigatórios não recebidos.';
}

// Retornar resposta JSON
echo json_encode($response);

// 🔹 **Fechando conexão corretamente**
$pdo_1 = null;
$pdo = null;
