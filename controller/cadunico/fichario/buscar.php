<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

header('Content-Type: application/json');

if (isset($_POST['cpf'])) {
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']); // Remove caracteres não numéricos do CPF

    // Remove zeros à esquerda do CPF
    $cpf_db = ltrim($cpf, '0');

    $sql = "SELECT cod_familiar_fam, nom_pessoa FROM tbl_tudo WHERE num_cpf_pessoa = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $cpf_db);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'nome' => $row['nom_pessoa'],
            'cod_fam_familia' => $row['cod_familiar_fam']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'CPF não fornecido']);
}
?>
