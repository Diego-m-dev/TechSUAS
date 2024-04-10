<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido de Água e Gás</title>
</head>
<body>
    <h1>Realizar Pedido</h1>
    <form action="salvar_pedido.php" method="post">
        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo">
            <option value="agua">Água</option>
            <option value="gas">Gás</option>
        </select><br>

        <label for="local">Local:</label>
        <input type="text" id="local" name="local"><br>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade"><br>

        <button type="submit">Enviar Pedido</button>
    </form>

    <?php
    if(isset($_GET['msg'])) {
        echo "<p>{$_GET['msg']}</p>";
    }
    ?>
</body>
</html>
