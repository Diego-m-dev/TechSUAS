<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/fichario_dig/style.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <script src="/TechSUAS/js/gestor.js"></script>

    <title>Folha de Ponto - TechSUAS</title>
</head>
<body>

<h1>FOLHA DE PONTO</h1>

  <h3><div id="infoCabec"></div></h3> <div id="printButton"></div>
  <select name="entrevistador" id="entrevistador" onchange="mudainfocabecalho()">
    <option value="" disabled selected hidden >Selecione</option>
    <?php
        $setor = $_SESSION['name_sistema'];
        $municipio = $_SESSION['municipio'];

        $stmt_entrevistadores = "SELECT nome, nis_func FROM operadores WHERE name_sistema = '$setor' AND municipio = '$municipio' ORDER BY nome";
        $stmt_entrevistadores_query  = $conn_1->query($stmt_entrevistadores) or die("Erro ". $conn_1 - error);

        if ($stmt_entrevistadores_query->num_rows > 0) {
          while ($dataEntrevist = $stmt_entrevistadores_query->fetch_assoc()) {

            ?>
            <option value="<?php echo $dataEntrevist['nis_func']; ?>"><?php echo $dataEntrevist['nome']; ?></option>
            <?php
          }
        }

    ?>

      </select>

      <label for="mes">Mês:</label>
      <select name="calendario" id="calendario">
        <option value="1">Janeiro</option>
        <option value="2">Fevereiro</option>
        <option value="3">Março</option>
        <option value="4">Abril</option>
        <option value="5">Maio</option>
        <option value="6">Junho</option>
        <option value="7">Julho</option>
        <option value="8">Agosto</option>
        <option value="9">Setembro</option>
        <option value="10">Outubro</option>
        <option value="11">Novembro</option>
        <option value="12">Dezembro</option>
      </select>

    <label for="ano">Ano:</label>
      <input type="number" name="ano" id="ano">

      <button type="button" onclick="buscaPonto()">Buscar</button>

      <div id="informacoes">

      </div>
</body>
</html>