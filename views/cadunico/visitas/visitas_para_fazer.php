<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

$sql_ano = "SELECT DISTINCT YEAR(dat_atual_fam) AS ano FROM tbl_tudo ORDER BY ano DESC";
$result_sql_ano = $conn->query($sql_ano);

if (!$result_sql_ano) {
    die("ERRO ao consultar! " . $conn->error);
}

$anos = [];
while ($d = $result_sql_ano->fetch_assoc()) {
    $anos[] = $d['ano'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Visitas Pendentes - TechSUAS</title>

    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/visitas_pend.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/cadunico/visitas/h1-visitas_pend.svg" alt="NoImage">
        </h1>
    </div>
    <div class="bloco">
        <div>
            <form action=''>
                <label for="">Selecione ano e mês:
    <select name="mes_select" id="mes_select">
        <option value="" disabled selected hidden>Mês</option>
        <option value="01">Janeiro</option>
        <option value="02">Fevereiro</option>
        <option value="03">Março</option>
        <option value="04">Abril</option>
        <option value="05">Maio</option>
        <option value="06">Junho</option>
        <option value="07">Julho</option>
        <option value="08">Agosto</option>
        <option value="09">Setembro</option>
        <option value="10">Outubro</option>
        <option value="11">Novembro</option>
        <option value="12">Dezembro</option>
    </select>

    <select id="ano_select" name="ano_select">
        <option value="" disabled selected hidden>Ano</option>
<?php
foreach ($anos as $ano) {
    echo "<option value='$ano'>$ano</option>";
}
?>
    </select>
    </label>

    <label>Fitre a localidade:</label>
        <input name="localidade" class="busca2" placeholder="Qual localdade" type="text">
            <button type="submit" id="buscar">Buscar</button>
            <a href="index">
                <span class="fas fa-arrow-left"></span>
                Voltar
            </a>
        </form>


        </div>
    </div>
    <?php include '../../../controller/cadunico/parecer/tbl_tudo.php'; ?>
    <script src='/TechSUAS/js/personalise.js'></script>
    <script>
        // Verifica se a tabela possui pelo menos duas linhas com conteúdo
        var hasContent = false;
        var contentCount = 0; // Contador para linhas com conteúdo

        for (var i = 0; i < table.rows.length; i++) {
            if (table.rows[i].cells[0].textContent.trim() !== "") {
                contentCount++; // Incrementa o contador se a primeira célula tiver conteúdo
                if (contentCount >= 2) { // Verifica se já há pelo menos duas linhas com conteúdo
                    hasContent = true;
                    break;
                }
            }
        }   

        // Exibe ou oculta o botão de acordo com a presença de conteúdo (mínimo 2 linhas)
        if (hasContent) {
            button.style.display = "block";
        } else {
            button.style.display = "none";
        }
    </script>
</body>

</html>