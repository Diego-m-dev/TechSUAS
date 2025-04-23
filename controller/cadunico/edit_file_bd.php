<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/models/cadunico/submit_model.php';

$operador = $_SESSION['nome_usuario'];

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('concluido' => false); // Inicialmente definido como falso

try {
    if (isset($_POST['id'])) {
        $id_i = $_POST['id'];

        // Limpando o código familiar para salvar apenas os números
        $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);
        $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

        $tipo_documento = $_POST['tipo_documento'];
        $dataEntre = $_POST['dataEntre'];

        // Preparando a atualização
        $stmt = $pdo->prepare("UPDATE cadastro_forms 
                               SET cod_familiar_fam = :codfam, 
                                   data_entrevista = :dataE, 
                                   tipo_documento = :tipo 
                               WHERE id = :id");

        // Vinculando os parâmetros corretamente
        $stmt->bindParam(':codfam', $ajustando_cod);
        $stmt->bindParam(':dataE', $dataEntre);
        $stmt->bindParam(':tipo', $tipo_documento);
        $stmt->bindParam(':id', $id_i);

        // Executando a consulta
        if ($stmt->execute()) {
            $response['concluido'] = true;
            $response['resposta'] = 'Foi alterado dados referentes ao cadastro ' . $_POST['codfam'];
        } else {
            $response['concluido'] = false;
            $response['resposta'] = 'Erro ao alterar dados referentes ao cadastro ' . $_POST['codfam'];
        }
    } else {
        $response['concluido'] = false;
        $response['resposta'] = 'Campos obrigatórios não preenchidos.';
    }

} catch (Exception $e) {
    echo json_encode(['msg' => "Erro: " . $e->getMessage()]);
    exit; // Finaliza o script após erro
}

// Retorna resposta JSON
echo json_encode($response);
?>