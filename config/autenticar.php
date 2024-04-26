<?php

session_set_cookie_params(['httponly' => true]);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_index_cad">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
<?php
require_once "conexao.php";
session_start();

session_regenerate_id(true);

$usuario = $_POST['usuario'];
$senha_login = $_POST['senha'];

$stmt_login = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
$stmt_login->bindValue(":usuario", $usuario);
$stmt_login->execute();

$dados = $stmt_login->fetch(PDO::FETCH_ASSOC);
if ($dados && is_array($dados) && array_key_exists('setor', $dados)) {
    $setor_ = $dados['setor'];
    $senhalogin = $dados['senha'];

    if ($usuario == $dados['usuario'] && password_verify($senha_login, $dados['senha'])) {
        $_SESSION['user_usuario'] = $dados['usuario'];
        $_SESSION['nivel_usuario'] = $dados['nivel'];
        $_SESSION['nome_usuario'] = $dados['nome'];
        $_SESSION['apelido'] = $dados['apelido'];
        $_SESSION['funcao'] = $dados['funcao'];
        $_SESSION['setor'] = $dados['setor'];
        
        if ($dados['acesso'] == 1) {
            header("location:/TechSUAS/views/geral/primeiro_acesso");
            exit();
        }

        // Redirecione com base no nível de acesso
        if ($_SESSION['nivel_usuario'] == 'suport') {
            header("location:/TechSUAS/suporte/");
            exit();
        } elseif ($_SESSION['nivel_usuario'] == 'admin') {
            if ($_SESSION['setor'] == "CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL") {
                header("location:/TechSUAS/views/cadunico/");
            } elseif ($_SESSION['setor'] == "SUPORTE") {
                header("location:/TechSUAS/suporte/");
            }
            exit();
        } elseif ($_SESSION['nivel_usuario'] == 'usuario') {
            if ($_SESSION['setor'] == "CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL") {
                header("location:/TechSUAS/views/cadunico/");
            } elseif ($_SESSION['setor'] == "CONCESSÃO") {
                header("location:/TechSUAS/views/concessao/");
            } elseif ($_SESSION['setor'] == 'ADMINISTRATIVO E CONCESSÃO') {
                ?>
                    <script>
                        Swal.fire({
                            html:`
                            <h2>PERFIL PERMISSIONADO PARA DOIS SETORES</h2>
            <div class="visitas">
                <a class="menu-button" onclick="location.href='/TechSUAS/views/concessao/';">
                    CONCESSÃO
                </a>
            </div>

            <div class="folha">
                <a class="menu-button" onclick="location.href='/TechSUAS/views/administrativo/';">
                    ADMINISTRATIVO
                </a>
            </div>
        `,
            }).then((result) => {
                if(result.isConfirmed) {
                    window.location.href = "/TechSUAS/config/logout";
                }
            })
        </script>
                <?php
            }
            exit();
        } else {
            ?>
        <script>
            Swal.fire({
            icon: "info",
            title: "SEM PERMISSÃO",
            text: "Você ainda não foi permissionado.",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/";
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
    title: "DADOS VAZIO",
    text: "Não localizado.",
    confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/TechSUAS/index";
        }
    });
</script>
    <?php

}
?>
    </body>
</html>