<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_index_cad">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

if ($_SESSION['funcao'] == '0') {
    header("location:/TechSUAS/suporte/index");
    exit();
} elseif ($_SESSION['name_sistema'] == "CADUNICO") {
    header("location:/TechSUAS/views/cadunico/index");
    exit();
} elseif ($_SESSION['name_sistema'] == 'CONCESSAO') {
    header("location:/TechSUAS/views/concessao/index");
    exit();
} else {
    header("location:/TechSUAS/config/logout");
} 
?>
</body>
</html>