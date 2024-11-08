<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

if (isset($_POST['codfam'])) {
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

    // Mapeamento de parentesco
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

    // Consulta única para obter dados da família e a data da entrevista do responsável familiar
    $stmt = $pdo->prepare("SELECT t.nom_pessoa, t.cod_parentesco_rf_pessoa, t.num_nis_pessoa_atual, t.dta_entrevista_fam, f.arm_gav_pas AS localizacao_arquivo
                            FROM tbl_tudo t
                            LEFT JOIN fichario f ON t.cod_familiar_fam = f.codfam
                            WHERE cod_familiar_fam = :codfam 
                            ORDER BY t.cod_parentesco_rf_pessoa ASC, t.dta_nasc_pessoa ASC");
    $stmt->execute(array(':codfam' => $ajustando_cod));

    if ($stmt->rowCount() > 0) {
        $response['encontrado'] = true;
        $response['dados_familia'] = array();
        $data_entrevista = null;

        while ($dados_familia = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $parentesco = $parentesco_map[$dados_familia['cod_parentesco_rf_pessoa']];
            $response['dados_familia'][] = array(
                'nome' => $dados_familia['nom_pessoa'],
                'parentesco' => $parentesco,
                'nis_atual' => $dados_familia['num_nis_pessoa_atual']
            );

            // Captura a data de entrevista do responsável familiar (cod_parentesco_rf_pessoa = 1)
            if ($dados_familia['cod_parentesco_rf_pessoa'] == 1 && !empty($dados_familia['dta_entrevista_fam'])) {
                $data_entrevista = $dados_familia['dta_entrevista_fam'];
                $fichario = $dados_familia['localizacao_arquivo'];
            }

        }

        // Formata a data de entrevista, se encontrada
        if ($data_entrevista) {
            $response['data_entrevista'] = DateTime::createFromFormat('Y-m-d', $data_entrevista) 
                ? DateTime::createFromFormat('Y-m-d', $data_entrevista)->format('d/m/Y') 
                : "Data inválida.";
        } else {
            $response['data_entrevista'] = "Data não fornecida.";
        }
        if ($fichario) {
          $response['fichario'] = $fichario;
        } else {
          $response['fichario'] = "Sem Fichário";

        }
    } else {
        $response['dados_familia'] = "NENHUMA VISITA ENCONTRADA!";
    }

    // Retorna a resposta JSON com base no valor de 'encontrado'
    if ($response['encontrado']) {
        echo json_encode($response);
    } else {

        echo json_encode(array('encontrado' => false, 'error' => 'Nenhum resultado encontrado.'));
    }
} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "codfam" não recebido.'));
}
