<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';


  $data5yearsago = new DateTime();
  $data5yearsago->modify('-5 years');
	$data5yearsagoFormatada = $data5yearsago->format('Y-m-d');
    $stmt_up_5 = $pdo->prepare("SELECT id, cod_familiar_fam, DATE_FORMAT(data_entrevista, '%d/%m/%Y') AS data_entrevista, tipo_documento, operador FROM cadastro_forms WHERE data_entrevista < :data5yearsago");
    $stmt_up_5->bindValue(":data5yearsago", $data5yearsagoFormatada);
    $stmt_up_5->execute();
    ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png" />
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/td.css" />
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

<table style="align-items: center;" width="90%">
    <tr>
        <th>Seq.</th>
        <th>Código Familiar</th>
        <th>Data da Entrevista</th>
        <th>Tipo de Documento</th>
        <th>Operador</th>
    </tr>

    <?php
    $seq = 0;
    if ($stmt_up_5->rowCount() > 0) {
        while ($abbc = $stmt_up_5->fetch(PDO::FETCH_ASSOC)) {
            $seq ++;
            ?>
    <tr class="destaque">
        <td><?php echo $seq; ?></td>
        <td style="display: flex; align-items: center; gap: 5px;">
					<pre><?php echo $abbc['cod_familiar_fam']; ?></pre>
						<a onclick='copiarTexto(this)' style="cursor: pointer;">
        			<i class="material-symbols-outlined">content_copy</i>
						</a>
				</td>
        <td><?php echo $abbc['data_entrevista']; ?></td>
        <td><?php echo $abbc['tipo_documento']; ?></td>
        <td><?php echo $abbc['operador']; ?></td>

    </tr>
    <tr id="linhaPDF_<?php echo $seq; ?>" style="display: none;">
        <td colspan="5">
            <iframe id="iframePDF_<?php echo $seq; ?>" width="100%" height="500px" style="border: 1px solid #ccc;"></iframe>
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