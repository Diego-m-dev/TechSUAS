<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_impr_form.css">
    <link rel="website icon" type="image/png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Concessão - TechSUAS</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/concessao.js"></script>

</head>

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';
    

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dt_pg = $_POST['dt_pg'];
        $mes_pg = $_POST['mes_pg'];
        $itens_conc = $_POST['itens_conc'];
        $quantidade = $_POST['quantidade'];
        $valor_unitario = $_POST['valor_unitario'];
        $valor_total = $_POST['valor_total'];
        $situacao = $_POST['situacao'];
        $id_hist = $_POST['id_hist'];

        $valor_unitario = str_replace(',', '.', $valor_unitario);
        $valor_total = str_replace(',', '.', $valor_total);

        $smtp = $conn->prepare("UPDATE concessao_historico SET nome_item=?, qtd_item=?, valor_uni=?, valor_total=?, mes_pag=?, pg_data=?, situacao_concessao=? WHERE id_hist=?");
        $smtp->bind_param("ssssssss", $itens_conc, $quantidade, $valor_unitario, $valor_total, $mes_pg, $dt_pg, $situacao, $id_hist);
        if ($smtp->execute()) {

            if ($situacao == "CANCELADA") {
    ?>
                <script>
                    Swal.fire({
                        icon: "info",
                        html: `<h1>CANCELADO</h1>
                            <p>Concessão CANCELADA com sucesso.</p>`,
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/TechSUAS/views/concessao/consultar"
                        }
                    })
                </script>
                <?php
            } else {
                $smtp_historico = $conn->query("SELECT * FROM concessao_historico WHERE id_hist LIKE '$id_hist'");
                // Verifica se há resultados na consulta
                if ($smtp_historico->num_rows > 0) {
                    $dados_hist = $smtp_historico->fetch_assoc();
                    $cpf_pessoa = $dados_hist['cpf_resp'];
                    $smtp_resp = $conn->query("SELECT * FROM concessao_tbl WHERE cpf_pessoa LIKE '$cpf_pessoa'");
                    $dados_resp = $smtp_resp->fetch_assoc();

                    $cpf_benef1 = $dados_hist['cpf_benef'];
                    $cpf_benef = preg_replace('/[^0-9]/', '', $cpf_benef1);
                    $smtp_benef = $conn->query("SELECT * FROM tbl_tudo WHERE num_cpf_pessoa LIKE '$cpf_benef'");
                    if ($smtp_benef->num_rows > 0) {
                        $dados_benef = $smtp_benef->fetch_assoc();
                        $naturalidade = $dados_benef['nom_ibge_munic_nasc_pessoa'];
                        $nome_mae_benef = $dados_benef['nom_completo_mae_pessoa'];
                    } else {
                        $smtp_benef_sem_cad = $conn->query("SELECT * FROM beneficiario WHERE cpf_beneficio LIKE '$cpf_benef1'");
                        $dados_benef_sem_cad = $smtp_benef_sem_cad->fetch_assoc();
                        $naturalidade = $dados_benef_sem_cad['naturalidade'];
                        $nome_mae_benef = $dados_benef_sem_cad['nome_mae_benef'];
                    }
                ?>
                    <div class="titulo">
                        <div class="tech">
                            <p>TechSUAS-Concessão</p>
                        </div>
                        <div id="dataHora">
                            <?php
                            $datinha = new DateTime();
                            echo $datinha->format('d/m/Y H:i:s');
                            ?>
                        </div>
                    </div>
                    <div class="container">
                        <div class="cab0" style="text-align: center;">
                            <h2>CONCESSÃO DE BENEFÍCIO EVENTUAL</h2>
                            <p>(Amparada pela Lei Municipal nº 1.978, de 01 de novembro de 2017)</p>
                        </div>
                        <div class="form">
                            <p><?php
                                echo  "Formulário nº " . $dados_hist['num_form'] . '/' . $dados_hist['ano_form'];
                                ?></p>
                        </div>
                        <div class="cab1">
                            <div class="cab11" style="text-align: justify;" style="text-indent: 1cm;">
                                <p>Considerando a Lei nº 8.742, de 07 de dezembro de 1973 - Lei Orgânica da Assistência Social, em seu Art. 22;</p>
                                <p>Considerando a Lei Municipal n° 1.978, 01 de novembro de 2017 e Pela Resolução CMAS n° 13/2017;</p>
                                <p>Considerando a solicitação do Benefício Eventual feita pelo(a) usuário(a) abaixo qualificado(a), e por ele(a) se enquadrar no perfil para acesso a Concessão de Benefício Eventual e apresentar os documentos necessários, conforme anexo;</p>
                                <p>Considerando a avaliação técnica da condição de vulnerabilidade social temporária em se apresenta o(a) beneficiário(a);</p>
                            </div>
                        </div>
                    </div>
                    <div class="tabela">
                        <table align="center" width="500px" border='1'>
                            <tr class="resultado">
                                <td class="resultado" colspan="2">RESPONSÁVEL:</td>
                                <td class="resultado" colspan="9" id="nome_resp"><?php echo $dados_resp['nome']; ?></td>
                                <td class="resultado" colspan="2">NATURALIDADE:</td>
                                <td class="resultado" colspan="3" id="naturalidade_resp"><?php echo $dados_resp['naturalidade']; ?></td>
                            </tr>
                            <tr class="resultado">
                                <td class="resultado" colspan="2">NOME DA MÃE:</td>
                                <td class="resultado" colspan="9" id="nome_m"><?php echo $dados_resp['nome_mae']; ?></td>
                                <td class="resultado" colspan="2">CONTATO:</td>
                                <td class="resultado" colspan="3" id="contato"><?php echo $dados_resp['contato']; ?></td>
                            </tr>
                            <tr class="resultado">
                                <td class="resultado" colspan="16">Dados dos documentos do(a) Responsável:</td>
                            </tr>
                            <tr class="resultado">
                                <td class="resultado" colspan="3" id="cpf_pessoa">CPF:<?php echo $dados_resp['cpf_pessoa']; ?></td>
                                <td class="resultado" colspan="1" id="tet_ili">TÍTULO:<?php echo $dados_resp['tit_eleitor_pessoa']; ?></td>
                                <td class="resultado" colspan="9" id="rg_pessoa">RG:<?php echo $dados_resp['rg_pessoa']; ?></td>
                                <td class="resultado" colspan="3" id="nis_pessoa">NIS:<?php echo $dados_resp['nis_pessoa']; ?></td>
                            </tr>
                            <tr class="resultado">
                                <td class="resultado" colspan="3">BENEFICIÁRIO:</td>
                                <td class="resultado" colspan="6" id="nome_benef"><?php echo $dados_hist['nome_benef']; ?></td>
                                <td class="resultado" colspan="3">NATURALIDADE:</td>
                                <td class="resultado" colspan="4" id="munic_nasc"><?php echo $naturalidade; ?></td>
                            </tr>
                            <tr class="resultado">
                                <td class="resultado" colspan="3">NOME DA MÃE:</td>
                                <td class="resultado" colspan="8" id="nom_mae_pessoa"><?php echo $nome_mae_benef; ?></td>
                                <td class="resultado" colspan="2">RENDA MEDIA:</td>
                                <td class="resultado" colspan="3" id="renda_media">R$<?php echo $dados_hist['renda_media']; ?>,00</td>
                            </tr>
                            <tr class="resultado">
                                <td class="resultado" colspan="3">ENDEREÇO:</td>
                                <td class="resultado" colspan="13" id="endereco_conc"><?php echo $dados_hist['endereco']; ?></td>
                            </tr>
                            <tr class="resultado">
                                <td class="resultado" colspan="16">Dados dos documentos do(a) Beneficiário(a):</td>
                            </tr>
                            <tr class="resultado">
                                <td class="resultado" colspan="3" id="cpf_pessoa_b">CPF: <?php echo $dados_hist['cpf_benef']; ?></td>
                                <td class="resultado" colspan="1" id="tet_ili_b">T.E.: <?php echo $dados_hist['tit_benef']; ?></td>
                                <td class="resultado" colspan="9" id="rg_pessoa_b">RG: <?php echo $dados_hist['rg_benef']; ?></td>
                                <td class="resultado" colspan="3" id="nis_pessoa_b">NIS: <?php echo $dados_hist['nis_benef']; ?></td>
                            </tr>
                        </table><br>


                        <p align="center" width="500px" id="parentes"></p>

                        <table align="center" width="500px" border='1'>
                            <tr>
                                <th>ITEM</th>
                                <th>Descrição sucinta do bem, objeto ou serviço a ser concedido.</th>
                                <th>QUANT.</th>
                                <th>VALOR UN</th>
                                <th>VALOR TOTAL</th>
                            </tr>
                            <tr>
                                <td id="nome_item"><?php echo $dados_hist['nome_item']; ?></td>
                                <td id="descricao"><?php echo $dados_hist['descricao']; ?></td>
                                <td id="qtd_item"><?php echo $dados_hist['qtd_item']; ?></td>
                                <td id="valor_uni"><?php echo $dados_hist['valor_uni']; ?></td>
                                <td id="valor_total"><?php echo $dados_hist['valor_total']; ?></td>
                            </tr>
                        </table><br>

                        <div class="sbu" style="text-align: right;">
                            <p id="local_data"> </p>
                        </div>


                        <div class="cab2">
                            <p>_________________________________________________________________________<br>ASSINATURA DO RESPONSÁVEL:</p>
                            <p>____________________________________________________________<br>MARTHONY DORNELA SANTANA<br>SECRETÁRIO DE ASSISTÊNCIA SOCIAL<br>PORTARIA 143/2023</p>
                        </div>
                    </div>
                    </div>

                    <script>
                        window.print()
                        setTimeout(function() {
                            Swal.fire({
                                icon: "success",
                                html: `<h1>SALVO</h1>
                        <p>Dados salvos com sucesso!</p>`,
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "/TechSUAS/views/concessao/consultar.php"
                                }
                            })
                        }, 1500);
                    </script>
    <?php
                }

                exit();
            }
        } else {
            echo "Erro na atualização das informações: " . $smtp->error;
        }
        $smtp->close();
    }
    ?>
    
</body>

</html>