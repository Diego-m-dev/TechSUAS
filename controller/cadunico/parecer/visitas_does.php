<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
if (!isset($_POST['excluir'])) {
    ?>
    <script>
            Swal.fire({
                icon: "info",
                title: "NENHUM NIS SELECIONADO",
                text: "Selecione ao menos um NIS!",
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back()
                }
            })
    </script>
    <?php
} else {
    $nis_form = $_POST['excluir'];


?>
<a href="/TechSUAS/views/cadunico/visitas/visitas_para_fazer">
    <i class="fas fa-arrow-left"></i> Voltar
</a>
<?php
foreach ($nis_form as $nis) {

    $sql_dados = "SELECT * FROM tbl_tudo  WHERE num_nis_pessoa_atual LIKE '%$nis%'";
    $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

    if ($sql_query->num_rows == 0) {
        echo 'Sem informação desse NIS: '. $nis;
    } else {
        $dados = $sql_query->fetch_assoc();
        $codigo_familiar = $dados['cod_familiar_fam'];
        $dat_atual_fam = $dados['dat_atual_fam'];
                    if (!empty($dat_atual_fam)) {
                        $formatando_data = DateTime::createFromFormat('Y-m-d', $dat_atual_fam);

                        // Verifica se a data foi criada corretamente
                        if ($formatando_data) {
                            $dat_atual_fam_formatado = $formatando_data->format('d/m/Y');
                        } else {
                            $dat_atual_fam_formatado = "Data inválida.";
                        }
                    } else {
                        $dat_atual_fam_formatado = "Data não fornecida.";
                    }
        ?>
        <h4>INFORMAÇÕES RELATIVAS A ULTIMA ATUALIZAÇÃO <?php echo $dat_atual_fam_formatado; ?> </h4>
        <?php
        $codigo_formatado = substr_replace(str_pad($dados['cod_familiar_fam'], 11, '0',STR_PAD_LEFT), '-', 9, 0);
        echo $codigo_formatado. '<br>';
        echo 'RF: '. $dados['nom_pessoa']. '<br>';

        ?>
        <table border="1">
            <tr>
                <th>ENDEREÇO</th>
            </tr>
            <tr>
                <td>
        <?php

        echo '<span id="localidade">1.11 - Localidade: '. $dados['nom_localidade_fam'] . '</span>';
        echo '<span id="tipo">1.12 - Tipo: '. $dados['nom_tip_logradouro_fam'] . '</span>';
        echo '<span id="titulo">1.13 - Título: '. $dados['nom_titulo_logradouro_fam'] . '</span>';
        echo '<span id="nome_logradouro">1.14 - Nome: '. $dados['nom_logradouro_fam'] . '</span>';
        echo '<span id="numero_logradouro">1.15 - Número: '. $dados['num_logradouro_fam'] . '</span>';
        echo '<span id="complemento_numero">1.16 - Complemento do Número: '. $dados['des_complemento_fam'] . '</span>';
        echo '<span id="complemento_adicional">1.17 - Complemento Adicional: '. $dados['des_complemento_adic_fam'] . '</span>';
        $cep = substr_replace($dados['num_cep_logradouro_fam'], '-', 5, 0);
        echo '<span id="cep">1.18 - CEP: '. $cep . '</span>';
        echo '<span id="referencia_localizacao">1.20 - Referência para Localização: '. $dados['txt_referencia_local_fam'] . '</span>';

        ?>
                </td>
            </tr>
        </table><br>
        <?php

            $sql_dados_fam = "SELECT * FROM tbl_tudo  WHERE cod_familiar_fam LIKE '%$codigo_familiar%' AND cod_parentesco_rf_pessoa != 1";
            $sql_query_fam = $conn->query($sql_dados_fam) or die("ERRO ao consultar !" . $conn - error);

            if ($sql_query_fam->num_rows == 0) {
                
            } else {
                ?>
                <table border="1">
                <tr>
                    <th colspan="3">MEMBROS</th>
                </tr>
<?php
                while ($fam = $sql_query_fam->fetch_assoc()) {
                    ?>
                    <tr>
                    <td><?php echo $fam['cod_parentesco_rf_pessoa']; ?></td>
                    <td><?php echo $fam['nom_pessoa']; ?></td>
                    <td><?php echo $fam['num_nis_pessoa_atual']; ?></td>
                    </tr>
                    <?php
                }
?>
                </table>
<?php
        }
    }
    ?>
    <hr>
    <?php
    //echo 'NIS: '. htmlspecialchars($nis). '<br>';
}
}
?>

</body>
</html>