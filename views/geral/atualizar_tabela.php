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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Importar CSV - TechSUAS</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/geral/h1-banco.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <form action="/TechSUAS/controller/geral/import.php" method="POST" enctype="multipart/form-data">
            <label>Informe a tabela: </label>
            <select name="csv_tbl" required>
                <option value="" disabled selected hidden>Selecione</option>
                <option value="tudo">Base de Dados do Cadastro Único</option>
                <option value="folha">Folha de Pagamento</option>
                <option value="unipessoal">Averiguação Unipessoal</option>
                <option value="averenda">Averiguação por Renda</option>
            </select><br>
            <label>Selecione o arquivo CSV: </label>
            <input type="file" name="arquivoCSV" id="arquivoCSV" accept=".csv" required>
            <button type="submit" value="Importar"> Importar </button>
            <div class="btn">
                <a href="/TechSUAS/config/back">
                    <i class="fas fa-arrow-left"></i> Voltar ao menu
                </a>
            </div>
        </form>
    </div>
</body>
</html>
