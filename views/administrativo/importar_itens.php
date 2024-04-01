<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';
$ano_atual = date('Y');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/TechSUAS/css/administrativo/style_cad_consul_cont.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Importar Itens</title>
</head>

<body>
    <script>
    Swal.fire({
    icon: "info",
    html:`
    <h3>ATENÇÃO</h3>
    <p>Para importação de tabela, certifique-se de importar um arquivo CSV autentico para não prejudicar a segurança do sistema, antes de importar altere para o formato padrão para que o sistema identifique os dados contido no arquivo.</p>
    `,
    confirmButtonText: 'OK',
    })
    </script>
    <form action="/TechSUAS/controller/administrativo/importar_itens" method="POST" enctype="multipart/form-data">
        <label for="">Numero Contrato:</label>
        <input type="text" name="num_contrato" id="num_contrato">
        <label for="">Importar:</label>
        <input type="file" name="arquivoCSV" id="arquivoCSV" accept=".csv">
        <button type="submit" value="Importar"> Importar </button>
    </form>
</body>