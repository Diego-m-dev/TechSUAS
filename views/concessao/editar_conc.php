<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';

$data_atual = date('Y');
$qtd_conc = "SELECT COUNT(*) as total_registros FROM concessao_historico WHERE ano_form = $data_atual";

$stmt = $pdo->query($qtd_conc);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$hoje_ = date('d/m/Y H:i');

$sql_ed_conc = $pdo->prepare("SELECT * FROM concessao_historico WHERE id_hist = :id_hist");
$sql_ed_conc->execute(array(':id_hist' => $_POST['id_concessao']));

if ($sql_ed_conc->rowCount() > 0) {
    $conc = $sql_ed_conc->fetch(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link id="css_link" rel="stylesheet" href="/TechSUAS/css/concessao/style_consultar.css">
        <link rel="website icon" type="image/png" href="/TechSUAS/img/geral/logo.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <title>Concessão Consulta</title>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/TechSUAS/js/concessao.js"></script>
    </head>

    <body>
<div id="conteiner_hide">
        <div class="img">
            <h1 class="titulo-com-imagem">
                <img src="/TechSUAS/img/concessao/h1-consulta.svg" alt="Titulocomimagem">
            </h1>
        </div>
        <div class="container">
            <h3><?php
echo 'Feito por ' . $conc['operador'] . ' em ' . $conc['data_registro'];
    ?></h3>
            <h3>DADOS DO FORMULÁRIO</h3>
            <?php
echo 'Nº: ' . $conc['num_form'] . '/' . $conc['ano_form'] . '<br>';
    if ($funcao == "Tecnico(a)") {
        echo '<b>Parecer Tecnico: </b>' . $conc['parecer'] . '<br>';
    }
    ?>
            <div class="visual">
                <?php
                if ($conc['pg_data'] == '0000-00-00') {
                    $data_pago = "Não foi paga.";
                } else {
                    $data_pago = $conc['pg_data'];
                }
    echo 'Mês de Pagamento: ' . $conc['mes_pag'] . '<br>';
    echo 'PAGO: ' . $data_pago . '<br>';
    echo 'SITUAÇÃO: ' . $conc['situacao_concessao'] . '<br>';
    ?>
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
                        <td><?php echo $conc['nome_item']; ?></td>
                        <td><?php echo $conc['qtd_item']; ?></td>
                        <td><?php echo $conc['valor_uni']; ?></td>
                        <td><?php echo $conc['valor_total']; ?></td>
                    </tr>
                </table>

            </div>
            <form method="POST" action="/TechSUAS/controller/concessao/salva_alt_conc" class="editar_info" style="display: none">
                <!--Tabela inicialmente oculta-->
                <input name="id_hist" value="<?php echo $conc['id_hist']; ?>" style="display: none">
                <label>PAGO:</label>
                <input type="date" name="dt_pg" value="<?php echo $conc['pg_data']; ?>" requires>

                <label>SITUAÇÃO:</label>
                <select name="situacao">
                    <option><?php echo $conc['situacao_concessao']; ?></option>
                    <option value="ENCAMINHADO">ENCAMINHAR</option>
                    <option value="PAGO">PAGAR</option>
                    <option value="FINALIZADO">FINALIZAR</option>
                    <option value="CANCELADA">CANCELAR</option>
                </select>

                <label>MÊS DE PAGAMENTO:</label>
                <select name="mes_pg">
                    <option><?php echo $conc['mes_pag']; ?></option>
                    <option value="Janeiro">Janeiro</option>
                    <option value="Fevereiro">Fevereiro</option>
                    <option value="Marco">Março</option>
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

                <table width="500px" border="1" id="tabelaItens" style="margin-top: 20px ;">
                    <tr>
                        <th colspan="4">TABELA ITENS (Modo de edição)</th>
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
                                <option><?php echo $conc['nome_item']; ?></option>
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
                        <td><input type="text" name="quantidade" class="quantidade" value="<?php echo $conc['qtd_item']; ?>"></td>
                        <td><input type="text" name="valor_unitario" class="valor-unitario" value="<?php echo $conc['valor_uni']; ?>"></td>
                        <td><input type="text" name="valor_total" class="valor-total" readonly></td>
                    </tr>
                </table>
                <div class="btn">
                    <button type="submit">SALVAR</button>
                </div>
            </form>
            <div class="btn">
                <button type="button" id="btn_editar">EDITAR</button>
                <button type="button" id="btn_imprimir" name="<?php echo $conc['id_hist']; ?>">IMPRIMIR</button>
                <a href="/TechSUAS/config/back">
                    <i class="fas fa-arrow-left"></i> Voltar ao menu
                </a>
            </div>

            <h3>DADOS DO BENEFICIÁRIO</h3>
            <?php
    echo 'Nome: ' . $conc['nome_benef'] . '<br>';
    echo 'NIS: ' . $conc['nis_benef'] . '<br>';
    echo 'Endereço: ' . $conc['endereco'] . '<br>';
    echo 'Renda Media: R$ ' . $conc['renda_media'] . ',00<br>';

    ?>
            <h3>DADOS DO RESPONSÁVEL</h3>
        <?php
    $idConcessao = $conc['id_concessao'];
    $sql_respo = $pdo->prepare("SELECT * FROM concessao_tbl WHERE id_concessao = :id_conc");
    $sql_respo->execute(array(':id_conc' => $idConcessao));

    if ($sql_respo->rowCount() > 0) {
        $resp = $sql_respo->fetch(PDO::FETCH_ASSOC);
        echo 'NOME: ' . $resp['nome'] . '<br>';
        echo 'CPF: ' . $resp['cpf_pessoa'] . '<br>';
        echo 'Endereço: ' . $resp['endereco'] . '<br>';
        echo 'O responsável é ' . $conc['parentesco'] . '.';
    }
}
?>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#btn_editar').click(function() {
        
        $('.editar_info').show()
        $('.visual').hide()
        $('#btn_editar').hide()
    })
})

$(document).ready(function() {
            // Máscara para formatar os números
            $('.valor-unitario').mask('000000,00', {
                reverse: true
            });

            // Função para calcular o total
            function calcularTotal() {
                // Recebe a quantidade e valor unitário
                var quantidade = parseFloat($(".quantidade").val().replace(",", ".")) || 0;
                var valorUnitario = parseFloat($(".valor-unitario").val().replace(",", ".")) || 0;

                // Calcula o total
                var total = quantidade * valorUnitario;

                // Formata o total como string
                var formattedTotal = total.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                // Define o valor formatado no campo
                $(".valor-total").val(formattedTotal);
            }

            // Anexa a função aos eventos de alteração de entrada
            $(".quantidade, .valor-unitario").on("input", calcularTotal);
        });

        // Função para formatar valor monetário
        function formatCurrency(value) {
            return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }

        // Preenchendo a tabela com os dados
        document.getElementById("nome_item").innerText = dados.nome_item;
        document.getElementById("descricao").innerText = dados.descricao;
        document.getElementById("qtd_item").innerText = dados.qtd_item;
        document.getElementByclass("valor_uni").innerText = dados.valor_uni === 0 ? '' : formatCurrency(dados.valor_uni);
        document.getElementByclass("valor_total").innerText = dados.valor_total === 0 ? '' : formatCurrency(dados.valor_total);

</script>

<div id="conteiner_show" style="display: none;">
<div class="titulo">
        <div class="tech">
            <p>TechSUAS-Concessão</p>
        </div>
            <div
            id="dataHora">
        </div>
    </div>
    <div class="container">
        <div class="cab0" style="text-align: center;">
            <h2>CONCESSÃO DE BENEFÍCIO EVENTUAL</h2>
            <p>(Amparada pela Lei Municipal nº 1.978, de 01 de novembro de 2017)</p>
        </div>
        <div class="form">
            <p id="num_form"></p>
        </div>
        <div class="cab1">
            <div class="cab11" style="text-align: justify;" style="text-indent: 1cm;">
                <p>Considerando a Lei nº 8.742, de 07 de dezembro de 1973 - Lei Orgânica da Assistência Social, em seu Art. 22;</p>
                <p>Considerando a Lei Municipal n° 1.978, 01 de novembro de 2017 e Pela Resolução CMAS n° 13/2017;</p>
                <p>Considerando a solicitação do Benefício Eventual feita pelo(a) usuário(a) abaixo qualificado(a), e por ele(a) se enquadrar no perfil para acesso a Concessão de Benefício Eventual e apresentar os documentos necessários, conforme anexo;</p>
                <p>Considerando a avaliação técnica da condição de vulnerabilidade social temporária em se apresenta o(a) beneficiário(a);</p>
            </div>
        </div>
    </div>
    <div class="tabela">
    <table align="center" width="500px" border='1'>
        <tr class="resultado">
            <td class="resultado" colspan="2">RESPONSÁVEL:</td>
            <td class="resultado" colspan="9" id="nome_resp"></td>
            <td class="resultado" colspan="2">NATURALIDADE:</td>
            <td class="resultado" colspan="3" id="naturalidade_resp"></td>
        </tr>
        <tr class="resultado">
            <td class="resultado" colspan="2">NOME DA MÃE:</td>
            <td class="resultado" colspan="9" id="nome_m"></td>
            <td class="resultado" colspan="2">CONTATO:</td>
            <td class="resultado" colspan="3" id="contato"></td>
        </tr>
        <tr class="resultado">
            <td class="resultado" colspan="16">Dados dos documentos do(a) Responsável:</td>
        </tr>
        <tr class="resultado">
            <td class="resultado" colspan="3" id="cpf_pessoa"></td>
            <td class="resultado" colspan="1" id="tet_ili"></td>
            <td class="resultado" colspan="9" id="rg_pessoa"></td>
            <td class="resultado" colspan="3" id="nis_pessoa">NIS: </td>
        </tr>
        <tr class="resultado">
            <td class="resultado" colspan="3">BENEFICIÁRIO:</td>
            <td class="resultado" colspan="6" id="nome_benef"></td>
            <td class="resultado" colspan="3">NATURALIDADE:</td>
            <td class="resultado" colspan="4" id="munic_nasc"></td>
        </tr>
        <tr class="resultado">
            <td class="resultado" colspan="3">NOME DA MÃE:</td>
            <td class="resultado" colspan="8" id="nom_mae_pessoa"></td>
            <td class="resultado" colspan="2">RENDA MEDIA:</td>
            <td class="resultado" colspan="3" id="renda_media"></td>
        </tr>
        <tr class="resultado">
            <td class="resultado" colspan="3">ENDEREÇO:</td>
            <td class="resultado" colspan="13" id="endereco_conc"></td>
        </tr>
        <tr class="resultado">
            <td class="resultado" colspan="16">Dados dos documentos do(a) Beneficiário(a):</td>
        </tr>
        <tr class="resultado">
            <td class="resultado" colspan="3" id="cpf_pessoa_b"></td>
            <td class="resultado" colspan="1" id="tet_ili_b"></td>
            <td class="resultado" colspan="9" id="rg_pessoa_b"></td>
            <td class="resultado" colspan="3" id="nis_pessoa_b"></td>
        </tr>
    </table><br>


    <p align="center" width="500px" id="parentes"></p>

    <table align="center" width="500px" border='1'>
        <tr>
            <th>ITEM</th>
            <th>Descrição sucinta do bem, objeto ou serviço a ser concedido.</th>
            <th>QUANT.</th>
            <th>VALOR UN</th>
            <th>VALOR TOTAL</th>
        </tr>
        <tr>
            <td id="nome_item"></td>
            <td id="descricao"></td>
            <td id="qtd_item"></td>
            <td id="valor_uni"></td>
            <td id="valor_total"></td>
        </tr>
    </table><br>
    
    <div class="sbu" style="text-align: right;">
        <p id="local_data"></p>
    </div>


    <div class="cab2">
        <p>_________________________________________________________________________<br>ASSINATURA DO RESPONSÁVEL:</p>
        <p>____________________________________________________________<br>MARTHONY DORNELA SANTANA<br>SECRETÁRIO DE ASSISTÊNCIA SOCIAL<br>PORTARIA 143/2023</p>
    </div>
    </div>
</div>
</div>
<script>
        // Função para formatar um número com dois dígitos
function formatarNumero(numero) {
    return numero < 10 ? '0' + numero : numero;
}

// Função para obter a data e hora atual e exibir na página
function mostrarDataHoraAtual() {
    let dataAtual = new Date();

    let dia = formatarNumero(dataAtual.getDate());
    let mes = formatarNumero(dataAtual.getMonth() + 1);
    let ano = dataAtual.getFullYear();

    let horas = formatarNumero(dataAtual.getHours());
    let minutos = formatarNumero(dataAtual.getMinutes());
    let segundos = formatarNumero(dataAtual.getSeconds());

    let dataHoraFormatada = `${dia}/${mes}/${ano} ${horas}:${minutos}:${segundos}`;

    document.getElementById('dataHora').textContent = " - " + dataHoraFormatada;
}

// Chamando a função para exibir a data e hora atual quando a página carrega
window.onload = function() {
    mostrarDataHoraAtual();
    // Atualizar a cada segundo
    setInterval(mostrarDataHoraAtual, 1000);
};

    </script>
</body>
</html>