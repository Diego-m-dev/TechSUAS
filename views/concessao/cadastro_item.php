<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Itens - TechSUAS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_item.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/concessao/h1-cad_itens.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <div id="form_1">
            <form method="POST" id="meuFormulario">
                <label for="cod_item">Código do Item:</label>
                <input type="text" id="cod_item" name="cod_item" required>

                <label for="caracteristiva">Tipo do Item:</label>
                <input type="text" id="caracteristiva" name="caracteristiva" required oninput="this.value = this.value.toUpperCase()" />

                <label for="nome_item">Nome Item:</label>
                <input type="text" id="nome_item" name="nome_item" required oninput="this.value = this.value.toUpperCase()" />
                <button type="submit">SALVAR</button>
                <a href="/TechSUAS/config/back">
                    <i class="fas fa-arrow-left"></i> Voltar ao menu
                </a>
            </form>
        </div>
        <div class="btn">
            <label id="consultar_info">Veja os itens cadastrados:</label>
            <button id="consultar" onclick="window.location.href='/TechSUAS/views/concessao/tbl_itens'">ABRIR TABELA</button>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $cod_item = $_POST['cod_item'];
            // Verifica se já existe no banco de dados
            $verifica_usuario = $conn->prepare("SELECT cod_item FROM concessao_itens WHERE cod_item = ?");
            $verifica_usuario->bind_param("s", $cod_item);
            $verifica_usuario->execute();
            $verifica_usuario->store_result();

            if ($verifica_usuario->num_rows > 0) {
        ?>
                <script>
                    Swal.fire({
                        icon: 'info',
                        title: 'ITEM JÁ CADASTRADO',
                        text: 'Já existe um cadastro com esse código.',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/Suas-Tech/concessao/index.php"
                        }
                    })
                </script>
            <?php
                exit();
            }
            $smtp_item = $conn->prepare("INSERT INTO concessao_itens (cod_item, caracteristica, nome_item) VALUES (?,?,?)");
            $smtp_item->bind_param("sss", $_POST['cod_item'], $_POST['caracteristiva'], $_POST['nome_item']);

            if ($smtp_item->execute()) { ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'SALVO',
                        text: 'Dados salvos com sucesso!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var outraAcao = window.confirm('Deseja realizar outro cadastro?')

                            if (outraAcao) {
                                window.location.href = "/TechSUAS/views/concessao/cadastro_item"
                            } else {
                                window.location.href = "/TechSUAS/views/concessao/index"
                            }

                        }
                    })
                </script>
        <?php
            } else {
                echo "ERRO no envio dos DADOS: " . $smtp_item->error;
            }
            $smtp_item->close();
            $conn->close();
        }
        ?>
        <script>
            $(document).ready(function() {
                $('#cod_item').mask('0000000000000000')
            })
        </script>
    </div>
</body>

</html>