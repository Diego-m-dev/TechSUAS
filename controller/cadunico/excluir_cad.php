<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style-visitas_does.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Visitas Pendentes</title>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

// Captura o NIS enviado via POST
$nis_exclui = $_POST['unip'];

try {
    // Preparar a query de exclusão usando prepared statement
    $stmt_exclui = $conn->prepare("INSERT INTO cadastros_excluidos (cod_familiar) VALUES (?)");
    $stmt_exclui->bind_param("s", $nis_exclui);

    // Executar a query
    if ($stmt_exclui->execute()) {
      ?>
      <script>
              Swal.fire({
                  icon: "success",
                  title: "CADASTRO EXCLUIDO DO SISTEMA TECHSUAS",
                  text: "esse cadastro foi exclído, mas caso você atualize os dados da base no TechSUAS!",
                  confirmButtonText: 'OK',
              }).then((result) => {
                  if (result.isConfirmed) {
                      if (window.history.back('5') == "%/TechSUAS/controller/cadunico/parecer/visitas_does%"){
                          window.location.href = "/TechSUAS/controller/cadunico/parecer/visitas_does"
                      } else {
                          window.location.href = "/TechSUAS/views/cadunico/area_gestao/index"
                      }
                  }
              })
      </script>
      <?php
    } else {
        echo "Erro ao excluir o registro.";
    }
} catch (PDOException $e) {
    // Tratamento de erro
    echo "Erro: " . $e->getMessage();
}
$conn_1->close();
?>
</body>
</html>