<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

if ($_SESSION['funcao'] != '1' && $_SESSION['funcao'] != '0') {
    echo '<script>window.history.back()</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/geral/stylebanco.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <title>Importar CSV - TechSUAS</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/geral/h1-banco.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
    <form id="csvForm">
    <label>Informe a tabela: </label>
    <select name="csv_tbl" id="csvTable" required>
        <option value="" disabled selected hidden>Selecione</option>
        <option value="tudo">Base de Dados do Cadastro Único</option>
        <option value="folha">Folha de Pagamento</option>
        <option value="unipessoal">Averiguação Unipessoal</option>
        <option value="averenda">Averiguação por Renda</option>
    </select>
    <br>
    <label>Selecione o arquivo CSV: </label>
    <input type="file" id="arquivoCSV" accept=".csv" required>
    <br>
    <button type="button" id="processCSV">Processar CSV</button>
</form>

<!-- Pré-visualização -->
<div id="csvPreview">
    <h3>Pré-visualização:</h3>
    <table id="previewTable" border="1"></table>
</div>

    </div>
    <script src="/TechSUAS/js/import.js"></script>
</body>
</html>
