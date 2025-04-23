<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSUAS - Concessão</title>
    <link rel="stylesheet" href="#">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/apresentar.js"></script>
</head>

<body>

<?php


  if (isset($_GET['cpf_R'])) {
    $cpf_R = preg_replace('/\D/', '', $_GET['cpf_R']);

    $stmt = $pdo->prepare("SELECT id, nome, endereco, quant_mes, quant_conc_resp, quant_conc_bene
                          FROM dados_pessoal_concessao
                          WHERE cpf = ?");
    $stmt->execute([$cpf_R]);
    $dados_apresent = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dados_apresent) {
      echo "CPF não encontrado.";
      exit;
    }

    echo "<h1>HISTÓRICO DE CONCESSÃO DE " . $dados_apresent['nome'] . "</h1>";

    echo "<input type='hidden' id='cpf_r' value='" . $_GET['cpf_R'] . "'>";
    echo "<input type='hidden' id='nome' value='" . $dados_apresent['nome'] . "'>";

    //DADOS DO RESPONSÁVEL
    echo "Responsável: " . $dados_apresent['nome'] . " => CPF: " . $_GET['cpf_R'];
    echo "<br>Endereço: " . $dados_apresent['endereco'];
    echo "<br><button type='button' onclick='alt_dados_pessoais()'>Editar Dados</button>";

    //QUANTIDADE DE MESES DISPONIBILIZADOS
    if ($dados_apresent['quant_mes'] === 0 || $dados_apresent['quant_mes'] === NULL) {
      $limite = "Não foi limitado concessões para essa pessoa você pode alterar clicando no <button type='button' onclick='alt_limite()'>botão</button> ";
    } else {
      $limite = $dados_apresent['quant_mes'] . ". Caso deseje alterar clique no <button type='button' onclick='alt_limite()'>botão</button>";
    }
    echo "<br>Quantidade de concessões disponibilizadas " . $limite;

    $restant = $dados_apresent['quant_mes'] - $dados_apresent['quant_conc_bene'];

    echo "<br>Quantidade de concessões realizadas " . $dados_apresent['quant_conc_bene'] . " ";
    echo $restant == 1 ? "resta " . $restant : "restam " . $restant;

    //TABELA COM OS DADOS DAS CONCESSÕES JÁ FEITAS

    $stmt = $pdo->prepare("SELECT c.id, c.num_formulario, c.ano_formulario, c.parentesco, c.situacao, c.mes_pg, c.item, c.quantidade, c.valor_uni, c.valor_total, c.operador, r.nome
                          FROM concessao c
                          JOIN dados_pessoal_concessao r ON r.id = c.beneficiario_id
                          WHERE c.responsavel_id = ?
                          ORDER BY c.ano_formulario DESC, c.num_formulario DESC");
    $stmt->execute([$dados_apresent['id']]);


    ?>
    <table border="1">
      <tr>
        <th colspan="7">Responsável por as seguintes concessões</th>
      </tr>
      <tr>
        <th>Nº</th>
        <th>Concedido</th>
        <th>Valor Total</th>
        <th>Beneficiário</th>
        <th>Situação</th>
        <th>Imprimir</th>
        <th>Editar</th>
      </tr>
    <?php
        $multiplicador = 0;
        
    while ($dados_apresent_conc = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $multiplicador += $dados_apresent_conc['valor_total'];
      ?>
      <tr>
        <td>
      <?php echo $dados_apresent_conc['num_formulario'] . "/" . $dados_apresent_conc['ano_formulario']; ?>
        </td>
        <td>
          <?php echo $dados_apresent_conc['item']; ?>
        </td>
        <td>
          <?php echo 'R$ ' . number_format(floatval(str_replace(',', '', $dados_apresent_conc['valor_total'])), 2, ',', '.'); ?>
        </td>
        <td>
          <?php echo $dados_apresent_conc['nome']; ?>
        </td>
        <td>
          <?php echo $dados_apresent_conc['situacao']; ?>
        </td>
        <td>
          <input type="button" id="id" value="<?php echo $dados_apresent_conc['id']; ?>">
        </td>
        <td>
          <input type="button" id="id" value="<?php echo $dados_apresent_conc['id']; ?>">
        </td>
      </tr>
      <?php
    }
    
    ?>
    <tr>
      <td colspan="4">Total</td>
      <td colspan="3"><?php echo 'R$ ' . number_format(floatval(str_replace(',', '', $multiplicador)), 2, ',', '.'); ?></td>
    </tr>
  </table>
    <?php
    $stmt = $pdo->prepare("SELECT id, num_formulario, ano_formulario, item, situacao, valor_total FROM concessao WHERE beneficiario_id = ?");
    $stmt->execute([$dados_apresent['id']]);

    ?>
    <table border="1">
      <tr>
        <th colspan="6">Beneficiário nas seguintes concessões</th>
      </tr>
      <tr>
        <th>Nº</th>
        <th>Concedido</th>
        <th>Valor Total</th>
        <th>Situação</th>
        <th>Imprimir</th>
        <th>Editar</th>
      </tr>
    <?php

      while ($dados_apresent_conc_benef = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
          <td>
            <?php echo $dados_apresent_conc_benef['num_formulario'] . "/" . $dados_apresent_conc_benef['ano_formulario']; ?>
          </td>
          <td>
          <?php echo $dados_apresent_conc_benef['item']; ?>
          </td>
          <td>
          <?php echo 'R$ ' . number_format(floatval(str_replace(',', '', $dados_apresent_conc_benef['valor_total'])), 2, ',', '.'); ?>
        </td>
        <td>
          <?php echo $dados_apresent_conc_benef['situacao']; ?>
        </td>
        <td>
          <input type="button" id="id" value="<?php echo $dados_apresent_conc_benef['id']; ?>">
        </td>
        <td>
          <input type="button" id="id" value="<?php echo $dados_apresent_conc_benef['id']; ?>">
        </td>
        </tr>
        <?php
      }
    ?>
    </table>
    <?php
  } else {
    ?>
      <form action="" method="get">
        <input type="text" name="cpf_R" id="cpf_R">
          <button type="submit">Buscar</button>
      </form>
    <?php
  } 


?>

</body>
</html>