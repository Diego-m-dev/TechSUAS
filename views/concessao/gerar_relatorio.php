<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Relatório Concessão</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_gerar_relatorio.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/concessao.js"></script>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/concessao/h1-gerar_relatorio.svg" alt="Titulocomimagem">
        </h1>
    </div>
<div class="tudo">
<div class="container1">
        <div id="somaCaracteristicas"></div>

        <form method="POST" id="filtroForm">
            <label for="ano">Ano:</label>
            <select name="ano" id="ano" required>
                <option value="" disabled selected hidden>Selecione</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
            <label for="mes_pg">Mês de Pagamento</label>
            <select name="mes_pg" id="mes_pg" required>
                <option value="" disabled selected hidden>Selecione</option>
                <option value="Janeiro">Janeiro</option>
                <option value="Fevereiro">Fevereiro</option>
                <option value="Março">Março</option>
                <option value="Abril">Abril</option>
                <option value="Maio">Maio</option>
                <option value="Junho">Junho</option>
                <option value="Julho">Julho</option>
                <option value="Agosto">Agosto</option>
                <option value="Setembro">Setembro</option>
                <option value="Outubro">Outubro</option>
                <option value="Novembro">Novembro</option>
                <option value="Dezembro">Dezembro</option>
            </select>
            <button type="submit">BUSCAR</button>
        </form>
        
</div>

        <?php
        if (!isset($_POST['ano'])) {
        } else {
        ?>
        <div class="container">
            <h3>RELATÓRIO DE CONCESSÃO DE BENEFÍCIOS EVENTUAIS</h3>
                <?php
                $mes_pago = $_POST['mes_pg'];

                $sql_quantidade_itens_mes = "SELECT COUNT(*) AS mes_pag FROM concessao_historico WHERE mes_pag = '$mes_pago'";
                $resultado_quantidade_itens_mes = $conn->query($sql_quantidade_itens_mes);

                if ($resultado_quantidade_itens_mes->num_rows > 0) {
                    $row = $resultado_quantidade_itens_mes->fetch_assoc();
                    $total_itens_mes = $row['mes_pag'];
                } else {
                    $total_itens_mes = "Nenhum resultado encontrado para o mês de $mes_escolhido.";
                }

                $soma_total_mes = "SELECT SUM(valor_total) AS soma_total_mes FROM concessao_historico WHERE mes_pag = '$mes_pago'";
                $result_soma_total_mes = $conn->query($soma_total_mes);
                $valor_total_mes = [];

                while ($c = $result_soma_total_mes->fetch_assoc()) {
                    $valor_total_mes[] = $c['soma_total_mes'];
                }

                $sql_soma_valor_total = "SELECT SUM(valor_total) AS soma_total, nome_item AS nome_item, situacao_concessao AS situacao_concessao FROM concessao_historico
    WHERE mes_pag = '$mes_pago'
    GROUP BY nome_item
    ORDER BY nome_item ASC";
                $resultado_valor_total = $conn->query($sql_soma_valor_total);

                $valor_total = [];
                $categoria = [];
                $situacao = [];

                while ($a = $resultado_valor_total->fetch_assoc()) {
                    $valor_total[] = $a['soma_total'];
                    $categoria[] = $a['nome_item'];
                    $situacao[] = $a['situacao_concessao'];
                }

                ?>
                <P class="num_conc">No mês de <?php echo $mes_pago; ?> foram realizadas <?php echo $total_itens_mes; ?> concessões, com um valor total de
                    <?php
                    foreach ($valor_total_mes as $total_concessao_mes) {
                        $valor_formatado_mes = number_format($total_concessao_mes, 2, ',', '.');
                        echo 'R$ ' . $valor_formatado_mes;
                    }
                    ?>.
                </P>
                <ul>
                    <?php

                    echo '<div class="list">';
                    foreach ($categoria as $index => $subcat) {
                        $valor_formatado = number_format($valor_total[$index], 2, ',', '.');
                        echo '<div>•' . $subcat . ' - R$ ' . $valor_formatado . '</div>';
                    }
                    echo '</div>';


                    $sql_mes = $conn->real_escape_string($_POST['mes_pg']);
                    $sql_ano = $conn->real_escape_string($_POST['ano']);
                    $sql_dados = "SELECT * FROM concessao_historico WHERE mes_pag = ? AND ano_form = ? ORDER BY nome_benef ASC";

                    if ($stmt_dados = $conn->prepare($sql_dados)) {
                        $stmt_dados->bind_param("ss", $sql_mes, $sql_ano);
                        $stmt_dados->execute();

                        if ($stmt_dados->errno) {
                            die("ERRO ao consultar: " . $stmt_dados->error);
                        } else {
                            // Manipule os resultados aqui
                            $result = $stmt_dados->get_result();
                            // Faça algo com os resultados

                    ?>
            </ul>
            <table id="tabelaConcessoes" border="1">
                <thead>
                    <tr>
                        <th>NÚMERO</th>
                        <th>NOME PESSOA</th>
                        <th>CONCEDIDO</th>
                        <th>VALOR</th>
                        <th class="marc">MARCAÇÃO</th>
                    </tr>
                </thead>

                <?php
                            while ($row = $result->fetch_assoc()) {
                                echo "<tbody>";
                                echo "<td>" . $row['num_form'] . "/" . $row['ano_form'] . "</td>";
                                echo "<td>" . $row['nome_benef'] . "</td>";
                                echo "<td>" . $row['nome_item'] . "</td>";
                                echo "<td>" . $row['valor_total'] . "</td>";
                                echo '<td><input type="checkbox" class="marc"></td>';
                                echo "</tbody>";
                            }
                ?>
            </table>
        <?php
                        }
        ?>

</div>
        <div class="btns">
            <button class="btns" type="button" id="btn_immprimir">IMPRIMIR</button>
        </div>
<?php
                        $stmt_dados->close();
                    } else {
                        // Tratamento de erro se a preparação da consulta falhar
                        die("ERRO ao preparar a consulta: " . $conn->error);
                    }
                }
?>

<script>
$(document).ready(function() {
    $('#btn_immprimir').click(function() {
        // Oculta o botão de imprimir e outros elementos que não devem aparecer na impressão
        $(this).hide();
        $('#filtroForm, #btn_new_consulta').hide();
        
        // Rola a página para o topo
        window.scrollTo({ top: 0 });

        // Prepara a página para impressão
        $('body').css({
            'background-image': 'url(/TechSUAS/img/concessao/timbre.svg)',
            'background-size': '210mm 297mm',
            'box-shadow': 'none'
        });
        $('.tudo').css({
            'background-color': 'transparent',
            'box-shadow': 'none'
        });
        $('.titulo-com-imagem, td.marc, .marc, .container1, .btns').hide();
        $('table').css({
            'width': '95%',
            'border-radius': '0',
            'page-break-before': 'always',
            'margin': '60px'
        });
        $('h3').css('padding-top', '100px');
        $('.num_conc').css({
            'margin-bottom': '30px',
            'width': '90%'
        });

        // Define as margens da página
        var style = $('<style>@page { size: auto; margin: 0mm 0mm 0mm 0mm; }</style>');
        $('head').append(style);

        // Imprime a página
        window.print();

        // Restaura os estilos originais após a impressão
        $(this).show();
        $('#filtroForm, #btn_new_consulta').show();
        $('body').css({
            'background-image': '',
            'background-size': '',
            'box-shadow': ''
        });
        $('.tudo').css({
            'background-color': '#ffffff',
            'box-shadow': '0px 5px 15px rgba(0, 0, 0, 0.3)'
        });
        $('.titulo-com-imagem, td.marc, .marc, .container1, .btns').show();
        $('table').css({
            'width': '100%',
            'page-break-before': '',
            'margin': ''
        });
        $('h3').css('padding-top', '');
        $('.num_conc').css({
            'margin-bottom': '',
            'width': ''
        });
        style.remove();
        
        // Redireciona após um pequeno atraso
        setTimeout(function() {
            window.location.href = '/TechSUAS/views/concessao/gerar_relatorio';
        }, 2000);
    });
});


</script>
</div>
    </div>
</body>

</html>