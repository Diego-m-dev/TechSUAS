<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/TechSUAS/css/suporte/style-suporte.css">
        <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <title>TechSUAS - Suporte - DDV</title>
</head>

<body>
        <div class="img">
                <h1 class="titulo-com-imagem">
                        <img class="titulo-com-imagem" src="/TechSUAS/img/suporte/h1-ddv.png" alt="Titulocomimagem">
                </h1>
        </div>
        <div class="container">
                <div class="menu">
                        <div class="bloco1">
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='#';">
                                                Sistema de Atendimento
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='../cadunico/painel-adm/adm-view';">
                                                Cadastro único
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='/TechSUAS/views/concessao/index';">
                                                Concessão
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='../suas/views/adm/menu_adm';">
                                                Administrativo
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='../cozinha_comunitaria/menu';">
                                                Cozinha Comunitária
                                        </a>
                                </div>

                        </div>
                        <div class="bloco2">
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='total_peixe';">
                                                Controle Peixe
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='../cras/views/menu-cras-am';">
                                                CRAS Antonio Matias
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='../cras/views/menu-cras-st';">
                                                CRAS Santo Afonso
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='../creas/views/menu-creas';">
                                                CREAS Gildo Soares
                                        </a>
                                </div>
                        </div>
                        <div class="bloco2">
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='setores';">
                                                <span class="material-symbols-outlined">
                                                        domain_add
                                                </span>
                                                Cadastrar Setores
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='/Suas-Tech/cadunico/painel-adm/cadastro_user';">
                                                <span class="material-symbols-outlined">
                                                        person_add
                                                </span>
                                                Cadastrar Operadores
                                        </a>
                                </div>
                                <div class="btn">
                                        <a class="menu-button" onclick="location.href='/Suas-Tech/suas/views/atualizar_tabela';">
                                                <span class="material-symbols-outlined">
                                                        library_add
                                                </span>
                                                Importar Banco de Dados
                                        </a>
                                </div>
                        </div>
                </div>
        </div>
        <div class="drop-all">
                <div class="menu-drop">
                        <button class="logout" type="button" name="drop">
                                <span class="material-symbols-outlined">
                                        Settings
                                </span>
                                <div class="drop-content">
                                        <a title="Sair" href='/TechSUAS/config/logout.php' ;>
                                                <span title="Sair" class="material-symbols-outlined">logout</span>
                                        </a>
                                        <a title="Alterar Usuário" href='/TechSUAS/controller/suporte/conta.php' ;>
                                                <span class="material-symbols-outlined">manage_accounts</span>
                                        </a>
                                </div>
                </div>
</body>

</html>