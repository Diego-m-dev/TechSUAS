<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';

$cod_ibge = $_POST['codIBGE'];

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_POST['codIBGE'])) {
    $cod_ibge = $_POST['codIBGE'];

    $response = array('encontrado' => false);

    // Consulta ao banco de dados
    $stmt_tudo = "SELECT * FROM setores WHERE cod_ibge LIKE '$cod_ibge'";
    $sql_query = $conn_1->query($stmt_tudo) or die("ERRO ao consultar !" . $conn_1->error);

    if ($sql_query->num_rows > 0) {
        $dados_tudo = $sql_query->fetch_assoc();
        $instituicao = $dados_tudo['instituicao'];
        $nomeInstituicao = $dados_tudo['nome_instit'];
        $id_setor = $dados_tudo['id'];

        // Retorna os dados em formato JSON
        echo json_encode(array(
            'encontrado' => true, 
            'instituicao' => $instituicao, 
            'id' => $id_setor, 
            'nomeInstituicao' => $nomeInstituicao
        ));
    } else {
        http_response_code(404);
        echo json_encode(array('encontrado' => false, 'error' => 'Nenhum resultado encontrado.'));
    }
}
$conn_1->close();
?>
