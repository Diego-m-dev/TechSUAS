<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/fichario/style_conferir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Cadastrar fichario</title>

</head>

<body>
    <h1>Cadastrar Fichario</h1>

    <form method="POST">

      <label for="">Armário:</label>
        <input type="number" name="arm" required/>
      <label for="">Gaveta:</label>
        <input type="number" name="gav" required/>
      <label for="">Pasta:</label>
        <input type="number" name="pas" required/>

    <button type="submit">Salvar</button>

    </form>


<?php

if (isset($_POST['arm']) && isset($_POST['gav']) && isset($_POST['pas'])) {
  $arm = str_pad(($conn->real_escape_string($_POST['arm'])), 2,'0',STR_PAD_LEFT);
  $gav = str_pad(($conn->real_escape_string($_POST['gav'])), 2,'0',STR_PAD_LEFT);
  $pasta = $conn->real_escape_string($_POST['pas']);

  $sql_fichario = 
}
?>
</body>
</html>