<?php
session_start();
include "conexao.php";

// Verifica se o usuário está autenticado como admin ou usuário ou suporte
if (!isset($_SESSION['nome_usuario'])) {
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
                        window.location.href = '/TechSUAS/'
                    }
                })
            })
        </script>
    </body>
    </html>
    <?php
    exit; // Encerra o script após exibir o alerta
}