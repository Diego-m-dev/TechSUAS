<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style-visitas_does.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Visitas Pendentes</title>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

// Captura o NIS enviado via POST
$nis_exclui = $_POST['unip'];
?>

<script>
    // Função para mostrar o alerta de confirmação
    Swal.fire({
        icon: "warning",
        text: "Você tem certeza que deseja excluir esse cadastro?",
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar a requisição para excluir o cadastro
            $.ajax({
                url: '/TechSUAS/controller/cadunico/excluir_cadastro.php',
                type: 'POST',
                data: { unip: '<?php echo $nis_exclui; ?>' },
                success: function(response) {
                    if (response === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "CADASTRO EXCLUÍDO DO SISTEMA TECHSUAS",
                            text: "Esse cadastro foi excluído, mas caso você atualize os dados da base no TechSUAS!",
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.history.go(-2);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Erro",
                            text: "Não foi possível excluir o cadastro. Tente novamente.",
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Erro",
                        text: "Ocorreu um erro ao tentar excluir o cadastro.",
                        confirmButtonText: 'OK'
                    });
                }
            });
        } else {
            window.history.go(-2);
        }
    })
</script>
<?php
$conn_1->close();
?>
</body>
</html>
