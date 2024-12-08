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

    <link rel="stylesheet" href="/TechSUAS/css/cadunico/area_gestor/gestor.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <script src="/TechSUAS/js/gestor.js"></script>

    <title>Ponto dos Servdores - TechSUAS</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/area_gestor/h1-area_gestor.svg" alt="Título com imagem">
        </h1>

        <div class="bt">
            <button class="menu-button" onclick="folhadeponto()">
              <span></span>
                Folha de Ponto
            </button>
        </div>

        <div class="bt">
            <button class="menu-button" onclick="importeponto()">
              <span></span>
                Importe o ponto
            </button>
        </div>

        <div class="bt">
            <button class="menu-button" onclick="justificativa()">
              <span></span>
                Justificar Falta
            </button>
        </div>

        <div class="bt">
            <button class="menu-button" onclick=voltarMenu()>
                Voltar ao menu
                <span class="material-symbols-outlined">
                    arrow_back
                </span>
            </button>
        </div>

    <form action="/TechSUAS/controller/cadunico/area_gestor/edt_ponto" method="post">

    </form>
<?php
  $conn_1->close();
?>
</body>

</html>