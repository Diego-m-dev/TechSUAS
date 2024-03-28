<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cozinha_comunitaria/style-menu.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>TechSUAS - Cozinha Comunitária</title>
</head>
<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/cozinha_comunitaria/h1-cozinha.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="apelido">    
        <h3>Bem-vindo (a)
            <?php echo $apelido; ?>.
        </h3> 
    </div>    
    <div class="container">
        <div class="menu"> 
            <nav>
                <!--<div class="pagina1">
                    <a class="menu-button" onclick="location.href='cadastro_operadores.php';">
                    <span class="material-symbols-outlined">
                        person_add
                    </span>
                    Cadastrar Operadores
                    </a>
                </div> -->
                <div class="pagina2">
                    <a class="menu-button" onclick="location.href='/TechSUAS/views/cozinha_comunitaria/fluxo_diario';">
                    <span class="material-symbols-outlined">
                        patient_list
                    </span>
                    Fluxo Diário
                    </a>
                </div>    
                <div class="pagina3">
                        <a class="menu-button" onclick="location.href='/TechSUAS/views/cozinha_comunitaria/estoque';">
                        <span class="material-symbols-outlined">
                            inventory
                        </span>
                        Controle de Estoque
                        </a>
                </div>
            </nav>
        </div>  
        <footer><img src="/TechSUAS/img/cozinha_comunitaria/footer-cozinha.svg" alt=""></footer>
    <div class="drop-all">
        <div class="menu-drop">
            <button class="logout" type="button" name="drop">
            <span class="material-symbols-outlined">
            Settings
            </span> 
        <div class="drop-content">
            <a title="Sair" href='TechSUAS/config/logout';>
            <span title="Sair" class="material-symbols-outlined">logout</span>    
            </a>
            <a title="Alterar Usuário" href='views/conta.php';>
            <span  class="material-symbols-outlined">manage_accounts</span>       
            </a>
            <?php
    if($nivel == 'suport'){
        ?> <a title="Suporte" href='/TechSUAS/suporte/';>
        <span  class="material-symbols-outlined">rule_settings</span>       
        </a> <?php
        exit();
    }
    ?>     
        </div>
    </div>
</body>
</html>
