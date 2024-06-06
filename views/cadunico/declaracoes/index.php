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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Declarações</title>
</head>
<body>
    <h1>DECLARAÇÕES</h1>
    <!--DECLARAÇÃO PARA INFORMAR SE A PESSOA É INSCRITA NO CADASTRO ÚNICO E/OU TEM BENEFÍCIO-->
    <a type="button" id="btn_dec_cad">
        <i class="fas fa-home icon"></i> Declaração Cadastro Único
    </a>

    <!--ENCAMINHAMENTO ELABORAÇÃO DE INFORMATIVO PARA ENCAMINHAR O USUÁRIO PARA OUTROS SERVIÇOS-->
    <a type="button" id="btn_encamnhamento">
        <i class="fas fa-home icon"></i> Encaminhamentos
    </a>

    <!--DOCUMENTO PARA FIRMAR O DESLIGAMENTO VOLUNTÁRIO-->
    <a type="button" id="btn_des_vol">
        <i class="fas fa-home icon"></i> Desligamento Voluntário
    </a>

    <!--DOCUMENTO PARA CAIXA REALIZAR UM PAGAMENTO CASO A TROCA DE RF NÃO TENHA SIDO REFLETIDO NO SIBEC OU NOS SISTEMAS CAIXA-->
    <a type="button" id="btn_troca">
        <i class="fas fa-home icon"></i> Troca de RF - C.E.F.
    </a>


</body>    
</html>