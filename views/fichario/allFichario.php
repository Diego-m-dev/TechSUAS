<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

$stmt_fic = "SELECT id, codfam, arm_gav_pas, operador FROM fichario
WHERE print_id != 'S'
ORDER BY arm ASC, gav ASC, pas ASC ";
$stmt_fic_query = $conn->query($stmt_fic) or die("Erro ". $conn - error);

if ($stmt_fic_query->num_rows > 0) {

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/fichario/style_conferir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Registro fichario - TechSUAS</title>

</head>
<body>
  <form action="/TechSUAS/controller/cadunico/print_etiqueta_sel" method="post">
  <button type="submit" id="print">imprimir</button>

  <table>
    <tr>
      <th>CÓDIGO FAMILIAR</th>
      <th>FICHÁRIO</th>
      <th>NOME</th>
      <th class="check">
        <label class="urg">
          <input type="checkbox" id="selecionarTodos">
          <span class="checkmark"></span>
        </label>
      </th>
    </tr>
<?php
    while ($fichario = $stmt_fic_query->fetch_assoc()) {
?>
    <tr>
      <td><?php echo $fichario['codfam']; ?></td>
      <td><?php echo $fichario['arm_gav_pas']; ?></td>
      <td><?php echo $fichario['operador']; ?></td>
      <td class="check">
        <label class="urg">
          <input type="checkbox" name="excluir[]" value="<?php echo $fichario['id']; ?>">
          <span class="checkmark"></span>
        </label>
      </td>
    </tr>
<?php
    }
?>
  </table>
  </form>
<?php
  }

  $conn->close();
  $conn_1->close();
?>
<script>
    document.getElementById('selecionarTodos').addEventListener('click', function() {
        var checkBoxes = document.querySelectorAll('input[name="excluir[]"]')
        checkBoxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('selecionarTodos').checked
        })
    })
</script>
</body>
</html>