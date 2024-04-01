
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='website icon' type='png' href='/TechSUAS/img/geral/logo.png'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <title>Importar Itens</title>
</head>
<body>
<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';

$data_registro = date('d-m-Y');

$num_contrato = $_POST['num_contrato'];
$stmt_id_contrato = $pdo->prepare("SELECT * FROM contrato_tbl WHERE num_contrato = :num_contrato");
$stmt_id_contrato->execute(array(':num_contrato' => $num_contrato));


if ($stmt_id_contrato->rowCount() > 0) {
    $dados_atende = $stmt_id_contrato->fetch(PDO::FETCH_ASSOC);
    $id_contrato = $dados_atende['id_contrato'];



ini_set('memory_limit', '8192M');
ini_set('max_execution_time', 300);
$arquivo = $_FILES['arquivoCSV'];

$linhas_importadas = 0;
$linhas_n_importadas = 0;
$linha_nao_importada = "";
$tamanho_do_lote = 1000;

if ($arquivo['type'] == 'text/csv') {
    $dados = fopen($arquivo['tmp_name'], "r");
    // Ignorar cabeçalho
    fgetcsv($dados);

    while ($linha = fgetcsv($dados, 1000, ";")) {

        $query = "INSERT INTO contrato_itens (id_contrato, cod_produto, nome_produto, marca, quantidade, und_medida, valor_uni, valor_total, operador, data_cadastro)   VALUES (:id_contrato, :cod_produto, :nome_produto, :marca, :quantidade, :und_medida, :valor_uni, :valor_total, :operador, :data_cadastro)";

        $import_data = $pdo->prepare($query);
        $import_data->bindValue(':id_contrato', ($id_contrato));
        $import_data->bindValue(':cod_produto', ($linha[0] ?? "NULL"));
        $import_data->bindValue(':nome_produto', ($linha[1] ?? "NULL"));
        $import_data->bindValue(':marca', ($linha[2] ?? "NULL"));
        $import_data->bindValue(':quantidade', ($linha[3] ?? "NULL"));
        $import_data->bindValue(':und_medida', ($linha[4] ?? "NULL"));
        $import_data->bindValue(':valor_uni', ($linha[5] ?? "NULL"));
        $import_data->bindValue(':valor_total', ($linha[6] ?? "NULL"));
        $import_data->bindValue(':operador', ($nome));
        $import_data->bindValue(':data_cadastro', ($data_registro));
        $import_data->execute();

        if ($import_data->rowCount()) {
            $linhas_importadas++;
        } else {
            $linhas_n_importadas++;
            $linha_nao_importada = $linhas_n_importadas . ", " . ($linha[0] ?? "NULL");
        }
    }
    
    ?>
        <script>
            Swal.fire({
            icon: "success",
            html:`
            <h3>ITENS IMPORTADOS</h3>
            <p>Os dados foram importados com sucesso.</p>
            <?php echo "<p> $linhas_importadas linha(s) importadas, $linhas_n_importadas linha(s) com erro.</p>";?>
            `,
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/administrativo/";
                }
            })
        </script>
<?php

} else {
?>
    <script>
    Swal.fire({
    html:`
    <h3>ATENÇÃO</h3>
    <p>Só é permitido a importação de arquivos CSV.</p>
    `,
    confirmButtonText: 'OK',
    })
    </script>
<?php
}
} else {
    ?>
<script>
Swal.fire({
icon: "error",
title: "NÃO ENCONTRADO",
text: "Nenhum contrato com esse número!",
confirmButtonText: 'OK'
}).then((result) => {
if (result.isConfirmed) {
    window.location.href = "/TechSUAS/views/administrativo/cadastro_contrato";
}
})
</script>
<?php
exit();
}


?>
<body>
</html>