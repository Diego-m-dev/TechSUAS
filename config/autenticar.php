<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
<?php
require_once "conexao.php";
session_start();

$usuario = $_POST['usuario'];
$senha_login = $_POST['senha'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
$stmt->bindValue(":usuario", $usuario);
$stmt->execute();

$dados = $stmt->fetch(PDO::FETCH_ASSOC);
if ($dados && is_array($dados) && array_key_exists('setor', $dados)) {
$setor_ = $dados['setor'];
$senhalogin = $dados['acesso'];

if ($dados && password_verify($senha_login, $dados['senha'])) {
    $_SESSION['nome_usuario'] = $dados['nome'];
    $_SESSION['user_usuario'] = $dados['usuario'];
    $_SESSION['nivel_usuario'] = $dados['nivel'];

        // Verifique se é o primeiro acesso pela senha
        if ($senhalogin == "1") {
            // Passa o nome do usuário para a página de primeiro acesso
            $_SESSION['nome_user_1_acesso'] = $dados['usuario'];
    
            // Redirecione para a página de conclusão do cadastro
            header("Location: ../cadunico/views/acessos/primeiro_acesso");
            exit();
        }

    if ($setor_ == "CRIANÇA FELIZ"){
        header("location:../suas/peixe/logado/form");
        exit();
    }
    // Redirecione com base no nível de acesso
    if ($_SESSION['nivel_usuario'] == 'suport') {
        header("location:../acesso_suporte/index");
        exit();
    } elseif ($setor_ == "CRAS - ANTONIO MATIAS") {
        header("Location: ../cras/views/menu-cras-am");
        exit();
    } elseif ($setor_ == "CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL") {
        if ($_SESSION['nivel_usuario'] == 'admin') {
            header("location:../cadunico/painel-adm/adm-view");
            exit();
        } elseif ($_SESSION['nivel_usuario'] == 'usuario') {
            header("location:../cadunico/painel-usuario/user-painel");
            exit();
        }
    } elseif ($setor_ == "CRAS - SANTO AFONSO") {
        header("Location: ../cras/views/menu-cras-st");
    } elseif ($setor_ == "CREAS - GILDO SOARES") {
        header("Location: ../creas/views/menu-creas");
    } elseif ($setor_ == "COZINHA COMUNITARIA - MARIA NEUMA DA SILVA") {
        header("Location: ../cozinha_comunitaria/menu");
    }else{
        ?>
        <script>
            Swal.fire({
            icon: "error",
            title: "SENHA INCORRETA",
            text: "Usuário ou senha não condiz com a base de dados.",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/index";
                }
            });
        </script>
            <?php
    }

    } else {

    ?>
<script>
    Swal.fire({
    icon: "error",
    title: "SENHA INCORRETA",
    text: "Usuário ou senha não condiz com a base de dados.",
    confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/TechSUAS/index";
        }
    });
</script>
    <?php
    }
} else {
    ?>
<script>
    Swal.fire({
    icon: "error",
    title: "SENHA INCORRETA",
    text: "Usuário ou senha não condiz com a base de dados.",
    confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/TechSUAS/index.php";
        }
    });
</script>
    <?php

}
?>
    </body>
</html>