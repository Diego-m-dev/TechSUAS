<?php
// Configuração do banco de dados
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Limpar a tabela 'tbl_tudo'
    $plasdfe = $pdo->prepare("TRUNCATE tbl_tudo");
    $plasdfe->execute();

?>