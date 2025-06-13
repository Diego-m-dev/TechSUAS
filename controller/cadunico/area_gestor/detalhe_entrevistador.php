<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

if (!isset($_POST['detalhe']) || empty($_POST['detalhe'])) {
    echo '<script>window.history.back()</script>';
    exit();
}

$entrevistador = $_POST['detalhe'];

// Consulta principal (todos os cadastros)
$stmt_cadastro = $conn->prepare("SELECT * FROM tbl_tudo
    WHERE nom_entrevistador_fam LIKE ?
    AND cod_parentesco_rf_pessoa = 1
    ORDER BY dat_atual_fam DESC");
$param = $entrevistador;
$stmt_cadastro->bind_param("s", $param);
$stmt_cadastro->execute();
$result_cadastro = $stmt_cadastro->get_result();

// Copia os dados para reutilização
$registros = [];
while ($row = $result_cadastro->fetch_assoc()) {
    $registros[] = $row;
}

// Consulta de visitas
$stmt_visitas = $conn->prepare("SELECT COUNT(*) AS quantidade_visitas
    FROM visitas_feitas
    WHERE entrevistador = ?");
$stmt_visitas->bind_param("s", $entrevistador);
$stmt_visitas->execute();
$result_visitas = $stmt_visitas->get_result();
$quant_visita = $result_visitas->fetch_assoc();

// Consulta para gráfico por ano
$stmt_ano = $conn->prepare("SELECT YEAR(dat_atual_fam) AS ano, COUNT(*) AS total
    FROM tbl_tudo
    WHERE nom_entrevistador_fam LIKE ?
    AND cod_parentesco_rf_pessoa = 1
    GROUP BY YEAR(dat_atual_fam)
    ORDER BY dat_atual_fam DESC");
$stmt_ano->bind_param("s", $param);
$stmt_ano->execute();
$result_ano = $stmt_ano->get_result();
$dados_ano = [];
while ($row = $result_ano->fetch_assoc()) {
    $dados_ano[] = $row;
}

// Consulta para gráfico por mês
$stmt_mes = $conn->prepare("SELECT DATE_FORMAT(dat_atual_fam, '%Y-%m') AS mes, COUNT(*) AS total
    FROM tbl_tudo
    WHERE nom_entrevistador_fam LIKE ?
    AND cod_parentesco_rf_pessoa = 1
    GROUP BY DATE_FORMAT(dat_atual_fam, '%Y-%m')
    ORDER BY dat_atual_fam DESC");
$stmt_mes->bind_param("s", $param);
$stmt_mes->execute();
$result_mes = $stmt_mes->get_result();
$dados_mes = [];
while ($row = $result_mes->fetch_assoc()) {
    $dados_mes[] = $row;
}

$conn->close();

function formatarData($data) {
    if (empty($data)) return "Data não fornecida.";
    $dt = DateTime::createFromFormat('Y-m-d', $data);
    return $dt ? $dt->format('d/m/Y') : "Data inválida.";
}

function formatarCPF($cpf) {
    $cpf = sprintf('%011s', preg_replace('/\D/', '', $cpf));
    return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Entrevistador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/area_gestor/gestor.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<a href="/TechSUAS/views/cadunico/area_gestao/index">
    <i class="fas fa-arrow-left"></i> Voltar
</a>

<?php if (count($registros) === 0): ?>
    <p>Nenhum cadastro encontrado para esse Entrevistador.</p>
<?php else: ?>
    <h2>Todos os cadastros realizados por <?= htmlspecialchars($entrevistador) ?></h2>
    <span>CPF do Entrevistador: <?= formatarCPF($registros[0]['num_cpf_entrevistador_fam']) ?></span>
    <p>Em todo o tempo no Cadastro Único já realizou <?= $quant_visita['quantidade_visitas'] . ($quant_visita['quantidade_visitas'] == 1 ? " visita." : " visitas.") ?></p>

    <a class="menu-button" href="/TechSUAS/views/cadunico/visitas/accompany_visits">
        <span class="material-symbols-outlined">library_add</span>
        Confira as visitas aqui
    </a>

    <!-- Gráfico por Ano -->
    <h3>Cadastros por Ano</h3>
    <canvas id="graficoAno"></canvas>

    <!-- Gráfico por Mês -->
    <h3>Cadastros por Mês</h3>
    <canvas id="graficoMes"></canvas>

    <!-- Tabela -->
    <table border="1">
        <tr>
            <th>CÓDIGO FAMILIAR</th>
            <th>NOME RUF</th>
            <th>DATA ATUALIZAÇÃO</th>
            <th>DATA ENTREVISTA</th>
        </tr>
        <?php foreach ($registros as $a): ?>
            <?php $classe_css = ($a['dat_atual_fam'] !== $a['dta_entrevista_fam']) ? 'destaque' : ''; ?>
            <tr class="<?= $classe_css ?>">
                <td><?= htmlspecialchars($a['cod_familiar_fam']) ?></td>
                <td><?= htmlspecialchars($a['nom_pessoa']) ?></td>
                <td><?= formatarData($a['dat_atual_fam']) ?></td>
                <td><?= formatarData($a['dta_entrevista_fam']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<!-- Scripts dos gráficos -->
<script>
const dadosAno = <?= json_encode($dados_ano) ?>;
const labelsAno = dadosAno.map(item => item.ano);
const dataAno = dadosAno.map(item => item.total);

const dadosMes = <?= json_encode($dados_mes) ?>;
const labelsMes = dadosMes.map(item => item.mes);
const dataMes = dadosMes.map(item => item.total);

// Gráfico por Ano
new Chart(document.getElementById('graficoAno').getContext('2d'), {
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
            y: { beginAtZero: true }
        }
    }
});

// Gráfico por Mês
new Chart(document.getElementById('graficoMes').getContext('2d'), {
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
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
