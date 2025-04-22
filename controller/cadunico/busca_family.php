<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

if (isset($_POST['codfam'])) {
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

    // 🔹 **1ª Consulta: Buscar dados da família na tbl_tudo**
    $stmt = $pdo->prepare("SELECT t.nom_pessoa, t.cod_parentesco_rf_pessoa, t.num_nis_pessoa_atual, t.dta_entrevista_fam, f.arm_gav_pas AS localizacao_arquivo
                            FROM tbl_tudo t
                            LEFT JOIN fichario f ON t.cod_familiar_fam = f.codfam
                            WHERE cod_familiar_fam = :codfam 
                            ORDER BY t.cod_parentesco_rf_pessoa ASC, t.dta_nasc_pessoa ASC");
    $stmt->execute(array(':codfam' => $ajustando_cod));

    $dados_familia = array();
    $data_entrevista = null;
    $fichario = null;
    
    if ($stmt->rowCount() > 0) {
        $response['encontrado'] = true;

        while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
            $parentesco = $parentesco_map[$dados['cod_parentesco_rf_pessoa']];
            $dados_familia[] = array(
                'nome' => $dados['nom_pessoa'],
                'parentesco' => $parentesco,
                'nis_atual' => $dados['num_nis_pessoa_atual']
            );

            // Captura a data de entrevista do responsável familiar (cod_parentesco_rf_pessoa = 1)
            if ($dados['cod_parentesco_rf_pessoa'] == 1 && !empty($dados['dta_entrevista_fam'])) {
                $data_entrevista = $dados['dta_entrevista_fam'];
                $fichario = $dados['localizacao_arquivo'];
            }
        }
    }

    // Formata a data de entrevista, se encontrada
    $response['data_entrevista'] = $data_entrevista ? DateTime::createFromFormat('Y-m-d', $data_entrevista)->format('d/m/Y') : "Data não fornecida.";
    $response['fichario'] = $fichario ? $fichario : "Sem Fichário";
    $response['dados_familia'] = !empty($dados_familia) ? $dados_familia : "NENHUMA VISITA ENCONTRADA!";

    // 🔹 **2ª Consulta: Buscar arquivos na tabela `cadastro_forms`** (Independente da 1ª consulta)
    $stmt_arquivos = $pdo->prepare("
        SELECT id, caminho_arquivo, tipo_documento, data_entrevista
        FROM cadastro_forms
        WHERE cod_familiar_fam = :codfam
    ");
    $stmt_arquivos->execute(array(':codfam' => $ajustando_cod));

    $arquivos = array();
    
    if ($stmt_arquivos->rowCount() > 0) {
        while ($arquivo = $stmt_arquivos->fetch(PDO::FETCH_ASSOC)) {
            $arquivos[] = array(
                'id' => $arquivo['id'],
                'caminho_arquivo' => $arquivo['caminho_arquivo'],
                'tipo_documento' => $arquivo['tipo_documento'],
                'data_entrevista' => DateTime::createFromFormat('Y-m-d', $arquivo['data_entrevista']) 
                    ? DateTime::createFromFormat('Y-m-d', $arquivo['data_entrevista'])->format('d/m/Y') 
                    : "Data inválida."
            );
        }
    }

    // Adiciona os arquivos ao JSON de resposta
    $response['arquivos'] = !empty($arquivos) ? $arquivos : "Nenhum arquivo encontrado.";

    // 🔹 **Agora, mesmo se a 1ª consulta falhar, a 2ª será retornada**
    echo json_encode($response);

} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "codfam" não recebido.'));
}

// Fechando conexão corretamente**
$pdo_1 = null;
$pdo = null;