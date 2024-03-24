
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processo de Salvamento</title>
    <link rel="stylesheet" href="#">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';

if (isset($_POST['nome_pessoa'])) {
    $cpf_post = $_SESSION['cpf'];
    // Verifica se o nome de usuário já existe no banco de dados
    $verifica_usuario = $conn->prepare("SELECT cpf_pessoa FROM concessao_tbl WHERE cpf_pessoa = ?");
    $verifica_usuario->bind_param("s", $cpf_post);
    $verifica_usuario->execute();
    $verifica_usuario->store_result();

    if ($verifica_usuario->num_rows > 0) {
        ?>
        <script>
            Swal.fire({
                icon: 'info',
                title: 'JÁ EXISTE',
                text: 'Já existe um cadastro com esse CPF.',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/concessao/index"
                }
            })
        </script>
    <?php
exit();
    }
    $data_atual = date('d/m/Y H:i');
    $smtp_conc = $conn->prepare("INSERT INTO concessao_tbl (nome, naturalidade, nome_mae, contato, cpf_pessoa, rg_pessoa, tit_eleitor_pessoa, nis_pessoa, renda_media, endereco, operador, data_cadastro) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    $smtp_conc->bind_param("ssssssssssss", $_POST['nome_pessoa'], $_POST['naturalidade_pessoa'], $_POST['nome_mae_pessoa'], $_POST['contato'], $cpf_post, $_POST['rg_pessoa'], $_POST['te_pessoa'], $_POST['nis_pessoa'], $_POST['renda_per'], $_POST['endereco'], $nome, $data_atual);

    if ($smtp_conc->execute()) {?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'SALVO',
                        text: 'Dados salvos com sucesso!',
                    }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/concessao/index"
                }
            })
                </script>
            <?php
} else {
        echo "ERRO no envio dos DADOS: " . $smtp_conc->error;
    }
    $smtp_conc->close();
    $conn->close();

} else {
    echo 'não funcionou';
}
?>


</body>
</html>
