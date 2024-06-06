<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

//REQUISIÇÃO PARA DADOS DOS USUÁRIOS CREDENCIADOS COM ACESSO ADMINISTRATIVO E/OU CARGO COMISSIONADO
$sql_user = "SELECT * FROM usuarios WHERE cargo = 'COORDENAÇÃO' AND setor = 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL'";
$sql_user_query = $conn->query($sql_user) or die("ERRO ao consultar! " . $conn - error);

//PRAZO DE 30 DIAS
$data_hj = date("d/m/Y");
$data_hj_modufy = DateTime::createFromFormat('d/m/Y', $data_hj);
$data_hj_modufy->modify('+30 days');
$data_prazo = $data_hj_modufy->format('d/m/Y'); 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href=/TechSUAS/css/cadunico/declaracoes/styledec.css>
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Declaração CadÚnico</title>

</head>
<body>

<?php
if (isset($_POST['nis_tc_new']) && isset($_POST['nis_tc_old'])) {

?>
<img src="/TechSUAS/img/cadunico/declaracoes/brasao.png" alt="TECHSUAS">
    <h2>MINISTÉRIO DO DESENVOLVIMENTO SOCIAL E COMBATE À FOME</h2>
    <h3>Secretaria Nacional de Renda de Cidadania</h3>
    <hr>
    <h2>ANEXO II</h2>
    <h3>Declaração de Substituição de Responsável Legal</h3>
    <p>Declaro, em observância ao disposto no § 2º do artigo 23 do Decreto nº5. 209, de 17 de setembro de 2004, e ao Art. 20, X da Portaria nº 555, de 11 de novembro de 2005, que foi habilitado nesta Coordenação Municipal do Programa Bolsa Família novo Responsável Legal da família, conforme abaixo informado:</p>
<?php
        $nis_tc_new = $_POST['nis_tc_new'];
        $nis_tc_old = $_POST['nis_tc_old'];

        $sql_new = "SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = '$nis_tc_new'" ;
        $sql_query_new = $conn->query($sql_new) or die("ERRO ao consultar! " . $conn - error);

        $sql_old = "SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = '$nis_tc_old'" ;
        $sql_query_old = $conn->query($sql_old) or die("ERRO ao consultar! " . $conn - error);

        //RF ANTIGO
        if ($sql_query_old->num_rows > 0) {
            $dados_old = $sql_query_old->fetch_assoc();
            $nome_old = $dados_old['nom_pessoa'];
            $nis_old = $dados_old['num_nis_pessoa_atual'];

        } else {
?>
        <script>
            Swal.fire({
                icon: "error",
                title: "O ANTIGO RF NÃO FOI LOCALIZADO",
                text: "Certifique-se no CadÚnico a situação do NIS: <?php echo $nis_tc_old; ?>",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/cadunico/declaracoes/index"
                }
            })
        </script>
<?php
die();
        }

        //RF NOVO
        if ($sql_query_new->num_rows > 0) {
            $dados_new = $sql_query_new->fetch_assoc();
            $nome_new = $dados_new['nom_pessoa'];
            $nis_new = $dados_new['num_nis_pessoa_atual'];


        } else {
?>
        <script>
            Swal.fire({
                icon: "error",
                html:`
                <h3>O NOVO RF NÃO FOI LOCALIZADO</h3>
                <p>Certifique-se no CadÚnico a situação do NIS: <?php echo $nis_tc_new; ?>.</p>
                <p>É importante ter certeza da situação do novo RF antes de concluir essa operação.</p>
                <input type="text" name="nome_new_rf" id="nome_new_rf" placeholder="Digite o nome do novo RF" />
                `,

            }).then((result) => {
                if (result.isConfirmed) {
                    var nome_new_rf = $("#nome_new_rf").val()
                    $('#nome_wen').text(nome_new_rf)
                }
            })
        </script>
<?php
            $nome_new = '<span id="nome_wen"></span>';
            $nis_new = $nis_tc_new;
        }

?>
<br><strong><h5>
<?php
        echo 'ANTIGO RL:    '. $nome_old. '<br>';
        echo 'NIS:          '. $nis_old. '<br>';
        echo 'NOVO RL:      '. $nome_new. '<br>';
        echo 'NIS:          '. $nis_new;
?>
</h5></strong>
        <p> Informamos que se encontra em andamento a devida substituição do novo Resposánvel  Legal, acima identificado, nos sistemas computacionais do Cadastro Único do Governo Federeal, visando á atualização dos dados cadastrais da Família e a emissão definitiva do cartão ao novo Responsável Legal da Família.</p>
        <p>No período de validade abaixo definido, será permitido saques de todas as parcelas de pagamento disponíveis, desde que dentro da validade, para todos os benefícios sociais vinculados a essa Família na agência da Caixa Econômica Federal denominada CAIXA ECONOMICA FEDERAL AG. BELO JARDIM, situada no endereço: RUA JOSE ROBALINHO NUM 106 - CENTRO, durante o período de validade abaixo definido.</p>

        <p style='text-align:right;'>São Bento do Una, <?php echo $data_formatada; ?></p>
        <p style='text-align:center;'>__________________________________________________________________________</p>
        <p style='text-align:center;'>Assinatura e carimbo do(a) gestor(a) municipal do Programa Bolsa Família</p>

        <table  width="800px" border="1">
        <tr>
            <td  width="400px">VALIDADE DESTE DOCUMENTO:
                <p><?php echo 'DE '. $data_hj . ' A '. $data_prazo ?></p>
                <p>(máximo de um mês)</p>
            </td>
            <td  width="400px"><p>Sr. Caixa Executivo,</p>
                <p>Esta declaração confere ao portador, devidamente identificado, durante o período de validade, direito ao saque de benefícios por meio de guia de retirada individual, devendo ser arquivada cópia da mesma nos arquivos da agência</p>
            </td>
        </tr>
        </table>

        <h6>INSTRUÇÃO OPERACIONAL Nº12 SENARC/MDS</h6>
        <div class="no-print">
        <button onclick="printWithSignature()">Imprimir com Assinatura Eletrônica</button>
        <button onclick="printWithFields()">Imprimir com Campos de Assinatura</button>
        <button onclick="voltar()">Voltar</button>
    </div>

<?php
        // Fechando a declaração preparada
        $sql_query_new->close();
        $sql_query_old->close();
}