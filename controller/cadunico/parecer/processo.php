<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style-processo.css">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/png">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <title>Registrar visitas</title>
</head>
<body>

<?php
    //PEGANDO OS DADOS DO FORMULÁRIO
    $data_visita = $_POST['data_visita'];
    $acao_visita = $_POST['acao_visita'];
    $parecer = nl2br($_POST['parecer']);
    $codigo_familiar = $_POST['codigo_familiar'];
    $cod_limpo = preg_replace('/\D/', '', $codigo_familiar);
    $cod_ajustado = substr_replace(str_pad($cod_limpo, 11,'0',STR_PAD_LEFT), '-', 9, 0);
    $cod_sem_zeros = ltrim($cod_limpo, '0');

    $smtp = $conn->prepare("INSERT INTO visitas_feitas (cod_fam, data, acao, parecer_tec, entrevistador) VALUES (?,?,?,?,?)");
    $smtp->bind_param("sssss", $cod_sem_zeros, $data_visita, $acao_visita, $parecer, $_SESSION['nome_usuario']);

    //consulta a composição familiar

    $sql_dados = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam LIKE '$codigo_familiar'";
    $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

    /*
    if ($sql_query->num_rows == 0) {
        echo "Confira se está correto ". $codigo_familiar. ". Confira no V7 a situação da família.";
    } else {
        while ($dados = $sql_query->fetch_assoc()) {

            echo "NOME: ". $dados['nom_pessoa'];
            echo "<br>NIS: ". $dados['num_nis_pessoa_atual'];
            echo "<br>Data de Nascimento: ". $dados['dta_nasc_pessoa'];
            $parentesco = $dados['cod_parentesco_rf_pessoa'];
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
            echo "PARENTESCO: ". $parentesco_pessoa;
        }
    }
*/
        if($smtp->execute()){
        // Redireciona para a página registrar caso deseje realizar um novo registro
?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'SALVO',
            text: 'Dados salvos com sucesso!',
            html: `
            <h5>Dados da família</h5>
            <p>Código Familiar: <?php echo $cod_ajustado; ?></p>
            `,
        }).then((result) => {
            if (result.isConfirmed) {
                var outraAcao = window.confirm('Deseja realizar outro cadastro?')

                if (outraAcao) {
                    window.location.href = "/TechSUAS/views/cadunico/visitas/registrar"
                } else {
                    window.location.href = "/TechSUAS/views/cadunico/visitas/index"
                }
            }
        })
    </script>
<?php
        } else {
            echo "ERRO no envio dos DADOS: ".   $smtp->error;
        }
        $smtp->close();
        $conn->close();

?>
</body>
</html>