<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/TechSUAS/css/cadunico/visitas/stylebuscar.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Buscar Visitas</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/cadunico/visitas/h1-buscar_visita.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="camp1">
        <form method="post" action="/TechSUAS/controller/cadunico/parecer/conferir">
            <label for="codfam" class="busca">CÓDIGO FAMILIAR:</label>
            <input type="text" name="codfam" class="busca2" placeholder="Digite aqui..." required>

            <button type="submit">Buscar</button>
            <a href="visitas.php"><i class="fas fa-arrow-left"></i>Voltar</a>
    </div>
    <div class="linha"></div>
    </form>
</body>

</html>