<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulários - TechSUAS</title>
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/menu_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png" >
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <header>
    <h1 class="titulo-com-imagem">
        <img src="/TechSUAS/img/cadunico/forms/h1-formularios.svg" alt="Titulocomimagem">
    </h1>
  </header>
  <nav>
    <a type="button" id="btn_residencia">
      <i class="fas fa-home icon"></i> Termo de Declaração de Residência
    </a>

    <a type="button" id="btn_dec_renda">
      <i class="fas fa-file-invoice-dollar icon"></i> Termo de Declaração de Renda
    </a>

    <a type="button" id="btn_fc_familia">
      <i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Familia
    </a>

    <a type="button" id="btn_fc_pessoa">
      <i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Pessoa
    </a>

    <a href="/TechSUAS/config/back">
      <i class="fas fa-arrow-left"></i> Voltar ao menu
    </a>
  </nav>  
  <script src="/TechSUAS/js/cadastro_unico.js"></script>
  <script src="/TechSUAS/js/cpfvalid.js"></script>
</body>
</html>