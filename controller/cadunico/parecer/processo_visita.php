<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

header("Content-Type: application/json");
$response = array('salvo' => false); // Inicialmente definido como não encontrado
// Verificar método e token
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["erro" => "Método não permitido."]);
    exit;
}

try {
    $data_visita = $_POST['datVis'];
    $acao_visita = $_POST['acaVis'];
    $parecer = nl2br($_POST['parEnt']);
    $codigo_familiar = $_POST['codFam'];
    $cod_limpo = preg_replace('/\D/', '', $codigo_familiar);
    $cod_ajustado = str_pad($cod_limpo, 11,'0',STR_PAD_LEFT);

    $smtp = $conn->prepare("INSERT INTO visitas_feitas (cod_fam, data, status, acao, parecer_tec, entrevistador) VALUES (?,?,?,?,?,?)");
    $smtp->bind_param("ssssss", $cod_ajustado, $data_visita, 'feito', $acao_visita, $parecer, $_SESSION['nome_usuario']);

        if($smtp->execute()){
        // Retorna resposta JSON
        $response['salvo'] = true;
            echo json_encode($response);
        } else {
            $response['msg'] = "ERRO no envio dos DADOS: ".   $smtp->error;
            echo json_encode($response); 
        }
} catch (Exception $e) {
	http_response_code(500);
	echo json_encode(['msg' => "Erro: " . $e->getMessage()]);
}
        $smtp->close();
        $conn->close();

?>