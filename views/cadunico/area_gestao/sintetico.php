<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

// Calcular idade (0 a 6 anos)
$sql = "
    SELECT 
        cod_sexo_pessoa,
        cod_raca_cor_pessoa,
        cod_deficiencia_memb,
        bairro, 
        COUNT(*) as total
    FROM tbl_tudo
    WHERE TIMESTAMPDIFF(YEAR, dta_nasc_pessoa, CURDATE()) BETWEEN 0 AND 6
    GROUP BY cod_sexo_pessoa, cod_raca_cor_pessoa, cod_deficiencia_memb, bairro
";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$jsonData = json_encode($data);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/fichario/style_arquivo.css">


    <title>Estudo Sintético - Crianças 0 a 6 anos</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/fichario.js"></script>

</head>

<body>
    <h2>Estudo Sintético (0 a 6 anos)</h2>

    <div style="width:45%; float:left;">
        <canvas id="sexoChart"></canvas>
    </div>
    <div style="width:45%; float:left;">
        <canvas id="corChart"></canvas>
    </div>
    <div style="width:45%; float:left;">
        <canvas id="defChart"></canvas>
    </div>
    <div style="width:45%; float:left;">
        <canvas id="bairroChart"></canvas>
    </div>

    <h3>Tabela Resumida</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Sexo</th>
            <th>Cor/Raça</th>
            <th>Deficiência</th>
            <th>Bairro</th>
            <th>Total</th>
        </tr>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['cod_sexo_pessoa'] == 1 ? 'Homem' : 'Mulher' ?></td>
            <td>
                <?php
                $cores = [1=>'Branca', 2=>'Preta', 3=>'Amarela', 4=>'Parda', 5=>'Indígena'];
                echo $cores[$row['cod_raca_cor_pessoa']] ?? 'Não informado';
                ?>
            </td>
            <td><?= $row['cod_deficiencia_memb'] == 1 ? 'Sim' : 'Não' ?></td>
            <td><?= $row['bairro'] ?></td>
            <td><?= $row['total'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script>
        const rawData = <?= $jsonData ?>;

        // Função para agrupar
        function groupBy(arr, key) {
            return arr.reduce((acc, obj) => {
                let k = obj[key];
                acc[k] = (acc[k] || 0) + parseInt(obj.total);
                return acc;
            }, {});
        }

        // Sexo
        let sexoMap = {1: 'Homem', 2: 'Mulher'};
        let sexoData = groupBy(rawData, 'cod_sexo_pessoa');
        new Chart(document.getElementById('sexoChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(sexoData).map(k => sexoMap[k]),
                datasets: [{data: Object.values(sexoData)}]
            }
        });

        // Cor/Raça
        let corMap = {1:'Branca',2:'Preta',3:'Amarela',4:'Parda',5:'Indígena'};
        let corData = groupBy(rawData, 'cod_raca_cor_pessoa');
        new Chart(document.getElementById('corChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(corData).map(k => corMap[k]),
                datasets: [{label:'Por Cor/Raça', data: Object.values(corData)}]
            }
        });

        // Deficiência
        let defMap = {1:'Sim', 2:'Não'};
        let defData = groupBy(rawData, 'cod_deficiencia_memb');
        new Chart(document.getElementById('defChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(defData).map(k => defMap[k]),
                datasets: [{data: Object.values(defData)}]
            }
        });

        // Bairro
        let bairroData = groupBy(rawData, 'bairro');
        new Chart(document.getElementById('bairroChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(bairroData),
                datasets: [{label:'Por Bairro', data: Object.values(bairroData)}]
            }
        });
    </script>
</body>

</html>
