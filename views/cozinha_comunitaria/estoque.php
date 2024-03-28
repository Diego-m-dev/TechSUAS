<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cozinha_comunitaria/style-estoque.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Controle de Estoque</title>
</head>
<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/cozinha_comunitaria/h1-estoque.svg" alt="Titulocomimagem">
        </h1>
    </div>  
    </div>    
    <div class="container">
        <div class="menu"> 
            <nav>
                <div class="btn">
                    <a class="menu-button" onclick="location.href='#';">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    Cadastrar Itens
                    </a>
                </div>
                <div class="btn">
                    <a class="menu-button" onclick="location.href='#';">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                    Buscar Itens
                    </a>
                </div>    
                <div class="btn">
                        <a class="menu-button" onclick="location.href='#';">
                        <span class="material-symbols-outlined">
                        sync_problem
                        </span>
                        Pedidos/Solicitações
                        </a>
                </div>
                <div class="btn">
                        <a class="menu-button" href="/Suas-Tech/controller/back.php">
                        <span class="material-symbols-outlined">
                        keyboard_backspace
                        </span>
                        Voltar ao menu
                        </a>
                </div>
            </nav>
    </div>    
    <script src='../../controller/back.js'></script>
</body>
</html>
