<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
if ($_SESSION['setor'] != "SUPORTE") {
  echo "VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR AQUI!";
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
  <link rel="stylesheet" href="/TechSUAS/css/suporte/style-suporte.css">
  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <title>TechSUAS - Suporte - DDV</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/suporte.js"></script>
</head>

<body>
  <form action="/TechSUAS/suporte/controller/bd" method="post">

  <label>Cidade:</label>
      <select name="cod_ibge_3" required>
        <option value="" disabled selected hidden>Selecione</option>
        <?php

$consultacidade = $conn_1->query("SELECT cod_ibge, municipio FROM municipios");

// Verifica se há resultados na consulta
if ($consultacidade->num_rows > 0) {

    // Loop para criar as opções do select
    while ($city = $consultacidade->fetch_assoc()) {
?>
    <option value="<?php echo $city['cod_ibge']; ?>"><?php echo $city['municipio']; ?></option>
<?php
    }
}
?>
    </select>

    <label>Sistema:</label>
      <select name="sistema" required>
        <option value="" disabled selected hidden>Selecione</option>
        <?php

$consultacidade = $conn_1->query("SELECT name_sistema FROM operadores GROUP BY name_sistema");

// Verifica se há resultados na consulta
if ($consultacidade->num_rows > 0) {

    // Loop para criar as opções do select
    while ($city = $consultacidade->fetch_assoc()) {
?>
    <option value="<?php echo $city['name_sistema']; ?>"><?php echo $city['name_sistema']; ?></option>
<?php
    }
}
?>
    </select>

  <label>Função: </label>
    <select name="funcao" id="funcao" required>
      <option value="" disabled selected hidden>Selecione</option>
      <option value="0">Suporte</option>
      <option value="1">Gestão</option>
      <option value="2">Tecnico(a)</option>
      <option value="3">Outros</option>
    </select>

  <button type="submit">Trocar</button>
  </form>
</body>
</html>