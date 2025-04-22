<?php
// Configuração do banco de dados
$host = 'srv1898.hstgr.io';
$usuario = 'u444556286_pedidos';
$senha = 'wW1234(o';
$banco = 'u444556286_pedidos';
$port = 3306;

$conn = new mysqli($host, $usuario, $senha, $banco, $port);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Obtém o ano e o mês selecionados ou usa o mês atual se não for fornecido
$anoSelecionado = isset($_POST['ano']) ? $_POST['ano'] : date("Y");
$mesSelecionado = isset($_POST['mes']) ? $_POST['mes'] : date("m");

// Consulta para somar a quantidade de pedidos de Água no mês e ano selecionados
$sqlAgua = "SELECT SUM(quantidade) AS totalAgua FROM pedidos WHERE tipo='Água' AND YEAR(data) = $anoSelecionado AND MONTH(data) = $mesSelecionado";
$resultAgua = $conn->query($sqlAgua);

// Verifica se a consulta retornou resultados
if ($resultAgua->num_rows > 0) {
    $totalAgua = $resultAgua->fetch_assoc()['totalAgua'] ?? 0;
} else {
    $totalAgua = 0;
}

// Consulta para somar a quantidade de pedidos de Gás no mês e ano selecionados
$sqlGas = "SELECT SUM(quantidade) AS totalGas FROM pedidos WHERE tipo='Gás' AND YEAR(data) = $anoSelecionado AND MONTH(data) = $mesSelecionado";
$resultGas = $conn->query($sqlGas);

// Verifica se a consulta retornou resultados
if ($resultGas->num_rows > 0) {
    $totalGas = $resultGas->fetch_assoc()['totalGas'] ?? 0;
} else {
    $totalGas = 0;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <title>Pedidos - Água e Gás</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="pedidos.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">

        <form action="salvar_pedido.php" method="post">
            <div>
                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo">
                    <option value="Água">Água</option>
                    <option value="Gás">Gás</option>
                </select>
            </div>
            <div>
                <label for="local">Local:</label>
                <select id="local" name="local" required>
                    <option value="">Selecione o local</option>
                    <option value="CASA DE APOIO (APÓS 16H)">CASA DE APOIO</option>
                    <option value="SEDE ASSISTÊNCIA SOCIAL">SEDE ASSISTÊNCIA SOCIAL</option>
                    <option value="CRAS ANTONIO MATIAS">CRAS ANTONIO MATIAS</option>
                    <option value="CRAS SANTO AFONSO">CRAS SANTO AFONSO</option>
                    <option value="CREAS GILDO SOARES">CREAS GILDO SOARES</option>
                    <option value="CASA DOS CONSELHOS">CASA DOS CONSELHOS</option>
                    <option value="COZINHA COMUNITÁRIA">COZINHA COMUNITÁRIA</option>
                    <option value="CONSELHO TUTELAR">CONSELHO TUTELAR</option>
                    <option value="MILART">MILART</option>
                    <option value="LAR DOS ANJOS">LAR DOS ANJOS</option>
                </select>
            </div>
            <div>
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" required>
            </div>
            <div>
                <button type="submit">Enviar Pedido</button>
            </div>
        </form>

        <!-- Exibição da mensagem de sucesso após redirecionamento -->
        <?php
        if (isset($_GET['msg'])) {
            echo "<p>{$_GET['msg']}</p>";
        }
        ?>

        <!-- Formulário para selecionar o mês e ano -->
        <form method="POST" action="index.php">
            <div>
                <label for="mes">Mês:</label>
                <select name="mes" id="mes">
                    <option value="01" <?php echo $mesSelecionado == '01' ? 'selected' : ''; ?>>Janeiro</option>
                    <option value="02" <?php echo $mesSelecionado == '02' ? 'selected' : ''; ?>>Fevereiro</option>
                    <option value="03" <?php echo $mesSelecionado == '03' ? 'selected' : ''; ?>>Março</option>
                    <option value="04" <?php echo $mesSelecionado == '04' ? 'selected' : ''; ?>>Abril</option>
                    <option value="05" <?php echo $mesSelecionado == '05' ? 'selected' : ''; ?>>Maio</option>
                    <option value="06" <?php echo $mesSelecionado == '06' ? 'selected' : ''; ?>>Junho</option>
                    <option value="07" <?php echo $mesSelecionado == '07' ? 'selected' : ''; ?>>Julho</option>
                    <option value="08" <?php echo $mesSelecionado == '08' ? 'selected' : ''; ?>>Agosto</option>
                    <option value="09" <?php echo $mesSelecionado == '09' ? 'selected' : ''; ?>>Setembro</option>
                    <option value="10" <?php echo $mesSelecionado == '10' ? 'selected' : ''; ?>>Outubro</option>
                    <option value="11" <?php echo $mesSelecionado == '11' ? 'selected' : ''; ?>>Novembro</option>
                    <option value="12" <?php echo $mesSelecionado == '12' ? 'selected' : ''; ?>>Dezembro</option>
                </select>
            </div>
            <div>
                <label for="ano">Ano:</label>
                <select name="ano" id="ano">
                    <option value="<?php echo date("Y"); ?>" <?php echo $anoSelecionado == date("Y") ? 'selected' : ''; ?>><?php echo date("Y"); ?></option>
                    <option value="<?php echo date("Y") - 1; ?>" <?php echo $anoSelecionado == (date("Y") - 1) ? 'selected' : ''; ?>><?php echo date("Y") - 1; ?></option>
                </select>
            </div>
            <button type="submit">Mostrar Totais</button>
        </form>

        <div class="totais">
            <h2>Resumo dos Pedidos</h2>
            <p>Total de Água no Mês <?php echo $mesSelecionado; ?>/<?php echo $anoSelecionado; ?>: <?php echo $totalAgua; ?></p>
            <p>Total de Gás no Mês <?php echo $mesSelecionado; ?>/<?php echo $anoSelecionado; ?>: <?php echo $totalGas; ?></p>
        </div>
        
    </div>
    <footer><img src="footer.svg" alt=""></footer>
</body>

</html>
