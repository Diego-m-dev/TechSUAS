<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style_conferir.css">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style_reprint.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Registro de visita domiciliar</title>

</head>

<body>
    <h1>REGISTRO DE INFORMAÇÕES COMPLEMENTARES DE VISITA DOMICILIAR</h1>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/controller/cadunico/declaracao/create_moth.php';

    $id_visita = $_POST["id_visita"];

    //data criada com formato 'DD de mmmm de YYYY'
    $data_formatada_at = $dia_atual . " de " . $mes_formatado . " de ". $ano_atual;

    // Consulta SQL para contar os registros
    $sqlr = "SELECT COUNT(*) as total_registros FROM historico_parecer_visita";
    $result = $pdo->query($sqlr);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalRegistros = $row['total_registros'];
    $numero_parecer = $totalRegistros + 1;

    $numero_parecer_formatado = str_pad($numero_parecer, 4, "0", STR_PAD_LEFT);

    $sqli = $pdo->prepare("SELECT * FROM visitas_feitas WHERE id = :idvisita");
    $sqli->bindParam(':idvisita', $id_visita, PDO::PARAM_STR);
    $sqli->execute();

    // Verifica se o formulário foi enviado via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //Verifica se a consulta em visita_feitas retornou algum resultado
        if ($sqli->rowCount() > 0) {
            // Recupera os dados da consulta
            $dadosv = $sqli->fetch(PDO::FETCH_ASSOC);
            $codfam = $dadosv['cod_fam'];

            $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE cod_familiar_fam = LPAD(:codfam, 11, '0') AND cod_parentesco_rf_pessoa = 1");
            $sql->bindParam(':codfam', $codfam, PDO::PARAM_STR);
            $sql->execute();

            $sql_familia_pessoa = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam LIKE '%$codfam%' ORDER BY cod_parentesco_rf_pessoa ASC, dta_nasc_pessoa ASC";
            $sql_familia_pessoa_query = $conn->query($sql_familia_pessoa) or die("ERRO ao consultar! " . $conn - error);

            //Verifica se a consulta em tbl_tudo retornou algum resultado
            if ($sql->rowCount() > 0) {
                $dados_tudo = $sql->fetch(PDO::FETCH_ASSOC);
?>
                <!-- INICIA O FORMULÁRIO PARA CONFERIR OS DADOS E POSTERIORMENTE IMPRIMIR -->
                <form id="visitaForm">
                    <span id="id_visita" style="display: none;"><?php echo $id_visita; ?></span>
                    <label for="">Nº Documento:</label>
                    <span id="numero_parecer"><?php echo $numero_parecer_formatado; ?></span>/<span id="ano_parecer"><?php echo $ano_atual; ?></span>
                    <span>São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</span>

            <!-- MOSTRAR OS DADOS DA FAMÍLIA DE ACORDO COM A TBL_TUDO-->
            <h4>DADOS DA FAMÍLIA</h4>
<?php
            //CÓDIGO FAMILIAR SENDO FORMATADO E EXIBIDO
            $codigo_formatado = substr_replace(str_pad($dados_tudo['cod_familiar_fam'], 11, '0',STR_PAD_LEFT), '-', 9, 0);
            echo 'CÓDIGO FAMILIAR: <span id="codigo_familiar">'. $codigo_formatado. '</span>';

                //DATA DA ULTIMA ATUALIZAÇÃO FORMATADA E EXIBINDO
                $data = $dadosv['data'];
                    if (!empty($data)) {
                        $formatando_data = DateTime::createFromFormat('Y-m-d', $data);
                        // Verifica se a data foi criada corretamente
                        if ($formatando_data) {
                            $data_formatada = $formatando_data->format('d/m/Y');
                        } else {
                            $data_formatada = "Data inválida.";
                        }
                    } else {
                        $data_formatada = "Data não fornecida.";
                    }
            echo 'DATA DA VISITA: <span id="data_entrevista">'. $data_formatada. '</span>';

            //RENDA PERCAPITA FORMATADA E EXIBIDA
            echo 'RENDA PER CAPITA DA FAMÍLIA: <span id="renda_per_capita">R$ '. $dados_tudo['vlr_renda_media_fam']. ',00 </span>';
?>
            <!--ENDEREÇO DA FAMÍLIA-->
            <h4>ENDEREÇO DA FAMÍLIA</h4>
<?php
            echo '<span id="localidade">1.11 - Localidade: '. $dados_tudo['nom_localidade_fam'] . '</span>';
            echo '<span id="tipo">1.12 - Tipo: '. $dados_tudo['nom_tip_logradouro_fam'] . '</span>';
            echo '<span id="titulo">1.13 - Título: '. $dados_tudo['nom_titulo_logradouro_fam'] . '</span>';
            echo '<span id="nome_logradouro">1.14 - Nome: '. $dados_tudo['nom_logradouro_fam'] . '</span>';
            echo '<span id="numero_logradouro">1.15 - Número: '. $dados_tudo['num_logradouro_fam'] . '</span>';
            echo '<span id="complemento_numero">1.16 - Complemento do Número: '. $dados_tudo['des_complemento_fam'] . '</span>';
            echo '<span id="complemento_adicional">1.17 - Complemento Adicional: '. $dados_tudo['des_complemento_adic_fam'] . '</span>';
            $cep = substr_replace($dados_tudo['num_cep_logradouro_fam'], '-', 5, 0);
            echo '<span id="cep">1.18 - CEP: '. $cep . '</span>';
            echo '<span id="referencia_localizacao">1.20 - Referência para Localização: '. $dados_tudo['txt_referencia_local_fam'] . '</span>';

?>
            <!-- EXIBIR CADA MEMBRO DA FAMÍLIA-->
            <h4>COMPONENTES DA FAMÍLIA</h4><hr>
<?php
            if ($sql_familia_pessoa_query->num_rows == 0) {
                //NENHUM MEMBRO FAMILIAR ENCONTRADO
            } else {
                while ($member = $sql_familia_pessoa_query->fetch_assoc()) {
                                $parentesco = $member['cod_parentesco_rf_pessoa'];
                                $parentesco_pessoa = '';
                                if ($parentesco == 1){
                                    $parentesco_pessoa = "RESPONSAVEL FAMILIAR";
                                } elseif ($parentesco == 2){
                                    $parentesco_pessoa = "CONJUGE OU COMPANHEIRO";
                                } elseif ($parentesco == 3){
                                    $parentesco_pessoa = "FILHO(A)";
                                } elseif ($parentesco == 4){
                                    $parentesco_pessoa = "ENTEADO(A)";
                                } elseif ($parentesco == 5){
                                    $parentesco_pessoa = "NETO(A) OU BISNETO(A)";
                                } elseif ($parentesco == 6){
                                    $parentesco_pessoa = "PAI OU MÃE";
                                } elseif ($parentesco == 7){
                                    $parentesco_pessoa = "SOGRO(A)";
                                } elseif ($parentesco == 8){
                                    $parentesco_pessoa = "IRMÃO OU IRMÃ";
                                } elseif ($parentesco == 9){
                                    $parentesco_pessoa = "GENRO OU NORA";
                                } elseif ($parentesco == 10){
                                    $parentesco_pessoa = "OUTROS PARENTES";
                                } elseif ($parentesco == 11){
                                    $parentesco_pessoa = "NÃO PARENTE";
                                } else {
                                    $parentesco_pessoa = "FAMÍLIA SEM RESPONSÁVEL FAMILIAR (consulte o V7)";
                                }
                                echo '<span class="parentesco">' . $parentesco_pessoa . '</span>';
                                echo '<span class="nome_completo">4.02 - Nome Completo: ' . $member['nom_pessoa'] . '</span>';
                                echo '<span class="nis">4.03 - NIS: ' . $member['num_nis_pessoa_atual'] . '</span>';

                                $data_nasc = $member['dta_nasc_pessoa'];
                                if (!empty($data_nasc)) {
                                    $formatando_data = DateTime::createFromFormat('Y-m-d', $data_nasc);
                                    // Verifica se a data foi criada corretamente
                                    if ($formatando_data) {
                                        $data_formatada_nasc = $formatando_data->format('d/m/Y');
                                    } else {
                                        $data_formatada_nasc = "Data inválida.";
                                    }
                                } else {
                                    $data_formatada_nasc = "Data não fornecida.";
                                }
                                echo '<span class="data_nascimento">4.06 - Data de Nascimento: ' . $data_formatada_nasc . '<hr></span>';
                }
            }
?>
            <!--AREA DAS INFORMAÇÕES DO ENTREVISTADOR-->
            <h4>OBSERVAÇÕES DO ENTREVISTADOR</h4>
            <h5>Situação</h5>
<?php
                    if ($dadosv['acao'] == 1) {
                        $acao = "ATUALIZAÇÃO REALIZADA";
                    } else if ($dadosv['acao'] == 2) {
                        $acao = "NÃO LOCALIZADO";
                    } else if ($dadosv['acao'] == 3) {
                        $acao = "FALECIMENTO DO RESPONSÁVEL FAMILIAR";
                    } else if ($dadosv['acao'] == 4) {
                        $acao = "A FAMÍLIA RECUSOU ATUALIZAR";
                    } else if ($dadosv['acao'] == 5) {
                        $acao = "ATUALIZAÇÃO NÃO REALIZADA";
                    }
                    echo '<span id="situacao">' . $acao . '</span>';
?>

            <h5>Resumo da visita</h5>
<?php
                    echo '<span id="resumo_visita">' . $dadosv['parecer_tec'] . '</span>';
?>
            <button type="button"  onclick="imprimirParecerPARTE()">IMPRIMIR</button>
                </form>
<?php
        } else {

            //CASO NÃO HAJA DADOS DA FAMÍLIA EM TBL_TUDO UM FORMULÁRIO PARA PREENCHIMENTO MANUAL SERÁ EXIBIDO
?>
            <!-- INICIA O FORMULÁRIO PARA CONFERIR OS DADOS E POSTERIORMENTE IMPRIMIR -->
            <form id="visitaForm">
            <label for="">Nº Documento:</label>
            <span id="id_visita" style="display: none;"><?php echo $id_visita; ?></span>
            <span id="numero_parecer"><?php echo $numero_parecer_formatado; ?></span>/<span id="ano_parecer"><?php echo $ano_atual; ?></span>
            <span>São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</span>

            <!-- MOSTRAR OS DADOS DA FAMÍLIA DE ACORDO COM A TBL_TUDO-->
            <h4>DADOS DA FAMÍLIA</h4>
<?php
            echo 'CÓDIGO FAMILIAR: <span id="codigo_familiar">'. substr_replace(str_pad($codfam, 11, "0", STR_PAD_LEFT), '-', 9, 0). '</span>';

            //DATA DA ULTIMA ATUALIZAÇÃO FORMATADA E EXIBINDO
                    $data = $dadosv['data'];
                    if (!empty($data)) {
                        $formatando_data = DateTime::createFromFormat('Y-m-d', $data);
                        // Verifica se a data foi criada corretamente
                        if ($formatando_data) {
                            $data_formatada = $formatando_data->format('d/m/Y');
                        } else {
                            $data_formatada = "Data inválida.";
                        }
                    } else {
                        $data_formatada = "Data não fornecida.";
                    }
            echo 'DATA DA VISITA: <span id="data_entrevista">'. $data_formatada. '</span>';

                //RENDA PERCAPITA FORMATADA E EXIBIDA
                echo 'RENDA PER CAPITA DA FAMÍLIA: <span id="renda_per_capita">R$ <span class="editable-field" contenteditable="true" ></span>,00 </span>';

?>
            <h4>ENDEREÇO DA FAMÍLIA</h4>
<?php
        echo '1.11 - Localidade: <span id="localidade" class="editable-field" contenteditable="true" ></span>';
        echo '1.12 - Tipo: <span id="tipo" class="editable-field" contenteditable="true" ></span>';
        echo '1.13 - Título: <span id="titulo" class="editable-field" contenteditable="true" ></span>';
        echo '1.14 - Nome: <span id="nome_logradouro" class="editable-field" contenteditable="true" ></span>';
        echo '1.15 - Número: <span id="numero_logradouro" class="editable-field" contenteditable="true" ></span>';
        echo '1.16 - Complemento do Número: <span id="complemento_numero" class="editable-field" contenteditable="true" ></span>';
        echo '1.17 - Complemento Adicional: <span id="complemento_adicional" class="editable-field" contenteditable="true" ></span>';
        echo '1.18 - CEP: <span id="cep" class="editable-field" contenteditable="true" ></span>';
        echo '1.20 - Referência para Localização: <span id="referencia_localizacao" class="editable-field" contenteditable="true" ></span>';
?>
            <h4>INFORMAÇÕES DO RESPONSÁVEL PELA UNIDADE FAMILIAR</h4>
<?php
        echo '<hr>4.02 - Nome Completo: <span id="nome_completo" class="editable-field" contenteditable="true" ></span>';
        echo '4.03 - NIS: <span id="nis" class="editable-field" contenteditable="true" ></span>';
        echo '4.06 - Data de Nascimento: <span id="data_nascimento" class="editable-field" contenteditable="true" ></span><hr>';
        
?>
            <h4>OBSERVAÇÕES DO ENTREVISTADOR</h4>
            <h5>Situação</h5>
<?php
                                if ($dadosv['acao'] == 1) {
                                    $acao = "ATUALIZAÇÃO REALIZADA";
                                } else if ($dadosv['acao'] == 2) {
                                    $acao = "NÃO LOCALIZADO";
                                } else if ($dadosv['acao'] == 3) {
                                    $acao = "FALECIMENTO DO RESPONSÁVEL FAMILIAR";
                                } else if ($dadosv['acao'] == 4) {
                                    $acao = "A FAMÍLIA RECUSOU ATUALIZAR";
                                } else if ($dadosv['acao'] == 5) {
                                    $acao = "ATUALIZAÇÃO NÃO REALIZADA";
                                }
            echo '<span id="situacao">'. $acao .'</span>';
?>
            <h5>Resumo da visita</h5>
<?php
            echo '<span id="resumo_visita">'. $dadosv['parecer_tec']. '</span>';
?>
</form>

<?php
        }

    } else {

    }
}
?>

</body>

</html>