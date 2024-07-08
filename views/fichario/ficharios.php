<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

$stmt_fic = "SELECT * FROM ficharios
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

    <title>Registro fichario</title>

</head>
<body>
    <table>
        <tr>
            <th>ARMÁRIOS</th>
            <th>GAVETAS</th>
            <th>PASTAS</th>
        </tr>
<?php
        while ($fichario = $stmt_fic_query->fetch_assoc()) {
            $arm = $fichario['arm'];
            $gav = $fichario['gav'];
            $pas = $fichario['pas'];
            $sql_fic = "SELECT codfam FROM fichario WHERE arm = '$arm' and gav = '$gav' AND pas = '$pas'";
            $sql_fic_query = $conn->query($sql_fic) or die("Error " . $conn - error);

            if ($sql_fic_query->num_rows == 0) {
?>
                <tr>
                    <td><?php echo $fichario['arm']; ?></td>
                    <td><?php echo $fichario['gav']; ?></td>
                    <td><?php echo $fichario['pas']; ?></td>
                </tr>
<?php
            } else {
              $dadinho = $sql_fic_query->fetch_assoc();
?>
                <tr>
                    <td><?php echo $fichario['arm']; ?></td>
                    <td><?php echo $fichario['gav']; ?></td>
                    <td><?php echo $fichario['pas']. ' - ('. $dadinho['codfam'] . ')'; ?></td>
                </tr>
<?php
            }
        }
?>
    </table>
<?php
  }
?>
</body>
</html>