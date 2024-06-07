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
    <title>Visitas pendentes</title>
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
                <select id="ano_select" name="ano_select">
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="<?php echo $data2; ?>"><?php echo $data2; ?></option>
                    <option value="<?php echo $data3; ?>"><?php echo $data3; ?></option>
                    <option value="<?php echo $data4; ?>"><?php echo $data4; ?></option>
                    <option value="<?php echo $data5; ?>"><?php echo $data5; ?></option>
                    <option value="<?php echo $data6; ?>"><?php echo $data6; ?></option>
                    <option value="<?php echo $data7; ?>"><?php echo $data7; ?></option>
                    <option value="<?php echo $data8; ?>"><?php echo $data8; ?></option>
                    <option value="<?php echo $data9; ?>"><?php echo $data9; ?></option>
                    <option value="<?php echo $data1; ?>"><?php echo $data1; ?></option>
                </select>
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