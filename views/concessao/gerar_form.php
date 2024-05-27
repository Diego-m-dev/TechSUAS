<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Formulário Concessão</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_gerar_form.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/concessao.js"></script>
    <script>
        $(document).ready(function() {
            // Máscara para formatar os números
            $('.valor-unitario').mask('000000,00', {
                reverse: true
            });

            if (typeof nisBeneficiario !== 'undefined') {
                // Atribui o valor da variável ao campo NIS
                document.getElementById('nis_b').value = nisBeneficiario;
            }

            // Função para calcular o total
            function calcularTotal() {
                // Recebe a quantidade e valor unitário
                var quantidade = parseFloat($(".quantidade").val().replace(",", ".")) || 0;
                var valorUnitario = parseFloat($(".valor-unitario").val().replace(",", ".")) || 0;

                // Calcula o total e formata como moeda brasileira
                var total = quantidade * valorUnitario


                // Formata o total como string
                var formattedTotal = total.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })

                // Define o valor formatado no campo
                $(".valor-total").val(total)
            }
            // Anexa a função aos eventos de alteração de entrada
            $(".quantidade, .valor-unitario").on("input", calcularTotal)
        })
    </script>
</head> 

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/concessao/h1-relatorio.svg" alt="Titulocomimagem">
        </h1>
    </div>

    <div class="container">
        <form action="/TechSUAS/controller/concessao/gerar_form" method="POST">
            <div id="form">
                <label>CPF DO RESPONSÁVEL:</label>
                <input type="text" name="cpf" id="cpf" maxlength="14" required>

                <label>NIS DO BENEFICIÁRIO:</label>
                <input type="text" name="nis" maxlength="11" required id="nis_b">

                <label>Mês de Pagamento</label>
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
                <a href="/TechSUAS/config/back" style="margin-left: 50px;">
                    <i class="fas fa-arrow-left"></i> Voltar ao menu
                </a>
                <p>QUAL PARENTESCO O RESPONSÁVEL TEM COM O BENEFICIÁRIO?</label>
                    <select name="parentesco" id="parentesco" required>
                        <option value="" disabled selected hidden>Selecione</option>
                        <option value="UNIPESSOAL">Unipessoal</option>
                        <option value="CONJUGE">Conjuge</option>
                        <option value="FILHO(A)">Filho(a)</option>
                        <option value="ENTEADO(A)">Enteado(a)</option>
                        <option value="NETO OU BISNETO">Neto ou Bisneto</option>
                        <option value="PAI OU MAE">Pai ou Mae</option>
                        <option value="SOGRO(A)">Sogro(a)</option>
                        <option value="IRMAOS OU IRMA">Irmão ou Irmã</option>
                        <option value="GENRO OU NORA">Genro ou Nora</option>
                        <option value="OUTRO PARENTE">Outro Parente</option>
                        <option value="NAO PARENTE">Não Parente</option>
                    </select>
            </div>

            <table width="500px" border="1" id="tabelaItens">
                <tr>
                    <th colspan="4">TABELA ITENS</th>
                </tr>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                </tr>
                <tr>
                    <td>
                        <select name="itens_conc" required>
                            <option value="" disabled selected hidden>Selecione</option>
                            <?php
                            $consultaSetores = $conn->query("SELECT caracteristica FROM concessao_itens");
                            // Verifica se há resultados na consulta
                            if ($consultaSetores->num_rows > 0) {
                                // Loop para criar as opções do select
                                while ($setor = $consultaSetores->fetch_assoc()) {
                                    echo '<option value="' . $setor['caracteristica'] . '">' . $setor['caracteristica'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="quantidade" class="quantidade"></td>
                    <td><input type="text" name="valor_unitario" class="valor-unitario"></td>
                    <td><input type="text" name="valor_total" class="valor-total" readonly></td>
                </tr>
            </table>
            <div class="btns">
                <div class="btn">
                    <button type="submit" id="btn_gerar">GERAR CAPA</button>
                </div>
                </form>
                <div class="bloc2">
                        <div class="btn">
                            <form action="">
                                <button type="buttun" id="btn_bsc_nis">BUSCAR NIS</button>
                                <input type="text" name="cpf_benef">
                                </form>
                        </div>
                <div>
            </div>

    </div>
    </div>
    
    <?php
    if (!isset($_GET['cpf_benef'])) {
    } else {
        $cpf = $_GET['cpf_benef'];

        // Remove todos os caracteres não numéricos
        $cpfNumerico = preg_replace('/\D/', '', $cpf);

        // Remove os zeros à esquerda
        $cpf_benef = ltrim($cpfNumerico, '0');

        $sql_cons_nis = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_cpf_pessoa = :cpf_benef");
        $sql_cons_nis->bindParam(':cpf_benef', $cpf_benef, PDO::PARAM_STR);
        $sql_cons_nis->execute();
        if ($sql_cons_nis->rowCount() > 0) {
            $dados_benef = $sql_cons_nis->fetch(PDO::FETCH_ASSOC);
            echo "<p>O NIS foi adicionado com sucesso no campo NIS.</p>";
            if (isset($dados_benef['num_nis_pessoa_atual'])) {
                // Imprime o valor da variável no script JavaScript
                echo '<script>var nisBeneficiario = "' . $dados_benef['num_nis_pessoa_atual'] . '";</script>';
            }
        } else {
    ?>
            <script>
                Swal.fire({
                    icon: "erro",
                    title: "NÃO ENCONTRADO",
                    text: "Não há cadastro para essa pessoa!",
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/TechSUAS/views/concessao/cadastrar_beneficiario"
                    }
                })
            </script>
    <?php
        }
    }
    ?>
    </div>
    </div>
    </div>
</body>

</html>