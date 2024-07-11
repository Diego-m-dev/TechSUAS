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

  <title>Incluir BD município</title>

</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $cod_ibge = $_POST['cod_ibge_3'];
  $cpf_gest = $_POST['cpf_gest'];
  $nome_bd = $_POST['nome_bd'];
  $nome_user = $_POST['nome_user'];
  $senha_bd = $_POST['senha_bd'];

  $stmt_munic = $conn_1->prepare("UPDATE municipios SET nome_bd=?, user_bd=?, pass_bd=? WHERE cod_ibge=?");
  $stmt_oper = $conn_1->prepare("UPDATE operadores SET nome_bd=?, user_bd=?, pass_bd=? WHERE cpf=?");

  if (!$stmt_munic || !$stmt_oper) {
    die('Falha de comunicação no sistema. Código: Y909Z');
  }

  $stmt_munic->bind_param("ssss", $nome_bd, $nome_user, $senha_bd, $cod_ibge);
  $stmt_oper->bind_param("ssss", $nome_bd, $nome_user, $senha_bd, $cpf_gest);

    if ($stmt_munic->execute() && $stmt_oper->execute()) {
      ?>
      <script>
      Swal.fire({
      icon: "success",
      title: "SALVO",
      text: "Dados alterados com sucesso!",
      confirmButtonText: 'OK',
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = "/TechSUAS/suporte/index";
          }
      });
      </script>
      <?php
      exit();
    } else {
      echo "Atualização falhou: Verifique o código Y902Z.";
    }

  $stmt_munic->close();
  $stmt_oper->close();
  $conn_1->close();
}
?>
</body>
</html>