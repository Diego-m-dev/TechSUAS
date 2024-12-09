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
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';

    $nome_mun = $_POST['nome_mun'];
    $cnpj_prefeitura = $_POST['cnpj_prefeitura'];
    $nome_prefeito = $_POST['nome_prefeito'];
    $nome_vice = $_POST['nome_vice'];
    $cod_ibge = $_POST['cod_ibge'];
    $uf = $_POST['uf'];

  // Verifica se o nome de usuário já existe no banco de dados
  $verifica_municipio = $conn_1->prepare("SELECT cod_ibge FROM municipios WHERE cod_ibge = ?");
  $verifica_municipio->bind_param("s", $cod_ibge);
  $verifica_municipio->execute();
  $verifica_municipio->store_result();

  if ($verifica_municipio->num_rows > 0) {
    // Se o município já está cadastrado, exibe uma mensagem e volta a pagina
?>
    <script>
      Swal.fire({
      icon: "info",
      title: "JÁ CADASTRADO",
      text: "Município já cadastrado.",
      confirmButtonText: 'OK',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "/TechSUAS/suporte/municipios";
        }
      })
    </script>
<?php
    exit();
  }

    $query = "INSERT INTO municipios (cod_ibge, municipio, estado, cnpj, prefeito, vice_prefeito) VALUE (:cod_ibge, :municipio, :estado, :cnpj, :prefeito, :vice_prefeito)";

    $salva_dados = $pdo_1->prepare($query);

    $salva_dados->bindValue(":cod_ibge", ($cod_ibge ?? "NULL"));
    $salva_dados->bindValue(":municipio", ($nome_mun ?? "NULL"));
    $salva_dados->bindValue(":estado", ($uf ?? "NULL"));
    $salva_dados->bindValue(":cnpj", ($cnpj_prefeitura ?? "NULL"));
    $salva_dados->bindValue(":prefeito", ($nome_prefeito ?? "NULL"));
    $salva_dados->bindValue(":vice_prefeito", ($nome_vice ?? "NULL"));

    if ($salva_dados->execute()) {
    ?>
      <script>
        Swal.fire({
        icon: "success",
        title: "CADASTRADO",
        text: "Dados salvo com sucesso!",
        confirmButtonText: 'OK',
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/TechSUAS/suporte/municipios";
          }
        })
      </script>
    <?php

    } else {
      echo "erro " . $pdo_1 - error;
    }
  }
  $conn_1->close();
?>
</body>
</html>