<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/cadunico/fichario/index_fichario.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>
    <title>Fichario</title>
</head>

<body>
    <div class="container">
        <div class="cont-btns">
            <div class="header_cont_buttom">
                <h2> MENU DE OPÇÕES </h2>
            </div>
            <div class="btns">
                <div class="bt">
                    <a type="button" href="/TechSUAS/views/cadunico/fichario/solicita_form.php" class="menu-button" id="menu-button">
                        SOLICITAÇÕES DE FORMULARIOS
                    </a>
                </div>
                
                <div class="bt">
                    <a type="button" href="/TechSUAS/fichario_test/form_fichario" class="menu-button" id="menu-button">
                        <span class="material-symbols-outlined"></span>
                        FICHARIO FISICO
                    </a>
                </div>

                <div class="bt">
                    <a type="button" href="/TechSUAS/views/cadunico/fichario/fichario_home.php" class="menu-button" id="menu-button">
                        <span class="material-symbols-outlined"></span>
                        FICHARIO DIGITAL
                    </a>
                </div>

            </div>
        </div>
        <div class="mural_stats">
            <h2>MURAL DE AVISOS</h2>
        </div>

</body>

</html>