<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style_conferir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Registro de visita domiciliar</title>

</head>

<body>
    <h1>REGISTRO DE INFORMAÇÕES COMPLEMENTARES DE VISITA DOMICILIAR</h1>
    <?php
// Inclui o arquivo "conexao.php" que deve conter a configuração da conexão com o banco de dados
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

    $sqli = $pdo->prepare("SELECT * FROM visitas_feitas WHERE id = :idvisita");
    $sqli->bindParam(':idvisita', $id_visita, PDO::PARAM_STR);
    $sqli->execute();

    // Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Verifica se a consulta em visita retornou algum resultado
    if ($sqli->rowCount() > 0) {
        // Recupera os dados da consulta
        $dadosv = $sqli->fetch(PDO::FETCH_ASSOC);
        $codfam = $dadosv['cod_fam'];

    $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE cod_familiar_fam = LPAD(:codfam, 11, '0') AND cod_parentesco_rf_pessoa = 1");
    $sql->bindParam(':codfam', $codfam, PDO::PARAM_STR);
    $sql->execute();

    $sql_vis_did = $pdo->prepare("SELECT * FROM visitas_feitas WHERE cod_fam = :codfam");
    $sql_vis_did->bindParam(':codfam', $codfam, PDO::PARAM_STR);
    $sql_vis_did->execute();

        if ($sql->rowCount() > 0) {
            // Recupera os dados da consulta
            $dados = $sql->fetch(PDO::FETCH_ASSOC);
            $dados_vis_did = $sql_vis_did->fetch(PDO::FETCH_ASSOC);

            //Formatando o código familiar
            $cod_familiar = $dados["cod_familiar_fam"];
            $cod_familiar_formatado = substr_replace(str_pad($cod_familiar, 11, "0", STR_PAD_LEFT), '-', 9, 0);
            //Formatando o nis
            $nis_responsavel = $dados["num_nis_pessoa_atual"];
            $nis_responsavel_formatado = substr_replace(str_pad($nis_responsavel, 11, "0", STR_PAD_LEFT), '-', 10, 0);

            $tipo_logradouro = $dados["nom_tip_logradouro_fam"];
            $nom_logradouro_fam = $dados["nom_logradouro_fam"];
            $num_logradouro_fam = $dados["num_logradouro_fam"];
            if ($num_logradouro_fam == "") {
                $num_logradouro = "S/N";
            } else {
                $num_logradouro = $dados["num_logradouro_fam"];
            }
            $nom_localidade_fam = $dados["nom_localidade_fam"];
            $nom_titulo_logradouro_fam = $dados["nom_titulo_logradouro_fam"];
            if ($nom_titulo_logradouro_fam == "") {
                $nom_tit = "";
            } else {
                $nom_tit = $dados["nom_titulo_logradouro_fam"];
            }
            $txt_referencia_local_fam = $dados["txt_referencia_local_fam"];
            if ($txt_referencia_local_fam == "") {
                $referencia = "SEM REFERÊNCIA";
            } else {
                $referencia = $dados["txt_referencia_local_fam"];
            }
            $cpf_rf = $dados["num_cpf_pessoa"];
            $cpf_formatado = sprintf('%011s', $cpf_rf);
            $cpf_formatado = substr($cpf_formatado, 0, 3) . '.' . substr($cpf_formatado, 3, 3) . '.' . substr($cpf_formatado, 6, 3) . '-' . substr($cpf_formatado, 9, 2);
            $sexo_rf = $dados["cod_sexo_pessoa"];
            if ($sexo_rf == "1") {
                $sexo = " filho de ";
            } else {
                $sexo = " filha de ";
            }
            if ($sexo_rf == "1") {
                $sexo1 = " o ";
            } else {
                $sexo1 = " a ";
            }
            $nom_mae_rf = $dados["nom_completo_mae_pessoa"];
            $id_vis = $dados_vis_did['id'];

            ?>
    <form method="post" action="gerarpdf.php">
        <p name="numero_parecer">Parecer: <?php echo $numero_parecer; ?> / <?php echo $ano_atual; ?></p>
        <p><label>CÓDIGO FAMILIAR: </label>
        <?php
    $endereco_conpleto = $tipo_logradouro . " " . $nom_tit . " " . $nom_logradouro_fam . ", " . $num_logradouro . " - " . $nom_localidade_fam . ", " . $referencia;
            // Exibe as informações encontradas
            echo $cod_familiar_formatado;?></p>
        <label>NIS do Responsável pela(o) Unidade Familiar (RUF): </label>
        <?php
echo $nis_responsavel_formatado;
            // Outras informações que você deseja exibir
        } else {
            echo "Nenhum registro encontrado para o CPF informado.";
        }

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
        $data = $dadosv['data'];
        // Verifica se a data não está vazia e tenta criar um objeto DateTime
        if (!empty($data)) {
            $formatando_data = DateTime::createFromFormat('Y-m-d', $data);
        
            // Verifica se a data foi criada corretamente
            if ($formatando_data) {
                $data_formatada = $formatando_data->format('d/m/Y');
            } else {
                echo "Data inválida.";
            }
        } else {
            echo "Data não fornecida.";
        }
?>

        <p>Data Visita: <?php echo $data_formatada; ?></p>
        <p>Endereço: <?php echo $endereco_conpleto; ?></p>
        <p>Nome Responsável Familiar: <?php echo $dados["nom_pessoa"]; ?></p>
        <p>CPF: <?php echo $cpf_formatado; ?></p>
        <p>Nome da Mãe: <?php echo $nom_mae_rf; ?></p>
        <p>Ação: <?php echo $acao; ?></p>
        <p>Parecer Técnico: <?php echo $dadosv["parecer_tec"]; ?></p>
        <p>São Bento do Una - PE, <?php echo $data_formatada_at; ?></p>
        <hr><input type="submit" name="btn-pdf" value="Gerar Arquivo">
    </form>
    <?php
$parecer_tec = $dadosv["parecer_tec"];
        $nom_pessoa = $dados['nom_pessoa'];
        $texto_parecer = "Foi realizado no dia " . $data_formatada . ", no endereço " . $endereco_conpleto . " declarado por " . $dados["nom_pessoa"] . ", CPF: " . $cpf_formatado . ", " . $sexo . " " . $nom_mae_rf . ", mas " . $sexo1 . " " . $acao . ". Em busca ativa obteve a seguinte informação " . $dadosv["parecer_tec"];

        // Armazene a variável na sessão
        $_SESSION['dados_conferidos'] = array(
            'numero_parecer' => $numero_parecer,
            'cod_familiar' => $cod_familiar,
            'nom_pessoa' => $nom_pessoa,
            'texto_parecer' => $texto_parecer,
            'nis_rf' => $nis_responsavel_formatado,
            'data_formatada' => $data_formatada,
            'endereco_conpleto' => $endereco_conpleto,
            'sexo' => $sexo,
            'nom_mae_rf' => $nom_mae_rf,
            'sexo1' => $sexo1,
            'acao' => $acao,
            'parecer_tec' => $parecer_tec,
            'data_formatada_at' => $data_formatada_at,
            'cpf_formatado' => $cpf_formatado,
            'id_visita' => $id_vis

        );
    } else {
        echo "<hr><br><a href='/TechSUAS/views/cadunico/visitas/visitas'><i class='fas fa-arrow-left'></i><button>Voltar</button></a>";
    }
}?>

</body>

</html>