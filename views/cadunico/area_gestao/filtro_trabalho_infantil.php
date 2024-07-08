<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
if ($_SESSION['funcao'] != '1') {
    echo '<script>window.history.back()</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/gestor.js"></script>

    <title>Filtros Trabalho Infantil</title>
</head>
<body>
    <h1>CADASTROS ÚNICO <?php echo $cidade; ?></h1>
  <table border="1">
    <tr>
    <th>Código Familiar</th>
    <th>Nome</th>
    <th>NIS</th>
    <th>Indicativo</th>
    </tr>
<?php
$sql_TI = "SELECT * FROM tbl_tudo WHERE ind_trabalho_infantil_pessoa = 1";
$sql_TI_query = $conn->query($sql_TI) or die("Erro ". $conn - error);

  if ($sql_TI_query->num_rows == 0) {
?>
    <tr>
      <td colspan="4">Não tem nenhum caso indicado de Trabalho Infantil</td>
    </tr>
<?php
  } else {
    while ($dados = $sql_TI_query->fetch_assoc()) {
?>
      <tr>
      <td><?php echo $dados['cod_familiar_fam']; ?></td>
      <td><?php echo $dados['nom_pessoa']; ?></td>
      <td><?php echo $dados['num_nis_pessoa_atual']; ?></td>
      <td><?php echo $dados['ind_trabalho_infantil_pessoa']; ?></td>
      </tr>
<?php
    }
  }
?>
  </table>
    <button onclick="voltarFiltros()">Voltar</button>
</body>
</html>
