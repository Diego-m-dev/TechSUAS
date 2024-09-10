<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Verifica permissões de acesso
if ($_SESSION['funcao'] != '0' || $_SESSION['name_sistema'] != "RECEPCAO") {
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
    <link rel="icon" type="image/png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>
    <title>Recepção</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/geral/h1-recepcao.svg" alt="Título com imagem">
        </h1>
    </div>
    <div class="container">
        <div class="cont-btns">
            <div class="header_cont_buttom">
                <h2> MENU DE OPÇÕES </h2>
            </div>
            <div class="btns">
                <div class="bt">
                    <button type="button" class="modal-trigger" id="menu-button">
                        <span class="material-symbols-outlined">quick_reference_all</span>
                        SOLICITAR FORMULÁRIOS
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
                        CADASTRO DE USUÁRIOS
                    </button>
                </div>

            </div>
        </div>
        <div class="mural_stats">
            <h2>MURAL DE AVISOS</h2>

            <div class="cont-solict">
                <div class="solict">
                    <h3>SOLICITAÇÕES PENDETES</h3>
                    <table id="dataTable1">
                        <thead>
                            <tr>
                                <th>CPF</th>
                                <th>NOME</th>
                                <th>TIPO</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Os dados serão preenchidos via AJAX -->
                        </tbody>
                    </table>
                </div>

                <div class="solict">
                    <h3>SOLICITAÇÕES PRONTAS</h3>
                    <table id="dataTable">
                        <thead>
                            <tr>
                                <th>CPF</th>
                                <th>NOME</th>
                                <th>TIPO</th>
                                <th>STATUS</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Os dados serão preenchidos via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalText"></h2> <!-- TÍTULO DO BOTÃO AUTOMÁTICO -->
                <form id="myForm" method="POST">
                    <div class="grid-container">
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" required>
                        </div>
                        <div class="form-group">
                            <label for="cod">Código Familiar</label>
                            <input type="text" name="cod" id="cod">
                        </div>
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="text" name="nis" id="nis">
                        </div>
                        <div class="form-group-wide">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome">
                        </div>
                        <div class="form-group">
                            <label for="tipo">SOLICITAÇÃO</label>
                            <select name="tipo" id="tipo">
                                <option value="1">NIS</option>
                                <option value="2">DECLARAÇÃO CADÚNICO</option>
                                <option value="3">ENTREVISTA</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="submitBtn" class="submit-btn">Enviar</button>
                    <div id="loading" style="display:none;">Carregando...</div>
                </form>
            </div>
        </div>

        <!-- FOOTER DA PAGINA -->
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/footer.php'; ?>

        <div class="drop-all">
            <div class="menu-drop">
                <button class="logout" type="button" name="drop">
                    <span class="material-symbols-outlined">settings</span>
                </button>
                <div class="drop-content">
                    <a title="Sair" href="/TechSUAS/config/logout">
                        <span title="Sair" class="material-symbols-outlined">logout</span>
                    </a>
                    <a title="Alterar Usuário" href="/TechSUAS/views/geral/conta">
                        <span class="material-symbols-outlined">manage_accounts</span>
                    </a>
                    <?php if ($_SESSION['funcao'] == '0') { ?>
                        <a title="Suporte" href="/TechSUAS/config/back">
                            <span class="material-symbols-outlined">rule_settings</span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <script src="/TechSUAS/js/request_forms.js"></script>
</body>

</html>
<?php
$conn_1->close();