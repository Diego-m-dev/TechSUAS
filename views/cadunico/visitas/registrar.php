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
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <title>Registrar visitas</title>
</head>

<body>
    <h1 class="img">
        <img src="/TechSUAS/img/cadunico/visitas/visitash1.svg">
    </h1>
    <div class="container">
        <!-- Apresenta Nome da tabela TUDO e se já ouve registro de visita -->
        <div id="caixaRolagem">
            <label id="conteudoLabel" for="">
                <span id="nome"></span>
                <h4><span id="titulo_tela"></span></h4>
                <div id="data_visita"></div>
            </label>
        </div>

    <!--Formulário para registrar a visita caso não haja-->
        <form method="post" action="/TechSUAS/controller/cadunico/parecer/processo">
            <div class="codfamiliar">
                <label>CÓDIGO FAMILIAR: </label>
                <input type="text" id="codfamiliar" name="codigo_familiar" onblur="consultarFamilia()" placeholder="Digite o CÓDIGO FAMILIAR." required>
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
                <textarea rows="7" name="parecer" placeholder="Faça um breve resumo de como foi a visita." required></textarea>
            </div>
            <div class="btn">
                <button type="submit">Enviar</button>
                <a href="visitas">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </form>
    </div>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

</body>
</html>