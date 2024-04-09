<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_POST['id_hist'])) {
    $idHist = $_POST['id_hist'];

    $stmt_conc_print = $pdo->prepare("SELECT * FROM concessao_historico WHERE id_hist = :id_hist");
    $stmt_conc_print->execute(array(':id_hist' => $idHist));

    if ($stmt_conc_print->rowCount() > 0) {
        $dados_conc = $stmt_conc_print->fetch(PDO::FETCH_ASSOC);

        $id_concessao = $dados_conc['id_concessao'];
        $nis_benef = $dados_conc['nis_benef'];
        $cpf_benef = $dados_conc['cpf_benef'];

        $stmt_resp_print = $pdo->prepare("SELECT * FROM concessao_tbl WHERE id_concessao = :id_concessao");
        $stmt_resp_print->execute(array(':id_concessao' => $id_concessao));
        $dados_conc_resp = $stmt_resp_print->fetch(PDO::FETCH_ASSOC);

        $stmt_benef_print = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = :nis_concessao");
        $stmt_benef_print->execute(array(':nis_concessao' => $nis_benef));
        $dados_conc_benef = $stmt_benef_print->fetch(PDO::FETCH_ASSOC);

        if ($stmt_benef_print->rowCount() == 0) {

            $stmt_other_benef_print = $pdo->prepare("SELECT * FROM beneficiario WHERE cpf_beneficio = :cpf_beneficio");
            $stmt_other_benef_print->execute(array(':cpf_beneficio' => $cpf_benef));
            $dados_conc_benef_other = $stmt_other_benef_print->fetch(PDO::FETCH_ASSOC);

            if ($dados_conc_resp['nis_pessoa'] == null) {
                $nis_config = "";
            } else {
                $nis_config = $dados_conc_resp['nis_pessoa'];
            }

            if ($dados_conc['nis_benef'] == null) {
                $nis_config_b = "";
            }

            echo json_encode(array(
                'encontrado' => true,
                'num_form' => $dados_conc['num_form'],
                'ano_form' => $dados_conc['ano_form'],
                'nome_resp' => $dados_conc_resp['nome'],
                'naturalidade_resp' => $dados_conc_resp['naturalidade'],
                'nome_m' => $dados_conc_resp['nome_mae'],
                'contato' => $dados_conc_resp['contato'],
                'cpf_resp' => $dados_conc_resp['cpf_pessoa'],
                'tit_eleitor_pessoa' => $dados_conc_resp['tit_eleitor_pessoa'],
                'rg_pessoa' => $dados_conc_resp['rg_pessoa'],
                'nis_pessoa' => $nis_config,
                'nome_benef' => $dados_conc['nome_benef'],
                'naturalidade_benef' => $dados_conc['nome_benef'],
                'munic_nasc' => $dados_conc_benef_other['naturalidade'],
                'nom_mae_pessoa' => $dados_conc_benef_other['nome_mae_benef'],
                'renda_media' => $dados_conc_benef_other['renda_media'],
                'endereco' => $dados_conc['endereco'],
                'cpf_pessoa_b' => $dados_conc['cpf_benef'],
                'tet_ili_b' => $dados_conc['tit_benef'],
                'rg_pessoa_b' => $dados_conc['rg_benef'],
                'nis_pessoa_b' => $nis_config_b,
                'parentes' => $dados_conc['parentesco'],
                'nome_item' => $dados_conc['nome_item'],
                'descricao' => $dados_conc['descricao'],
                'qtd_item' => $dados_conc['qtd_item'],
                'valor_uni' => $dados_conc['valor_uni'],
                'valor_total' => $dados_conc['valor_total'],
                'local_data' => $dados_conc['ano_form'],

            ));
            exit;
        } else {

            echo json_encode(array(
                'encontrado' => true,
                'num_form' => $dados_conc['num_form'],
                'ano_form' => $dados_conc['ano_form'],
                'nome_resp' => $dados_conc_resp['nome'],
                'naturalidade_resp' => $dados_conc_resp['naturalidade'],
                'nome_m' => $dados_conc_resp['nome_mae'],
                'contato' => $dados_conc_resp['contato'],
                'cpf_resp' => $dados_conc_resp['cpf_pessoa'],
                'tit_eleitor_pessoa' => $dados_conc_resp['tit_eleitor_pessoa'],
                'rg_pessoa' => $dados_conc_resp['rg_pessoa'],
                'nis_pessoa' => $dados_conc_resp['nis_pessoa'],
                'nome_benef' => $dados_conc['nome_benef'],
                'naturalidade_benef' => $dados_conc['nome_benef'],
                'munic_nasc' => $dados_conc_benef['nom_ibge_munic_nasc_pessoa'],
                'nom_mae_pessoa' => $dados_conc_benef['nom_completo_mae_pessoa'],
                'renda_media' => $dados_conc_benef['vlr_renda_media_fam'],
                'endereco' => $dados_conc['endereco'],
                'cpf_pessoa_b' => $dados_conc['cpf_benef'],
                'tet_ili_b' => $dados_conc['tit_benef'],
                'rg_pessoa_b' => $dados_conc['rg_benef'],
                'nis_pessoa_b' => $dados_conc['nis_benef'],
                'parentes' => $dados_conc['parentesco'],
                'nome_item' => $dados_conc['nome_item'],
                'descricao' => $dados_conc['descricao'],
                'qtd_item' => $dados_conc['qtd_item'],
                'valor_uni' => $dados_conc['valor_uni'],
                'valor_total' => $dados_conc['valor_total'],
                'local_data' => $dados_conc['ano_form'],
            ));
            exit; // Garante que nenhum código adicional seja executado
        }
    } else {
        http_response_code(404);
        echo json_encode(array('encontrado' => false, 'error' => 'Nenhum resultado encontrado.'));
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "id_hist" não recebido.'));
    exit;
}
