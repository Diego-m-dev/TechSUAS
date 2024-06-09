<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style_reprint.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Visita domiciliar</title>

</head>

<body>
    <div class="tudo">
    <h3>REGISTRO DE INFORMAÇÕES COMPLEMENTARES DE VISITA DOMICILIAR</h3>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

    $id_visita = $_POST["id_visita"];

    $sqli = $pdo->prepare("SELECT * FROM historico_parecer_visita WHERE id_visitas = :idvisita");
    $sqli->bindParam(':idvisita', $id_visita, PDO::PARAM_STR);
    $sqli->execute();

    // Verifica se o formulário foi enviado via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //Verifica se a consulta em visita_feitas retornou algum resultado
        if ($sqli->rowCount() > 0) {
            // Recupera os dados da consulta
            $dadosv = $sqli->fetch(PDO::FETCH_ASSOC);
            $codfam = $dadosv['codigo_familiar'];
            $num_parecer = $dadosv['numero_parecer'];
            $ano_parecer = $dadosv['ano_parecer'];
            $carimbo = $dadosv['created_at'];
            $date = new DateTime($carimbo);

            $monthNames = [
                'January' => 'janeiro',
                'February' => 'fevereiro',
                'March' => 'março',
                'April' => 'abril',
                'May' => 'maio',
                'June' => 'junho',
                'July' => 'julho',
                'August' => 'agosto',
                'September' => 'setembro',
                'October' => 'outubro',
                'November' => 'novembro',
                'December' => 'dezembro'
            ];
            
            $day = $date->format('d');
            $month = $monthNames[$date->format('F')];
            $year = $date->format('Y');
            
            $formattedDateManual = "$day de $month de $year"; // Saída: 01 de junho de 2024
            
?>
                <!-- INICIA O FORMULÁRIO PARA CONFERIR OS DADOS E POSTERIORMENTE IMPRIMIR -->
                    <label for="">Nº Documento:</label>
                    <span ><?php echo $num_parecer. '/'. $ano_parecer; ?></span><br>
                    <span class="cidade_data">São Bento do Una - PE, <?php echo $formattedDateManual; ?>.</span>

            <!-- MOSTRAR OS DADOS DA FAMÍLIA DE ACORDO COM A TBL_TUDO-->
            <h4>DADOS DA FAMÍLIA</h4>
<?php
            //CÓDIGO FAMILIAR SENDO FORMATADO E EXIBIDO
            $codigo_formatado = substr_replace(str_pad($codfam, 11, '0',STR_PAD_LEFT), '-', 9, 0);
            echo 'Código Familiar: <span id="codigo_familiar">'. $codigo_formatado. '</span>';

                //DATA DA ULTIMA ATUALIZAÇÃO FORMATADA E EXIBINDO
                $data = $dadosv['data_entrevista'];
            echo 'Data da visita: <span id="data_entrevista">'. $data. '</span><br>';

            //RENDA PERCAPITA FORMATADA E EXIBIDA
            echo 'Renda per capita da família: <span id="renda_per_capita"> '. $dadosv['renda_per_capita']. '</span>';
?>
            <!--ENDEREÇO DA FAMÍLIA-->
            <h4>ENDEREÇO DA FAMÍLIA</h4>
<?php echo '<div class="end_familia" class="tabela">'; ?>
        <table>
        <tr>
            <td class="title_line" colspan="5">1.11 - Localidade:</td>
            <td colspan="20"><?php echo '<span id="localidade">'. $dadosv['localidade'] . '</span>'; ?></td>
        </tr>
        <tr>
            <td class="title_line" colspan="4">1.12 - Tipo:</td>
            <td colspan="16"><?php echo '<span id="tipo">'. $dadosv['tipo'] . '</span>'; ?></td>
            <td class="title_line" colspan="2">1.13 - Título:</td>
            <td colspan="3"><?php echo '<span id="titulo">'. $dadosv['titulo'] . '</span>'; ?></td>
        </tr>
        <tr>
            <td class="title_line" colspan="4">1.14 - Nome:</td>
            <td colspan="21"><?php echo '<span id="nome_logradouro">'. $dadosv['nome_logradouro'] . '</span>'; ?></td>
        </tr>
        <tr>
            <td class="title_line" colspan="8">1.15 - Número:</td>
            <td colspan="4"><span id="numero_logradouro"><?php echo $dadosv['numero_logradouro'] == 0 ? "" : $dadosv['numero_logradouro']; ?></span></td>
            <td class="title_line" colspan="8">1.16 - Complemento do Número:</td>
            <td colspan="5"><?php echo '<span id="complemento_numero">'. $dadosv['complemento_numero'] . '</span>'; ?></td>
        </tr>
        <tr>
            <td colspan="12">1.17 - Complemento Adicional:</td>
            <td colspan="8"><?php echo '<span id="complemento_adicional">'. $dadosv['complemento_adicional'] . '</span>'; ?></td>
            <td colspan="2">1.18 - CEP:</td>
            <td colspan="3"><?php echo '<span id="cep">'.  $dadosv['cep'] . '</span>'; ?></td>
        </tr>
        <tr>
            <td colspan="12">1.20 - Referência para Localização:</td>
            <td colspan="13"><?php echo '<span id="referencia_localizacao">'. $dadosv['referencia_localizacao'] . '</span>'; ?></td>
        </tr>
<?php echo '</div>'; ?>
        </table>
            <!-- EXIBIR CADA MEMBRO DA FAMÍLIA-->
            <h4>COMPONENTES DA FAMÍLIA</h4><hr>
<?php
                $id_parecer = $dadosv['id'];
                $sql_membro_familia = "SELECT * FROM membros_familia WHERE parecer_id LIKE '$id_parecer' ORDER BY id ASC";
                $sql_membro_familia_query = $conn->query($sql_membro_familia) or die("ERRO ao consultar! " . $conn - error);

            if ($sql_membro_familia_query->num_rows == 0) {
                //NENHUM MEMBRO FAMILIAR ENCONTRADO
            } else {
                while ($member = $sql_membro_familia_query->fetch_assoc()) {
?>
    <table width="800">
        <tr>
            <td colspan="8"><?php echo '<span class="parentesco">' . $member['parentesco']. '</span>:<br>'; ?></td>
        </tr>
        <tr>
            <td colspan="2">4.02 - Nome:</td>
            <td colspan="6"><?php echo ' <span class="nome_completo">' . $member['nome_completo'] . '</span><br>'; ?></td>
        </tr>
        <tr>
        <td colspan="3">4.03 - NIS:</td>
        <td colspan="3"><?php echo '<span class="nis">' . $member['nis'] . '</span>'; ?></td>
        <td colspan="1">4.06 - Data De Nascimento:</td>
        <td colspan="1"><?php echo '<span class="data_nascimento">' . $member['data_nascimento'] . '</span>'; ?></td>
        </tr>
    </table><hr>
<?php
                }
            }
?>
            <!--AREA DAS INFORMAÇÕES DO ENTREVISTADOR-->
            <h4>OBSERVAÇÕES DO ENTREVISTADOR</h4>
            <h4>Situação</h4>
<?php
            echo '<span id="situacao">' . $dadosv['situacao'] . '</span>';
?>

            <h4>Resumo da visita</h4>
<?php
                    echo '<span id="resumo_visita">' . $dadosv['resumo_visita'] . '</span>';
    }
}
?>
    </div>
<script>
        
            window.print()
            setTimeout(function() {
                window.location.href = "/TechSUAS/views/cadunico/visitas/buscarvisita";
            }, 3000);
</script>