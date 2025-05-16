<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';


    $stmt_up = $pdo->prepare("SELECT c.id,
            c.cod_familiar_fam AS cod_familiar,
            DATE_FORMAT(c.data_entrevista, '%d/%m/%Y') AS data_entrevista,
            c.tipo_documento,
            c.caminho_arquivo,
            c.operador,
            c.sit_beneficio,
            t.cod_familiar_fam
    FROM cadastro_forms c
    LEFT JOIN tbl_tudo t ON t.cod_familiar_fam = c.cod_familiar_fam
    WHERE t.cod_familiar_fam IS NULL AND c.certo != 1 AND YEAR(data_entrevista) < 2021 AND (c.operador = :operador OR c.operador = :cpfOperador)
    GROUP BY c.id
    ORDER BY c.criacao ASC
    ");
    $cpf_limpo = preg_replace('/\D/', '', $_SESSION['cpf']);
    $stmt_up->execute(array(
      'operador' => $_SESSION['nome_usuario'],
      'cpfOperador' => $cpf_limpo
    ));

      $data5yearsago = new DateTime();
      $data5yearsago->modify('-5 years');
        $data5yearsagoFormatada = $data5yearsago->format('Y-m-d');
    $stmt_up_5 = $pdo->prepare("SELECT id FROM cadastro_forms WHERE data_entrevista < :data5yearsago");
    $stmt_up_5->bindValue(":data5yearsago", $data5yearsagoFormatada);
    $stmt_up_5->execute();

    ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png" />
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/style-painel_entrevistador.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />


  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="/TechSUAS/js/uploadPcorrigir.js"></script>

  <title>Painel do Entrevistador - TechSUAS</title>
</head>

<body>

<?php
    if ($_SESSION['funcao'] == 1) {
        ?>
            <button type="button" onclick="excluir_arquivos()">EXCLUIR ARQUIVOS COM MAIS DE 5 ANOS</button>
        <?php
    }
?>

<table border="1" width="90%">
    <tr>
        <th>Seq.</th>
        <th>Código Familiar</th>
        <th>Data da Entrevista</th>
        <th>Tipo de Documento</th>
        <th>Ação</th>
    </tr>

    <?php
    $seq = 0;
    if ($stmt_up->rowCount() > 0 || $stmt_up_5->rowCount() > 0) {
        while ($abbc = $stmt_up->fetch(PDO::FETCH_ASSOC)) {
            $seq ++;
            ?>
    <tr>
        <td><?php echo $seq; ?></td>
        <td><?php echo $abbc['cod_familiar']; ?></td>
        <td><?php echo $abbc['data_entrevista']; ?></td>
        <td><?php echo $abbc['tipo_documento']; ?></td>
        <td>
            <a id="printArquivo" href="<?php echo $abbc['caminho_arquivo']?>" target="_blank" style="color: green; font-size: 16px; margin-right: 18px;">
                <i class="fa fa-download"></i>
            </a>
            <a id="editarArquivo" onclick="editarArquivo('<?php echo $abbc['id']; ?>', '<?php echo $abbc['data_entrevista']; ?>', '<?php echo $abbc['tipo_documento']; ?>', '<?php echo $abbc['cod_familiar_fam']; ?>')" style="cursor: poiter;">
                <i class="fas fa-edit"></i>
            </a>
            <a id="excluirArquivo" onclick="excluirArquivo('<?php echo $abbc['id']; ?>', '<?php echo $abbc['caminho_arquivo']?>')" style="color: red; margin-left: 18px; cursor: pointer;">
                <i class="fas fa-trash-alt"></i>
            </a>
            <a id="certo" onclick="certo('<?php echo $abbc['id']; ?>')" style="color: blue; margin-left: 18px; cursor: pointer;">
                <i class="material-symbols-outlined">task_alt</i>
            </a>
        </td>
    </tr>
            <?php
        }
    } else {
        header("location:/TechSUAS/views/cadunico/dashboard");
        exit;
    }
?>
</table>
</body>
</html>