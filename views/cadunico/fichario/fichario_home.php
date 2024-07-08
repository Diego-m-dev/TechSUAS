<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>
<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichário</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../../css/cadunico/fichario/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <h3>CADASTROS FAMILIAR</h3>
            <form id="consultaForm">
                <label for="consulta">Consultar Família</label>
                <input type="text" id="consulta" name="consulta">
                <button type="submit">Consultar</button>
            </form>

            <div class="listar_cadastros">
                <table border="1" id="informacaoCadastro">
                    <thead>
                        <tr>
                            <th>COD FAMILIAR</th>
                            <th>RESPONSAVEL FAMILIAR</th>
                            <th>STATUS</th>
                            <th>ULTIMA ATUALIZAÇÃO</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dados preenchidos dinamicamente -->
                    </tbody>
                </table>
                <div id="mensagem">Nenhum dado encontrado</div>
            </div>
        </div>


        <div class="card">
            <h3>HISTORICO DE FORMULARIO</h3>
            <div id="infoFamilia">
                <p><strong>Nome do Responsável:</strong> <span id="nomeResponsavel"></span></p>
                <p><strong>Código Familiar:</strong> <span id="codFamiliar"></span></p>
                
            </div>
            <table border="1" id="dadosCadastro">
                <thead>
                    <tr>
                        <th>Data da Entrevista</th>
                        <th>Tipo de Documento</th>
                        <th>Nome do Arquivo</th>
                        <th>Tamanho do Arquivo</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dados preenchidos dinamicamente -->
                </tbody>
            </table>
            <div id="mensagem">Nenhum dado encontrado</div>
        </div>
    </div>

    <script>
    $(document).ready(function () {

        function consultarPorCodFamiliar(codFamiliar) {
            $.ajax({
                url: '../../../controller/cadunico/fichario/consultar_por_codfamiliar.php',
                type: 'POST',
                data: { codFamiliar: codFamiliar },
                success: function (data) {
                    $("#dadosCadastro tbody").empty().html(data);
                },
                error: function () {
                    $("#mensagem").text("Erro na consulta").show();
                }
            });
        }

        
        $(document).on('click', '.mais-btn', function () {
            var codFamiliar = $(this).data('codfamiliar');
            consultarPorCodFamiliar(codFamiliar);
        });

     
        $("#consultaForm").submit(function (event) {
            event.preventDefault();

            $.ajax({
                url: '../../../controller/cadunico/fichario/request_lista_cadastro.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (data) {
                    $("#informacaoCadastro tbody").empty();
                    if (data.trim() === "Nenhum resultado encontrado") {
                        $("#mensagem").text("Nenhum dado encontrado").show();
                    } else {
                        $("#mensagem").text("").hide();
                        $("#informacaoCadastro tbody").html(data);
                    }
                },
                error: function () {
                    $("#mensagem").text("Erro na consulta").show();
                }
            });
        });
    });
</script>


</body>

</html>