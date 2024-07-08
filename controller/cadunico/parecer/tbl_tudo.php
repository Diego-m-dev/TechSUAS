<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/visitas_pend.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>



    <?php
if (!isset($_GET['ano_select'])) {
?>
<p>Selecione ao menos o ano.</p>
<p>Antes de realizar a visita domiciliar, é crucial consultar cadastro de cada família no sistema V7.</p>
<?php
} else {
    ?>

<form action="/TechSUAS/controller/cadunico/parecer/visitas_does" method="POST">

<div class="tabela">


    <table border="1">
    <th class="btn_impr"><button type="submit" id="print">imprimir</button></th>
<tr class="titulo">
      <th class="check">
        <label class="urg">
            <input type="checkbox" id="selecionarTodos">
          <span class="checkmark"></span>
        </label>
      </th>
    <th class="cabecalho">NOME</th>
    <th class="cabecalho">DATA ATUALIZAÇÃO</th>
    <th class="cabecalho">BAIRRO</th>
    <th class="cabecalho">RUA</th>
    
</tr>

    <?php

    $sql_cod = $conn->real_escape_string($_GET['ano_select']);
    $sqli_cod = $conn->real_escape_string($_GET['localidade']);
    if (empty($_GET['mes_select'])) {
        $sql_dados = "SELECT * FROM tbl_tudo  WHERE dat_atual_fam LIKE '%$sql_cod%' AND nom_localidade_fam LIKE '%$sqli_cod%' AND cod_parentesco_rf_pessoa = 1
        ORDER BY cod_local_domic_fam ASC,nom_localidade_fam ASC, num_logradouro_fam ASC";
        $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

        $num_result = $sql_query->num_rows;

        } else {
        $sqlm_cod = ($_GET['mes_select']);
        $sql_dados = "SELECT * FROM tbl_tudo  WHERE dat_atual_fam LIKE '%$sql_cod%' AND nom_localidade_fam LIKE '%$sqli_cod%' AND MONTH(dat_atual_fam) = '$sqlm_cod' AND cod_parentesco_rf_pessoa = 1
        ORDER BY cod_local_domic_fam ASC,nom_localidade_fam ASC, num_logradouro_fam ASC";
        $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

        $num_result = $sql_query->num_rows;
    }

    if ($sql_query->num_rows == 0) {
        ?>
    <tr class="resultado">
    <td colspan="7">Nenhum resultado encontrado...</td>
    </tr>
        <?php
    } else {
        if ($num_result == 1) {
?>
        <h5>Foi encontrado <?php echo $num_result; ?> resultado.</h5>
<?php
        } else {
?>
        <h5>Foram encontrados <?php echo $num_result;?> resultados.</h5>
<?php
}
    $seq = 1; //CASO QUEIRA INCREMENTAR UMA SEQUENCIA À TABELA BASTA APRESENTAR ESSA VARIÁVEL DENTRO DA TABELA.
        while ($dados = $sql_query->fetch_assoc()) {
            
            ?>
        <tr class="resultado">
            <td class="check">
              <label class="urg">
                <input type="checkbox" name="excluir[]" value="<?php echo $dados['num_nis_pessoa_atual']; ?>">
                <span class="checkmark"></span>
              </label>
            </td>
            <td class="resultado"><?php echo $dados['nom_pessoa']; ?></td>
            <td class="resultado"><?php 
            
            $data = $dados['dat_atual_fam'];
            if (!empty($data)) {
                $formatando_data = DateTime::createFromFormat('Y-m-d', $data);
                if ($formatando_data) {
                    $data_formatada = $formatando_data->format('d/m/Y');
                    echo $data_formatada;
                } else {
                    echo "Data inválida.";
                }
            } else {
                echo "Data não fornecida.";
            }            
            ?></td>
            <td class="resultado"><?php echo $dados["nom_localidade_fam"]; ?></td>
            <td class="resultado"><?php 
            echo $dados["nom_tip_logradouro_fam"]. ' ';
            echo $dados["nom_titulo_logradouro_fam"] == "" ? "" : $dados["nom_titulo_logradouro_fam"]. ' ';
            echo $dados["nom_logradouro_fam"]. ', ';
            echo $dados["num_logradouro_fam"] == "" ? "S/N" : $dados["num_logradouro_fam"];

            ?></td>
        </tr>
<?php
            $seq++;
        }
    }
}
?>
  </table>
  </div>
  </form>
  <script>
    document.getElementById('selecionarTodos').addEventListener('click', function (){
    // Obter todos os checkboxes na tabela
      var checkBoxes = document.querySelectorAll('input[name="excluir[]"]')

    checkBoxes.forEach(function(checkbox){
        checkbox.checked = document.getElementById('selecionarTodos').checked
      })
    })
  </script>
</body>
</html>