<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
$cpf_residencia = $_POST['cpf_residencia'];

$cpf_limpo = preg_replace('/\D/', '', $_POST['cpf_residencia']);
$cpf_already = ltrim($cpf_limpo, '0');

$sql_reside = $pdo->prepare("SELECT nom_tip_logradouro_fam, nom_logradouro_fam, nom_localidade_fam, num_logradouro_fam, nom_titulo_logradouro_fam, txt_referencia_local_fam, nom_pessoa, num_nis_pessoa_atual FROM tbl_tudo WHERE num_cpf_pessoa = :cpf_residencia");
$sql_reside->bindParam(':cpf_residencia', $cpf_already, PDO::PARAM_STR);
$sql_reside->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termo de Responsabilidade - TechSUAS</title>
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/tr.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="<?php echo 'background-' . $_SESSION['estilo']; ?>">
<div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único - </span><?php echo $data_cabecalho; ?>
        </div>
    </div>
    <div class="container">
        <h1 class="center">ANEXO II - TERMO DE RESPONSABILIDADE</h1>
<?php
if ($sql_reside->rowCount() > 0) {
    $dados_reside = $sql_reside->fetch(PDO::FETCH_ASSOC);

    $tipo_logradouro = $dados_reside["nom_tip_logradouro_fam"];
    $nom_logradouro_fam = $dados_reside["nom_logradouro_fam"];
    $num_logradouro_fam = $dados_reside["num_logradouro_fam"];
    if ($num_logradouro_fam == "") {
        $num_logradouro = "S/N";
    } else {
        $num_logradouro = $dados_reside["num_logradouro_fam"];
    }
    $nom_localidade_fam = $dados_reside["nom_localidade_fam"];
    $nom_titulo_logradouro_fam = $dados_reside["nom_titulo_logradouro_fam"];
    if ($nom_titulo_logradouro_fam == "") {
        $nom_tit = "";
    } else {
        $nom_tit = $dados_reside["nom_titulo_logradouro_fam"];
    }
    $txt_referencia_local_fam = $dados_reside["txt_referencia_local_fam"];
    if ($txt_referencia_local_fam == "") {
        $referencia = "SEM REFERÊNCIA";
    } else {
        $referencia = $dados_reside["txt_referencia_local_fam"];
    }


    $endereco_conpleto = $tipo_logradouro . " " . $nom_tit . " " . $nom_logradouro_fam . ", " . $num_logradouro . " - " . $nom_localidade_fam . ", " . $referencia;

    $cpf_formatado = sprintf('%011s', $cpf_residencia);
    $cpf_formatado = substr($cpf_formatado, 0, 3) . '.' . substr($cpf_formatado, 3, 3) . '.' . substr($cpf_formatado, 6, 3) . '-' . substr($cpf_formatado, 9, 2);
?>
        <p class="paragraph">Eu, <span class="nome" contenteditable="true"><?php echo $dados_reside['nom_pessoa']; ?></span>, CPF: <span class="cpf"><?php echo $cpf_residencia; ?></span>, NIS: <span class="nis"><?php echo $dados_reside['num_nis_pessoa_atual']; ?></span>, declaro, sob as penas da lei, que moro sem nenhuma outra pessoa da minha família no domicílio de endereço: <span class="editable-field" contenteditable="true"><?php echo $endereco_conpleto; ?></span>, indicado no Cadastro Único.</p>

        <p class="paragraph">Declaro ter clareza de que:</p>
            <ul>
                <li class="topic">É crime de falsidade ideológica, de acordo com o art. 299 do Código Penal, deixar de declarar informações ou prestar informações falsas para o Cadastro Único, com o objetivo de participar ou de se manter no Programa Bolsa Família ou em qualquer outro programa social.</li>
                <li class="topic">É de responsabilidade do Responsável pela Unidade Familiar apresentar dados referentes a TODAS as pessoas da sua família, conforme art. 3°, inciso I, do Decreto nº 11.016, de 29 de março de 2022.</li>
                <li class="topic">A qualquer tempo poderei ser convocado pelo município ou por órgãos federais de controle e fiscalização, para avaliar se as informações que prestei ao Cadastro Único estão de acordo com a realidade.</li>
                <li class="topic">A prestação de informações falsas ao Programa Bolsa Família é motivo de cancelamento do benefício, e pode gerar processo administrativo para ressarcimento dos valores recebidos indevidamente, nos termos do art. 18 da Medida Provisória nº 1.164, de 2 de março de 2023. Pode também ocasionar processo penal e cível nos termos da legislação geral brasileira.</li>
            </ul>
            <div class="right"><?php echo $cidade; ?> <?php echo $data_formatada_extenso; ?>.</div>
            <br><br><br>
            <div class="center ass" class="assinatura">
                    <p class="signature-line"></p>
                    <p>Assinatura do(a) Responsável pela Unidade Familiar 
            </div>

            <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
            <button class="impr" onclick="voltarAoMenu()"><i class="fas fa-arrow-left"></i>Voltar</button>
<?php
} else {

    ?>
        <p class="paragraph">Eu, <span class="editable-field" contenteditable="true" ></span>, CPF: <span class="editable-field"><?php echo $cpf_residencia; ?></span>, NIS: <span class="editable-field" contenteditable="true" ></span>, declaro, sob as penas da lei, que moro sem nenhuma outra pessoa da minha família no domicílio de endereço: <span class="editable-field" contenteditable="true" ></span>, indicado no Cadastro Único.</p>
        <p class="paragraph">Declaro ter clareza de que:</p>
        <ul>
            <li class="topic">É crime de falsidade ideológica, de acordo com o art. 299 do Código Penal, deixar de declarar informações ou prestar informações falsas para o Cadastro Único, com o objetivo de participar ou de se manter no Programa Bolsa Família ou em qualquer outro programa social.</li>
            <li class="topic">É de responsabilidade do Responsável pela Unidade Familiar apresentar dados referentes a TODAS as pessoas da sua família, conforme art. 3°, inciso I, do Decreto nº 11.016, de 29 de março de 2022.</li>
            <li class="topic">A qualquer tempo poderei ser convocado pelo município ou por órgãos federais de controle e fiscalização, para avaliar se as informações que prestei ao Cadastro Único estão de acordo com a realidade.</li>
            <li class="topic">A prestação de informações falsas ao Programa Bolsa Família é motivo de cancelamento do benefício, e pode gerar processo administrativo para ressarcimento dos valores recebidos indevidamente, nos termos do art. 18 da Medida Provisória nº 1.164, de 2 de março de 2023. Pode também ocasionar processo penal e cível nos termos da legislação geral brasileira.</li>
        </ul>
        <div class="right"><?php echo $cidade; ?> <?php echo $data_formatada_extenso; ?>.</div>
            <br><br><br>
            <div class="center ass" class="assinatura">
                    <p class="signature-line"></p>
                    <p>Assinatura do(a) Responsável pela Unidade Familiar 
            </div>

            <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
            <button class="impr" onclick="voltarAoMenu()"><i class="fas fa-arrow-left"></i>Voltar</button>
    <?php
}
?>
    </div>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
</body>
</html>