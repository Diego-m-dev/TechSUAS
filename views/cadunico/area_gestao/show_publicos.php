<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

if (!isset($_POST['unip']) && empty($_POST['unip'])) {
  echo '<script>window.history.back()</script>';
  exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/cadunico/area_gestor/gestor.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/gestor.js"></script>
    <title>Detalhes do Entrevistador</title>
</head>
<body>
  
<?php
$unip = $_POST['unip'];

$stmt_unip = "SELECT co_familiar_fam, no_pessoa_rf, in_situacao FROM unipessoal WHERE in_inconsistencia_uni = '$unip' ORDER BY in_situacao DESC";
$stmt_unip_query = $conn->query($stmt_unip) or die("Erro " . $conn - error);
if ($stmt_unip_query->num_rows != 0) {
  ?>
  <table>
    <thead>
      <tr>
        <th>CÓDIGO FAMILIAR</th>
        <th>NOME</th>
        <th>SITUAÇÃO</th>
        <th>ID</th>
      </tr>
    </thead>
    <tbody>
  <?php
  while ($dados_unip = $stmt_unip_query->fetch_assoc()) {
    ?>
    <tr>
      <td><?php echo $dados_unip['co_familiar_fam']; ?></td>
      <td><?php echo $dados_unip['no_pessoa_rf']; ?></td>
      <td><?php echo $dados_unip['in_situacao']; ?></td>
      <td>
        <form method="POST">
          <input type="hidden" name="det_familia" value="<?php echo $dados_unip['co_familiar_fam']; ?>"/>
          <button type="submit">views</button>
        </form>
      </td>
    </tr>
    <?php
  }
  ?>
  </tbody>
  </table>
  <?php
}
?>
</body>
</html>