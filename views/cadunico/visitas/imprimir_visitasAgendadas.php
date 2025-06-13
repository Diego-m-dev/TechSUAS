<?php
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
    <title>Visitas Registradas</title>
</head>
<body>
<div class="rint-section">
    <div class="titulo">
            <div class="tech">
                <span>TechSUAS-Cadastro Único </span><?php echo $data_cabecalho; ?>
            </div>
        </div>
    <?php
if (isset($_POST['selecionados'][0])) {
    $json = $_POST['selecionados'][0]; // pega a primeira (e única) string JSON
    $ids = json_decode($json, true);   // agora sim, decodifica

    foreach ($ids as $id) {
        $sql = "
            SELECT nome, endereco
            FROM visitas_feitas
            WHERE id = :id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        echo htmlspecialchars($dados['nome']) . '<br>' . htmlspecialchars($dados['endereco']) . '<br><br>';
    }
} else {
    echo "Nenhum dado recebido.";
}
?>
</body>
</html>