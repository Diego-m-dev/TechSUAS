<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
if ($_SESSION['funcao'] != '1') {
    echo '<script>window.history.back()</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/gestor.js"></script>

    <title>Filtros</title>
</head>
<body>
    <h1>CADASTROS ÚNICO <?php echo $cidade; ?></h1>

    <button onclick="filtroGPTE()">Filtrar GPTEs</button>
    <button onclick="filtroTrabInf()">Trabalho Infantil</button>
    <button onclick="filtroCriIdo()">Geral</button>
</body>
</html>
