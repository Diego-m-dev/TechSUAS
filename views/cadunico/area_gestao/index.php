<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_ag_cad.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <title>Área Gestor</title>
</head>
<body>
    <canvas id="myChart"></canvas>

    <script>
        // Recuperar os dados do PHP
        var data = <?php echo json_encode($data); ?>;

        // Processar os dados para o gráfico
        var labels = [];
        var dataValues = [];

        data.forEach(function(item) {
            if (labels.includes(item.IN_PROCESSO)) {
                var index = labels.indexOf(item.IN_PROCESSO);
                dataValues[index]++;
            } else {
                labels.push(item.IN_PROCESSO);
                dataValues.push(1);
            }
        });

        // Criar o gráfico
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Quantidade de Cadastros',
                    data: dataValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
