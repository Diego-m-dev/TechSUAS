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

    <style>
        #noformat,
        #noformat * {
            all: unset;
            display: revert;
            /* Reverte o display ao valor padrão para cada elemento */
        }
    </style>

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style_print_visita.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Registro de visita domiciliar</title>

</head>

<body class="<?php echo 'background-' . $_SESSION['estilo']; ?>">
    <div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único</span> - <?php echo $data_cabecalho; ?>
        </div>
    </div>

    <div class="tudo">
        <h1>REGISTRO DE INFORMAÇÕES COMPLEMENTARES DE VISITA DOMICILIAR</h1><br>
        <?php
        $id_visita = $_POST["id_visita"];

        //data criada com formato 'DD de mmmm de YYYY'
        $data_formatada_at = $dia_atual . " de " . $mes_formatado . " de " . $ano_atual;

        // Consulta SQL para contar os registros
        $sqlr = "SELECT COUNT(*) as total_registros FROM historico_parecer_visita WHERE ano_parecer = '$ano_atual'";
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
                        <span id="numero_parecer"><?php echo $numero_parecer_formatado; ?></span>/<span id="ano_parecer"><?php echo $ano_atual; ?></span><br>
                        <span class="cidade_data">São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</span>

                        <!-- MOSTRAR OS DADOS DA FAMÍLIA DE ACORDO COM A TBL_TUDO-->
                        <h3>DADOS DA FAMÍLIA</h3>
                        <?php
                        //CÓDIGO FAMILIAR SENDO FORMATADO E EXIBIDO
                        $codigo_formatado = substr_replace(str_pad($dados_tudo['cod_familiar_fam'], 11, '0', STR_PAD_LEFT), '-', 9, 0);
                        echo 'Código Familiar: <span id="codigo_familiar">' . $codigo_formatado . '</span>';

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
                        echo 'Data da visita: <span id="data_entrevista">' . $data_formatada . '</span><br>';

                        //RENDA PERCAPITA FORMATADA E EXIBIDA
                        echo 'Renda per capita da família: <span id="renda_per_capita">R$ ' . $dados_tudo['vlr_renda_media_fam'] . ',00 </span>';
                        $cep = substr_replace($dados_tudo['num_cep_logradouro_fam'], '-', 5, 0);
                        ?>
                        <!--ENDEREÇO DA FAMÍLIA-->
                        <h3>ENDEREÇO DA FAMÍLIA</h3><br>
                        <?php echo '<div class="end_familia">'; ?>
                        <table class="table_alin" id="noformat" style="margin: -0.8cm">
                            <tr>
                                <td class="title_line" colspan="8">1.11 - Localidade:</td>
                                <td colspan="17"><?php echo '<span id="localidade">' . $dados_tudo['nom_localidade_fam'] . '</span>'; ?></td>
                            </tr>
                            <tr>
                                <td class="title_line" colspan="8">1.12 - Tipo:</td>
                                <td colspan="6"><?php echo '<span id="tipo">' . $dados_tudo['nom_tip_logradouro_fam'] . '</span>'; ?></td>
                                <td class="title_line" colspan="3">1.13 - Título:</td>
                                <td colspan="8"><?php echo '<span id="titulo">' . $dados_tudo['nom_titulo_logradouro_fam'] . '</span>'; ?></td>
                            </tr>
                            <tr>
                                <td class="title_line" colspan="5">1.14 - Nome:</td>
                                <td colspan="20"><?php echo '<span id="nome_logradouro">' . $dados_tudo['nom_logradouro_fam'] . '</span>'; ?></td>
                            </tr>
                            <tr>
                                <td class="title_line" colspan="8">1.15 - Número:</td>
                                <td colspan="4"><span id="numero_logradouro"><?php echo $dados_tudo['num_logradouro_fam'] == 0 ? "" : $dados_tudo['num_logradouro_fam']; ?></span></td>
                                <td class="title_line" colspan="8">1.16 - Complemento do Número:</td>
                                <td colspan="5"><?php echo '<span id="complemento_numero">' . $dados_tudo['des_complemento_fam'] . '</span>'; ?></td>
                            </tr>
                            <tr>
                                <td colspan="12">1.17 - Complemento Adicional:</td>
                                <td colspan="8"><?php echo '<span id="complemento_adicional">' . $dados_tudo['des_complemento_adic_fam'] . '</span>'; ?></td>
                                <td colspan="2">1.18 - CEP:</td>
                                <td colspan="3"><?php echo '<span id="cep">' . $cep . '</span>'; ?></td>
                            </tr>
                            <tr>
                                <td colspan="12">1.20 - Referência para Localização:</td>
                                <td colspan="13"><?php echo '<span id="referencia_localizacao">' . $dados_tudo['txt_referencia_local_fam'] . '</span>'; ?></td>
                            </tr>
                        </table><br>
                        <?php echo '</div>'; ?>
                        <!-- EXIBIR CADA MEMBRO DA FAMÍLIA-->
                        <h3>COMPONENTES DA FAMÍLIA</h3>
                        <hr>
                        <?php
                        if ($sql_familia_pessoa_query->num_rows == 0) {
                            //NENHUM MEMBRO FAMILIAR ENCONTRADO
                        } else {
                            while ($member = $sql_familia_pessoa_query->fetch_assoc()) {

                                $parentesco_map = [
                                    1 => "RESPONSAVEL FAMILIAR",
                                    2 => "CONJUGE OU COMPANHEIRO",
                                    3 => "FILHO(A)",
                                    4 => "ENTEADO(A)",
                                    5 => "NETO(A) OU BISNETO(A)",
                                    6 => "PAI OU MÃE",
                                    7 => "SOGRO(A)",
                                    8 => "IRMÃO OU IRMÃ",
                                    9 => "GENRO OU NORA",
                                    10 => "OUTROS PARENTES",
                                    11 => "NÃO PARENTE"
                                ];

                                echo '<span class="parentesco">' . $parentesco_map[$member['cod_parentesco_rf_pessoa']] . '</span><br>' ?? "FAMÍLIA SEM RESPONSÁVEL FAMILIAR (consulte o V7)";
                                echo '4.02 - Nome Completo: <span class="nome_completo">' . $member['nom_pessoa'] . '</span><br>';
                                echo '4.03 - NIS: <span class="nis">' . $member['num_nis_pessoa_atual'] . '</span>';

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
                                echo '4.06 - Data de Nascimento: <span class="data_nascimento">' . $data_formatada_nasc . '<hr></span>';
                            }
                        }
                        ?>
                        <!--AREA DAS INFORMAÇÕES DO ENTREVISTADOR-->
                        <h3>OBSERVAÇÕES DO ENTREVISTADOR</h3>
                        <h4>Situação</h4>
                        <?php
                        $acao_map = [
                            1 => "ATUALIZAÇÃO REALIZADA",
                            2 => "NÃO LOCALIZADO",
                            3 => "FALECIMENTO DO RESPONSÁVEL FAMILIAR",
                            4 => "A FAMÍLIA RECUSOU ATUALIZAR",
                            5 => "ATUALIZAÇÃO NÃO REALIZADA"
                        ];

                        echo '<span id="situacao">' . $acao_map[$dadosv['acao']] . '</span>' ?? "SEM MOTIVO";
                        ?>

                        <h4>Resumo da visita</h4>
                        <?php
                        $texto_paragrafo = str_replace("<br />", '</p><p id="resumo_visita">', $dadosv['parecer_tec']);
                        echo '<p id="resumo_visita">' . $texto_paragrafo . '</p>';
                        ?>
                    </form>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            imprimirParecer()
                        })
                    </script>
                <?php
                } else {
                    //CASO NÃO HAJA DADOS DA FAMÍLIA EM TBL_TUDO UM FORMULÁRIO PARA PREENCHIMENTO MANUAL SERÁ EXIBIDO
                ?>
                    <!-- INICIA O FORMULÁRIO PARA CONFERIR OS DADOS E POSTERIORMENTE IMPRIMIR -->
                    <form id="visitaForm">
                        <label for="">Nº Documento:</label>
                        <span id="id_visita" style="display: none;"><?php echo $id_visita; ?></span>
                        <span id="numero_parecer"><?php echo $numero_parecer_formatado; ?></span>/<span id="ano_parecer"><?php echo $ano_atual; ?></span><br>
                        <span class="cidade_data">São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</span>

                        <!-- MOSTRAR OS DADOS DA FAMÍLIA DE ACORDO COM A TBL_TUDO-->
                        <h3>DADOS DA FAMÍLIA</h3>
                        <?php
                        $codigo_fami = substr_replace(str_pad($codfam, 11, "0", STR_PAD_LEFT), '-', 9, 0);
                        echo 'Código familiar: <span id="codigo_familiar"><span id="titulo" class="editable-field" contenteditable="true" >' . $codigo_fami . '</span></span>';

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
                        echo 'Data da visita: <span id="data_entrevista">' . $data_formatada . '</span><br>';

                        //RENDA PERCAPITA FORMATADA E EXIBIDA
                        echo 'Renda per capita da família: <span id="renda_per_capita">R$ <span class="editable-field" contenteditable="true" ></span>,00 </span>';

                        ?>
                        <h3>ENDEREÇO DA FAMÍLIA</h3>
                        <table>
                            <!--L1-->
                            <tr>
                                <td class="title_line" colspan="5">1.11 - Localidade:</td>
                                <td colspan="20"><?php echo '<span id="localidade" class="editable-field" contenteditable="true" ></span>'; ?></td>
                            </tr>
                            <!--L2-->
                            <tr>
                                <td class="title_line" colspan="5">1.12 - Tipo:</td>
                                <td colspan="6"><?php echo '<span id="tipo" class="editable-field" contenteditable="true" ></span>'; ?></td>
                                <td class="title_line" colspan="3">1.13 - Título:</td>
                                <td colspan="11"><?php echo '<span id="titulo" class="editable-field" contenteditable="true" ></span>'; ?></td>
                            </tr>
                            <!--L3-->
                            <tr>
                                <td class="title_line" colspan="5">1.14 - Nome:</td>
                                <td colspan="20"><?php echo '<span id="nome_logradouro" class="editable-field" contenteditable="true" ></span>'; ?></td>
                            </tr>
                            <!--L4-->
                            <tr>
                                <td class="title_line" colspan="5">1.15 - Número:</td>
                                <td colspan="6"><?php echo '<span id="numero_logradouro" class="editable-field" contenteditable="true" ></span>'; ?></td>
                                <td class="title_line" colspan="5">1.16 - Complemento do Número:</td>
                                <td colspan="9"><?php echo '<span id="complemento_numero" class="editable-field" contenteditable="true" ></span>'; ?></td>
                            </tr>
                            <!--L5-->
                            <tr>
                                <td class="title_line" colspan="5">1.17 - Complemento Adicional:</td>
                                <td colspan="20"><?php echo '<span id="complemento_adicional" class="editable-field" contenteditable="true" ></span>'; ?></td>
                            </tr>
                            <!--L6-->
                            <tr>
                                <td class="title_line" colspan="3">1.18 - CEP:</td>
                                <td colspan="7"><?php echo '<span id="cep" class="editable-field" contenteditable="true" ></span>'; ?></td>
                                <td class="title_line" colspan="6">1.20 - Referência para Localização:</td>
                                <td colspan="9"><?php echo '<span id="referencia_localizacao" class="editable-field" contenteditable="true" ></span>'; ?></td>
                            </tr>
                        </table>
                        <h3>INFORMAÇÕES DO RESPONSÁVEL PELA UNIDADE FAMILIAR</h3>
                        <?php
                        echo '<hr>4.02 - Nome Completo: <span id="nome_completo" class="editable-field" contenteditable="true" ></span>';
                        echo '4.03 - NIS: <span id="nis" class="editable-field" contenteditable="true" ></span>';
                        echo '4.06 - Data de Nascimento: <span id="data_nascimento" class="editable-field" contenteditable="true" ></span><hr>';

                        ?>
                        <h3>OBSERVAÇÕES DO ENTREVISTADOR</h3>
                        <h4>Situação</h4>
                        <?php
                        $acao_map = [
                            1 => "ATUALIZAÇÃO REALIZADA",
                            2 => "NÃO LOCALIZADO",
                            3 => "FALECIMENTO DO RESPONSÁVEL FAMILIAR",
                            4 => "A FAMÍLIA RECUSOU ATUALIZAR",
                            5 => "ATUALIZAÇÃO NÃO REALIZADA"
                        ];

                        echo '<span id="situacao">' . $acao_map[$dadosv['acao']] . '</span>' ?? "Não existe outra nada aqui";
                        ?>
                        <h5>Resumo da visita</h5>
                        <?php
                        echo '<div">';
                        echo '<p><span id="resumo_visita">' . $dadosv['parecer_tec'] . '</span></p>';
                        echo '</div">';
                        ?>
                        <button type="button" onclick="salvaCodigoEditado(); imprimirParecer()">IMPRIMIR</button>
                        <a href="/TechSUAS/config/back"><i class="fas fa-arrow-left"></i>VOLTAR</a>
                    </form>

    </div>
<?php

                }
?>
<br><br>
<div class="assinatura">_________________________________________________________________<br>Assinatura do Entrevistador</div><br><br>
<div class="assinatura">_________________________________________________________________<br>Assinatura do Responsável</div>

<?php
            } else {
            }
        }
?>


</body>

</html>