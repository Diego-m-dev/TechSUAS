<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_POST['codfam'])) {
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);

    // Inicializa o array de resposta
    $response = array('encontrado' => false);

    // Consulta na tabela visitas_feitas
    $stmt_visita = $pdo->prepare("SELECT * FROM visitas_feitas WHERE cod_fam = :codfamiliar");
    $stmt_visita->execute(array(':codfamiliar' => $codfamiliar));

    if ($stmt_visita->rowCount() > 0) {
        $dados_visita = $stmt_visita->fetch(PDO::FETCH_ASSOC);
        $response['encontrado'] = true;

        //formatando a data

        $data = $dados_visita['data'];
        // Verifica se a data não está vazia e tenta criar um objeto DateTime
        if (!empty($data)) {
            $formatando_data = DateTime::createFromFormat('Y-m-d', $data);
        
            // Verifica se a data foi criada corretamente
            if ($formatando_data) {
                $data_formatada = $formatando_data->format('d/m/Y');
            } else {
                echo "Data inválida.";
            }
        } else {
            echo "Data não fornecida.";
        }

        $response['data_visita'] = ' DATA DA VISITA: '. $data_formatada;
        $response['acao'] = $dados_visita['acao'];
        $response['entrevistador'] = $dados_visita['entrevistador'];
    } else {
        $response['encontrado'] = true;
        $response['data_visita'] = "NENHUMA VISITA ENCONTRADA";
    }

    // Consulta na tabela tbl_tudo
    $stmt_tudo = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam LIKE '%$codfamiliar%' AND cod_parentesco_rf_pessoa = 1";
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
