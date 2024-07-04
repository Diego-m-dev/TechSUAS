<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
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
                <p id="modalText"></p><!-- TITULO DO BOTÃO AUTOMATICO -->
                <form action="/TechSUAS/controller/cadunico/fichario/inserir.php" method="POST">
                    <label>CPF</label>
                    <input type="text" name="cpf">
                    <label>NOME</label>
                    <input type="text" name="nome">
                    <label>CODIGO FAMILIAR</label>
                    <input type="text" name="cod" id="">
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>

        <script>
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
        </script>


</body>

</html>