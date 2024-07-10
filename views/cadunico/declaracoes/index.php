<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href=/TechSUAS/css/cadunico/declaracoes/styledec.css>
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    

    <title>Declarações - TechSUAS</title>
</head>

<body>
<div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/cadunico/declaracoes/h1-declaração.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <nav>
            <!--DECLARAÇÃO PARA INFORMAR SE A PESSOA É INSCRITA NO CADASTRO ÚNICO E/OU TEM BENEFÍCIO-->
            <a type="button" id="btn_dec_cad">
                <i class="material-symbols-outlined">assignment_add</i> Declaração Cadastro Único
            </a>

            <!--ENCAMINHAMENTO ELABORAÇÃO DE INFORMATIVO PARA ENCAMINHAR O USUÁRIO PARA OUTROS SERVIÇOS-->
            <a type="button" id="btn_encamnhamento">
                <i class="material-symbols-outlined">export_notes</i> Encaminhamentos
            </a>

            <!--DOCUMENTO PARA FIRMAR O DESLIGAMENTO VOLUNTÁRIO-->
            <a type="button" id="btn_des_vol">
                <i class="material-symbols-outlined">contract_delete</i> Desligamento Voluntário
            </a>

            <!--DOCUMENTO PARA CAIXA REALIZAR UM PAGAMENTO CASO A TROCA DE RF NÃO TENHA SIDO REFLETIDO NO SIBEC OU NOS SISTEMAS CAIXA-->
            <a type="button" id="btn_troca">
                <i class="material-symbols-outlined">quick_reference</i> Troca de RF - C.E.F.
            </a>

            <a href="/TechSUAS/config/back"><i class="fas fa-arrow-left"></i>Voltar ao menu</a>
        </nav>
    </div>
</body>

</html>