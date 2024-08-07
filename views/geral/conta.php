<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/suporte/style-alt-user.css">
    <link rel="website icon" type="image/png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>Sala do Usuário - TechSUAS</title>
    <style>
        .edicao {
            display: none;
        }
    </style>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
        <img src="/TechSUAS/img/geral/h1-alt-user.svg" alt="Titulocomimagem">
        </h1>
    </div>
<div class="tudo">
    <form method="post" action="/TechSUAS/controller/cadunico/salva_alteracao.php">
        <div id="nomeVisual">
            Nome completo: <?php echo $nome; ?>
            <button type="button" onclick="iniciarEdicao('nome')">Editar</button> <br>
        </div>
        <!-- Campos de edição (inicialmente ocultos) -->
        <div id="nomeEdicao" class="edicao">
            <label for="nome">Nome completo:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" oninput="sempre_maiusculo(this)" required>
        </div>

        <div id="apelidoVisual">
            Como quer ser chamado(a)? <?php echo $apelido; ?>
            <button type="button" onclick="iniciarEdicao('apelido')">Editar</button> <br>
        </div>
        <!-- Campos de edição (inicialmente ocultos) -->
        <div id="apelidoEdicao" class="edicao">
            <label for="apelido">Como quer ser chamado(a)? </label>
            <input type="text" id="apelido" name="apelido" value="<?php echo $apelido; ?>" oninput="sempre_maiusculo(this)" required>
        </div>

      <?php echo "CPF: " . $cpf . "<br>";
      echo "Data de Nascimento: " . $dtNasc . "<br>"; ?>

        <div id="teleVisual">
            Contato: <?php echo $telefone; ?>
            <button type="button" onclick="iniciarEdicao('tele')">Editar</button><br>
        </div>
        <!-- Campos de edição (inicialmente ocultos) -->
        <div id="teleEdicao" class="edicao">
            <label for="tele">Contato: </label>
            <input type="text" id="tele" name="tele" value="<?php echo $telefone; ?>" required>
        </div>

        <div id="emailVisual">
            Email: <?php echo $email; ?>
            <button type="button" onclick="iniciarEdicao('email')">Editar</button><br>
        </div>
        <!-- Campos de edição (inicialmente ocultos) -->
        <div id="emailEdicao" class="edicao">
            <label for="email">Email: </label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>

        <div id="cargoVisual">
            Cargo: <?php echo $cargo; ?>
            <button type="button" onclick="iniciarEdicao('cargo')">Editar</button><br>
        </div>
        <!-- Campos de edição (inicialmente ocultos) -->
        <div id="cargoEdicao" class="edicao">
            <label for="cargo">Cargo: </label>
            <input type="text" id="cargo" name="cargo" value="<?php echo $cargo; ?>" oninput="sempre_maiusculo(this)" required>
        </div>

        <div id="idcargoVisual">
            Certificado ou Matricula: <?php echo $idcargo; ?>
            <button type="button" onclick="iniciarEdicao('idcargo')">Editar</button><br>
        </div>
        <!-- Campos de edição (inicialmente ocultos) -->
        <div id="idcargoEdicao" class="edicao">
            <label for="idcargo">Certificado ou Matricula: </label>
            <input type="text" id="idcargo" name="idcargo" value="<?php echo $idcargo; ?>" required>
        </div>
<?php
if ($_SESSION['funcao'] == "0"){
  ?>
      <label for="">Banco de Dados:</label>
      <select name="ibge" required>
      <option value="" disabled selected hidden>Selecione</option>
<?php
    $consultaSetores = $conn_1->query("SELECT cod_ibge, municipio FROM municipios WHERE id != 4");
// Verifica se há resultados na consulta
  if ($consultaSetores->num_rows > 0) {
      // Loop para criar as opções do select
    while ($setor = $consultaSetores->fetch_assoc()) {
?>
<option value="<?php echo $setor['cod_ibge']; ?>"><?php echo $setor['municipio']; ?></option>
<?php
    }
  }

?>
    </select>
<?php
}
?>
    <button type="submit">Salvar Alterações</button>
      <a href="/TechSUAS/config/back.php">
        <i class="fas fa-arrow-left"></i> Voltar ao menu
      </a>
  </form>

</div>
    <script src='/TechSUAS/js/personalise.js'></script>
</body>
</html>