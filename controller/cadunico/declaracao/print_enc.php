<!DOCTYPE html>
<html lang="pt-BR">

    <head>
<style>
#modal {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    justify-content: center;
                    align-items: center;
                }

                #modal-form {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                }
</style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir encaminhamento</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="../../img/logo.png">
    </head>
<body>
<div class="justified-text">

<?php
require "encaminhamento.php";
echo $_GET['conteudo'];
?>
</div>
</body>

<script>
    setTimeout(function(){
        history.go(-2);
    }, 3000);

    window.onload = function() {
        window.print();
    };
    </script>
</html>
