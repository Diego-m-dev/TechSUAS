<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('salvo' => false); // Inicialmente definido como não encontrado

if (isset($_POST['codfam'], $_POST['cod_talao'], $_POST['cpf_valido'], $_POST['nome_pessoa'], $_POST['entrega'], $_POST['bpc'])) {
    // 🔹 **Sanitização e ajustes dos valores recebidos**
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']); // Apenas números no CPF
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

    // $ajustando_cod = ltrim($cpf_limpo, '0'); // Remover zeros à esquerda

    $codigo_talao = $_POST['cod_talao'];
    $nome_pessoa = $_POST['nome_pessoa'];
    $cpf_valido = $_POST['cpf_valido'];
    $entrega = $_POST['entrega'];
    $cadastro = $_SESSION['lc_cad'];
    $operador = $_SESSION['nome_usuario']; // Assumindo que existe uma sessão com o operador logado
    // $parentesco = 'Desconhecido';  Defina se houver um parâmetro correspondente

    try {

        $stmt = $pdo->prepare("SELECT codigo_talao FROM peixe WHERE codigo_talao = :codigo_talao");
        $stmt->bindParam(':codigo_talao', $codigo_talao);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response['salvo'] = false;
            $response['msg'] = 'Talão <strong>' . str_pad($codigo_talao, 4, '0', STR_PAD_LEFT) . '</strong> já cadastrado';
            echo json_encode($response);

            exit();
        }


        // 🔹 **Inserção dos dados na tabela `peixe`**
        $stmt = $pdo->prepare("INSERT INTO peixe (codigo_talao, cpf, nome, cod_fam, operador, local_entrega, local_cadastro, bpc) 
                               VALUES (:cod_talao, :cpf, :nome, :cod_fam, :operador, :local_entrega, :local_cadastro , :bpc)");

        $stmt->bindParam(':cod_talao', $codigo_talao);
        $stmt->bindParam(':cpf', $cpf_valido);
        $stmt->bindParam(':nome', $nome_pessoa);
        $stmt->bindParam(':cod_fam', $ajustando_cod);
        $stmt->bindParam(':operador', $operador);
        $stmt->bindParam(':local_entrega', $entrega);
        $stmt->bindParam(':local_cadastro', $cadastro);
        $stmt->bindParam(':bpc', $_POST['bpc']);
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