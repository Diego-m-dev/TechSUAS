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

  <title>Alterar BD</title>

</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cod_ibge = $_POST['cod_ibge_3'];
    $funcao = $_POST['funcao'];
    $cpf_ = $_SESSION['cpf'];
    $sistema = $_POST['sistema'];

    $sql_bd = "SELECT municipio, nome_bd, user_bd, pass_bd FROM municipios WHERE cod_ibge = '$cod_ibge'";
    $sql_bd_query = $conn_1->query($sql_bd) or die("Error " . $conn_1 - error);

    if ($sql_bd_query->num_rows > 0) {
      $dados_bd = $sql_bd_query->fetch_assoc();

      $nome_bd = $dados_bd['nome_bd'];
      $senha = $dados_bd['pass_bd'];
      $nome_user = $dados_bd['user_bd'];
      $municipio = $dados_bd['municipio'];
    } else {
      echo "Município não encontrado!";
      exit();
    }
    // Busca o id do setor na tabela setores baseado no cpf do responsável
    $stmt_munic = $conn_1->prepare("UPDATE operadores SET funcao=?, name_sistema=?, nome_bd=?, user_bd=?, pass_bd=? WHERE cpf=?");

    if (!$stmt_munic) {
      die('Erro na preparação da consulta: ' . $conn_1->error);
  }

    $stmt_munic->bind_param("ssssss", $funcao, $sistema, $nome_bd, $nome_user, $senha, $cpf_);
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
              window.location.href = "/TechSUAS/config/logout";
          }
      });
      </script>
      <?php
      exit();
  } else {
      echo "Erro na atualização das informações: " . $stmt_munic->error;
  }

  $stmt_munic->close();
  $conn_1->close();
}
?>
</body>
</html>