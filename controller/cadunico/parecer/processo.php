<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

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
    $cod_ajustado = str_pad($cod_limpo, 11,'0',STR_PAD_LEFT);

    $smtp = $conn->prepare("INSERT INTO visitas_feitas (cod_fam, data, acao, parecer_tec, entrevistador) VALUES (?,?,?,?,?)");
    $smtp->bind_param("sssss", $cod_ajustado, $data_visita, $acao_visita, $parecer, $_SESSION['nome_usuario']);

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
            <p>Código Familiar: <?php echo substr_replace($cod_ajustado, '-', 9, 0); ?></p>
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
            echo "ERRO no envio dos DADOS: " . $smtp->error;
				}
$smtp->close();
$conn->close();

?>
</body>
</html>