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

    <title>Registro fichario - TechSUAS</title>
</head>

<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codfam'], $_POST['arm_gav_pas'])) {
    $codfam = $conn->real_escape_string($_POST['codfam']);
    $arm_gav_pas = $_POST['arm_gav_pas'];
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

            // Verifica se o nome de codigo já existe no banco de dados
            $verifica_fichario = $conn->prepare("SELECT codfam FROM fichario WHERE codfam = ?");
            if (!$verifica_fichario) {
              die('Erro na preparação da consulta: ' . $conn->error);
            }
            $verifica_fichario->bind_param("s", $ajustando_cod);
            $verifica_fichario->execute();
            $verifica_fichario->store_result();

    if ($verifica_fichario->num_rows > 0) {
        ?>
        <script>
            Swal.fire({
            icon: "info",
            title: "JÁ EXISTE",
            text: "O código <?php echo $ajustando_cod; ?> está arquivado em <?php echo $arm_gav_pas; ?>.",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/fichario/form_fichario";
                }
            });
        </script>
        <?php
        $conn->close();
        exit();
    }

    $verifica_cadastro = $conn->prepare("SELECT cod_familiar_fam FROM tbl_tudo WHERE cod_familiar_fam = ?");
    if (!$verifica_cadastro) {
      die('Erro na preparação da consulta: ' . $conn->error);
    }
    $verifica_cadastro->bind_param("s", $ajustando_cod);
    $verifica_cadastro->execute();
    $verifica_cadastro->store_result();

    if ($verifica_cadastro->num_rows == 0) {
      ?>
      <script>
          Swal.fire({
          icon: "info",
          title: "SEM CADASTRO NA BASE",
          text: "O código <?php echo $ajustando_cod; ?> não está em sua base de dados atual, confira no V7.",
          confirmButtonText: 'OK',
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = "/TechSUAS/views/fichario/form_fichario";
              }
          })
      </script>
          <?php
          $conn->close();
      exit();
  }

    $stmt_troca_fic = $conn->prepare("UPDATE fichario SET codfam=? WHERE arm_gav_pas=?");
    if (!$stmt_troca_fic) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt_troca_fic->bind_param("ss", $ajustando_cod, $arm_gav_pas);
    if ($stmt_troca_fic->execute()) {
        ?>
        <script>
            Swal.fire({
            icon: "success",
            title: "SALVO",
            text: "Os dados foram salvos com sucesso!",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/fichario/form_fichario";
                }
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
            icon: "error",
            title: "ERRO",
            text: 'Erro ao salvar registro: <?php echo $stmt_troca_fic->error; ?>',
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/fichario/form_fichario";
                }
            });
        </script>
        <?php
    }
    $stmt_troca_fic->close();
    $conn->close();
} else {
    echo "Erro no recebimento POST";
}
?>
</body>
</html>