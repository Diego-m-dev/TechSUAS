<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descartes - TechSUAS</title>
    <!-- <link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/td.css"> -->
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_descarte.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  </head>
<body>


  <form action="" method="post">
  <div>
    <h1>FORMULÁRIO DE DESCARTES</h1>
    <label for="">Código familiar:</label>
    <input type="number" name="cod_famila" required/>

    <label for="">Data da entrevista:</label>
    <input type="date" name="dat_entre" required/>

    <label for="">Formulários:</label>
      <div class="lista_form">
      <input type="checkbox" name="principal" id="principal" value="PRINCIPAL"> PRINCIPAL
        <input type="number" name="quant_principal" class="quantidades" id="quant_principal"><br>
      <input type="checkbox" name="av1" id="av1" value="AVULSO 1"> AVULSO 1
        <input type="number" name="quant_av1" class="quantidades" id="quant_av1"><br>
      <input type="checkbox" name="av2" id="av2" value="AVULSO 2"> AVULSO 2
        <input type="number" name="quant_av2" class="quantidades" id="quant_av2"><br>
      <input type="checkbox" name="fichaExclus" id="fichaExclus" value="FICHA DE EXCLUSÃO"> FICHA DE EXCLUSÃO
        <input type="number" name="quant_fichaExclus" class="quantidades" id="quant_fichaExclus"><br>
      <input type="checkbox" name="termos" id="termos" value="TERMOS"> TERMOS
        <input type="number" name="quant_termos" class="quantidades" id="quant_termos">
      </div>

      <label for="">Observação:</label>
      <textarea name="obs_ret" id=""></textarea>
  </div>
    <button type="submit">Salvar</button>
  </form>

  <?php
  if (!isset($_POST['cod_famila'])){

  } else {
    echo $_POST['cod_famila'] .'<br>'. $_POST['dat_entre'] .'<br>'. $_POST['quant_principal'].'<br>'. $_POST['principal'];
    $cod_familia = $conn->real_escape_string($_POST['cod_famila']);
    $dta_entrevista = $_POST['dat_entre'];

    $status = "1";

    //STATUS `1` => NÃO FOI IMPRESSO AINDA


    $cpf_limpo = preg_replace('/\D/', '', $_POST['cod_famila']);
    $cpf_already = ltrim($cpf_limpo, '0');
    $cpf_zero = str_pad($cpf_already, 11, "0", STR_PAD_LEFT);

    $tipos = [];

    if (isset($_POST['principal'])) {
        $tipos[] = ['tipo' => $_POST['principal'], 'quantidade' => $_POST['quant_principal']];
    }
    
    if (isset($_POST['av1'])) {
        $tipos[] = ['tipo' => $_POST['av1'], 'quantidade' => $_POST['quant_av1']];
    }
    
    if (isset($_POST['av2'])) {
        $tipos[] = ['tipo' => $_POST['av2'], 'quantidade' => $_POST['quant_av2']];
    }
    
    if (isset($_POST['fichaExclus'])) {
        $tipos[] = ['tipo' => $_POST['fichaExclus'], 'quantidade' => $_POST['quant_fichaExclus']];
    }
    
    if (isset($_POST['termos'])) {
        $tipos[] = ['tipo' => $_POST['termos'], 'quantidade' => $_POST['quant_termos']];
    }
    
    // Converte o array para uma string JSON
    $tipos_json = json_encode($tipos);
    
    // Preparar e executar a inserção no banco de dados
    $stmt_desc = $conn->prepare("INSERT INTO descartes (codfam, data_entrevista, operador, tipo, status) VALUES (?, ?, ?, ?, ?)");
    $stmt_desc->bind_param("sssss", $cpf_zero, $dta_entrevista, $_SESSION['nome_usuario'], $tipos_json, $status);
    
    if ($stmt_desc->execute()) {
        // Redireciona para a página registrar caso deseje realizar um novo registro
        ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'SALVO',
                text: 'Dados salvos com sucesso!',
                html: `
                <p>Código Familiar: <?php echo substr_replace($cpf_zero, '-', 9, 0); ?></p>
                `,
            }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "/TechSUAS/views/cadunico/descarte"
                }
            })
        </script>
    <?php
            } else {
                echo "ERRO no envio dos DADOS: ".   $smtp->error;
            }
            $stmt_desc->close();
            $conn->close();
        

  }
  $conn_1->close();
  ?>
</body>

<script>
$(document).ready(function () {
    $('.quantidades').hide() // Esconde todos os campos de quantidade inicialmente

    // Função para mostrar/esconder campos de quantidade baseado no checkbox
    $('input[type="checkbox"]').change(function () {
        const quantField = $(this).next('.quantidades') // Seleciona o campo de quantidade correspondente

        if (this.checked) {
            quantField.show() // Mostra o campo de quantidade
            quantField.prop('required', true) // Torna o campo obrigatório
        } else {
            quantField.hide() // Esconde o campo de quantidade
            quantField.prop('required', false) // Remove a obrigatoriedade
            quantField.val('') // Limpa o valor do campo
        }
    })
})

  </script>

</html>