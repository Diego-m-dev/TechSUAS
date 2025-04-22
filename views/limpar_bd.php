<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Definir o tamanho do lote
$lote = 100;
$offset = 0;

do {
    // Atualiza os registros em lotes para evitar estouro de memória
    $stmt = $pdo->prepare("UPDATE cadastro_forms SET arquivo = NULL WHERE arquivo IS NOT NULL LIMIT $lote");
    $stmt->execute();

    $linhasAfetadas = $stmt->rowCount();
    if ($linhasAfetadas === 0) {
        break; // Se não houver mais registros para atualizar, para o loop
    }

} while (true);

echo "Arquivos excluídos do banco de dados!";
?>
