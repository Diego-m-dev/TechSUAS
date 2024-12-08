<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/visitas_pend.css">
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/area_gestor/filtro_geral.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="/TechSUAS/js/gestor.js"></script>

  <title>Carga Horária</title>
</head>
<body>
  <label for="cpf_servidor">CPF:
    <input type="text" name="cpf_servidor" id="cpf_servidor" required/>
  </label>
  <button type="button" onclick="cadastroCargaHoraria()">Cadastrar Horários</button>

  <script>
      $('#cpf_servidor').mask('000.000.000-00')
  </script>

</body>
</html>