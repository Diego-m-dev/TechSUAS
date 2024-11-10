<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichário Digital - TechSUAS</title>

    <link rel="stylesheet" href="/TechSUAS/css/fichario_dig/style.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-9yFkgZODpjftI3OUb8zH9FvyJfcd8jrZG1wQ0Ww4PovU4DwHms1tBhJhbAB8WdcWb6n7B8g/uJc1NGIc8J02+w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="/TechSUAS/js/entrevistadores.js"></script>

</head>
<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/fichario/h1-fichario_digital.svg"
                alt="Título com imagem">
        </h1>
    </div>
    <div class="container">
        <div class="card">
            <h3>CADASTROS NA BASE DE DADOS</h3>
            <form id="consultaForm">
                <label for="consulta">Consultar Família</label>
                <input type="text" id="consulta" name="consulta">
                <button type="submit">Consultar</button>
                <a href="./index"><i class="fas fa-arrow-left"></i>Voltar</a>
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
            </div>
        </div>


        <div class="card">
            <h3>HISTORICO DE FORMULARIO</h3>
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
        </div>
    </div>

    <script>
        $(document).ready(function () {

            function consultarPorCodFamiliar(codFamiliar) {
                $.ajax({
                    url: '/TechSUAS/controller/fichario_dig/consultar_por_codfamiliar.php',
                    type: 'POST',
                    data: {
                        codFamiliar: codFamiliar
                    },
                    success: function (data) {
                        $("#dadosCadastro tbody").empty().html(data);
                        $("#infoFamilia").show();  // Certifique-se de mostrar o histórico
                        $("#dadosCadastro").show();  // Certifique-se de mostrar a tabela de histórico
                        $("#mensagem").hide();
                    },
                    error: function () {
                        $("#mensagem").text("Erro na consulta do histórico").show();
                    }
                });
            }

            $("#consultaForm").submit(function (event) {
                event.preventDefault();

                $.ajax({
                    url: '/TechSUAS/controller/fichario_dig/request_lista_cadastro.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (data) {
                        $("#informacaoCadastro tbody").empty();
                        if (data.trim() === "Nenhum resultado encontrado") {
                            $("#mensagem").text("Nenhum dado encontrado").show();
                            $("#infoFamilia").hide();  // Esconde o histórico se nenhum dado for encontrado
                            $("#dadosCadastro").hide();  // Esconde a tabela de histórico se nenhum dado for encontrado

                            Swal.fire({
                                title: 'Código não encontrado na base',
                                text: 'Deseja informar a inclusão?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Sim',
                                cancelButtonText: 'Não',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: 'Informar Novo Registro',
                                        html: `
                                <form id="inclusaoForm">
                                    <label for="codFamiliar">Código Familiar</label>
                                    <input type="text" id="codFamiliar" name="cod_fam" class="swal2-input" value="${$("#consulta").val()}" readonly>
                                    <label for="dataAtualizacao">Data de Atualização</label>
                                    <input type="text" id="dataAtualizacao" name="data_entrevista" class="swal2-input" placeholder="DD/MM/AAAA">
                                    <label for="nomeResponsavel">Nome do Responsável Familiar</label>
                                    <input type="text" id="nomeResponsavel" name="nome_pess" class="swal2-input" placeholder="Nome do Responsável">
                                </form>
                            `,
                                        focusConfirm: false,
                                        preConfirm: () => {
                                            const form = Swal.getPopup().querySelector('#inclusaoForm');
                                            const formData = new FormData(form);
                                            return fetch('/TechSUAS/controller/fichario_dig/incluir_novo_registro.php', {
                                                method: 'POST',
                                                body: formData
                                            }).then(response => response.json()).then(data => {
                                                if (data.success) {
                                                    Swal.fire('Inclusão realizada!', data.message, 'success');
                                                } else {
                                                    Swal.fire('Erro!', data.message, 'error');
                                                }
                                            }).catch(() => {
                                                Swal.fire('Erro!', 'Erro na inclusão do registro.', 'error');
                                            });
                                        }
                                    });
                                }
                            });
                        } else {
                            $("#mensagem").text("").hide();
                            $("#informacaoCadastro tbody").html(data);

                            // Assumindo que o primeiro cod_familiar encontrado será utilizado para consulta de histórico
                            var firstCodFamiliar = $("#informacaoCadastro tbody tr:first-child").find(".mais-btn").data('codfamiliar');

                            if (firstCodFamiliar) {
                                consultarPorCodFamiliar(firstCodFamiliar);
                            }
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