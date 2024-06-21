<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
if ($_SESSION['setor'] != "SUPORTE") {
    echo "VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR AQUI!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="/TechSUAS/js/cadastro_unico.js"></script>

  <title>Declaração CadÚnico</title>

</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cod_ibge = $_POST['cod_ibge_3'];

    $nome_bd = $_POST['nome_bd'];
    $nome_user = $_POST['nome_user'];
    $senha = $_POST['senha_bd'];

    // Busca o id do setor na tabela setores baseado no cpf do responsável
    $stmt_munic = $conn->prepare("UPDATE municipios SET nome_bd=?, usuario=?, senha_bd=? WHERE cod_ibge=?");

    if (!$stmt_munic) {
      die('Erro na preparação da consulta: ' . $conn->error);
  }

    $stmt_munic->bind_param("ssss", $nome_bd, $nome_user, $senha, $cod_ibge);
    $stmt_munic->execute();

    if ($stmt_munic->execute()) {
      ?>
      <script>
      Swal.fire({
      icon: "success",
      title: "SALVO",
      text: "Dados alterados com sucesso!",
      confirmButtonText: 'OK',
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = "/TechSUAS/suporte/municipios";
          }
      });
      </script>
      <?php
      exit();
  } else {
      echo "Erro na atualização das informações: " . $stmt_munic->error;
  }

  $stmt_munic->close();

}
?>
</body>
</html>