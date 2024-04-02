<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/style-processo.css">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/png">
    <title>Registrar visitas</title>
</head>
<body>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
    //PEGANDO OS DADOS DO FORMULÁRIO
    $codigo_familiar = $_POST['codigo_familiar'];
    $nomerf = $_POST['nomerf'];
    $data_visita = $_POST['data_visita'];
    $acao_visita = $_POST['acao_visita'];
    $parecer = $_POST['parecer'];

    $smtp = $conn->prepare("INSERT INTO visitas_feitas (cod_fam, nome, data, acao, parecer_tec) VALUES (?,?,?,?,?)");
    $smtp->bind_param("sssss", $codigo_familiar, $nomerf, $data_visita, $acao_visita, $parecer);

        if($smtp->execute()){?>
            <H1 >"DADOS ENVIADOS COM SUCESSO!" </H1>
            <div class="linha"></div> 
            <?php
            // Redireciona para a página registrar.html após 3 segundos
            echo '<script> setTimeout(function(){ window.location.href = "/TechSUAS/views/cadunico/visitas/registrar.php"; }, 3000); </script>';
        
        } else {
            echo "ERRO no envio dos DADOS: ".$smtp->error;
        }
        $smtp->close();
        $conn->close();

?>
</body>
</html>