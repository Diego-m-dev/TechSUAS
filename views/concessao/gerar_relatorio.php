<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';

$data1 = date('Y');
$data2 = $data1 - 8;
$data3 = $data1 - 7;
$data4 = $data1 - 6;
$data5 = $data1 - 5;
$data6 = $data1 - 4;
$data7 = $data1 - 3;
$data8 = $data1 - 2;
$data9 = $data1 - 1;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Relatório Concessão</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_gerar_form.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/concessao.js"></script>
</head>

<body>

<form action="" method="POST">
    <label>Mês de Pagamento</label>
        <select name="mes_pg" id="mes_pg" required>
            <option value="" disabled selected hidden>Selecione</option>
            <option value="Janeiro">Janeiro</option>
            <option value="Fevereiro">Fevereiro</option>
            <option value="Março">Março</option>
            <option value="Abril">Abril</option>
            <option value="Maio">Maio</option>
            <option value="Junho">Junho</option>
            <option value="Julho">Julho</option>
            <option value="Agosto">Agosto</option>
            <option value="Setembro">Setembro</option>
            <option value="Outubro">Outubro</option>
            <option value="Novembro">Novembro</option>
            <option value="Dezembro">Dezembro</option>
        </select>

        <label>ANO</label>
        <select id="ano_select" name="ano_select" required>
            <option value="" disabled selected hidden>Selecione</option>
            <option value="<?php echo $data9; ?>"><?php echo $data9; ?></option>
            <option value="<?php echo $data1; ?>"><?php echo $data1; ?></option>
        </select>
        <button type="submit">GERAR</button>
</form>
<?php
if (!isset($_POST['ano_select'])){
} else {

    ob_end_clean();
    require('../../pdf_combo/fpdf.php');

    $mes_pago = $_POST['mes_pg'];
    $ano_select = $_POST['ano_select'];

    $stmt_gera_relatorio = $pdo->prepare("SELECT * FROM concessao_historico WHERE ano_form = :ano_form");
    $stmt_gera_relatorio->bindParam(':ano_form', $ano_select, PDO::PARAM_STR);
    $stmt_gera_relatorio->execute();

    ?>

    <?php

    if ($stmt_gera_relatorio->rowCount() > 0) {
        while ($dados_hist = $stmt_gera_relatorio->fetch(PDO::FETCH_ASSOC)) {
            echo $dados_hist['nome_benef'] . '<br>';
        }
    
    }
?>
<button type="button" id="btn_new_consulta">NOVA CONSULTA</button>
<button type="button" id="btn_immprimir">IMPRIMIR</button>
<?php
}
?>
<script>
$(document).ready(function () {
    $('#btn_new_consulta').click(function () {
        window.location.href = 'TechSUAS/views/concessao/gerar_relatorio'
    })
})
</script>
</body>
</html>