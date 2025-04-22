<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

if (isset($_POST['id'])) {
    $arquivo = $_SERVER['DOCUMENT_ROOT'] . $_POST['caminho'];

    if (file_exists($arquivo)) {
        $id = $_POST['id'];
            $stmt = $pdo->prepare('DELETE FROM cadastro_forms WHERE id = :id');
            $stmt->bindParam(':id', $id);
            
        if (unlink($arquivo) && $stmt->execute()) {
            $response['encontrado'] = true;
            $response['icon'] = 'success';
            $response['title'] = 'DELETADO';
            $response['mensagem'] = 'Arquivo deletado com sucesso';
            
    
        } else {
            $response['encontrado'] = false;
            $response['icon'] = 'error';
            $response['title'] = 'ERRO';
            $response['mensagem'] = 'Erro ao deletar arquivo';

    
        }
    } else {
        $response['encontrado'] = false;
        $response['icon'] = 'warning';
        $response['title'] = 'OPS NÃO ENCONTREI';
    $response['mensagem'] = 'Arquivo não encontrado';

    }
} else {
    $response['encontrado'] = false;
    $response['icon'] = 'error';
    $response['title'] = 'ERRO';
    $response['mensagem'] = 'Arquivo não fornecido';
}
echo json_encode($response);
?>
