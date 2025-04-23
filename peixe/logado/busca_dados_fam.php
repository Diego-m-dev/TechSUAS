<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

if (isset($_POST['codfam'])) {
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);

    $stmt = $pdo->prepare("SELECT b.cpf, b.nome_titular, b.numero_beneficio, p.codigo_talao
                            FROM beneficiarios_BPC b
                            LEFT JOIN peixe p ON b.cpf = p.cpf
                            WHERE b.cpf = :cpf"
                        );
    $stmt->execute(array(':cpf' => $cpf_limpo));
    $resultado = $stmt->fetch();
    if ($resultado) {
        $response['bpc'] = 'S';
        $response['bpc_nome'] = $resultado['nome_titular'];
        $response['bpc_numero'] = $resultado['numero_beneficio'];
        $response['bpc_cpf'] = $resultado['cpf'];
        $talao_bpc = $resultado['codigo_talao'];
        $talao_bpc_0 = str_pad($talao_bpc, 4, '0', STR_PAD_LEFT);
        $response['bpc_talao'] = $talao_bpc ? $talao_bpc_0 : 'X';

    } else {
        $response['bpc'] = 'N';
        $stmt = $pdo->prepare("SELECT CONCAT('R$ ', vlr_renda_media_fam, ',00') AS vlr_renda_media_fam FROM tbl_tudo WHERE num_cpf_pessoa = :cpf AND vlr_renda_media_fam >= 501");
        $stmt->execute(array(':cpf' => $cpf_limpo));
        $result = $stmt->fetch();
        if ($result) {
            $response['encontrado'] = false;
            $response['dados_familia'] = '<p>Renda per capita da família: <strong>' . $result['vlr_renda_media_fam'] . '</strong>.</p> <p>De arcordo com as regras do programa essa família não tem perfil para o benefício, pois sua renda média é superior a R$ 500,00.</p> <p>Para mais informações encaminhe a pessoa a SAS</p>';
            echo json_encode($response);
            exit();
        }
    }

    



    // Consulta: Buscar dados da família na tbl_tudo
    $stmt = $pdo->prepare("SELECT t.nom_pessoa, t.cod_parentesco_rf_pessoa, r.num_nis_pessoa_atual, t.dta_entrevista_fam, t.num_cpf_pessoa, r.nom_pessoa, r.cod_parentesco_rf_pessoa, r.dta_nasc_pessoa, r.num_cpf_pessoa, p.codigo_talao, r.cod_familiar_fam, t.qtde_meses_desat_cat
                            FROM tbl_tudo t
                            LEFT JOIN tbl_tudo r ON t.cod_familiar_fam = r.cod_familiar_fam
                            LEFT JOIN peixe p ON t.cod_familiar_fam = p.cod_fam
                            WHERE t.num_cpf_pessoa = :codfam
                            ORDER BY r.cod_parentesco_rf_pessoa ASC, r.dta_nasc_pessoa ASC;");
    $stmt->execute(array(':codfam' => $cpf_limpo));

    $dados_familia = array();
    $data_entrevista = null;

    
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
                'nis_atual' => $dados['num_nis_pessoa_atual'],
                'cpf_pessoa' => $dados['num_cpf_pessoa']
            );

            // Captura a data de entrevista do responsável familiar (cod_parentesco_rf_pessoa = 1)
            if ($dados['cod_parentesco_rf_pessoa'] == 1 && !empty($dados['dta_entrevista_fam'])) {
                $data_entrevista = $dados['dta_entrevista_fam'];
                $codigo_talao = $dados['codigo_talao'];
                $nome_ = $dados['nom_pessoa'];
                $codigo_fam = $dados['cod_familiar_fam'];
                $situacao_cad = $dados['qtde_meses_desat_cat'];
            }
        }

        $codigo_talao_0 = str_pad($codigo_talao, 4, '0', STR_PAD_LEFT);
        $class ='cpfInformado';
        $nome_pessoa = '${response.nome_pessoa}';
        $cod_familia = '$${response.codigo_fam}';
    
    
        // Formata a data de entrevista, se encontrada
        $response['data_entrevista'] = $data_entrevista ? DateTime::createFromFormat('Y-m-d', $data_entrevista)->format('d/m/Y') : "Data não fornecida.";
        $response['situacao_cad'] = $situacao_cad >= 4 ? "Desatualizado" : "Atualizado";
        $response['nome_pessoa'] = $nome_ ? $nome_ : "N/A";
        $response['codigo_talao'] = $codigo_talao ? $codigo_talao_0 : 'X';
    
        $response['dados_familia'] = !empty($dados_familia) ? $dados_familia : "NENHUMA VISITA ENCONTRADA!";
        $response['codigo_fam'] = $codigo_fam;
    
    } else {
        $response['encontrado'] = false;
        $response['dados_familia'] = 'Não foi encontrado nenhum cadastro de família com o CPF informado';
    }


    // 🔹 **Agora, mesmo se a 1ª consulta falhar, a 2ª será retornada**
    echo json_encode($response);

} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "codfam" não recebido.'));
}
// Fechando conexão corretamente**
$pdo_1 = null;
$pdo = null;