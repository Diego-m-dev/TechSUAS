<?php
include $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

$result = $conn->query("SELECT * FROM cadastro_forms");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT nome_arquivo, tipo_mime, arquivo FROM cadastro_forms WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nome_arquivo, $tipo_mime, $arquivo);
    $stmt->fetch();

    header("Content-Type: " . $tipo_mime);
    header("Content-Disposition: attachment; filename=" . $nome_arquivo);
    echo $arquivo;

    $stmt->close();
}

$conn->close();
?>
