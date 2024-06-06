<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="/TechSUAS/css/cadunico/visitas/stylebuscar.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Buscar Visitas</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/cadunico/visitas/h1-buscar_visita.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
    <div class="camp1">
        <form method="post" action="">
            <label for="codfam" class="busca">CÓDIGO FAMILIAR:</label>

            <input type="text" name="codfam" class="busca2" id="codfamiliar" placeholder="Digite o CÓDIGO FAMILIAR." required>

            <button type="submit">Buscar</button>
            <a href="visitas"><i class="fas fa-arrow-left"></i>Voltar</a>
    </div>
    <div class="linha"></div>
    </form>
    </div>
    <!--
    <span id="sem_registro"></span><br/>
    <span id="nome"></span><br/>
    <span id="data_visita"></span><br/>
    <span id="acao"></span><br/>
    <span id="parecer_tec"></span><br/>
    <span id="entrevistador"></span>
    -->
    <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql_visita = $conn->real_escape_string($_POST['codfam']);

    $sql_dados_visitas = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam LIKE '$sql_visita' AND cod_parentesco_rf_pessoa = 1";
    $sql_query = $conn->query($sql_dados_visitas) or die("ERRO ao consultar !" . $conn - error);

    $dados_form = "SELECT * FROM visitas_feitas WHERE cod_fam LIKE '$sql_visita' ORDER BY id DESC";
    $form_query = $conn->query($dados_form) or die("ERRO ao consultar! " . $conn - error);

    if ($form_query->num_rows == 0) {
        ?>
            <script>
                Swal.fire({
                    icon: "info",
                    title: "NÃO ENCONTRADO",
                    text: "Não foi realizada nenhuma visita à família: <?php echo $_POST['codfam']; ?> !",
                    confirmButtonText: 'OK',
                })
            </script>
        <?php
} else {

    if ($sql_query->num_rows == 0) {
        echo '<span> Essa família não consta na sua base de dados. Confira no CadÚnico a situação da família. </span> ';
    } else {
        $dados = $sql_query->fetch_assoc();

        $cod_familiar_formatado = substr_replace(str_pad($dados['cod_familiar_fam'], 11, "0", STR_PAD_LEFT), '-', 9, 0);

        $nome = $dados['nom_pessoa'];
        echo 'Abaixo confira a(s) visita(s) realizada(s) à família de <strong>' . $nome . '</strong>, Código Familiar: <strong>' . $cod_familiar_formatado;
    }
        $dados_hist_visita = "SELECT * FROM historico_parecer_visita WHERE codigo_familiar LIKE '%$sql_visita%' ORDER BY id DESC";
        $hist_query = $conn->query($dados_hist_visita) or die("ERRO ao consultar! " . $conn - error);
            //$dados_hist = $sql_query->fetch_assoc();
        ?>

        <!-- INICIA A PRIMEIRA TABELA COM AS INFORMAÇÕES DAS VISITAS REALIZADAS -->

    <table width="650px" border="1">
    <tr>
        <th colspan="4">VISITAS REALIZADAS</th>
    </tr>
    <tr>
        <th>MOTIVO</th>
        <th>DATA DA VISITA</th>
        <th>ENTREVISTADOR</th>
        <th>AÇÃO</th>
    </tr>
            <?php

        while ($dados_hist_form = $form_query->fetch_assoc()) {

            ?>
        <tr>
    <!--1-->    <td><?php
            if ($dados_hist_form['acao'] == 1) {
                $acao = "ATUALIZAÇÃO REALIZADA";
            } else if ($dados_hist_form['acao'] == 2) {
                $acao = "NÃO LOCALIZADO";
            } else if ($dados_hist_form['acao'] == 3) {
                $acao = "FALECIMENTO DO RESPONSÁVEL FAMILIAR";
            } else if ($dados_hist_form['acao'] == 4) {
                $acao = "A FAMÍLIA RECUSOU ATUALIZAR";
            } else if ($dados_hist_form['acao'] == 5) {
                $acao = "ATUALIZAÇÃO NÃO REALIZADA";
            }
            echo $acao;
            ?></td>

    <!--2--><td><?php 
                $data = $dados_hist_form['data'];
// Verifica se a data não está vazia e tenta criar um objeto DateTime
if (!empty($data)) {
    $formatando_data = DateTime::createFromFormat('Y-m-d', $data);

    // Verifica se a data foi criada corretamente
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

    <!--3--><td><?php echo $dados_hist_form['entrevistador']; ?></td>

    <!--4--><td><?php
    $id_visitas_feitas = $dados_hist_form['id'];
$dados_hist_visita_1 = "SELECT * FROM historico_parecer_visita WHERE codigo_familiar LIKE '$sql_visita' AND id_visitas = $id_visitas_feitas ORDER BY id DESC";
$hist_query_1 = $conn->query($dados_hist_visita_1) or die("ERRO ao consultar! " . $conn->error);

                if ($dados_hist = $hist_query_1->fetch_assoc()){
                echo 'FEITO';
                } else {
                    ?>
                        <form action="/TechSUAS/controller/cadunico/parecer/print_visita" method="post" style="display:inline;">
                            <input type="hidden" name="id_visita" value="<?php echo $dados_hist_form['id']; ?>">
                            <button type="submit">GERAR</button>
                        </form>
                    </td>
        <?php
            }
?>
    </tr>
<?php
}

?>
        <!-- INICIA A SEGUNDA TABELA COM AS INFORMAÇÕES DOS PARECERES DAS VISITAS -->

        <table width="650px" border="1">
    <tr>
        <th colspan="4">PARECERES REFERENTE AS VISITAS</th>
    </tr>
    <tr>
        <th>Nº PARECER</th>
        <th>TEXTO DO PARECER</th>
        <th>DATA DA VISITA</th>
        <th>AÇÃO</th>
    </tr>
    <?php 
    if ($hist_query->num_rows == 0) {
        ?>
        <tr>
            <td coslpan="4"> Nenhum resultado encontrado</td>
        </tr>
        <?php
    } else {
        while ($dados_hist_feito = $hist_query->fetch_assoc()) {
            ?>
        <tr>
    <!--1--><td><?php 
                        $n1 = $dados_hist_feito['numero_parecer'];
                        $num_parecer = str_pad($n1, 4, "0", STR_PAD_LEFT);
                        echo $num_parecer. '/'. $dados_hist_feito['ano_parecer'];
    ?></td>

    <!--2--><td><?php echo $dados_hist_feito['resumo_visita']; ?></td>

    <!--3--><td><?php echo $dados_hist_feito['data_entrevista']; ?></td>

    <!--4--><td>
                <form action="/TechSUAS/controller/cadunico/parecer/reprint_visita" method="post" style="display:inline;">
                    <input type="hidden" name="id_visita" value="<?php echo $dados_hist_feito['id_visitas']; ?>">
                    <button type="submit">IMPRIMIR</button>
                </form>
        </td>
    </tr>

<?php
        }
    }
}

} else {

}
?>
<script>
            function printPage() {
            window.print();
        }
</script>
</body>

</html>