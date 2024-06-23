<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "conexao_acesso.php";

if (!isset($_SESSION['nome_usuario'])) {
    // Configurar o tipo de alerta (success, error, warning, etc.)
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
            Swal.fire({
                title: 'Você não está logado. Por favor, faça login.',
                icon: 'error',
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
} else {
    // Consulta ao banco de dados para buscar informações do sistema e setor
    $stmt_sistema = $pdo_1->prepare("SELECT * FROM sistemas WHERE id = :sis_id");
    $stmt_sistema->bindValue(":sis_id", $_SESSION['sistema_id'], PDO::PARAM_INT);
    $stmt_sistema->execute();

    
    if ($dado_sys = $stmt_sistema->fetch(PDO::FETCH_ASSOC)) {
        $sistema = $dado_sys['setores_id'];

        $stmt_setor = $pdo_1->prepare("SELECT * FROM setores WHERE id = :sis_id");
        $stmt_setor->bindValue(":sis_id", $sistema, PDO::PARAM_INT);
        $stmt_setor->execute();

        if ($dados_setor = $stmt_setor->fetch(PDO::FETCH_ASSOC)) {
            $sistemando = $dados_setor['instituicao'] . ' - ' . $dados_setor['nome_instit'];
            $id_municipio = $dados_setor['municipio_id'];
        }
    }
}
?>