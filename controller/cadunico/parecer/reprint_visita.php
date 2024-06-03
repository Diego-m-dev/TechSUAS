<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style_conferir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Visita domiciliar</title>

</head>

<body>
    <h1>REGISTRO DE INFORMAÇÕES COMPLEMENTARES DE VISITA DOMICILIAR</h1>
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
                    <span ><?php echo $num_parecer. '/'. $ano_parecer; ?></span>
                    <span>São Bento do Una - PE, <?php echo $formattedDateManual; ?>.</span>

            <!-- MOSTRAR OS DADOS DA FAMÍLIA DE ACORDO COM A TBL_TUDO-->
            <h4>DADOS DA FAMÍLIA</h4>
<?php
            //CÓDIGO FAMILIAR SENDO FORMATADO E EXIBIDO
            $codigo_formatado = substr_replace(str_pad($codfam, 11, '0',STR_PAD_LEFT), '-', 9, 0);
            echo 'CÓDIGO FAMILIAR: <span id="codigo_familiar">'. $codigo_formatado. '</span>';

                //DATA DA ULTIMA ATUALIZAÇÃO FORMATADA E EXIBINDO
                $data = $dadosv['data_entrevista'];
            echo 'DATA DA VISITA: <span id="data_entrevista">'. $data. '</span>';

            //RENDA PERCAPITA FORMATADA E EXIBIDA
            echo 'RENDA PER CAPITA DA FAMÍLIA: <span id="renda_per_capita"> '. $dadosv['renda_per_capita']. '</span>';
?>
            <!--ENDEREÇO DA FAMÍLIA-->
            <h4>ENDEREÇO DA FAMÍLIA</h4>
<?php
            echo '<span id="localidade">1.11 - Localidade: '. $dadosv['localidade'] . '</span>';
            echo '<span id="tipo">1.12 - Tipo: '. $dadosv['tipo'] . '</span>';
            echo '<span id="titulo">1.13 - Título: '. $dadosv['titulo'] . '</span>';
            echo '<span id="nome_logradouro">1.14 - Nome: '. $dadosv['nome_logradouro'] . '</span>';
            echo '<span id="numero_logradouro">1.15 - Número: '. $dadosv['numero_logradouro'] . '</span>';
            echo '<span id="complemento_numero">1.16 - Complemento do Número: '. $dadosv['complemento_numero'] . '</span>';
            echo '<span id="complemento_adicional">1.17 - Complemento Adicional: '. $dadosv['complemento_adicional'] . '</span>';
            echo '<span id="cep">1.18 - CEP: '. $dadosv['cep'] . '</span>';
            echo '<span id="referencia_localizacao">1.20 - Referência para Localização: '. $dadosv['referencia_localizacao'] . '</span>';

?>
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

                                echo '<span class="parentesco">' . $member['parentesco']. '</span>';
                                echo '<span class="nome_completo">' . $member['nome_completo'] . '</span>';
                                echo '<span class="nis">' . $member['nis'] . '</span>';
                                echo '<span class="data_nascimento">' . $member['data_nascimento'] . '<hr></span>';
                }
            }
?>
            <!--AREA DAS INFORMAÇÕES DO ENTREVISTADOR-->
            <h4>OBSERVAÇÕES DO ENTREVISTADOR</h4>
            <h5>Situação</h5>
<?php
            echo '<span id="situacao">' . $dadosv['situacao'] . '</span>';
?>

            <h5>Resumo da visita</h5>
<?php
                    echo '<span id="resumo_visita">' . $dadosv['resumo_visita'] . '</span>';
    }
}