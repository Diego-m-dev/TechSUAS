<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitas - TechSUAS</title>
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style_visitas.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        input {
            width: 300px;
            padding: auto;

        }
    </style>
  </head>
<body>
    <form action="" method="POST">
        <input type="text" name="cep" id="cep" placeholder="Digite o CEP" required/>
        <input type="text" name="ll11" placeholder="Digite o Log/Lat exp.: -8.520515, -36.446310" required/>
        <button type="submit" name="salvar">Salvar</button>
    </form>
    <script>
        $('#cep').mask("00.000-000")
    </script>

<?php

if (isset($_POST['salvar'])) {
    // Limpa e divide o CEP
    $cepCompleto = preg_replace('/[^0-9]/', '', $_POST['cep']); // remove pontos e traço
    $cep1 = substr($cepCompleto, 0, 5); // primeiros 5 dígitos
    $cep2 = substr($cepCompleto, 5);    // últimos 3 dígitos

    // Divide longitude e latitude
    $coordenadas = explode(',', $_POST['ll11']);
    $latitude = trim($coordenadas[0]);
    $longitude = trim($coordenadas[1]);

    // Prepara e executa o insert
    $sql = "INSERT INTO locais (cep_pre, cep_dig, longitude, latitude) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdd", $cep1, $cep2, $longitude, $latitude);

    if ($stmt->execute()) {
        echo "<script>alert('Dados salvos com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao salvar.');</script>";
    }

    $stmt->close();
}
?>

</body>
</html>