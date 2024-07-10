<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_POST['codfam'])) {
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

    $response = array('encontrado' => false);

    // Consulta na tabela visitas_feitas
    $stmt_family = $pdo->prepare("SELECT * FROM tbl_tudo WHERE cod_familiar_fam = :codfam ORDER BY cod_parentesco_rf_pessoa ASC, dta_nasc_pessoa ASC");
    $stmt_family->execute(array(':codfam' => $ajustando_cod));

    if ($stmt_family->rowCount() != 0) {
        $response['encontrado'] = true;
        $response['dados_familia'] = array();

        while ($dados_familia = $stmt_family->fetch(PDO::FETCH_ASSOC)) {

            $parentesco_map = [
                1 => "RESPONSAVEL FAMILIAR",
                2 => "CONJUGE OU COMPANHEIRO",
                3 => "FILHO(A)",
                4 => "ENTEADO(A)",
                5 => "NETO(A) OU BISNETO(A)",
                6 => "PAI OU MÃE",
                7 => "SOGRO(A)",
                8 => "IRMÃO OU IRMÃ",
                9 => "GENRO OU NORA",
                10 => "OUTROS PARENTES",
                11 => "NÃO PARENTE"
            ];
            $parentesco = $parentesco_map[$dados_familia['cod_parentesco_rf_pessoa']];
            $response['dados_familia'][] = array(
                'nome' => $dados_familia['nom_pessoa'],
                'parentesco' => $parentesco,
                'nis_atual' => $dados_familia['num_nis_pessoa_atual']
            );
        }
    } else {
        $response['encontrado'] = true;
        $response['dados_familia'] = "NENHUMA VISITA ENCONTRADA!";
    }

    $stmt_tudo = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam LIKE '$ajustando_cod' AND cod_parentesco_rf_pessoa = 1";
    $sql_query = $conn->query($stmt_tudo) or die("ERRO ao consultar !" . $conn->error);

    if ($sql_query->num_rows > 0) {
            $dados_tudo = $sql_query->fetch_assoc();
            $data_entrevista = $dados_tudo['dta_entrevista_fam'];
            $data_formatada_entrevista = !empty($data_entrevista) 
            ? (DateTime::createFromFormat('Y-m-d', $data_entrevista) 
            ? DateTime::createFromFormat('Y-m-d', $data_entrevista)->format('d/m/Y') 
            : "Data inválida.") 
            : "Data não fornecida.";
        $response['encontrado'] = true;
        $response['data_entrevista'] = $data_formatada_entrevista;
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


$conn->close();