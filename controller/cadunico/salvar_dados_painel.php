<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php'; // Ajuste o caminho conforme necessário

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cod_familiar_fam = $_POST['codfamiliar'];
    $data_entrevista = $_POST['data_entrevista'];
    $tipo_documento = $_POST['tipo_documento'];
    $tipo_arquivo = $_POST['tipo_arquivo'];
    $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']);
    $tamanho = $_FILES['arquivo']['size'];

    $stmt = $conn->prepare("INSERT INTO cadastro_forms (cod_familiar_fam, data_entrevista, tipo_documento, tipo_arquivo, arquivo, tamanho) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssbi", $cod_familiar_fam, $data_entrevista, $tipo_documento, $tipo_arquivo, $arquivo, $tamanho);

    if ($stmt->execute()) {
        echo "Formulário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar formulário: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
