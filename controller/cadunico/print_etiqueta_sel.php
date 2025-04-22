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
    <link rel="stylesheet" href="/TechSUAS/css/fichario/style_conferir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Etiquetas TechSUAS DDV</title>

</head>
<body>

    <?php
    if (!isset($_POST['excluir'])) {
        ?>
        <script>
            Swal.fire({
                icon: "info",
                html: `<h1>ATENÇÃO</h1>
                    <p>Nenhum cadastro foi selecionado.</p>`,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back()
                }
            })
        </script>
        <?php
        exit;
    } else {
        $id_array = $_POST['excluir'];
    }

    if (count($id_array) < 16) {
        ?>
        <script>
            Swal.fire({
                icon: "info",
                html: `<h1>ATENÇÃO</h1>
                    <p>Para imprimir as etiquetas de forma economica, você precisa selecionar pelo menos 16 cadastros.</p>`,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back()
                }
            })
        </script>
        <?php
        exit;
    }

    $printado = "S";
    foreach ($id_array as $id) {
        $stmt_fic = "SELECT codfam, arm_gav_pas FROM fichario WHERE id = '$id' ORDER BY arm ASC, gav ASC, pas ASC";
        $stmt_fic_query = $conn->query($stmt_fic) or die("Erro " . $conn->error);

        if ($stmt_fic_query->num_rows > 0) {
            $fichario = $stmt_fic_query->fetch_assoc();
            ?>
            <div class="container">
                <img src="/TechSUAS/img/geral/etiqueta.png" alt="Etiqueta" class="original-size">
                <div class="overlay">
                    <div id="arm" id="textarm"><?php echo $fichario['arm_gav_pas']; ?></div>
                    <div id="cod">☆ <?php echo $fichario['codfam']; ?> ☆</div>
                </div>
            </div>
            <?php
        }

        $sql_id = $conn->prepare("UPDATE fichario SET print_id=? WHERE id=?");
        $sql_id->bind_param("ss", $printado, $id);
        $sql_id->execute();
    }
    ?>
    <script>
      window.print();

      setTimeout(() => {
        window.location.href = "/TechSUAS/views/fichario/allFichario";
      }, 300);
    </script>
    <?php
  $conn->close();
  $conn_1->close();
    ?>

</body>
</html>
