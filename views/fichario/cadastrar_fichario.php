<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/fichario/style_conferir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Cadastrar fichario - TechSUAS</title>
    <style>
        #progressContainer {
            display: none;
            width: 100%;
            background-color: #f3f3f3;
            margin-top: 20px;
        }

        #progressBar {
            width: 0%;
            height: 30px;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
        }
    </style>
</head>

<body>
    <h1>Cadastrar Fichario</h1>

    <form method="POST" action="">
        <label for="">Armário:</label>
        <input type="number" name="arm" required />
        <label for="">Gaveta:</label>
        <input type="number" name="gav" required />
        <label for="">Pasta:</label>
        <input type="number" name="pas" required min="10" />
        <button type="submit">Salvar</button>
    </form>

    <div id="progressContainer">
        <div id="progressBar">0%</div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['arm']) && isset($_POST['gav']) && isset($_POST['pas'])) {
            $arm = str_pad($conn->real_escape_string($_POST['arm']), 2, '0', STR_PAD_LEFT);
            $gav = str_pad($conn->real_escape_string($_POST['gav']), 2, '0', STR_PAD_LEFT);
            $pasta = $conn->real_escape_string($_POST['pas']);

            $conn->begin_transaction();
            try {
                $stmt = $conn->prepare("INSERT INTO ficharios (arm, gav, pas) VALUES (?, ?, ?)");

                echo '<script>document.getElementById("progressContainer").style.display = "block";</script>';
                for ($i = 1; $i <= $pasta; $i++) {
                    $pas = str_pad($i, 3, '0', STR_PAD_LEFT);
                    $stmt->bind_param("sss", $arm, $gav, $pas);
                    $stmt->execute();

                    $progress = ($i / $pasta) * 100;
                    echo '<script>document.getElementById("progressBar").style.width = "' . $progress . '%"; document.getElementById("progressBar").innerText = "' . round($progress) . '%";</script>';
                    flush();
                    ob_flush();
                }

                $conn->commit();
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "SALVO",
                        text: "Os dados foram salvos com sucesso.",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/TechSUAS/views/fichario/cadastrar_fichario"
                        }
                    });
                </script>';
            } catch (Exception $e) {
                $conn->rollback();
                echo "Erro ao salvar os dados: " . $e->getMessage();
            }

            $stmt->close();
            $conn->close();
        }
    }
    ?>
</body>

</html>