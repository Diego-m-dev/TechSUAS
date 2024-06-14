<?php
require ('secret.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/png">
    <link rel="stylesheet"  type="text/css" href="/TechSUAS/css/geral/style-processo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <title>Cadastro Salvo</title>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tpacesso = $_POST['nivel'];
    $senha_hashed = password_hash($mddrRfc1nkKKKdsad56, PASSWORD_DEFAULT);
    $user_name = $_POST['nome_user'];
    $user_maiusc = strtoupper($user_name);
    $setor = $_POST['setor'];
    $funcao = $_POST['funcao'];

    $email = $_POST['email'];
    $nomeUsuario = gerarNomeUsuario($user_name);

    // Verifica se o nome de usuário já existe no banco de dados
    $verifica_usuario = $conn->prepare("SELECT usuario FROM usuarios WHERE usuario = ?");
    $verifica_usuario->bind_param("s", $nomeUsuario);
    $verifica_usuario->execute();
    $verifica_usuario->store_result();

    if ($verifica_usuario->num_rows > 0) {
        // Se o nome de usuário já está em uso, exibe uma mensagem e redirecione de volta ao login
        ?>
        <script>
            Swal.fire({
            icon: "info",
            title: "JÁ CADASTRADO",
            text: "Nome de usuário já em uso. Por favor, consulte o SUPORTE DDV",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/geral/cadastro_user";
                }
            })
        </script>
            <?php
        exit();
    }

    // Caso o Nome do Usuário seja unico será adicionado ao SQL
    $smtp = $conn->prepare("INSERT INTO usuarios (nome, usuario, senha, nivel, setor, funcao, email, acesso, data_registro) VALUES (?,?,?,?,?,?, ?, ?, NOW())");

    // Verifica se a preparação foi bem-sucedida
    if ($smtp === false) {
        die('Erro na preparação SQL: ' . $conn->error);
    }
    $acesso = "1";
    $smtp->bind_param("ssssssss", $user_maiusc, $nomeUsuario, $senha_hashed, $tpacesso, $setor, $funcao, $email, $acesso);

    if ($smtp->execute()) {
// Redireciona para a página DE CADASTRAR NOVO USUÁRIO após ALGUNS segundos
?>
<script>
    Swal.fire({
    icon: "success",
    title: "CADASTRADO",
    text: "Cadastro realizado com sucesso!",
    confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/TechSUAS/views/geral/cadastro_user";
        }
    })
</script>
    <?php
    } else {
        echo "ERRO no envio dos DADOS: " . $smtp->error;
    }
    $smtp->close();
    $conn->close();
}

function gerarNomeUsuario($user_name)
{
    $nomes = explode(" ", $user_name);
    $nomeUsuario = strtolower($nomes[0] . "." . end($nomes));
    return $nomeUsuario;
}
?>
</body>
</html>