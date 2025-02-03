<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Formulário Concessão - TechSUAS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_gerar_form.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>
    <script src="/TechSUAS/js/concessao.js"></script>
    <script src=""></script>
</head> 

<body>

<div id="form">
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/concessao/h1-relatorio.svg" alt="Titulocomimagem">
        </h1>
    </div>

      <label>CPF DO RESPONSÁVEL:</label>
        <input type="text" name="cpf" id="cpf" maxlength="14" required><br>
            Responsável: <span id="nome_resp"></span><br>
                <span id="select_parentesco"></span><br>
      <label>CPF DO BENEFICIÁRIO:</label>
        <input type="text" name="nis" id="nis" maxlength="14" required><br>
            Beneficiário: <span id="nome_benef"></span><br> <div id="status_ben"></div>

        <a href="/TechSUAS/config/back" style="margin-left: 50px;">
            <i class="fas fa-arrow-left"></i> Voltar ao menu
        </a>

      <button type="button" id="btn_avancar" onclick="btn_avancar()">AVANÇAR</button>
</div>
  <div id="conteudo"></div>
</body>
</html>