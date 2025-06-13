<?php
// dados enviados para a página de relatórios de entrevistadores.
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

$stmt = $pdo->prepare("
    SELECT 
        COUNT(*) AS totais, 
        LPAD(num_cpf_entrevistador_fam, 11, '0') AS num_cpf_entrevistador_fam 
    FROM tbl_tudo 
    WHERE cod_parentesco_rf_pessoa = 1 
    GROUP BY num_cpf_entrevistador_fam
");
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $resultado = [];
    while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $resultado[] = [
            'totais' => $dados['totais'],
            'num_cpf_entrevistador_fam' => $dados['num_cpf_entrevistador_fam'],
        ];
    }
    $response['encontrado'] = true;
    $response['resultado'] = $resultado;
}
    echo json_encode($response); // Envia a resposta como JSON
