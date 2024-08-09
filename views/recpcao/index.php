<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Verifica permissões de acesso
if ($_SESSION['funcao'] != '0' && $_SESSION['name_sistema'] != "RECEPCAO") {
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

            <table>
                <thead>
                    <tr>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Código Familiar</th>
                        <th>NIS</th>
                        <th>TIPO</th>
                        <th>STATUS</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta SQL para selecionar apenas registros com status "feito"
                    $sql = "SELECT * FROM solicita WHERE status = 'feito' LIMIT 5";
                    $result = $conn->query($sql);

                    // Verifica se há registros retornados
                    if ($result && $result->num_rows > 0) {
                        // Loop através dos resultados e exiba cada registro em uma linha da tabela
                        while ($row = $result->fetch_assoc()) {
                            $tipo = '';
                            if ($row['tipo'] == 1) {
                                $tipo = "NIS";
                            } elseif ($row['tipo'] == 3) {
                                $tipo = "ENTREVISTA";
                            } elseif ($row['tipo'] == 2) {
                                $tipo = "DECLARAÇÃO CAD";
                            }

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['cpf']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['cod_fam']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nis']) . "</td>";
                            echo "<td>" . htmlspecialchars($tipo) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td><i class='fas fa-check-circle check-icon' data-id='" . htmlspecialchars($row['id']) . "'></i></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Nenhum registro encontrado com status feito.</td></tr>";
                    }

                    // Feche a conexão com o banco de dados
                    $conn->close();
                    ?>
                </tbody>
            </table>

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
                                <option value="2">DECLARAÇÃO CADUNICO</option>
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

        <script>
            $(document).ready(function () {
                var modal = document.getElementById("myModal");
                var span = document.getElementsByClassName("close")[0];
                var modalTriggers = document.querySelectorAll(".modal-trigger");

                // Abre o modal ao clicar nos gatilhos
                modalTriggers.forEach(function (trigger) {
                    trigger.addEventListener("click", function (event) {
                        event.preventDefault();
                        // Obtém o texto do botão ignorando os filhos (ícones)
                        var buttonText = this.innerText.trim().split("\n").pop().trim();
                        document.getElementById("modalText").innerText = buttonText;
                        modal.style.display = "block";
                    });
                });

                // Fecha o modal ao clicar no botão de fechar
                span.onclick = function () {
                    modal.style.display = "none";
                };

                // Fecha o modal ao clicar fora dele
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                };

                // Aplica máscara para CPF
                $('#cpf').mask('000.000.000-00', { reverse: false });

                // Aplica máscara para Código Familiar (cod)
                $('#cod').mask('000000000-00', { reverse: false });

                // Aplica máscara para NIS
                $('#nis').mask('0000000000-0', { reverse: false });

                // Valida o CPF ao sair do campo
                $("#cpf").on("blur", function () {
                    validarCPF(this);
                });

                // Requisição AJAX para buscar dados do CPF
                document.getElementById('cpf').addEventListener('blur', function () {
                    const cpf = this.value.replace(/[^\d]/g, ''); // Remove caracteres não numéricos

                    if (cpf) {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '/TechSUAS/controller/recepcao/buscar.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        // Mostra o elemento de carregamento
                        document.getElementById('loading').style.display = 'block';

                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4) {
                                // Esconde o elemento de carregamento após a resposta
                                document.getElementById('loading').style.display = 'none';

                                if (xhr.status === 200) {
                                    const response = JSON.parse(xhr.responseText);
                                    if (response.success) {
                                        document.getElementById('nome').value = response.nome;
                                        document.getElementById('cod').value = response.cod_fam_familia;
                                        document.getElementById('nis').value = response.nis;
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Erro',
                                            text: 'CPF não encontrado!',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro',
                                        text: 'Erro na requisição. Por favor, tente novamente mais tarde!',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        };

                        // Envia o CPF para o servidor
                        xhr.send('cpf=' + cpf);
                    }
                });

                // Impede o envio do formulário se o CPF for inválido
                $("#submitBtn").on("click", function (event) {
                    var cpfInput = document.getElementById("cpf");
                    if (!validarCPF(cpfInput)) {
                        event.preventDefault();
                    } else {
                        // Mostra o loading enquanto processa o envio
                        $('#loading').css('display', 'block');

                        // Obtém os dados do formulário
                        var formData = $('#myForm').serialize();

                        // Envia os dados via AJAX
                        $.ajax({
                            type: 'POST',
                            url: '/TechSUAS/controller/recepcao/inserir.php',
                            data: formData,
                            success: function (response) {
                                // Esconde o loading após a resposta
                                $('#loading').css('display', 'none');

                                // Verifica a resposta do servidor
                                if (response.trim() === 'success') {
                                    // Mostra o SweetAlert de sucesso e redireciona, se necessário
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso!',
                                        text: 'Registro inserido com sucesso.',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '/TechSUAS/views/recpcao/index.php';
                                        }
                                    });
                                } else {
                                    // Mostra o SweetAlert de erro
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro',
                                        text: 'Erro ao inserir o registro. Tente novamente mais tarde.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                // Esconde o loading em caso de erro
                                $('#loading').css('display', 'none');

                                // Mostra o SweetAlert de erro
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: 'Erro na requisição. Por favor, tente novamente mais tarde!',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });

            // Função para validar CPF
            function validarCPF(el) {
                if (!_cpf(el.value)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'CPF Inválido',
                        text: 'Por favor, insira um CPF válido!',
                        confirmButtonText: 'OK'
                    });

                    // Limpa o valor do campo CPF
                    el.value = "";
                    return false;
                }
                return true;
            }

            $(document).ready(function () {
                $('.check-icon').click(function () {
                    var id = $(this).data('id');
                    // Requisição AJAX para atualizar o status
                    $.ajax({
                        url: '/TechSUAS/controller/recepcao/atualizar_status.php',
                        type: 'POST',
                        data: {
                            id: id,
                            novo_status: 'feito'
                        },
                        success: function (response) {
                            // Atualiza a linha na tabela após a atualização
                            if (response.trim() == 'success') {
                                location.reload(); // Atualiza a página após o sucesso
                            } else {
                                alert('Erro ao atualizar o status.');
                            }
                        },
                        error: function () {
                            alert('Erro ao conectar com o servidor.');
                        }
                    });
                });
            });
        </script>
</body>

</html>
