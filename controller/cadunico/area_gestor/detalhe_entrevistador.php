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
<a href="/TechSUAS/views/cadunico/area_gestao/index">
    <i class="fas fa-arrow-left"></i> Voltar
</a>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

if (!isset($_POST['detalhe']) && empty($_POST['detalhe'])) {
    echo '<script>window.history.back()</script>';
    exit();
}

$entrevistador = $_POST['detalhe'];

$stmt_cadastro = "SELECT nom_entrevistador_fam, num_cpf_entrevistador_fam, dat_atual_fam, dta_entrevista_fam, cod_familiar_fam, nom_pessoa FROM tbl_tudo
                    WHERE nom_entrevistador_fam
                    LIKE '$entrevistador'
                    AND cod_parentesco_rf_pessoa = 1
                    ORDER BY dat_atual_fam DESC";

$stmt_visitas = "SELECT COUNT(*) AS quantidade_visitas
                    FROM visitas_feitas
                    WHERE entrevistador = '$entrevistador'";

$stmt_query = $conn->query($stmt_cadastro) or die("ERRO ao consultar !" . $conn - error);
$stmt_query_visitas = $conn->query($stmt_visitas) or die("ERRO ao consultar !" . $conn - error);
    $quant_visita = $stmt_query_visitas->fetch_assoc();
if ($stmt_query->num_rows == 0) {
    echo "Nenhum cadastro encontrado para esse Entrevistador.";
} else {
    $b = $stmt_query->fetch_assoc();
    ?>
<h2>Todos os cadastros realizado por <?php echo $_POST['detalhe']; ?></h2>
<span>CPF do Entrevistador: <?php $cpf_entrevist = $b['num_cpf_entrevistador_fam'];
    $cpf_formatado = sprintf('%011s', $cpf_entrevist);
    $cpf_formatado = substr($cpf_formatado, 0, 3) . '.' . substr($cpf_formatado, 3, 3) . '.' . substr($cpf_formatado, 6, 3) . '-' . substr($cpf_formatado, 9, 2);
    echo $cpf_formatado;
    ?></span>
    <p> O entrevistador(a) já realizou <?php echo $quant_visita['quantidade_visitas'] == 1 ? $quant_visita['quantidade_visitas']. " visita." : $quant_visita['quantidade_visitas']. ' visitas.'; ?></p>
    <a class="menu-button" onclick="location.href='/TechSUAS/views/cadunico/visitas/accompany_visits';">
            <span class="material-symbols-outlined">
                    library_add
            </span>
        Confira as visitas aqui
    </a>
    <form action="/TechSUAS/views/cadunico/area_gestao/relatorio_entrevistador" method="post">
      <input type="hidden" value="<?php echo $cpf_entrevist; ?>" name="cpf_entrevistador"/>
      <input type="hidden" value="<?php echo $b['nom_entrevistador_fam']; ?>" name="nome_entrevistador"/>
      <button type="submit">Gerar relatório de visitas</button>
    </form>
        <!-- Gráfico por Ano -->
        <h3>Cadastros por Ano</h3>
        <canvas id="graficoAno"></canvas>

        <!-- Gráfico por Mês -->
        <h3>Cadastros por Mês</h3>
        <canvas id="graficoMes"></canvas>

<table border="1">
    <tr>
        <th>CÓDIGO FAMILIAR</th>
        <th>NOME RUF</th>
        <th>DATA ATUALIZAÇÃO</th>
        <th>DATA ENTREVISTA</th>
    </tr>
    <?php
while ($a = $stmt_query->fetch_assoc()) {
    $classe_css = ($a['dat_atual_fam'] != $a['dta_entrevista_fam']) ? 'destaque' : ''; // Verifica se as datas são diferentes e define a classe CSS
        ?>
    <tr class="<?php echo $classe_css; ?>">
        <td><?php echo $a['cod_familiar_fam']; ?></td>
        <td><?php echo $a['nom_pessoa']; ?></td>
        <td><?php $dataA = $a['dat_atual_fam'];
        if (!empty($dataA)) {
            $formatando_data = DateTime::createFromFormat('Y-m-d', $dataA);
        
            // Verifica se a data foi criada corretamente
            if ($formatando_data) {
                $data_formatada = $formatando_data->format('d/m/Y');
                echo $data_formatada;
            } else {
                echo "Data inválida.";
            }
        } else {
            echo "Data não fornecida.";
        }
        ?></td>
        <td><?php $dataE = $a['dta_entrevista_fam'];
        if (!empty($dataE)) {
            $formatando_data = DateTime::createFromFormat('Y-m-d', $dataE);
        
            // Verifica se a data foi criada corretamente
            if ($formatando_data) {
                $data_formatada = $formatando_data->format('d/m/Y');
                echo $data_formatada;
            } else {
                echo "Data inválida.";
            }
        } else {
            echo "Data não fornecida.";
        }
        ?></td>
    </tr>
    <?php
}
    ?>
</table>
<?php

// Query para obter as contagens de cadastros por ano
    $stmt_ano = "SELECT YEAR(dat_atual_fam) AS ano, COUNT(*) AS total
            FROM tbl_tudo
            WHERE nom_entrevistador_fam LIKE '$entrevistador'
            AND cod_parentesco_rf_pessoa = 1
            GROUP BY YEAR(dat_atual_fam)
            ORDER BY dat_atual_fam DESC";

    $query_ano = $conn->query($stmt_ano) or die("ERRO ao consultar !" . $conn->error);
    $dados_ano = [];
    while ($row = $query_ano->fetch_assoc()) {
        $dados_ano[] = $row;
    }

    // Query para obter as contagens de cadastros por mês
    $stmt_mes = "SELECT DATE_FORMAT(dat_atual_fam, '%Y-%m') AS mes, COUNT(*) AS total
            FROM tbl_tudo
            WHERE nom_entrevistador_fam LIKE '$entrevistador'
            AND cod_parentesco_rf_pessoa = 1
            GROUP BY DATE_FORMAT(dat_atual_fam, '%Y-%m')
            ORDER BY dat_atual_fam DESC";

    $query_mes = $conn->query($stmt_mes) or die("ERRO ao consultar !" . $conn->error);
    $dados_mes = [];
    while ($row = $query_mes->fetch_assoc()) {
        $dados_mes[] = $row;
    }
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

</body>
</html>