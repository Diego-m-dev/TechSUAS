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

    $query = "INSERT INTO municipios (cod_ibge, municipio, estado, cnpj, prefeito, vice_prefeito) VALUE (:cod_ibge, :municipio, :estado, :cnpj, :prefeito, :vice_prefeito)";

    $salva_dados = $pdo->prepare($query);

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
        title: "SALVO",
        text: "Os dados foram salvos com sucesso!",
        confirmButtonText: "OK"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "/TechSUAS/suporte/municipios"
        }
      }).then((result) => {
        Swal.fire({
    html: `
    <h3>CADASTRAR NOVO MUNICÍPIO</h3>

    <form method="POST" action="/TechSUAS/suporte/controller/salva_setor.php" id="form_cad_mun">

  Setor:
    <input type="text" id="setor" class="maiusculo" oninput="sempre_maiusculo(this) name="setor"/>

  Nome:
    <input type="text" name="nome_setor" class="maiusculo" id="nome_setor" oninput="sempre_maiusculo(this)" />

  CNPJ Prefeitura:
    <input type="text" name="cnpj_prefeitura" id="cnpj_prefeitura"/>
    Nome Prefeito:
    <input type="text" name="nome_prefeito" id="nome_prefeito" class="maiusculo"  oninput="sempre_maiusculo(this)" />
    Nome Vice-Prefeito:
    <input type="text" name="nome_vice" id="nome_vice" class="maiusculo"  oninput="sempre_maiusculo(this)" />
    </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Enviar',
    cancelButtonText: 'Cancelar',
    preConfirm: () => {
      const nome_mun = document.getElementById('nome_mun').value
      const cnpj_mun = document.getElementById('cnpj_prefeitura').value
      const nome_prefeito = document.getElementById('nome_prefeito').value
      const nome_vice = document.getElementById('nome_vice').value
        if (!nome_mun || !cnpj_mun || !nome_prefeito || !nome_vice) {
          Swal.showValidationMessage('Todos os campos são obrigatórios.')
          return false
        }
    },
    didOpen: () => {
      $('#cnpj_prefeitura').mask('00.000.000/0000-00')
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const form = document.getElementById("form_cad_mun")
      form.submit()
    }
  })

      })
    </script>
<?php
    } else {
      echo "erro " . $pdo - error;
    }
  }
?>
</body>
</html>