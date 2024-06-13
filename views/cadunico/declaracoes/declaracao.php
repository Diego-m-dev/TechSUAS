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

    <title>Declarações</title>
</head>
<body>
<div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único - </span><?php echo $data_cabecalho; ?>
        </div>
    </div>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/cadunico/declaracoes/h1-declaração.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <!--INICIO DA DECLARAÇÃO PARA PREFEITURA-->
    <div class="container">
        <div class="decprefeitura">
            <form method="post" action="declaracao_conferir">
                <h2>Declaração Para Contratação</h2>
                <select name="buscar_dados" required>
                    <option value="cpf_dec">CPF:</option>
                    <option value="nis_dec">NIS:</option>
                </select>
                <input type="text" name="valorescolhido" placeholder="Digite aqui:" required>
                <button type="submit">BUSCAR</button>
            </form>
            <div class=lin1>
                <div class="linha"></div>
            </div>
        </div>
            <!--INICIO DA DECLARAÇÃO PARA ENCAMINHAMENTO-->
        <div class="encaminhamento">
            <form method="post" action="/TechSUAS/controller/cadunico/declaracao/encaminhamento">
                <h2>Encaminhamento</h2>
                <select name="buscar_dados" required>
                    <option value="cpf_dec">CPF:</option>
                    <option value="nis_dec">NIS:</option>
                </select>
                <input type="text" name="valorescolhido" placeholder="Digite aqui:" required>

                <label>Encaminhar para: </label>
                <select id="setor" name="setor" required onchange="mostrarCampoTexto()">
        <option value="" disabled selected hidden>Selecione</option>
        <?php

$consultaSetores = $conn->query("SELECT instituicao, nome_instit FROM setores");

// Verifica se há resultados na consulta
if ($consultaSetores->num_rows > 0) {

    // Loop para criar as opções do select
    while ($setor = $consultaSetores->fetch_assoc()) {
        echo '<option value="' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '">' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '</option>';
    }
    ?>
    <option value="3">OUTROS</option>
    <?php
}
?>
    </select>

    <input type="text" name="funcao_outros" id="funcao_outros" style="display: none;" placeholder="Digite a função">

                <label>Texto: </label>
                <textarea id="" name="texto" required  oninput="ajustarTextarea(this)"></textarea>
                <button type="submit">BUSCAR</button>
            </form>
            <div class=lin1>
                <div class="linha"></div>
        </div>
        <!--INICIO DA DECLARAÇÃO PARA DESLIGAMENTO VOLUNTÁRIO-->
        <div class="desligamento">
            <form method="post" action="/TechSUAS/controller/cadunico/declaracao/desligamento_voluntario">
                <h2>Declaração Desligamento Voluntário</h2>
                <label>NIS:</label>
                <input type="text" name="nis_dec" placeholder="Digite aqui:" required>
                <button type="submit">BUSCAR</button>
            </form>
            <div class=lin1>
                <div class="linha"></div>
        </div>
                <a href="/TechSUAS/config/back">
                    <i class="fas fa-arrow-left"></i> Voltar ao menu
                </a>
    </div>
<script>
    function ajustarTextarea(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
    }

    function mostrarCampoTexto() {
        var select = document.getElementById("setor");
        var campoTexto = document.getElementById("funcao_outros");

        if (select.value == "3") {
            // Se a opção 'Outros' for selecionada, mostra o campo de texto
            campoTexto.style.display = "block";

        } else {
            // Caso contrário, oculta o campo de texto
            campoTexto.style.display = "none";
        }
    }
</script>
</body>

</html>