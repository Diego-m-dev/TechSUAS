<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/style-painel_entrevistador.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Painel entrevistador</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/h1-painel_entrevistador.svg" alt="Título com imagem">
        </h1>
    </div>

<div class="container">
    <form method="post" action="/TechSUAS/controller/cadunico/salvar_dados_painel" enctype="multipart/form-data">
        <!--FORMULARIO PARA IDENTIFICAÇÃO DA ENTREVISTA-->
        <label for="">
            <div class="bloc1">
                <div>
                    Código familiar:
                    <input type="text" name="cod_fam" id="codfamiliar" onblur="buscarDadosFamily()" required />
                </div>

                <span id="codfamiliar_print"></span>
                <span id="data_entrevista"></span>
                <span id="familia_show"></span>

                <div id="cont_data">
                    <label for="data_entrevista">Data da Entrevista:</label>
                    <input type="date" id="data_entrevista" name="data_entrevista" required>
                    <button type="button" onclick="dataHoje()">Hoje</button>
                </div>
            </div>

            <span id="data_entre"></span>

            Selecione a situação do benefício: 
            <div>
                <label class="urg">
                <input type="checkbox" name="fimRestricao" />   
                <span class="checkmark"></span>
                <span>Fim de restrinção especifica</span>
            </div>

            <div>
                <label class="urg">
                <input type="checkbox" name="fimRestricao" />   
                <span class="checkmark"></span>
                <input type="checkbox" name="bloc" />
                <span>Bloqueado</span>
            </div>

            <div>
                <label class="urg">
                <input type="checkbox" name="fimRestricao" />   
                <span class="checkmark"></span>
                <input type="checkbox" name="Canc" />
                <span>Cancelado</span>
            </div>
            <div>
                <label class="urg">
                <input type="checkbox" name="fimRestricao" />   
                <span class="checkmark"></span>
                <input type="checkbox" name="s_benef" />
                <span>Não tem benefício</span>
            </div>      

            <div>
                    Observação:<br>
                    <textarea name="resumo" id="resumo" placeholder="Se houve alguma observação durante a entrevista registre-a."></textarea>
                </label><br><input type="hidden" id="tipo_documento" value=".pdf">
            </div>

        <!--FORMULÁRIO PARA UPLOAD DOS ARQUIVOS-->
        <label for="formulario_upload">
            Tipo de Documento:
            <br>
            <select name="tipo_documento[]" id="tipo_documento" multiple required>
                <option value="" disabled hidden>Selecione o(s) tipo(s)</option>
                <option value="Cadastro">Cadastro</option>
                <option value="Atualização">Atualização</option>
                <option value="Assinatura">Assinatura</option>
                <option value="Fichas exclusão">Fichas exclusão</option>
                <option value="Relatórios">Relatórios</option>
                <option value="Parecer visitas">Parecer visitas</option>
                <option value="Documento externo">Documento externo</option>
            </select>
            <br>
            Arquivo:
            <input type="file" id="arquivo" name="arquivo" accept=".pdf" required>
            <br>
        </label>
        <button type="submit">Cadastrar</button>
    </form>

    <!--BOTÕES PARA FÁCIL ACESSO AOS FORMULÁRIO E DECLARAÇÕES-->
    <label for="">Botões de fácel acesso:</label><br>
    <button type="button" id="btn_residencia">Declaração de Residência</button>
    <button type="button" id="btn_dec_renda">Declaração de Renda</button>
    <button type="button" id="btn_fc_familia">Exclusão de Familia</button>
    <button type="button" id="btn_fc_pessoa">Exclusão de Pessoa</button><br>
    <button type="button" id="btn_dec_cad">Declaração Cadastro Único</button>
    <button type="button" id="btn_encamnhamento">Encaminhamentos</button>
    <a href="/TechSUAS/config/back"><i class="fas fa-arrow-left"></i>Voltar ao menu</a>
</div>
</body>

</html>