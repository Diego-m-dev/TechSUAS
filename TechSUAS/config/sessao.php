<?php
include "conexao.php";
session_start(); // Inicie a sessão para acessar as variáveis de sessão

// Inicialize a variável $voltar_link
$voltar_link1 = "/Suas-tech/index.php";

// Verifica se o usuário está autenticado como admin ou usuário
if (!isset($_SESSION['nome_usuario']) || ($_SESSION['nivel_usuario'] != 'admin' && $_SESSION['nivel_usuario'] != 'usuario' && $_SESSION['nivel_usuario'] != 'suport')) {
    // Configurar a mensagem do SweetAlert
    $mensagem = "Você não está logado. Por favor, faça login.";

    // Configurar o tipo de alerta (success, error, warning, etc.)
    $tipo_alerta = "error";
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../css/styledec.css">
        <link rel="website icon" type="png" href="../../img/logo.png">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <title>Declaração Cadastro único</title>
    </head>

    <body>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Exemplo de uso do SweetAlert2
                Swal.fire({
                    title: '<?php echo $mensagem; ?>',
                    icon: '<?php echo $tipo_alerta; ?>',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?php echo $voltar_link1; ?>';
                    }
                });
            });
        </script>

    </body>

    </html>

    <?php
    exit; // Encerra o script após exibir o alerta
}
//SALVAR LINK DO BOTÃO
if (isset($_SESSION['nivel_usuario']) && $_SESSION['nivel_usuario'] === 'admin') {
    // O operador é um administrador.
    $voltar_link = '../../painel-adm/adm-view.php';

} elseif (isset($_SESSION['nivel_usuario']) && $_SESSION['nivel_usuario'] === 'usuario') {
    // O operador é um usuário comum.
    $voltar_link = '../../painel-usuario/user-painel.php';
}elseif(isset($_SESSION['nivel_usuario']) && $_SESSION['nivel_usuario'] === 'suport'){
        // O operador é do suporte.
        $voltar_link = $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/acesso_suporte/index.php';
}
// Se o usuário estiver autenticado, continue com o restante do código...
?>