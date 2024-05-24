<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/TechSUAS/css/cadunico/visitas/style-registrar.css">
    <link rel="website icon type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Registrar visitas</title>
</head>

<body>
    <h1 class="img">
        <img src="/TechSUAS/img/cadunico/visitas/visitash1.svg">
    </h1>
    <div class="container">
        <form method="post" action="/TechSUAS/controller/cadunico/parecer/processo.php">
            <div class="codfamiliar">
                <label>CÓDIGO FAMILIAR: </label>
                <input type="text" name="codigo_familiar" placeholder="Digite o CÓDIGO FAMILIAR." required>
            </div>
            <div class="data">
                <label>DATA DA VISITA: </label>
                <input type="date" id="data_visita" name="data_visita" required>
            </div>
            <div class="cxacao">
                <label>AÇÃO DA VISITA:
                <select name="acao_visita" required>
                    <option value="" disabled selected hidden>Selecione a ação da visita.</option>
                    <option value="1">ATUALIZAÇÃO REALIZADA</option>
                    <option value="5">ATUALIZAÇÃO NÃO REALIZADA</option>
                    <option value="2">NÃO LOCALIZADO</option>
                    <option value="3">FALECIMENTO DO RESPONSÁVEL FAMILIAR</option>
                    <option value="4">A FAMÍLIA RECUSOU ATUALIZAR</option>
                </select>
                </label>
            </div>
            <div class="parecer">
                <div class="tituloparecer">
                    <label for="message" class="tituloparecer">PARECER TÉCNICO:</label>
                </div>
                <textarea rows="7" name="parecer" placeholder="Faça um breve resumo de como foi a visita."></textarea>
            </div>
            <div class="btn">
                <button type="submit">Enviar</button>
                <a href="visitas.php">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            </div>
        </form>

    </div>
</body>
</html>