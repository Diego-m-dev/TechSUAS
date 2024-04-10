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
                <select id="local" name="local" required><!-- Adicionando o atributo required -->
                    <option value="">Selecione o local</option><!-- Opção padrão vazia -->
                    <option value="SEDE ASSISTÊNCIA SOCIAL">SEDE ASSISTÊNCIA SOCIAL</option>
                    <option value="CRAS ANTONIO MATIAS">CRAS ANTONIO MATIAS</option>
                    <option value="CRAS SANTO AFONSO">CRAS SANTO AFONSO</option>
                    <option value="CREAS GILDO SOARES">CREAS GILDO SOARES</option>
                    <option value="CASA DOS CONSELHOS">CASA DOS CONSELHOR</option>
                    <option value="COZINHA COMUNITÁRIA">COZINHA COMUNITÁRIA</option>
                    <option value="CONSELHO TUTELAR">CONSELHO TUTELAR</option>
                </select>
            </div>
            <div>
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade"><br>
            </div>
            <div>
                <button type="submit">Enviar Pedido</button>
            </div>
        </form>

        <?php
        if (isset($_GET['msg'])) {
            echo "<p>{$_GET['msg']}</p>";
        }
        ?>
    </div>
    <footer><img src="footer.svg" alt=""></footer>
</body>

</html>
