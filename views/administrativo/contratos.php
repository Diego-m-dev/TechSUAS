<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/TechSUAS/css/administrativo/style_cad_cont.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="/TechSUAS/js/script_contrato.js"></script>
    <title>Contratos</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/administrativo/consul_cont.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <!-- Formulário de busca -->
        <form method="">
            <div>
                <label>Buscar contrato:</label>
                <div style="position: relative; display: inline-block;">
                    <input type="text" name="buscar" class="inpu1" placeholder="Buscar por qualquer informação do contrato..." required>
                    <span style="cursor: help; position: absolute; top: 50%; transform: translateY(-50%);" class="material-symbols-outlined" title="Caso sua busca seja feita por CNPJ, lembre-se de colocar os caracteres (. / -) para a busca retornar com sucesso;">info</span>
                </div>


                <button id="btn_busca">Buscar</button>
                <button type="button" class="back" onclick="window.location.href ='/TechSUAS/views/administrativo/';">
                    <i class="fas fa-arrow-left"></i>
                    Voltar ao menu
                </button>

            </div>

        </form>
        <div class="tabela">
            <?php
            // Verifica se o parâmetro 'buscar' não está definido na URL
            if (!isset($_GET['buscar'])) {
            } else {
                // Obtém o valor do parâmetro 'buscar' e evita injeção de SQL
                $contrato = $conn->real_escape_string($_GET['buscar']);
                // Consulta o banco de dados com base no contrato informado
                $valor_contrato = "SELECT * FROM contrato_tbl WHERE num_contrato LIKE '$contrato'";
                $contrato_query = $conn->query($valor_contrato) or die("ERRO ao consultar!" . $conn - error);

                // Verifica se nenhum contrato foi encontrado
                if ($contrato_query->num_rows == 0) {
            ?>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "NÃO ENCONTRADO",
                            text: "Não existe nenhum contrato com essa informação!",
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/TechSUAS/views/administrativo/contratos";
                            }
                        });
                    </script>
                    <?php
                } else {
                    // Exibe informações do contrato encontrado
                    $dados_contrato = $contrato_query->fetch_assoc();
                    $id_contrato = $dados_contrato['id_contrato'];
                    $dataVigencia = $dados_contrato['vigencia'];
                    $id_emp = $dados_contrato['id_empresa'];

                    $empresa = "SELECT * FROM contrato_empresa WHERE id_empresa LIKE '$id_emp'";
                    $empresa_query = $conn->query($empresa) or die("ERRO ao consultar!" . $conn - error);
                    
                    if ($empresa_query->num_rows > 0) {
                        $dados_empresa = $empresa_query->fetch_assoc();
                        $nome_empresa = $dados_empresa['nome'];
                        $razao_empresa = $dados_empresa['razao'];
                        $cnpj_empresa = $dados_empresa['cnpj'];
                        $contato_empresa = $dados_empresa['contato'];
                    }

                    echo '<div class="resultado">';
                    echo '<div class="empresa">Empresa: ' . $nome_empresa . '</div>';
                    echo '<div class="razao_social">Razão Social: ' . $razao_empresa . '</div>';
                    echo '<div class="cnpj">CNPJ: ' . $cnpj_empresa . '</div>';
                    echo '<div class="contato">Contato: ' . $contato_empresa . '</div>';
                    echo '<div class="numero_contrato">Número: ' . $dados_contrato['num_contrato'] . '</div>';
                    echo '<div class="#">Data de Vigência: ' . $dataVigencia. '</div>';

                    ?>
                        <button type="button" id="btn_pedido_itens">FAZER PEDIDO</button>
                    <?php

                    // cria uma sessão para transmitir o valor para outro php
                    $_SESSION['num_contrato'] = $dados_contrato['num_contrato'];

                    // consulta itens relacionados ao contrato
                    $itens = $conn->real_escape_string($id_contrato);
                    $valor_itens = "SELECT * FROM contrato_itens WHERE id_contrato LIKE '$itens'";
                    $itens_query = $conn->query($valor_itens) or die("ERRO ao consultar!" . $conn - error);

                    // Verifica se existem itens relacionados ao contrato
                    if ($itens_query->num_rows == 0) {
                        echo 'Não há itens para esse contrato.';
                    } else {
                        $soma_vlr_tot = 0;
                        echo '</div>';
                    ?>
                        <!-- Formulário para editar prazo -->
                        <div id="form_ed_data">
                            <form method="POST" action="/TechSUAS/controller/editar_prazo">
                                <label>Nova data</label>
                                <input type="date" name="data_alt">
                                <label>Apotilamento</label>
                                <input type="text" name="apostilamento_alt">
                                <button type="submit">SALVAR</button>
                            </form>
                        </div>
                        <button id="mostrar_form">Editar dados</button>
                        <!-- Tabela de itens do contrato -->
                        <table width="650px" border="1">
                            <tr>
                                <th>Código do Item</th>
                                <th>NOME</th>
                                <th>Quantidade</th>
                                <th>Valor Unitário</th>
                                <th>Total Itens</th>
                            </tr>
                            <?php

                            // Loop para exibir os itens
                            while ($dados_itens = $itens_query->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $dados_itens['cod_produto']; ?></td>
                                    <td><?php echo $dados_itens['nome_produto']; ?></td>
                                    <td><?php echo $dados_itens['quantidade']; ?></td>
                                    <td><?php
                                        // Formata o valor unitário
                                        $vlr_uni = $dados_itens['valor_uni'];
                                        $vlr_uni = str_replace(',', '.', str_replace('.', '', $vlr_uni));
                                        $vlr_uni_formatado = 'R$ ' . number_format((float) $vlr_uni / 100, 2, ',', '.');
                                        echo $vlr_uni_formatado; ?></td>
                                    <td><?php
                                        // Formata o valor total
                                        $vlr_tot = $dados_itens['valor_total'];
                                        $vlr_tot = str_replace(',', '.', str_replace('.', '', $vlr_tot));
                                        $vlr_tot_formatado = 'R$ ' . number_format((float) $vlr_tot / 100, 2, ',', '.');
                                        echo $vlr_tot_formatado;

                                        // Acumula o valor na variável de soma
                                        $soma_vlr_tot += (float) $vlr_tot / 100;
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td>Total</td>
                                <td colspan="4">
                                    <?php
                                    // Exibe o total da soma dos valores
                                    echo "R$ " . number_format($soma_vlr_tot, 2, ',', '.');
                                    ?>
                                </td>
                            </tr>
                        </table>
            <?php
                    }
                }
            }
            ?>
            <script>
                $(document).ready(function() {
                    $('#form_ed_data').hide()
                })
                $('#mostrar_form').click(function() {
                    $('#mostrar_form').hide()
                    $('#form_ed_data').show()
                })
            </script>
        </div>
        <a href="../../controller/tbl_contrato">Visualizar todos os contratos</a>
    </div>
</body>

</html>