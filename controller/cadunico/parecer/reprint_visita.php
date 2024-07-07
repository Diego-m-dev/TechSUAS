<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/controller/cadunico/declaracao/create_moth.php';
?>
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

<body class="<?php echo 'background-' . $_SESSION['estilo']; ?>">
    <div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único</span> - <?php echo $data_cabecalho; ?>
        </div>
    </div>
    <h1>REGISTRO DE INFORMAÇÕES COMPLEMENTARES DE VISITA DOMICILIAR</h1>
    <div class="tudo">
        
        <?php

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
        ?>
                <!-- INICIA O FORMULÁRIO PARA CONFERIR OS DADOS E POSTERIORMENTE IMPRIMIR -->
                <label for="">Nº Documento:</label>
                <span><?php echo $num_parecer . '/' . $ano_parecer; ?></span><br>
                <span class="cidade_data"><?php echo $cidade; ?><?php echo $data_formatada_extenso; ?>.</span>

                <div class="cidade_data">
                    <p style="text-align: left;"><?php  ?></p>.
                </div>

                <!-- MOSTRAR OS DADOS DA FAMÍLIA DE ACORDO COM A TBL_TUDO-->
                <h4>DADOS DA FAMÍLIA</h4>
                <?php
                //CÓDIGO FAMILIAR SENDO FORMATADO E EXIBIDO
                $codigo_formatado = substr_replace(str_pad($codfam, 11, '0', STR_PAD_LEFT), '-', 9, 0);
                echo 'Código Familiar: <span id="codigo_familiar">' . $codigo_formatado . '</span><br>';

                //DATA DA ULTIMA ATUALIZAÇÃO FORMATADA E EXIBINDO
                $data = $dadosv['data_entrevista'];
                echo 'Data da visita: <span id="data_entrevista">' . $data . '</span><br>';

                //RENDA PERCAPITA FORMATADA E EXIBIDA
                echo 'Renda per capita da família: <span id="renda_per_capita"> ' . $dadosv['renda_per_capita'] . '</span>';
                ?>
                <!--ENDEREÇO DA FAMÍLIA-->
                <h4>ENDEREÇO DA FAMÍLIA</h4>
                <?php echo '<div class="end_familia" class="tabela">'; ?>
                <table id="noformat" style="margin: -0.5cm">
                    <tr>
                        <td class="title_line" colspan="8">1.11 - Localidade:</td>
                        <td colspan="17"><?php echo '<span id="localidade">' . $dadosv['localidade'] . '</span>'; ?></td>
                    </tr>
                    <tr>
                        <td class="title_line" colspan="8">1.12 - Tipo:</td>
                        <td colspan="6"><?php echo '<span id="tipo">' . $dadosv['tipo'] . '</span>'; ?></td>
                        <td class="title_line" colspan="3">1.13 - Título:</td>
                        <td colspan="8"><?php echo '<span id="titulo">' . $dadosv['titulo'] . '</span>'; ?></td>
                    </tr>
                    <tr>
                        <td class="title_line" colspan="5">1.14 - Nome:</td>
                        <td colspan="20"><?php echo '<span id="nome_logradouro">' . $dadosv['nome_logradouro'] . '</span>'; ?></td>
                    </tr>
                    <tr>
                        <td class="title_line" colspan="8">1.15 - Número:</td>
                        <td colspan="4"><span id="numero_logradouro"><?php echo $dadosv['numero_logradouro'] == 0 ? "" : $dadosv['numero_logradouro']; ?></span></td>
                        <td class="title_line" colspan="8">1.16 - Complemento do Número:</td>
                        <td colspan="5"><?php echo '<span id="complemento_numero">' . $dadosv['complemento_numero'] . '</span>'; ?></td>
                    </tr>
                    <tr>
                        <td colspan="12">1.17 - Complemento Adicional:</td>
                        <td colspan="8"><?php echo '<span id="complemento_adicional">' . $dadosv['complemento_adicional'] . '</span>'; ?></td>
                        <td colspan="2">1.18 - CEP:</td>
                        <td colspan="3"><?php echo '<span id="cep">' .  $dadosv['cep'] . '</span>'; ?></td>
                    </tr>
                    <tr>
                        <td colspan="12">1.20 - Referência para Localização:</td>
                        <td colspan="13"><?php echo '<span id="referencia_localizacao">' . $dadosv['referencia_localizacao'] . '</span>'; ?></td>
                    </tr>
    </div>
    </table><br><br>
    <!-- EXIBIR CADA MEMBRO DA FAMÍLIA-->
    <h4>COMPONENTES DA FAMÍLIA</h4>
    <hr>
    <?php
                $id_parecer = $dadosv['id'];
                $sql_membro_familia = "SELECT * FROM membros_familia WHERE parecer_id LIKE '$id_parecer' ORDER BY id ASC";
                $sql_membro_familia_query = $conn->query($sql_membro_familia) or die("ERRO ao consultar! " . $conn - error);

                if ($sql_membro_familia_query->num_rows == 0) {
                    //NENHUM MEMBRO FAMILIAR ENCONTRADO
                } else {
                    while ($member = $sql_membro_familia_query->fetch_assoc()) {
                        echo '<span class="parentesco">' . $member['parentesco'] . '</span><br>' ?? "FAMÍLIA SEM RESPONSÁVEL FAMILIAR (consulte o V7)";
                        echo '4.02 - Nome Completo: <span class="nome_completo">' . $member['nome_completo'] . '</span><br>';
                        echo '4.03 - NIS: <span class="nis">' . $member['nis'] . '</span>';
                        echo '4.06 - Data de Nascimento: <span class="data_nascimento">' . $member['data_nascimento'] . '<hr></span>';

    ?>
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
                $texto_paragrafo = str_replace("<br />", '</p><p id="resumo_visita">', $dadosv['resumo_visita']);
                echo '<p id="resumo_visita">' . $texto_paragrafo . '</p>';
                //echo '<span id="resumo_visita">' . $dadosv[''] . '</span>';
            }
        }
?>
</div>
<br><br>
<div class="assinatura">_______________________________________________________________________<br>Assinatura do Entrevistador</div><br><br>
<div class="assinatura">_______________________________________________________________________<br>Assinatura do Responsável</div>

<script>
    window.print()
    setTimeout(function() {
        window.location.href = "/TechSUAS/views/cadunico/visitas/buscarvisita";
    }, 3000);
</script>