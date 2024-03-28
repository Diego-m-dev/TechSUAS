<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/cozinha_comunitaria/style-fluxo.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <title>Fluxo diário - TechSUAS</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';

ob_end_clean();
// Inclua a biblioteca FPDF
require('../../pdf_combo/fpdf.php');

$sql = 'SELECT nis_benef, nome, cpf_benef, data_de_entrega, encaminhado_cras, qtd_pessoa, qtd_marmita, marm_entregue FROM fluxo_diario_coz';
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $data_atual = date('d-m-Y');

    // Crie um objeto FPDF
    $pdf = new FPDF();
    $pdf->AddPage('L');

    // Adicione um título
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'RELATÓRIO DIÁRIO', 0, 1, 'C');

    // Adicione uma linha em branco
    $pdf->Ln(10);

// Larguras das células de cabeçalho
$largura_nis = 20;
$largura_nome = 80;
$largura_cpf = 25;
$largura_data_entrega = 30;
$largura_acompanhado = 40;
$largura_qtd_pessoa = 25;
$largura_marmitas_disp = 25;
$largura_marmitas_entregues = 25;

// Adicione as colunas
$pdf->SetFont('Arial', '', 8);
$pdf->Cell($largura_nis, 10, 'NIS', 1);
$pdf->Cell($largura_nome, 10, 'NOME', 1);
$pdf->Cell($largura_cpf, 10, 'CPF', 1);
$pdf->Cell($largura_data_entrega, 10, 'DATA ENTREGA', 1);
$pdf->Cell($largura_acompanhado, 10, utf8_decode('ACOMPANHADO'), 1);
$pdf->Cell($largura_qtd_pessoa, 10, utf8_decode('QTD PESSOA'), 1);
$pdf->Cell($largura_marmitas_disp, 10, 'MARMITA DISP', 1);
$pdf->Cell($largura_marmitas_entregues, 10, 'ENTREGUE', 1);
$pdf->Ln();

// Adicione os dados
$pdf->SetFont('Arial', '', 8);
while ($linha = $resultado->fetch_assoc()) {
    // Adicione cada coluna com a largura correspondente
    $pdf->Cell($largura_nis, 10, utf8_decode($linha['nis_benef']), 1);
    $pdf->Cell($largura_nome, 10, utf8_decode($linha['nome']), 1);
    $pdf->Cell($largura_cpf, 10, utf8_decode($linha['cpf_benef']), 1);
    $pdf->Cell($largura_data_entrega, 10, utf8_decode($linha['data_de_entrega']), 1);
    $pdf->Cell($largura_acompanhado, 10, utf8_decode($linha['encaminhado_cras']), 1);
    $pdf->Cell($largura_qtd_pessoa, 10, utf8_decode($linha['qtd_pessoa']), 1);
    $pdf->Cell($largura_marmitas_disp, 10, utf8_decode($linha['qtd_marmita']), 1);
    $pdf->Cell($largura_marmitas_entregues, 10, utf8_decode($linha['marm_entregue']), 1);
    $pdf->Ln();
}


    // Nome do arquivo
    $pdf_nome = 'RELATORIO_' . $data_atual . '.pdf';

    // Saída para o navegador
    $pdf->Output($pdf_nome, 'D');

    // Atualize os dados na tabela
    $editar_sql = "UPDATE fluxo_diario_coz SET data_de_entrega = NULL, marm_entregue = 0, entregue = 'não', entregue_por = NULL";
    if ($conn->query($editar_sql) === true) {
?>
    <script>
            Swal.fire({
                icon: "success",
                html: `<h1>RELATÓRIO GERADO</h1>
                        <p>Relatório gerado com sucesso!</p>`,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/cozinha_comunitaria/fluxo_diario"
                }
            })
    </script>
<?php
    } else {
        echo 'Falha na atualização de dados' . $conn->error;
    }
} else {
    echo 'Nenhum dado encontrado na tabela.';
}

// Feche a conexão com o banco de dados
$conn->close();
?>
</body>
</html>