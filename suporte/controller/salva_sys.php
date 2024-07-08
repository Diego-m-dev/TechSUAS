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
  $cpf_coord = $_POST['cpf'];

  $nome_sistema = $_POST['nome_sistema'];
  $data_aquisicao = $_POST['data_aquisicao'];
  $validade = $_POST['validade'];
  $secretaria = $_POST['secretaria'];

  // Busca o id do setor na tabela setores baseado no cpf do responsável
  $stmt_munic = $pdo_1->prepare("SELECT id, responsavel FROM setores WHERE cpf_coord = :cpf_coord");
  $stmt_munic->bindValue(":cpf_coord", $cpf_coord);
  $stmt_munic->execute();

  if ($stmt_munic->rowCount() != 0) {
      $dados_munic = $stmt_munic->fetch(PDO::FETCH_ASSOC);
      $municipio_id = $dados_munic['id'];
      $responsavel = $dados_munic['responsavel'];
  } else {
      // Trate o caso em que o município não foi encontrado
      die("Município não encontrado.");
  }

  // Consulta de inserção na tabela setores
  $query = "INSERT INTO sistemas (nome_sistema, data_aquisicao, setores_id, validade, secretaria, responsavel, cpf)
          VALUES (:nome_sistema, :data_aquisicao, :setores_id, :validade, :secretaria, :responsavel, :cpf)";

  $salva_dados = $pdo_1->prepare($query);

  // Vincula os valores aos parâmetros da consulta
  $salva_dados->bindValue(":nome_sistema", $nome_sistema);
  $salva_dados->bindValue(":data_aquisicao", $data_aquisicao);
  $salva_dados->bindValue(":setores_id", $municipio_id);
  $salva_dados->bindValue(":validade", $validade);
  $salva_dados->bindValue(":secretaria", $secretaria);
  $salva_dados->bindValue(":responsavel", $responsavel);
  $salva_dados->bindValue(":cpf", $cpf_coord);

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
}
?>
</body>
</html>