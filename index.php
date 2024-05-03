<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>login - TechSUAS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/TechSUAS/css/geral/login.css">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <link rel="icon" href="" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="login-form">
        <form action="/TechSUAS/config/autenticar.php" method="post">
            <div class="logo">
                <img src="/TechSUAS/img/geral/logo1.png" alt="TECHSUAS">
            </div>
            <h2 class="text-center">
                Acessar Sistema
            </h2>
            <div class="form-group">
                <input class="form-control" type="text" name="usuario" placeholder="Usuario" required>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input class="form-control" type="password" name="senha" id="senha" placeholder="Senha" required>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-eye" id="mostrar-senha"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="btn-login">LOGIN</button>
            </div>

            <div class="clearfix">
                <label class="float-left checkbox-inline">
                    <input type="checkbox">
                    Lembrar-me
                </label>
                <!--<a data-toggle="modal" data-target="#modal-senha" class="float-right">Recuperar Senha</a>-->
            </div>
        </form>
    </div>

    <footer class="rodape">
        Sistema desenvolvido por DDV &trade; &nbsp;&nbsp;&nbsp;&nbsp; Versão 5.2.35
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mostrarSenha = document.getElementById('mostrar-senha')
        const campoSenha = document.getElementById('senha')

        mostrarSenha.addEventListener('click', function () {
            if (campoSenha.getAttribute('type') === 'password') {
                campoSenha.setAttribute('type', 'text')
                mostrarSenha.classList.remove('fa-eye')
                mostrarSenha.classList.add('fa-eye-slash')
            } else {
                campoSenha.setAttribute('type', 'password')
                mostrarSenha.classList.remove('fa-eye-slash')
                mostrarSenha.classList.add('fa-eye')
            }
        })
    })
</script>
</body>
</html>
