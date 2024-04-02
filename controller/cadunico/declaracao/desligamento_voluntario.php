<!DOCTYPE html>
<html lang="pt-br">

<head>
    <style>


    body {
        font-family: Arial, sans-serif;

        background-image: url('../../img/marca.png');
        background-size: 790px;
        background-repeat: repeat;

    }

    #title {
        font-size: 26px;
        font-weight: bold;
        text-align: center;
    }

    #subtitle {
        font-size: 16px;
        text-align: center;
        margin-top: 10px;
    }


    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }


    textarea {
        width: 100%;
        padding: 5px;
        margin-top: 5px;
        height: 100px;
    }

    #right-align {
        font-size: 20px;
        text-align: right;
    }

    .signature-line {
        margin-top: 20px;
        font-size: 20px;
        text-align: center;
    }

    #justified-text {
        text-align: justify;
        font-size: 16px;
        text-indent: 50px;
        margin-top: 20px;
    }

    .conteudo{
    display:block;
    padding: 0px 5px 0px 30px;
}

    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="../../img/logo.png">
    <link rel="stylesheet" href="stylegerar.css">
    <title>documento oficial do cadastro único - são bento do una</title>
</head>

<body>
    <br><br><br><br><br>
    <?php
ini_set('memory_limit', '256M');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

require_once "../../../config/conexao.php";
include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/config/sessao.php';
if (!isset($_SESSION)) {
    session_start();
}
include '../acesso_user/dados_usuario.php';

if (isset($_POST['nis_dec'])) {
    $nis_dec = $_POST['nis_dec'];

    $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = :nis_dec");
    $sql->execute(array(':nis_dec' => $nis_dec));

    if ($sql->rowCount() > 0) {
        $dados = $sql->fetch(PDO::FETCH_ASSOC);
        $nom_pessoa = $dados["nom_pessoa"];
        $cpf_rf = $dados['num_cpf_pessoa'];
        $cpf_formatando = sprintf('%011s', $cpf_rf);
        $cpf_formatado = substr($cpf_formatando, 0, 3) . '.' . substr($cpf_formatando, 3, 3) . '.' . substr($cpf_formatando, 6, 3) . '-' . substr($cpf_formatando, 9, 2);
        $timestampptbr = time();
        $data_formatada_at = strftime('%d de %B de %Y', $timestampptbr);

        ?>
        <div id="title">DECLARAÇÃO DE DESLIGAMENTO VOLUNTÁRIO DO PROGRAMA BOLSA FAMÍLIA</div>

<h4 style='text-align: center;'>(Base legal: inc. XVII do caput do art. 24 e §§ 6º a 8º do art. 27 da Portaria MDS nº 897/2023)</h4>

        <form id="form">
        <div id="justified-text" class="conteudo">
<p>Prezado(a) coordenador(a) municipal do Programa Bolsa Família de São Bento do Una / PE,</p>
<p>Eu, <b><?php echo $nom_pessoa; ?></b> beneficiária(o) do Programa Bolsa Família (PBF), solicito meu desligamento voluntário do referido Programa, com a atualização cadastral no Cadastro Único para Programas Socias do Governo Federal (CadÚnico) e o registro da minha renda atual e/ou outras informações relevantes para o meu cadastro.</p>
<p>Declaro, ainda, que:</p>

<p>Estou ciente de que poderei, a qualquer momento dentro do prazo de 36 meses, solicitar meu retorno ao Programa Bolsa Família, mediante nova atualização cadastral que comprove minha necessidade socioeconômica para participar novamente do Programa.</p>
<p>Estou ciente de que esse retorno ao Programa não gera o pagamento das parcelas anteriormente canceladas, e que apenas poderei receber as parcelas geradas a partir do processamento de minha nova inclusão no PBF</p>
<br><br>
<p>Dados do(a) Responsável Familiar:</p>
<?php
echo "Nome completo: <b>" . $nom_pessoa . "</b><br>";
        echo "CPF: <b>" . $cpf_formatado . "</b><br>";
        echo "NIS: <b>" . $nis_dec . "</b><br>";
        ?>
    <br><br>
<p style='text-align:right;'>São Bento do Una, <?php echo $data_formatada_at; ?></p>
<br><br>
<p style='text-align:center;'>__________________________________________________________________________</p>
<p style='text-align:center;'>Assinatura do(a) Responsável Familiar</p>
</din>

<div id="justified-text" class="conteudo" style="page-break-before: always;">

<p style='margin-top: 100px;'>Eu, coordenador(a) municipal do Programa Bolsa Família de São Bento do Una/PE, ou por ele designado, afirmo que foi realizada, nesta data, a atualização cadastral do(a) beneficiário(a) acima identificado(a) no Cadastro Único para Programas Socias do Governo Federal (CadÚnico), e o cancelamento do benefício do Programa Bolsa Família, no Sistema de Benefícios ao Cidadão (Sibec), pelo motivo “Desligamento voluntário”.</p>
<p>Declaro, ainda, que procedi ao cancelamento apenas do benefício da família, e não a exclusão de seu cadastro.</p>
<p>O(a) responsável familiar acima identificado(a) poderá ter o cancelamento do seu benefício revertido dentro do prazo de 36 meses (três anos), retornando imediatamente à condição de beneficiário(a), caso sua renda volte a ser compatível com as regras do Programa Bolsa Família. Basta, para isso, que seus dados sejam atualizados no CadÚnico, e que o pedido de retorno garantido seja feito ao coordenador municipal do Programa.</p>
<p>A presente declaração foi assinada em duas vias, uma arquivada no município e a outra entregue para o(a) beneficiário(a).</p>
<br><br>
<p>Dados do(a) coordenador(a) municipal do Programa Bolsa Família:</p>
<?php
$mysql = "SELECT * FROM usuarios WHERE cargo LIKE '%CADASTRO ÚNICO%' ";
        $mysqlq = $conn->query($mysql) or die("ERRO ao consultar !" . $conn - error);

        if ($mysqlq->num_rows == 0) {
            echo "COORDENAÇÃO NÃO IDENTIFICADA.";
        } else {
            $dados = $mysqlq->fetch_assoc();
            echo "Nome completo: <b>" . $dados['nome'] . "</b><br>";
            echo "CPF: <b>" . $dados['cpf'] . "</b><br>";

        }
        ?>
    <br><br>
<p style='text-align:right;'>São Bento do Una, <?php echo $data_formatada_at; ?></p>
<br><br>
<p style='text-align:center;'>__________________________________________________________________________</p>
<p style='text-align:center;'>Assinatura do(a) coordenador(a) municipal do Programa Bolsa Família</p>
</div>
</form>
    </body>
    <script>
    setTimeout(function(){ 
        window.location.href = "../../views/declar/declaracao.php"; 
        }, 3000); 
        </script>
    <script>
    window.onload = function() {
        window.print();
    };
    </script>
    </html>
<?php

} else {
        echo "<script language='javascript'>window.alert('Nenhum dado encontrato.!'); </script>";
        echo "<script language='javascript'>window.location='../../views/declar/declaracao.php'; </script>";
    }
}
?>