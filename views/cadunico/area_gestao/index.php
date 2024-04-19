<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
if ($_SESSION['funcao'] != '1') {
    echo '<script>window.history.back()</script>';
    exit();
}
ini_set('memory_limit', '8192M');
ini_set('max_execution_time', 300);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_ag_cad.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <title>Área Gestor</title>
</head>
<body>
    <h1>AREA DO GESTOR</h1>
        <form method="post">
            <label for="">NOME:</label>
            <input type="text" name="nome_pessoa"/>
            <label for="">Código Familiar</label>
            <input type="text" name="codigo_familia">
            <button type="submit" name="btn_filtro">Buscar</button>
        </form>
    <?php

if (!isset($_POST['btn_filtro'])) {

} else {
    if ($_POST['nome_pessoa']){
        $filtro = $conn->real_escape_string($_POST['nome_pessoa']);
    } elseif ($_POST['codigo_familia']) {
        $filtro = $conn->real_escape_string($_POST['codigo_familia']);
    }
    $smtp_filtros = $conn->prepare("SELECT * FROM tbl_tudo WHERE cod_familiar_fam LIKE '%$filtro' OR nom_pessoa LIKE '%$filtro%'");
    $smtp_filtros->execute();

    $result = $smtp_filtros->get_result(); // Obter o resultado da consulta
    $dados_filtro = $result->fetch_all(MYSQLI_ASSOC); // Obter todas as linhas como uma matriz associativa

    foreach ($dados_filtro as $dados) {
        echo $dados['cod_parentesco_rf_pessoa']. ' - ' . $dados['cod_familiar_fam'] . " " . $dados['nom_pessoa'] . " - " . $dados['num_nis_pessoa_atual'] ."<br>";
    }
}
?>
</body>
</html>
