<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codfam = $_POST['codigo_alterado'];
    $id = $_POST['id_visita'];
        $cpf_limpo = preg_replace('/\D/', '', $codfam);
        $cpf_already = ltrim($cpf_limpo, '0');
    $smtp = $conn->prepare("UPDATE visitas_feitas SET cod_fam=? WHERE id_visita=?");
    $smtp->bind_param("ss", $cpf_already, $id);
    if ($smtp->execute()) {

        echo json_encode(['success' => true, 'message' => 'Dados salvos com sucesso']);
    exit();
    } else {
        echo json_encode(['success' => true, 'message' => 'Erro na atualização das informações: '. $smtp->error]);
    }

    $smtp->close();

}
