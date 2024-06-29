<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="style_conferir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Registro fichario</title>

    <style>
        .form-container {
            margin-bottom: 20px;
        }

        #textarm{
          font-size: 2cm;
        }

        .container {
            display: inline-block;
            position: relative;
            width: 8cm;
            height: 3cm;
            margin: 5px;
            border: 1px solid #ccc;
        }

        .original-size {
            width: 100%;
            height: 100%;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: black;
            font-weight: bold;
            font-size: 2em;
            text-align: center;
        }

        @media print {
            .form-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="">
            <label for="armario">ARMÁRIO</label>
            <input type="text" name="armario">
        </form>
    </div>

    <?php
    if (isset($_GET['armario'])) {
        $armario = $conn->real_escape_string($_GET['armario']);
        $stmt_fic = "SELECT codfam, arm_gav_pas FROM fichario WHERE arm_gav_pas LIKE '$armario%'";
        $stmt_fic_query = $conn->query($stmt_fic) or die("Erro " . $conn->error);

        if ($stmt_fic_query->num_rows > 0) {
            while ($fichario = $stmt_fic_query->fetch_assoc()) {
    ?>
        <div class="container">
            <img src="/TechSUAS/img/geral/etiqueta.png" alt="Etiqueta" class="original-size">
            <div class="overlay">
                <div id="arm" id="textarm"><?php echo $fichario['arm_gav_pas']; ?></div>
                <div id="cod"><?php echo $fichario['codfam']; ?></div>
            </div>
        </div>
    <?php
            }
        }
    }
    ?>

</body>
</html>
