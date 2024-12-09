<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

$nis_exclui = $_POST['unip'];

try {
    // Preparar a query de exclusão usando prepared statement
    $stmt_exclui = $conn->prepare("INSERT INTO cadastros_excluidos (cod_familiar) VALUES (?)");
    $stmt_exclui->bind_param("s", $nis_exclui);

    // Executar a query
    if ($stmt_exclui->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} catch (PDOException $e) {
    echo "error";
}

$conn->close();
?>
