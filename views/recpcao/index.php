<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
if ($_SESSION['funcao'] != '0') {
    echo '<script>window.history.back()</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/recepcao/style.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>
    <title>Recpção</title>
</head>

<body>
    <div class="container">
        <div class="cont-btns">
            <div class="header_cont_buttom">
                <h2> MENU DE OPÇÕES </h2>
            </div>
            <div class="btns">
                <div class="bt">
                    <button type="button" class="modal-trigger" id="menu-button">
                        <span class="material-symbols-outlined">quick_reference_all</span>
                        SOLICITAR FORMULARIOS
                    </button>
                </div>

                <div class="bt">
                    <button type="button" class="menu-button" id="menu-button">
                        <span class="material-symbols-outlined">group</span>
                        SISTEMA DE ATENDIMENTO
                    </button>
                </div>

                <div class="bt">
                    <button type="button" class="menu-button" id="menu-button">
                        <span class="material-symbols-outlined">group</span>
                        CADASTRO DE USUARIOS
                    </button>
                </div>

            </div>
        </div>
        <div class="mural_stats">
            <h2>MURAL DE AVISOS</h2>
        </div>





        <!-- Modal Structure -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalText"></h2> <!-- TÍTULO DO BOTÃO AUTOMÁTICO -->
                <form id="myForm" action="/TechSUAS/controller/cadunico/fichario/inserir.php" method="POST">
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" required>
                    </div>
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome">
                    </div>
                    <div class="form-group">
                        <label for="cod">Código Familiar</label>
                        <input type="text" name="cod" id="cod">
                    </div>
                    <button type="submit" class="submit-btn">Enviar</button>
                    <div id="loading" style="display:none;">Carregando...</div>

                </form>
            </div>
        </div>



        <script>
            $(document).ready(function () {
                var modal = document.getElementById("myModal");
                var span = document.getElementsByClassName("close")[0];
                var modalTriggers = document.querySelectorAll(".modal-trigger");

                modalTriggers.forEach(function (trigger) {
                    trigger.addEventListener("click", function (event) {
                        event.preventDefault();
                        // Obtém o texto do botão ignorando os filhos (ícones)
                        var buttonText = this.innerText.trim().split("\n").pop().trim();
                        document.getElementById("modalText").innerText = buttonText;
                        modal.style.display = "block";
                    });
                });

                span.onclick = function () {
                    modal.style.display = "none";
                }

                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }

                // Adiciona o evento blur ao campo CPF
                $("#cpf").on("blur", function () {
                    validarCPF(this);
                });

                $("#cpfForm").on("submit", function (event) {
                    var cpfInput = document.getElementById("cpf");
                    if (!validarCPF(cpfInput)) {
                        event.preventDefault(); // Impede o envio do formulário se o CPF for inválido
                    }
                });
            });

            function validarCPF(el) {
                if (!_cpf(el.value)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'CPF Inválido',
                        text: 'Por favor, insira um CPF válido!',
                        confirmButtonText: 'OK'
                    });

                    // Apaga o valor
                    el.value = "";
                    return false;
                }
                return true;
            }
            document.getElementById('cpf').addEventListener('blur', function () {
                const cpf = this.value.replace(/[^\d]/g, ''); // Remove caracteres não numéricos

                if (cpf) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/TechSUAS/controller/cadunico/fichario/buscar.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    // Mostra o elemento de carregamento
                    document.getElementById('loading').style.display = 'block';

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            // Esconde o elemento de carregamento
                            document.getElementById('loading').style.display = 'none';

                            if (xhr.status === 200) {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    document.getElementById('nome').value = response.nome;
                                    document.getElementById('cod').value = response.cod_fam_familia;
                                } else {
                                    alert('CPF ' + cpf + ' não encontrado');
                                }
                            } else {
                                alert('Erro ao processar a requisição.');
                            }
                        }
                    };
                    xhr.send('cpf=' + cpf);
                }
            });



        </script>


</body>

</html>