<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';



header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_POST['codfam'])) {
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);
    $ajustando_cod = str_pad($cpf_limpo, 11,'0',STR_PAD_LEFT);
    // Inicializa o array de resposta
    $response = array('encontrado' => false);

    // Consulta na tabela visitas_feitas
    $stmt_visita = $pdo->prepare("SELECT data, acao, entrevistador FROM visitas_feitas WHERE cod_fam = :codfamiliar");
    $stmt_visita->execute(array(':codfamiliar' => $cpf_limpo));
    



    if ($stmt_visita->rowCount() != 0) {
        $response['encontrado'] = true;
        $response['visitas'] = array();


        while ($dados_visita = $stmt_visita->fetch(PDO::FETCH_ASSOC)) {
        //formatando a data
        $data = $dados_visita['data'];
        // Verifica se a data não está vazia e tenta criar um objeto DateTime
        if (!empty($data)) {
            $formatando_data = DateTime::createFromFormat('Y-m-d', $data);

            // Verifica se a data foi criada corretamente
            if ($formatando_data) {
                $dados_visita['data'] = $formatando_data->format('d/m/Y');
            } else {
                $dados_visita['data'] = "Data inválida.";
            }
            $status = $dados_visita['acao'];
        } else {
            $dados_visita['data'] = "Data não fornecida.";
        }
        $response['visitas'][] = array(
            'data' => $dados_visita['data'],
            'acao' => $dados_visita['acao'],
            'entrevistador' => $dados_visita['entrevistador']
        );
    }
    } else {
        $response['encontrado'] = true;
        $response['data_visita'] = "NENHUMA VISITA ENCONTRADA!";
    }

    // Consulta na tabela tbl_tudo
    $stmt_tudo = "SELECT nom_pessoa FROM tbl_tudo WHERE cod_familiar_fam LIKE '$ajustando_cod' AND cod_parentesco_rf_pessoa = 1";
    $sql_query = $conn->query($stmt_tudo) or die("ERRO ao consultar !" . $conn->error);

    if ($sql_query->num_rows > 0) {
        $dados_tudo = $sql_query->fetch_assoc();
        $response['encontrado'] = true;
        $response['nome'] = $dados_tudo['nom_pessoa'];
    }

    if ($response['encontrado']) {
        echo json_encode($response);
    } else {
        http_response_code(404);
        echo json_encode(array('encontrado' => false, 'error' => 'Nenhum resultado encontrado.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "codfam" não recebido.'));
}