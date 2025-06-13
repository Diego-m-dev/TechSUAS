<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Exclui da tbl_tudo os registros que têm cod_familiar_fam igual a cod_familiar em cadastros_excluidos
$query = "
    DELETE FROM tbl_tudo
    WHERE cod_familiar_fam IN (
        SELECT cod_familiar FROM (
            SELECT cod_familiar FROM cadastros_excluidos
        ) AS temp
    )
";

// Executa a query
if ($conn->query($query)) {
    echo "Registros excluídos com sucesso! Total afetado: " . $conn->affected_rows;
} else {
    echo "Erro ao excluir registros: " . $conn->error;
}

$conn->close();
?>