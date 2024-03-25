<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';

$data_atual = date('Y');
$qtd_conc = "SELECT COUNT(*) as total_registros FROM concessao_historico WHERE ano_form = $data_atual";

$stmt = $pdo->query($qtd_conc);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$hoje_ = date('d/m/Y H:i');

$num_form = $result['total_registros'] + 1;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Formulário Concessão</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/Suas-Tech/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_impr_form.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="titulo">
        <div class="tech">
            <p>TechSUAS-Concessão</p>
        </div>
            <div
            id="dataHora">
        </div>
    </div>
    <div class="container">
        <?php

$nis_resp = $_POST['nis'];
$cpf_resp = $_POST['cpf'];
$mes_pg = $_POST['mes_pg'];
$parentesco = $_POST['parentesco'];
$situation = "EM PROCESSO";

if (isset($_POST['cpf'])) {

    $sql_query_resp = $pdo->prepare("SELECT * FROM concessao_tbl WHERE cpf_pessoa = :cpf_resp");
    $sql_query_resp->bindParam(':cpf_resp', $cpf_resp, PDO::PARAM_STR);
    $sql_query_resp->execute();

    $sql_query_benef = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = :nis_resp");
    $sql_query_benef->bindParam(':nis_resp', $nis_resp, PDO::PARAM_STR);
    $sql_query_benef->execute();

    if ($sql_query_resp->rowCount() == 0) {
        $mensagem_sem_cad_resp = "
        <script>
            Swal.fire({
                    icon: 'info',
                    title: 'RESPONSÁVEL SEM CADASTRO',
                    text: 'O responsável ainda não tem cadastro ou o CPF está incorreto confira $cpf_resp',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var outraAcao = window.confirm('Deseja cadastrar o RESPONSÁVEL?')

                        if (outraAcao) {
                            window.location.href = '/TechSUAS/views/concessao/cadastro_pessoa'
                        } else {
                            window.location.href = '/TechSUAS/views/concessao/gerar_form'
                        }
                    }
                })
        </script>
    ";
        echo $mensagem_sem_cad_resp;
        ?>
            <?php

    }

    if ($sql_query_resp->rowCount() > 0 && $sql_query_benef->rowCount() > 0) {
        $dados_resp = $sql_query_resp->fetch(PDO::FETCH_ASSOC);

        ?>
                <div class="cab0" style="text-align: center;">
                    <h2>CONCESSÃO DE BENEFÍCIO EVENTUAL</h2>
                    <p>(Amparada pela Lei Municipal nº 1.978, de 01 de novembro de 2017)</p>
                </div>
                <div class="form">
                    <p>Formulário: <?php echo $num_form; ?> / <?php echo $data_atual; ?></p>
                </div>
                <div class="cab1">
                    <div class="cab11" style="text-align: justify;">
                        <p>Considerando a Lei nº 8.742, de 07 de dezembro de 1973 - Lei Orgânica da Assistência Social, em seu Art. 22;</p>
                        <p>Considerando a Lei Municipal n° 1.978, 01 de novembro de 2017 e Pela Resolução CMAS n° 13/2017;</p>
                        <p>Considerando a solicitação do Benefício Eventual feita pelo(a) usuário(a) abaixo qualificado(a), e por ele(a) se enquadrar no perfil para acesso a Concessão de Benefício Eventual e apresentar os documentos necessários, conforme anexo;</p>
                        <p>Considerando a avaliação técnica da condição de vulnerabilidade social temporária em se apresenta o(a) beneficiário(a);</p>
                    </div>
                </div>

                <table border='1'>
                    <tr class="resultado">
                        <td class="resultado" colspan="2">RESPONSÁVEL:</td>
                        <td class="resultado" colspan="9"> <b> <?php echo $dados_resp['nome']; ?> </b> </td>
                        <td class="resultado" colspan="2">NATURALIDADE:</td>
                        <td class="resultado" colspan="3"> <b> <?php echo $dados_resp['naturalidade']; ?></td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="2">NOME DA MÃE:</td>
                        <td class="resultado" colspan="9"> <b> <?php echo $dados_resp['nome_mae']; ?> </b> </td>
                        <td class="resultado" colspan="2">CONTATO:</td>
                        <td class="resultado" colspan="3"><b> <?php echo $dados_resp['contato']; ?> </b></td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="16">Dados dos documentos do(a) Responsável:</td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="3">CPF: <b> <?php echo $_POST['cpf']; ?></b></td>
                        <td class="resultado" colspan="1">T.E: <b> <?php echo $dados_resp['tit_eleitor_pessoa']; ?></b></td>
                        <td class="resultado" colspan="9">RG: <b> <?php echo $dados_resp['rg_pessoa']; ?></b></td>
                        <td class="resultado" colspan="3">NIS: <b> <?php echo $dados_resp['nis_pessoa']; ?></b></td>
                    </tr>
                    <?php

        $dados_benef = $sql_query_benef->fetch(PDO::FETCH_ASSOC);

        $renda = $dados_benef['vlr_renda_media_fam'];
        // Formatando o número como moeda brasileira
        $renda_formatado = number_format($renda, 2, ',', '.');

        $rg_benef = $dados_benef['num_identidade_pessoa'];
        $rg_benef = ltrim($rg_benef, '0');
        $rg_benef_formatado = number_format(intval($rg_benef), 0, '', '.');

        $tit_benef = $dados_benef['num_titulo_eleitor_pessoa'];
        // Adicionar hífens na formatação
        $tit_benef = substr($tit_benef, -12);
        $tit_benef_formatado = implode('-', str_split($tit_benef, 4));

        //Formatando o CPF
        $cpf_benef = $dados_benef['num_cpf_pessoa'];
        $cpf_formatando_benef = sprintf('%011s', $cpf_benef);
        $cpf_formatado_benef = substr($cpf_formatando_benef, 0, 3) . '.' . substr($cpf_formatando_benef, 3, 3) . '.' . substr($cpf_formatando_benef, 6, 3) . '-' . substr($cpf_formatando_benef, 9, 2);

        //Define as variáveis com o endereço
        $tipo_logradouro = $dados_benef["nom_tip_logradouro_fam"];
        $nom_logradouro_fam = $dados_benef["nom_logradouro_fam"];
        $num_logradouro_fam = $dados_benef["num_logradouro_fam"];
        if ($num_logradouro_fam == "") {
            $num_logradouro = "S/N";
        } else {
            $num_logradouro = $dados_benef["num_logradouro_fam"];
        }
        $nom_localidade_fam = $dados_benef["nom_localidade_fam"];
        $nom_titulo_logradouro_fam = $dados_benef["nom_titulo_logradouro_fam"];
        if ($nom_titulo_logradouro_fam == "") {
            $nom_tit = "";
        } else {
            $nom_tit = $dados_benef["nom_titulo_logradouro_fam"];
        }
        $txt_referencia_local_fam = $dados_benef["txt_referencia_local_fam"];
        if ($txt_referencia_local_fam == "") {
            $referencia = "SEM REFERÊNCIA";
        } else {
            $referencia = $dados_benef["txt_referencia_local_fam"];
        }
        $endereco_completo = $tipo_logradouro . " " . $nom_tit . " " . $nom_logradouro_fam . ", " . $num_logradouro . " - " . $nom_localidade_fam . ", " . $referencia;
        ?>
                    <tr class="resultado">
                        <td class="resultado" colspan="3">BENEFICIÁRIO:</td>
                        <td class="resultado" colspan="6"> <b> <?php echo $dados_benef['nom_pessoa']; ?> </b> </td>
                        <td class="resultado" colspan="3">NATURALIDADE:</td>
                        <td class="resultado" colspan="4"> <b> <?php echo $dados_benef['nom_ibge_munic_nasc_pessoa']; ?></td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="3">NOME DA MÃE:</td>
                        <td class="resultado" colspan="8"> <b> <?php echo $dados_benef['nom_completo_mae_pessoa']; ?> </b> </td>
                        <td class="resultado" colspan="2">RENDA MEDIA:</td>
                        <td class="resultado" colspan="3"><b> R$ <?php echo $renda_formatado; ?> </b></td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="3">ENDEREÇO:</td>
                        <td class="resultado" colspan="13"> <b> <?php echo $endereco_completo; ?> </b> </td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="16">Dados dos documentos do(a) Beneficiário(a):</td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="3">CPF: <b><?php echo $cpf_formatado_benef; ?></b></td>
                        <td class="resultado" colspan="1">T.E: <b><?php echo $tit_benef_formatado; ?></b></td>
                        <td class="resultado" colspan="9">RG: <b><?php echo $rg_benef_formatado; ?></b></td>
                        <td class="resultado" colspan="3">NIS: <b><?php echo $dados_benef['num_nis_pessoa_atual']; ?></b></td>
                    </tr>
                </table>
                <p>QUAL PARENTESCO O RESPONSÁVEL TEM COM O BENEFICIÁRIO?: <b><?php echo $_POST['parentesco']; ?></b></p>

                <table border='1'>
                    <tr>
                        <th>ITEM</th>
                        <th>Descrição sucinta do bem, objeto ou serviço a ser concedido.</th>
                        <th>QUANT.</th>
                        <th>VALOR UN</th>
                        <th>VALOR TOTAL</th>
                    </tr>
                    <tr>
                        <td><?php echo $_POST['itens_conc']; ?></td>
                        <td><?php echo $_POST['itens_conc']; ?></td>
                        <td><?php echo $_POST['quantidade']; ?></td>
                        <td><?php echo $_POST['valor_unitario']; ?></td>
                        <td><?php echo $_POST['valor_total']; ?></td>
                    </tr>
                </table>
                <div class="sbu" style="text-align: right;">
                    <p>São Bento do Una - PE ____ de _____________ de <?php echo $data_atual ?></p>
                </div>


                <div class="cab2">
                    <p>_________________________________________________________________________<br>ASSINATURA DO RESPONSÁVEL:</p>
                    <p>____________________________________________________________<br>CIBELE SILVA DO NASCIMENTO<br>SECRETÁRIA ADJUNTA DE ASSISTÊNCIA SOCIAL<br>PORTARIA 182/2024 </p>
                </div>
                <?php

        $smtp_conc = $conn->prepare("INSERT INTO concessao_historico (id_concessao, num_form, ano_form, cpf_resp, nome_benef, nis_benef, cpf_benef, rg_benef, tit_benef, endereco, renda_media, nome_item, qtd_item, valor_uni, valor_total, data_registro, mes_pag, parentesco, operador, situacao_concessao) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        // Verifica se a preparação foi bem-sucedida
        if ($smtp_conc === false) {
            die('Erro na preparação SQL: ' . $conn->error);
        }

        $smtp_conc->bind_param("ssssssssssssssssssss", $dados_resp['id_concessao'], $num_form, $data_atual, $_POST['cpf'], $dados_benef['nom_pessoa'], $dados_benef['num_nis_pessoa_atual'], $cpf_formatado_benef, $rg_benef_formatado, $tit_benef_formatado, $endereco_completo, $renda_formatado, $_POST['itens_conc'], $_POST['quantidade'], $_POST['valor_unitario'], $_POST['valor_total'], $hoje_, $mes_pg, $parentesco, $nome, $situation);

        if ($smtp_conc->execute()) {
            ?>
        <script>
            window.print()
            setTimeout(function() {
                Swal.fire({
                    icon: "success",
                    title: "SALVO",
                    text: "Dados salvos com sucesso!",
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/TechSUAS/views/concessao/gerar_form"
                    }
                })
            }, 3000)
        </script>
    <?php
} else {
            ?>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "ERRO",
                            text: "Erro no salvamento, contacte o suporte.",
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/TechSUAS/views/concessao/gerar_form"
                            }
                        })
                    </script>
                <?php
}
    } elseif ($sql_query_resp->rowCount() > 0 && $sql_query_benef->rowCount() == 0) {
        ?>
                <script>
                    window.location.href = '/TechSUAS/views/concessao/cadastrar_beneficiario'
                </script>
        <?php
}
}
?>
    </div>
    <script>
        // Função para formatar um número com dois dígitos
function formatarNumero(numero) {
    return numero < 10 ? '0' + numero : numero;
}

// Função para obter a data e hora atual e exibir na página
function mostrarDataHoraAtual() {
    let dataAtual = new Date();

    let dia = formatarNumero(dataAtual.getDate());
    let mes = formatarNumero(dataAtual.getMonth() + 1);
    let ano = dataAtual.getFullYear();

    let horas = formatarNumero(dataAtual.getHours());
    let minutos = formatarNumero(dataAtual.getMinutes());
    let segundos = formatarNumero(dataAtual.getSeconds());

    let dataHoraFormatada = `${dia}/${mes}/${ano} ${horas}:${minutos}:${segundos}`;

    document.getElementById('dataHora').textContent = " - " + dataHoraFormatada;
}

// Chamando a função para exibir a data e hora atual quando a página carrega
window.onload = function() {
    mostrarDataHoraAtual();
    // Atualizar a cada segundo
    setInterval(mostrarDataHoraAtual, 1000);
};

    </script>
</body>

</html>