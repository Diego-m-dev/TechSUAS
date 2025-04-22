<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';
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

  $cod_ibge = $_POST['cod_ibge_2'];

  $instituicao = $_POST['instituicao'];
  $nome_instit = $_POST['nome_instit'];
  $rua = $_POST['rua'];
  $numero = $_POST['numero'];
  $bairro = $_POST['bairro'];
  $email = $_POST['email'];
  $responsavel = $_POST['responsavel'];
  $cpf_coord = $_POST['cpf_coord'];

  // Busca o id do município na tabela municipios baseado no cod_ibge
  $stmt_munic = $pdo_1->prepare("SELECT id FROM municipios WHERE cod_ibge = :cod_ibge");
  $stmt_munic->bindValue(":cod_ibge", $cod_ibge);
  $stmt_munic->execute();

  if ($stmt_munic->rowCount() != 0) {
      $dados_munic = $stmt_munic->fetch(PDO::FETCH_ASSOC);
      $municipio_id = $dados_munic['id'];
  } else {
      // Trate o caso em que o município não foi encontrado
      die("Município não encontrado.");
  }

  // Consulta de inserção na tabela setores
  $query = "INSERT INTO setores (cod_ibge, instituicao, nome_instit, rua, numero, bairro, email, responsavel, cpf_coord, municipio_id) 
            VALUES (:cod_ibge, :instituicao, :nome_instit, :rua, :numero, :bairro, :email, :responsavel, :cpf_coord, :municipio_id)";

  $salva_dados = $pdo_1->prepare($query);

  // Vincula os valores aos parâmetros da consulta
  $salva_dados->bindValue(":cod_ibge", $cod_ibge);
  $salva_dados->bindValue(":instituicao", $instituicao);
  $salva_dados->bindValue(":nome_instit", $nome_instit);
  $salva_dados->bindValue(":rua", $rua);
  $salva_dados->bindValue(":numero", $numero);
  $salva_dados->bindValue(":bairro", $bairro);
  $salva_dados->bindValue(":email", $email);
  $salva_dados->bindValue(":responsavel", $responsavel);
  $salva_dados->bindValue(":cpf_coord", $cpf_coord);
  $salva_dados->bindValue(":municipio_id", $municipio_id);

  // Executa a consulta de inserção
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
          })
      </script>
      <?php
  } else {
      echo "Erro ao salvar os dados: " . $pdo_1->errorInfo()[2];
  }
$conn->close();
}
?>
</body>
</html>