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
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php'; // Certifique-se de que este arquivo configure o PDO corretamente
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';

if (isset($_POST['nome_pessoa'])) {
    $cpf_post = $_SESSION['cpf'];

    try {
        // Verifica se o CPF já existe no banco de dados
        $verifica_usuario = $pdo->prepare("SELECT cpf_pessoa FROM concessao_tbl WHERE cpf_pessoa = :cpf_pessoa");
        $verifica_usuario->execute([':cpf_pessoa' => $cpf_post]);

        if ($verifica_usuario->rowCount() > 0) {
            ?>
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'JÁ EXISTE',
                    text: 'Já existe um cadastro com esse CPF.',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/TechSUAS/views/concessao/index";
                    }
                });
            </script>
            <?php
            exit();
        }

        $data_atual = date('Y-m-d H:i:s'); // Ajuste para o formato SQL
        $smtp_conc = $pdo->prepare("INSERT INTO concessao_tbl (nome, naturalidade, nome_mae, contato, cpf_pessoa, rg_pessoa, tit_eleitor_pessoa, nis_pessoa, renda_media, endereco, operador, data_cadastro) VALUES (:nome, :naturalidade, :nome_mae, :contato, :cpf_pessoa, :rg_pessoa, :tit_eleitor_pessoa, :nis_pessoa, :renda_media, :endereco, :operador, :data_cadastro)");
        $smtp_conc->execute([
            ':nome' => $_POST['nome_pessoa'],
            ':naturalidade' => $_POST['naturalidade_pessoa'],
            ':nome_mae' => $_POST['nome_mae_pessoa'],
            ':contato' => $_POST['contato'],
            ':cpf_pessoa' => $cpf_post,
            ':rg_pessoa' => $_POST['rg_pessoa'],
            ':tit_eleitor_pessoa' => $_POST['te_pessoa'],
            ':nis_pessoa' => $_POST['nis_pessoa'],
            ':renda_media' => $_POST['renda_per'],
            ':endereco' => $_POST['endereco'],
            ':operador' => $nome, // Verifique se a variável $nome está definida
            ':data_cadastro' => $data_atual
        ]);

        ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'SALVO',
                text: 'Dados salvos com sucesso!',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/concessao/index";
                }
            });
        </script>
        <?php
    } catch (PDOException $e) {
        echo "ERRO no envio dos DADOS: " . $e->getMessage();
    }

    // Fechar conexão PDO
    $pdo = null;
} else {
    echo 'Não funcionou';
}
?>
</body>
</html>
