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
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <title>Detalhes do Entrevistador</title>
</head>
<body>
  <h1>Relatório de Visitas</h1>
  <a href="/TechSUAS/views/cadunico/area_gestao/index">
    <i class="fas fa-arrow-left"></i> Voltar
</a>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

$cpf_entrevistador = $_POST['cpf_entrevistador'];
$nome_entrevistador = $_POST['nome_entrevistador'];

?>
  <h2>No Cadastro Único</h2>
        <!-- Gráfico por Ano -->
        <h3>Visitas por Ano</h3>
        <canvas id="graficoAno"></canvas>

        <!-- Gráfico por Mês -->
        <h3>Visitas por Mês</h3>
        <canvas id="graficoMes"></canvas>

<?php

$stmt_cadastro = "SELECT cod_familiar_fam, nom_pessoa FROM tbl_tudo
            WHERE num_cpf_entrevistador_fam
            LIKE '$cpf_entrevistador'
            AND cod_parentesco_rf_pessoa = 1
            AND cod_forma_coleta_fam = 2
            ORDER BY cod_familiar_fam ASC";
  $stmt_query = $conn->query($stmt_cadastro) or die("ERRO ao consultar !" . $conn - error);

  $stmt_visitas = "SELECT COUNT(*) AS quantidade_visitas
                    FROM tbl_tudo
                    WHERE num_cpf_entrevistador_fam = '$cpf_entrevistador'
                    AND cod_forma_coleta_fam = 2
                    AND cod_parentesco_rf_pessoa = 1";
                    
  $stmt_query_visitas = $conn->query($stmt_visitas) or die("ERRO ao consultar !" . $conn - error);
  $quant_visita = $stmt_query_visitas->fetch_assoc();

  echo "Total de visitas no Cadastro Único: ". $quant_visita['quantidade_visitas']. "<br>";

  if ($stmt_query->num_rows == 0) {
    echo "Nenhum cadastro encontrado para esse Entrevistador.";
  } else {
    ?>
    <table border="1">
      <tr>
        <th>CÓDIGO FAMILIAR</th>
        <th>NOME RUF</th>
      </tr>

    <?php
    while ($a = $stmt_query->fetch_assoc()) {
      ?>
      <tr class="">
          <td><?php echo $a['cod_familiar_fam']; ?></td>
          <td><?php echo $a['nom_pessoa']; ?></td>
<?php  

    }
?>
    </table>
<?php
  }

  ?>
  <h2>No TechSUAS</h2>
        <!-- Gráfico por Ano -->
        <h3>Visitas por Ano</h3>
        <canvas id="graficoAnoTech"></canvas>

        <!-- Gráfico por Mês -->
        <h3>Visitas por Mês</h3>
        <canvas id="graficoMesTech"></canvas>

<?php
  // Query para obter as contagens de cadastros por ano
  $stmt_ano = "SELECT YEAR(dat_atual_fam) AS ano, COUNT(*) AS total
  FROM tbl_tudo
  WHERE num_cpf_entrevistador_fam = '$cpf_entrevistador'
  AND cod_forma_coleta_fam = 2
  AND cod_parentesco_rf_pessoa = 1
  GROUP BY YEAR(dat_atual_fam)
  ORDER BY dat_atual_fam DESC";

$query_ano = $conn->query($stmt_ano) or die("ERRO ao consultar !" . $conn->error);
$dados_ano = [];
while ($row = $query_ano->fetch_assoc()) {
$dados_ano[] = $row;
}

  // Query para obter as contagens de cadastros por ano no TechSUAS
  $stmt_anotech = "SELECT YEAR(data) AS anotech, COUNT(*) AS totaltech
  FROM visitas_feitas
  WHERE entrevistador = '$nome_entrevistador'
  GROUP BY YEAR(data)
  ORDER BY data DESC";

$query_anotech = $conn->query($stmt_anotech) or die("ERRO ao consultar !" . $conn->error);
$dados_anotech = [];
while ($row = $query_anotech->fetch_assoc()) {
$dados_anotech[] = $row;
}

// Query para obter as contagens de cadastros por mês
$stmt_mes = "SELECT DATE_FORMAT(dat_atual_fam, '%Y-%m') AS mes, COUNT(*) AS total
  FROM tbl_tudo
  WHERE num_cpf_entrevistador_fam = '$cpf_entrevistador'
  AND cod_parentesco_rf_pessoa = 1
  AND cod_forma_coleta_fam = 2
  GROUP BY DATE_FORMAT(dat_atual_fam, '%Y-%m')
  ORDER BY dat_atual_fam DESC";

$query_mes = $conn->query($stmt_mes) or die("ERRO ao consultar !" . $conn->error);
$dados_mes = [];
while ($row = $query_mes->fetch_assoc()) {
$dados_mes[] = $row;
}

// Query para obter as contagens de cadastros por mês TechSUAS
$stmt_mestech = "SELECT DATE_FORMAT(data, '%Y-%m') AS mestech, COUNT(*) AS totaltech
  FROM visitas_feitas
  WHERE entrevistador = '$nome_entrevistador'
  GROUP BY DATE_FORMAT(data, '%Y-%m')
  ORDER BY data DESC";

$query_mestech = $conn->query($stmt_mestech) or die("ERRO ao consultar !" . $conn->error);
$dados_mestech = [];
while ($row = $query_mestech->fetch_assoc()) {
$dados_mestech[] = $row;
}

$conn->close();
$conn_1->close();
?>
<script>
        // Dados para o gráfico por ano
        const dadosAno = <?php echo json_encode($dados_ano); ?>;
        const labelsAno = dadosAno.map(item => item.ano);
        const dataAno = dadosAno.map(item => item.total);

        // Dados para o gráfico por mês
        const dadosMes = <?php echo json_encode($dados_mes); ?>;
        const labelsMes = dadosMes.map(item => item.mes);
        const dataMes = dadosMes.map(item => item.total);

        // Gráfico por Ano
        const ctxAno = document.getElementById('graficoAno').getContext('2d');
        const graficoAno = new Chart(ctxAno, {
            type: 'bar',
            data: {
                labels: labelsAno,
                datasets: [{
                    label: 'Cadastros por Ano',
                    data: dataAno,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico por Mês
        const ctxMes = document.getElementById('graficoMes').getContext('2d');
        const graficoMes = new Chart(ctxMes, {
            type: 'line',
            data: {
                labels: labelsMes,
                datasets: [{
                    label: 'Cadastros por Mês',
                    data: dataMes,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


    <script>
        // Dados para o gráfico por ano
        const dadosAnotech = <?php echo json_encode($dados_anotech); ?>;
        const labelsAnotech = dadosAnotech.map(item => item.anotech);
        const dataAnotech = dadosAnotech.map(item => item.totaltech);

        // Dados para o gráfico por mês
        const dadosMestech = <?php echo json_encode($dados_mestech); ?>;
        const labelsMestech = dadosMestech.map(item => item.mestech);
        const dataMestech = dadosMestech.map(item => item.totaltech);

        // Gráfico por Ano
        const ctxAnotech = document.getElementById('graficoAnoTech').getContext('2d');
        const graficoAnotech = new Chart(ctxAnotech, {
            type: 'bar',
            data: {
                labels: labelsAnotech,
                datasets: [{
                    label: 'Visitas por Ano',
                    data: dataAnotech,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        })
        // Gráfico por Mês
        const ctxMestech = document.getElementById('graficoMesTech').getContext('2d');
        const graficoMestech = new Chart(ctxMestech, {
            type: 'line',
            data: {
                labels: labelsMestech,
                datasets: [{
                    label: 'Visitas por Mês',
                    data: dataMestech,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        })
    </script>
</body>
</html>