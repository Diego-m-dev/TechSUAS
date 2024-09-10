<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

$cpf_declar = $_POST['cpf_declar'];

$cpf_limpo = preg_replace('/\D/', '', $_POST['cpf_declar']);
$cpf_already = ltrim($cpf_limpo, '0');

$sql_declar = $pdo->prepare("SELECT cod_familiar_fam, nom_pessoa FROM tbl_tudo WHERE num_nis_pessoa_atual = :cpf_declar");
$sql_declar->bindParam(':cpf_declar', $cpf_already, PDO::PARAM_STR);
$sql_declar->execute();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termo de delcaração de renda - TechSUAS</title>
    <!-- <link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/td.css"> -->
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <?php
  if ($sql_declar->rowCount() > 0) {
    $dados_declar = $sql_declar->fetch(PDO::FETCH_ASSOC);
    echo 'Código familiar: '. $dados_declar['cod_familiar_fam']. '<br>';
    echo 'Responsável familiar: '. $dados_declar['nom_pessoa']. '<br>';
    echo 'NIS: '. $_POST['cpf_declar']. '<br>';
  }
  ?>
<br>
<form action="" method="post">

<input type="hidden" name="rf_name" value="<?php echo $dados_declar['nom_pessoa']; ?>">
<input type="hidden" name="cod_fam" value="<?php echo $dados_declar['cod_familiar_fam']; ?>">
<input type="hidden" name="nis" value="<?php echo $_POST['cpf_declar']; ?>">

  <label for="sit_beneficio">Selecione a situação do benefício:</label>
    <select name="sit_beneficio" id="sit_beneficio" required>
      <option value="" disabled selected hidden>Escolha</option>
      <option value="FIM DE RESTRIÇÃO ESPECIFICA">FIM DE RESTRIÇÃO ESPECIFICA</option>
      <option value="CANCELADO">CANCELADO</option>
      <option value="BLOQUEADO">BLOQUEADO</option>
      <option value="FALTA DE ATUALIZAÇÃO">FALTA DE ATUALIZAÇÃO</option>
      <option value="UNIPESSOAL">UNIPESSOAL</option>
      <option value="TITULO DE ELEITOR">TITULO DE ELEITOR</option>
      <option value="CAMPOS OBRIGATÓRIO">CAMPOS OBRIGATÓRIO</option>
    </select>

    <button type="submit">Salvar</button>
    </form>

    <?php
    if (!isset($_POST['cpf_declar'])) {

    } else {

    }
    ?>
</body>
</html>

<?php
$conn_1->close();
?>