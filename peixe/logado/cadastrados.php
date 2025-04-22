<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
    if (isset($_POST['locais'])) {
    if ($_POST['locais'] == '1') {
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/TechSUAS/peixe/css/style_peixe.css">
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-cartesian.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-pie.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-cartesian-3d.min.js"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>

    
    <title>TechSUAS - Locais</title>
</head>
<body>
    <h1><span id="total"></span> Cadastros Feitos </h1>
    <?php
            ?>
                <div id='grafico'></div>
            <?php
        } else {

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/TechSUAS/peixe/css/style_print.css">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-cartesian.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-pie.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.13.0/js/anychart-base.min.js"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>

    
    <title>TechSUAS - Locais</title>
</head>
<body class="<?php echo 'background-' . $_SESSION['estilo']; ?>">
    <div class="container">
            <h1>RESPOSTA DE CONTATO<br>CONFIRMAÇÃO DE CADASTRO</h1>
<?php
                $lc_entre = $_POST['locais'];

            $stmt = $pdo->prepare("SELECT nome, codigo_talao, local_entrega, local_cadastro FROM peixe WHERE local_entrega = :lc_entre ORDER BY nome");
            $stmt->execute(array(':lc_entre' => $lc_entre));

                if ($stmt->rowCount() > 0) {

                    
            ?>

    <p>Destinatário: <span class="nome" contenteditable="true" class="editable-field"></span></p>
    <p>Prezados,</p>
    <p>Em resposta ao contato realizado por WhatsApp, informamos que os cadastros das pessoas vinculadas e próximas à <span class="nome" contenteditable="true" class="editable-field"></span> foram devidamente efetuados para participação no Programa de Distribuição de Peixe da Semana Santa. A entrega ocorrerá no dia <strong>16 de abril de 2025</strong>, conforme cronograma estabelecido pela Secretaria de Assistência Social.</p>
    <p>Os beneficiários cadastrados deverão comparecer ao local indicado na data mencionada, portando comprovante de cadastramento para retirada do peixe. Caso tenham realizado o cadastro em outra localidade e optem por retirar o benefício neste ponto de distribuição, a associação deverá permitir a retirada, desde que o beneficiário apresente o comprovante de cadastro. Qualquer dúvida ou necessidade de informações adicionais, estamos à disposição para esclarecimentos.</p>
    <p>Segue abaixo a relação das pessoas que tiveram seus cadastros efetivados por meio da parceria com a associação, bem como aquelas que realizaram o cadastro em outro local e optaram por retirar o benefício na associação em questão.</p>
        <table id="tabela" border="1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Código Talão</th>
                        <th>Nome</th>
                        <th>Local do Cadastro</th>
                    </tr>
                </thead>
    
                    <?php
                
                while ($peixes = $stmt->fetch()) {
                    
                    $nome = $peixes['nome'];
                    $codigo_talao = $peixes['codigo_talao'];
                    ?>
                    <tr>
                        <td><?php echo $codigo_talao; ?> </td>
                        <td><?php echo $nome; ?> </td>
                        <td><?php echo $peixes['local_cadastro']; ?> </td>
                    </tr>
                    <?php
                }
            ?>
        </table>
    <?php
            }
    ?>
            <p>Agradecemos a parceria e reforçamos nosso compromisso em garantir um atendimento eficiente e organizado à comunidade.</p>
            <p id="data_right"><?php echo $data_formatada_extenso . ', ' . $cidade; ?></p>
            <p  style="margin-botton: 3cm;">Eu, <span class="nome" contenteditable="true" class="editable-field"></span>, na qualidade de Representante da Associação citada neste documento, declaro para os devidos fins que recebi os comprovantes de cadastramento referentes ao Programa de Distribuição de Peixe da Semana Santa desta cidade, devidamente preenchidos em sistema e assinados pelos representante do programa por esta instituição.</p>
                <div class="signature-line"></div>
                <p><span class="nome" contenteditable="true" class="editable-field"></span></p>
            <p>Atenciosamente,</p><br><br>
                <div class="signature-line"></div>
            <p class="center"><?php echo $_SESSION['nome_usuario']; ?><br>
            <?php echo $_SESSION['cargo_usuario']; ?> DO CADÚNCIO E PROGRAMA BOLSA FAMÍLIA</span>
            
        <footer><div class="page-break"></div>
        </footer>
    </div>
    <?php
        }

        ?>
                <script src="/TechSUAS/peixe/js/graficos.js"></script>
</body>

</html>
<?php
    }
    ?>
