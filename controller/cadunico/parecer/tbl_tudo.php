<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
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
} else {
    ?>

<form action="/TechSUAS/controller/cadunico/parecer/visitas_does" method="POST">

<div class="tabela">


    <table border="1">
    <th class="btn_impr"><button type="submit" id="print" onclick="printerVisitas()">imprimir</button></th>
<tr class="titulo">
    <th class="check">
                <label class="urg">
                        <input type="checkbox" id="selecionarTodos">
                    <span class="checkmark"></span>
                </label>
            </th>
    <th class="cabecalho">NOME</th>
    <th class="cabecalho">DATA ATUALIZAÇÃO</th>
    <th class="cabecalho">ENDEREÇO</th>
    
</tr>

    <?PHP

    $sql_cod = $conn->real_escape_string($_GET['ano_select']);
    $sqli_cod = $conn->real_escape_string($_GET['localidade']);
    $sql_dados = "SELECT * FROM tbl_tudo  WHERE dat_atual_fam LIKE '%$sql_cod%' AND nom_localidade_fam LIKE '%$sqli_cod%' AND cod_parentesco_rf_pessoa = 1";
    $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

    if ($sql_query->num_rows == 0) {
        ?>
    <tr class="resultado">
    <td colspan="7">Nenhum resultado encontrado...</td>
    </tr>
        <?php
} else {

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
            <td class="resultado"><?php echo $dados['dat_atual_fam']; ?></td>
            <td class="resultado"><?php
//construindo o endereço
            $tipo_logradouro = $dados["nom_tip_logradouro_fam"];
            $nom_logradouro_fam = $dados["nom_logradouro_fam"];
            $num_logradouro_fam = $dados["num_logradouro_fam"];
            if ($num_logradouro_fam == "") {
                $num_logradouro = "S/N";
            } else {
                $num_logradouro = $dados["num_logradouro_fam"];
            }
            $nom_localidade_fam = $dados["nom_localidade_fam"];
            $nom_titulo_logradouro_fam = $dados["nom_titulo_logradouro_fam"];
            if ($nom_titulo_logradouro_fam == "") {
                $nom_tit = "";
            } else {
                $nom_tit = $dados["nom_titulo_logradouro_fam"];
            }
            $txt_referencia_local_fam = $dados["txt_referencia_local_fam"];
            if ($txt_referencia_local_fam == "") {
                $referencia = "SEM REFERÊNCIA";
            } else {
                $referencia = $dados["txt_referencia_local_fam"];
            }

            $endereco_conpleto = $tipo_logradouro . " " . $nom_tit . " " . $nom_logradouro_fam . ", " . $num_logradouro . " - " . $nom_localidade_fam;
            echo $endereco_conpleto;?></td>
        </tr>
<?php
}
    }
}?>
</table>
</div>
</form>
<p id="paraPrint"></p>
    </body>
    </html>