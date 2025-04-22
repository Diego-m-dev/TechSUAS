<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

if ($_SESSION['funcao'] != '1' && $_SESSION['funcao'] != '0')
{
  echo "VOCÊ NÃO PODE ACESSAR AQUI";
  exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/geral/style-reg-user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Cadastro de Usuários - TechSUAS</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/geral/h1-cad-user.svg" alt="NoImage">
        </h1>
    </div>

  <div class="container">
    <form method="post" action="/TechSUAS/controller/geral/processo_cad_user.php">

    <input type="hidden" name="cpf" value="<?php echo $_SESSION['municipio']; ?>">
      <div class="nome">
          <label>Nome completo:</label>
          <input type="text" class="nome" name="nome_user" placeholder="Sem Abreviação." required style="width: 300px;">
      </div>
      <div class="email">
          <label>E-mail:</label>
          <input type="email" name="email" placeholder="Digite aqui seu e-mail." required style="width: 300px;">
      </div>
      <div class="setor">
    <label>Setor:</label>
    <select name="setor" required>
      <option value="" disabled selected hidden>Selecione</option>
<?php
$idSistema = $_SESSION['sistema_id'];
  $sql_setor = "SELECT * FROM sistemas WHERE id = '$idSistema'";
  $sql_setor_query = $conn_1->query($sql_setor) or die("Erro ". $conn_1 - error);

  if ($sql_setor_query->num_rows > 0 ) {
    $bds = $sql_setor_query->fetch_assoc();
    $idSetor = $bds['setores_id'];
    $consultaSetores = $conn_1->query("SELECT instituicao, nome_instit FROM setores WHERE id = '$idSetor'");

// Verifica se há resultados na consulta
if ($consultaSetores->num_rows > 0) {

    // Loop para criar as opções do select
    while ($setor = $consultaSetores->fetch_assoc()) {
        echo '<option value="' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '">' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '</option>';
    }
}
  } elseif ($_SESSION['funcao'] == "0") {
    $consultaSetores = $conn_1->query("SELECT instituicao, nome_instit FROM setores ");

// Verifica se há resultados na consulta
  if ($consultaSetores->num_rows > 0) {

      // Loop para criar as opções do select
    while ($setor = $consultaSetores->fetch_assoc()) {
      echo '<option value="' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '">' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '</option>';
    }
  }
}
$conn->close();
?>
    </select>
</div>
  <div class="tipodeacesso">
    <label>Função: </label>
      <select name="funcao" id="funcao" required onchange="mostrarCampoTexto()">
        <option value="" disabled selected hidden>Selecione</option>
        <option value="1">Gestão</option>
        <option value="2">Tecnico(a)</option>
        <option value="3">Outros</option>
      </select>

        <input type="text" name="funcao_outros" id="funcao_outros" style="display: none;" placeholder="Digite a função">
      <div class="btns">
          <button type="submit">Cadastrar</button>
          <a href="/TechSUAS/config/back">
              <i class="fas fa-arrow-left"></i> Voltar ao menu
          </a>
      </div>
      </div>
  </form>
    </div>
    <script>
    function mostrarCampoTexto() {
        var select = document.getElementById("funcao");
        var campoTexto = document.getElementById("funcao_outros");

        if (select.value == "3") {
            // Se a opção 'Outros' for selecionada, mostra o campo de texto
            campoTexto.style.display = "block";
        } else {
            // Caso contrário, oculta o campo de texto
            campoTexto.style.display = "none";
        }
    }
</script>
<?php $conn_1->close(); ?>
</body>
</html>
