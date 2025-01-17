<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSUAS - Relatório</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_gerar_relatorio_endereco.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/concessao.js"></script>
</head>

<body>

    <table border="1">
<tr>
    <th>Seq.</th>
    <th>CPF</th>
    <th>Nome Responsável</th>
    <th>Nome Beneficiário</th>
    <th>Quantidade</th>
</tr>
<?php
        $seq = 1;
    // Consulta para buscar todos os dados
    $stmt = $pdo->prepare("SELECT COUNT(*) AS quant, nome_resp, nome_benef, cpf_resp
                            FROM concessao_historico
                            GROUP BY cpf_resp
                            ORDER BY nome_resp");

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($dadosEnd = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
        
?>
<tr>
    <td><?php echo $seq; ?></td>
    <td><?php echo $dadosEnd['cpf_resp']; ?></td>
    <td><?php echo $dadosEnd['nome_resp']; ?></td>
    <td><?php echo $dadosEnd['nome_benef']; ?></td>
    <td><?php echo $dadosEnd['quant']; ?></td>
</tr>
<?php
$seq++;
    }
}
?>
    </table>
</body>

</html>