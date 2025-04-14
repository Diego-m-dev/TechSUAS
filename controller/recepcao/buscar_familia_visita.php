<?php
// Esse arquivo é requisitado no visitas_recepcao.js para apresentar ao cliente dados das famílias que estão solicitando visitas.
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

$cpfpsas = $_POST['codfam'];

header('Content-Type: application/json');

$response = array('encontrado' => false);

try {
    // 🔹 Consulta principal: dados da pessoa
    $stmt = $pdo->prepare("SELECT t.cod_familiar_fam,
                t.nom_pessoa,
                t.num_cpf_pessoa,
                CONCAT(
                   t.nom_tip_logradouro_fam, ' ',
                   t.nom_titulo_logradouro_fam, ' ',
                   t.nom_logradouro_fam, ', ',
                   t.num_logradouro_fam, ' - ',
                   t.nom_localidade_fam, ', ',
                   SUBSTRING(t.num_cep_logradouro_fam, 1, 5), '-', SUBSTRING(t.num_cep_logradouro_fam, 6, 3), ', ',
                   t.txt_referencia_local_fam
                ) AS endereco
        FROM tbl_tudo t
        WHERE t.num_cpf_pessoa = :cpf_pessoa
    ");
    $stmt->execute([':cpf_pessoa' => $cpfpsas]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dados) {
        $response['encontrado'] = true;
        $response['nome'] = $dados['nom_pessoa'];
        $response['endereco'] = $dados['endereco'];
        $response['codfam'] = $dados['cod_familiar_fam'];
        

        // 🔹 Consulta das visitas (podem ser várias)
        $stmt2 = $pdo->prepare("SELECT status, parecer_tec,
        CASE
            WHEN data != NULL THEN DATE_FORMAT(data, '%d/%m/%Y')
            ELSE DATE_FORMAT(created_at, '%d/%m/%Y')
        END AS edata
        FROM visitas_feitas WHERE cpf = :cpf
        ORDER BY created_at DESC
        ");
        $stmt2->execute([':cpf' => $cpfpsas]);
        $visitas = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $response['visitas'] = $visitas; // array com 0 ou mais visitas
    } else {
        $response['msg'] = 'Não foi encontrado nenhum cadastro com esse CPF.';
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode(['msg' => "Erro: " . $e->getMessage()]);
}

$pdo = null;
?>
