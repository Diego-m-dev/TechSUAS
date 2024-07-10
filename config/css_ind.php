<?php
if ($_SESSION['municipio'] == "9876543") {
  ?>
  <!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suporte Cadastro Único - TechSUAS</title>
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_index_cad.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
</head>
  <?php
} elseif ($_SESSION['municipio'] == "2613008") {
  ?>
  <!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SBU Cadastro Único - TechSUAS</title>
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_index_cad.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
</head>
  <?php
}
?>