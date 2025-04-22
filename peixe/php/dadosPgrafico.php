<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

    $stmt = $pdo->prepare("SELECT COUNT(*) AS total_cadastros FROM peixe");
    $stmt->execute();
    $total_cadastros = $stmt->fetch(PDO::FETCH_ASSOC);


    // Consulta: Buscar dados da família na tbl_tudo
    $stmt = $pdo->prepare("SELECT COUNT(local_entrega) AS tt_local, local_entrega FROM peixe GROUP BY local_entrega");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $response['encontrado'] = true;
        $response['total_cadastros'] = $total_cadastros['total_cadastros'];       

        while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $dados_familia[] = array(
                'x' => $dados['local_entrega'],
                'value' => $dados['tt_local']
            );
        }

        $response['dados_local_entrega'] = $dados_familia;
    
    } else {
        $response['encontrado'] = false;
        $response['dados_familia'] = 'Não foi encontrado nenhum cadastro de família com o CPF informado';
    }
    // 🔹 **Agora, mesmo se a 1ª consulta falhar, a 2ª será retornada**
    echo json_encode($response);

// Fechando conexão corretamente**
$pdo_1 = null;
$pdo = null;