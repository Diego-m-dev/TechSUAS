$(document).ready(function () {
    if ($("#grafico").length === 0) {
        console.error("O elemento #grafico não existe na página.");
        return;
    }

    fetch('/TechSUAS/peixe/php/dadosPgrafico.php')
        .then(response => response.json())
        .then(response => {
            if (response.encontrado && response.dados_local_entrega.length > 0) {
                $('#total').text(response.total_cadastros)
                let dados = response.dados_local_entrega.map(item => [item.x, item.value])
                
                // Criando o gráfico
                let chart = anychart.column3d()
                let series = chart.column(dados)

                    chart.title("Distribuição por Local de Entrega")
                    chart.yAxis().title("Quantidade")
                    chart.xAxis().title("Locais")

                chart.xAxis().labels()
                    .rotation(-90)
                    .fontSize(10)
                    .fontColor("#0c327e")
                chart.barGroupsPadding(0)
                chart.container("grafico")
                chart.draw()
            } else {
                console.warn('Nenhum dado encontrado para o gráfico.')
                document.getElementById("grafico").innerHTML = "<p style='color:red;'>Nenhum dado disponível</p>"
            }
        })
        .catch(error => console.error('Erro ao carregar dados:', error))
});
