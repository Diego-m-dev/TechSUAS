<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/config/sessao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSUAS - Visitas</title>
    <link rel="stylesheet" href="../../css/visitas.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="../../img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <nav>
      <div class="img">
        <h1 class="titulo-com-imagem">
          <img src="../../img/h1-vistas.svg" alt="Titulocomimagem">
        </h1>
      </div>
      <div class="container">
        <div class="btns">
          <div class="buscarvisitas">
            <button class="menu-button" onclick="location.href='buscarvisita.php';">
              <span class="material-symbols-outlined">
                manage_search
              </span>
              Buscar visitas realizadas
            </button>
          </div>
          <div class="visitas_n">
            <button class="menu-button" onclick="location.href='visitas_para_fazer.php';">
              <span class="material-symbols-outlined">
                person_search
              </span>
              Visitas não realizadas
            </button>
          </div>

          <div class="parecer">
            <button class="menu-button" onclick="location.href='registrar.php';">
              <span class="material-symbols-outlined">
                forum
              </span>
              Registrar
            </button>
          </div>

          <div class="voltar">
            <a href="/Suas-Tech/controller/back.php" class="menu-button">
              <span class="fas fa-arrow-left">
              </span>
              Voltar ao menu
            </a>
          </div>
        </div>
        <div class="grafico">
          <canvas id="graficoPizza"></canvas>
        </div>
      </div>
    </nav>
    <?php

// Consulta SQL
$sql_ano = 'SELECT YEAR(dat_atual_fam) AS ano, COUNT(*) AS quantidade
FROM tbl_tudo
WHERE cod_parentesco_rf_pessoa = 1
GROUP BY YEAR(dat_atual_fam)
ORDER BY ano DESC';
$resultado_p_ano = $conn->query($sql_ano);

// Crie arrays para armazenar os anos e quantidades
$anos = [];
$quantidades = [];

while ($linha = $resultado_p_ano->fetch_assoc()) {
    $anos[] = $linha['ano'];
    $quantidades[] = $linha['quantidade'];
}

//dados totais dos registros de visitas
$sqlr = "SELECT COUNT(*) as total_visitas FROM visitas_feitas";
$result = $pdo->query($sqlr);
$row = $result->fetch(PDO::FETCH_ASSOC);
$totalRegistros = $row['total_visitas'];
$numero_parecer = $totalRegistros;

//$sql = "SELECT * FROM tbl_tudo WHERE dat_atual_fam LIKE '%$sql_ano%'";
?>
    <script>
    // Dados para o gráfico de pizza
    var anos = <?php echo json_encode($anos); ?>;
    var quantidades = <?php echo json_encode($quantidades); ?>;
    var volaroe = <?php echo $totalRegistros; ?>;

    // Adiciona volaroe às quantidades
    quantidades.push(volaroe);

    // Crie o gráfico de pizza
    var ctx = document.getElementById('graficoPizza').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: anos.concat([volaroe]),
            datasets: [{
                data: quantidades,
                backgroundColor: ['#13294b', '#065f33', '#8b0000', '#cd5c5c', '#008080', '#2e8b57', '#00ff00', '#ff9900']
            }]
        },
        options: {
        responsive: true,
        legend: {
            display: true, // Exibe a legenda
            position: 'bottom', // Posição da legenda (pode ser 'top', 'bottom', 'left', 'right')
            labels: {
                fontColor: 'black', // Cor do texto da legenda
                fontSize: 12 // Tamanho do texto da legenda
            }
        }
    }
    });
    </script>
    <script src='../../../controller/back.js'></script>
  </body>
</html>
