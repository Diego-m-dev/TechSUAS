<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style-visitas_does.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Visitas Pendentes</title>
</head>
<body>
<div class="rint-section">
    <div class="titulo">
            <div class="tech">
                <span>TechSUAS-Cadastro Único </span><?php echo $data_cabecalho; ?>
            </div>
        </div>
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
        <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>

        <?php
        echo '<div class="tudo">';
        echo '<h1>VISITAS PENDENTES</h1>';
        foreach ($nis_form as $nis) {

            $sql_dados = "SELECT * FROM tbl_tudo  WHERE num_nis_pessoa_atual LIKE '%$nis%'";
            $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

            if ($sql_query->num_rows == 0) {
                echo 'Sem informação desse NIS: '. $nis;
            } else {
                $dados = $sql_query->fetch_assoc();
                $codigo_familiar = $dados['cod_familiar_fam'];
                // Remove os zeros à esquerda
                $cod_fam = ltrim($codigo_familiar, '0');


                $sql_visitas_did = "SELECT * FROM visitas_feitas WHERE cod_fam = '$cod_fam'";
                $sql_query_vis_did = $conn->query($sql_visitas_did) or die("ERRO ao consultar !" . $conn - error);

                if ($sql_query_vis_did->num_rows == 0) {
                    $resultado = "";
                } else {
                    $dados_visitinha = $sql_query_vis_did->fetch_assoc();
                    $aviso = "ESSA FAMILIA JÁ FOI VISITADA NO DIA ";
                    $datadaVisita = $dados_visitinha['data'];

                    if (!empty($datadaVisita)) {
                        $formatando_data_visita = DateTime::createFromFormat('Y-m-d', $datadaVisita);
                
                        // Verifica se a data foi criada corretamente
                        if ($formatando_data_visita) {
                            $data_visita = $formatando_data_visita->format('d/m/Y');
                        } else {
                            $data_visita = "Data inválida.";
                        }
                    } else {
                        $aviso_base = "Data não fornecida.";
                    }
                    $resultado = $aviso . $data_visita;
                }


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
                <h4 style="color: red;"><?php echo $resultado; ?></h4>
                <?php
                $codigo_formatado = substr_replace(str_pad($dados['cod_familiar_fam'], 11, '0',STR_PAD_LEFT), '-', 9, 0);
                echo $codigo_formatado. '<br>';
                ?>
                <p>Responsável Familiar: <strong><?php echo $dados['nom_pessoa']; ?></strong></p>
                <?php

                $cep = substr_replace($dados['num_cep_logradouro_fam'], '-', 5, 0);
                ?>
                <table border="1" width="800">
                    <tr>
                        <th>ENDEREÇO</th>
                    </tr>
                    <tr>
                        <td>
                    <table class="table_alin" width="798">
                <tr>
                    <td class="title_line" colspan="5">1.11 - Localidade:</td>
                    <td colspan="20"><?php echo '<span id="localidade">'. $dados['nom_localidade_fam'] . '</span>'; ?></td>
                </tr>
                <tr>
                    <td class="title_line" colspan="4">1.12 - Tipo:</td>
                    <td colspan="16"><?php echo '<span id="tipo">'. $dados['nom_tip_logradouro_fam'] . '</span>'; ?></td>
                    <td class="title_line" colspan="2">1.13 - Título:</td>
                    <td colspan="3"><?php echo '<span id="titulo">'. $dados['nom_titulo_logradouro_fam'] . '</span>'; ?></td>
                </tr>
                <tr>
                    <td class="title_line" colspan="4">1.14 - Nome:</td>
                    <td colspan="21"><?php echo '<span id="nome_logradouro">'. $dados['nom_logradouro_fam'] . '</span>'; ?></td>
                </tr>
                <tr>
                    <td class="title_line" colspan="8">1.15 - Número:</td>
                    <td colspan="4"><span id="numero_logradouro"><?php echo $dados['num_logradouro_fam'] == 0 ? "" : $dados['num_logradouro_fam']; ?></span></td>
                    <td class="title_line" colspan="8">1.16 - Complemento do Número:</td>
                    <td colspan="5"><?php echo '<span id="complemento_numero">'. $dados['des_complemento_fam'] . '</span>'; ?></td>
                </tr>
                <tr>
                    <td colspan="12">1.17 - Complemento Adicional:</td>
                    <td colspan="8"><?php echo '<span id="complemento_adicional">'. $dados['des_complemento_adic_fam'] . '</span>'; ?></td>
                    <td colspan="2">1.18 - CEP:</td>
                    <td colspan="3"><?php echo '<span id="cep">'. $cep . '</span>'; ?></td>
                </tr>
                <tr>
                    <td colspan="12">1.20 - Referência para Localização:</td>
                    <td colspan="13"><?php echo '<span id="referencia_localizacao">'. $dados['txt_referencia_local_fam'] . '</span>'; ?></td>
                </tr>
            </table>
                        </td>
                    </tr>
                </table><br>
                <?php

                    $sql_dados_fam = "SELECT * FROM tbl_tudo  WHERE cod_familiar_fam LIKE '%$codigo_familiar%' AND cod_parentesco_rf_pessoa != 1";
                    $sql_query_fam = $conn->query($sql_dados_fam) or die("ERRO ao consultar !" . $conn - error);

                    if ($sql_query_fam->num_rows == 0) {
                        
                    } else {
                        ?>
                        <table border="1" width="800">
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

        <?php
        //echo 'NIS: '. htmlspecialchars($nis). '<br>';
    }
    }
    echo '</div>';
    ?>
</div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cria um elemento span para armazenar o número da página
            var pageNumber = document.createElement("span");
            pageNumber.classList.add("page-number");
            
            // Encontra o rodapé e adiciona o span do número da página a ele
            var footer = document.querySelector(".rodape");
            if (footer) {
                footer.appendChild(pageNumber);
            }
        });

        window.addEventListener("beforeprint", function() {
            var totalPages = document.querySelectorAll('.page').length;
            var pageNumbers = document.querySelectorAll('.page-number');

            pageNumbers.forEach((pageNumber, index) => {
                pageNumber.textContent = (index + 1) + " de " + totalPages;
            });
        });
    </script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
</body>
</html>