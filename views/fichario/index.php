<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
if ($_SESSION['funcao'] != '0') {
    echo '<script>window.history.back()</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/recepcao/style.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <title>Fichário - TechSUAS</title>
</head>
<body>
    <div class="container">
        <div class="cont-btns">
            <div class="header_cont_buttom">
                <h2> MENU DE OPÇÕES </h2>
            </div>
            <div class="btns">
                <div class="bt">
                    <button type="button" class="menu-button" id="btn_benef">
                        <span class="material-symbols-outlined">quick_reference_all</span> 
                        CONSULTAR FORMULARIOS
                    </button>
                </div>

                <div class="bt">
                    <button type="button" class="menu-button" id="btn_entrevistadores">
                        <span class="material-symbols-outlined">group</span>
                        CADASTRAR ARQUIVO
                    </button>
                </div>

                <div class="bt">
                    <button type="button" class="menu-button" id="btn_entrevistadores">
                        <span class="material-symbols-outlined">group</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- <div class="mural_stats">
            <h2>MURAL DE AVISOS</h2>
        </div> -->
</body>
