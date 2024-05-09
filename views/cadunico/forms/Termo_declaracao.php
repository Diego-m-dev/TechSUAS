<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
$cpf_declar = $_POST['cpf_declar'];

$sql_declar = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_cpf_pessoa = :cpf_declar");
$sql_declar->bindParam(':cpf_declar', $cpf_declar, PDO::PARAM_STR);
$sql_declar->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termo de delcaração de renda</title>
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/td.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
</head>

<body>
    <div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único</span> - <?php echo $data_cabecalho; ?>
        </div>
    </div>
    <div class="container">
        <h1 class="center1">ANEXO I TERMO DE DECLARAÇÃO</h1>

    <?php
if ($sql_declar->rowCount() > 0) {
    $dados_declar = $sql_declar->fetch(PDO::FETCH_ASSOC);

    //formata cpf
    $cpf_formatado = sprintf('%011s', $cpf_declar);
    $cpf_formatado = substr($cpf_formatado, 0, 3) . '.' . substr($cpf_formatado, 3, 3) . '.' . substr($cpf_formatado, 6, 3) . '-' . substr($cpf_formatado, 9, 2);

    ?>
                    <p class="paragraph">Eu, <span class="editable-field"><?php echo $dados_declar['nom_pessoa']; ?></span>, NIS: <span class="editable-field"><?php echo $dados_declar['num_nis_pessoa_atual']; ?></span>, CPF: <span class="editable-field"><?php echo $cpf_formatado; ?></span>,
                declaro, sob as penas da lei, que todas as pessoas listadas abaixo moram no meu domicílio e possuem o
                seguinte rendimento total detalhado para cada pessoa, incluindo remuneração de doação, de trabalho ou de
                outras fontes:</p>
            <p class="paragraph"><strong>RELAÇÃO DOS COMPONENTES DA UNIDADE FAMILIAR MORADORES DO DOMICÍLIO:</strong></p>
            <?php
$cod_familia = $dados_declar['cod_familiar_fam'];

    $sql_membros_familia = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam = ? ORDER BY cod_parentesco_rf_pessoa ASC";
    $stmt = $conn->prepare($sql_membros_familia);
    $stmt->bind_param('s', $cod_familia);
    $stmt->execute();
    $resultado_valor_total = $stmt->get_result();

    ?>
            <table id="tabela_membros" width="500px" border="1">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Ocupação</th>
                        <th>Renda Bruta Mensal</th>
                        <th class="impr">Ação</th>
                    </tr>
                </thead>
                <tbody>
<?php
while ($membros = $resultado_valor_total->fetch_assoc()) {

        //formatando data de nascimento
        $data_nascimento = $membros['dta_nasc_pessoa'];
        $dataNasc_formatando = new DateTime($data_nascimento);
        $dataNasc_formatada = $dataNasc_formatando->format('d/m/Y');

        ?>
        <tr>
            <td><span id="nome" class="editable-field" contenteditable="true"><?php echo $membros['nom_pessoa']; ?></span></td>
            <td><span id="nome" class="editable-field" contenteditable="true"><?php echo $dataNasc_formatada; ?></span></td>
            <td><span id="nome" class="editable-field" contenteditable="true"></span></td>
            <td>R$ <span id="nome" class="editable-field" contenteditable="true">,00</span></td>
            <td class="impr">
                <button onclick="removerLinha(this)">X</button>
            </td>
        </tr>
        <?php
}
    ?>
                </tbody>

            </table>
            <button onclick="adicionarLinha()">Adicionar Linha</button>
            <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
            <button class="impr" onclick="voltarAoMenu()">Voltar</button>

            <p class="paragraph1">Declaro ter clareza de que:</p>
            <ul>
                <li class="topic">É ilegal deixar de declarar informações ou prestar informações falsas para o Cadastro
                    Único, com o objetivo de participar ou de se manter no Programa Bolsa Família ou em qualquer outro
                    programa social.</li>
                <li class="topic">As famílias que fraudam o Programa Bolsa Família terão o benefício cancelado e responderão
                    processo administrativo instaurado para devolução dos valores recebidos indevidamente, além de responder
                    penal e civilmente pelas fraudes cometidas.</li>
                <li class="topic">A qualquer tempo poderei receber visita domiciliar de servidor do município, para avaliar
                    se a situação socioeconômica da minha família está de acordo com as informações prestadas ao Cadastro
                    Único. Assumo o compromisso de atualizar o cadastro sempre que ocorrer alguma mudança nas informações de
                    minha família, como endereço, renda e trabalho, nascimento ou óbito, entre outras.</li>
            </ul>
            <p class="right">São Bento do Una - PE, <?php echo $data_formatada; ?>.</p>
            <p class="center">______________________________________________________________<br>Assinatura do Responsável
                pela Unidade Familiar</p>

        <?php
} else {
    ?>

<p class="paragraph">Eu, <span id="nomeContainer"><span id="nome" class="editable-field" contenteditable="true"></span>, NIS: <span id="nis" class="editable-field" contenteditable="true"></span>, CPF: <span id="cpf" class="editable-field" contenteditable="true"></span>,
                declaro, sob as penas da lei, que todas as pessoas listadas abaixo moram no meu domicílio e possuem o
                seguinte rendimento total detalhado para cada pessoa, incluindo remuneração de doação, de trabalho ou de
                outras fontes:</p>
            <p class="paragraph"><strong>RELAÇÃO DOS COMPONENTES DA UNIDADE FAMILIAR MORADORES DO DOMICÍLIO:</strong></p>
            <table id="tabela_membros" width="500px" border="1">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Ocupação</th>
                        <th>Renda Bruta Mensal</th>
                        <th class="impr">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span id="nomeContainer">
                                <span id="nome" class="editable-field" contenteditable="true"></span>
                            </span>
                        </td>
                        <td>
                            <span id="nomeContainer">
                                <span id="nome" class="editable-field" contenteditable="true"></span>
                            </span>
                        </td>
                        <td>
                            <span id="nomeContainer">
                                <span id="nome" class="editable-field" contenteditable="true"></span>
                            </span>
                        </td>
                        <td>R$ 
                            <span id="nomeContainer">
                                <span id="nome" class="editable-field" contenteditable="true">,00</span>
                            </span>
                        </td>
                        <td class="impr">
                            <button onclick="removerLinha(this)">X</button>
                        </td>   

                    </tr>
                </tbody>
            </table>
            <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
            <button class="impr" onclick="voltarAoMenu()">Voltar</button>
            <button type="button" onclick="adicionarLinha()">Adicionar Linha</button>

            <p class="paragraph1">Declaro ter clareza de que:</p>
            <ul>
                <li class="topic">É ilegal deixar de declarar informações ou prestar informações falsas para o Cadastro
                    Único, com o objetivo de participar ou de se manter no Programa Bolsa Família ou em qualquer outro
                    programa social.</li>
                <li class="topic">As famílias que fraudam o Programa Bolsa Família terão o benefício cancelado e responderão
                    processo administrativo instaurado para devolução dos valores recebidos indevidamente, além de responder
                    penal e civilmente pelas fraudes cometidas.</li>
                <li class="topic">A qualquer tempo poderei receber visita domiciliar de servidor do município, para avaliar
                    se a situação socioeconômica da minha família está de acordo com as informações prestadas ao Cadastro
                    Único. Assumo o compromisso de atualizar o cadastro sempre que ocorrer alguma mudança nas informações de
                    minha família, como endereço, renda e trabalho, nascimento ou óbito, entre outras.</li>
            </ul>
            <p class="right">São Bento do Una - PE, <?php echo $data_formatada; ?>.</p>
            <p class="center">______________________________________________________________<br>Assinatura do Responsável
                pela Unidade Familiar</p>
        </form>
<?php
}
?>
        <script>
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

            const nisInput = document.getElementById("nisInput");
            const nomeContainer = document.getElementById("nomeContainer");
            const nomeSpan = document.getElementById("nome");
            const nisSpan = document.getElementById("nis");
            const cpfSpan = document.getElementById("cpf");
            const nisTabelaInput = document.getElementById("nisTabelaInput");
            const adicionarTabelaBtn = document.getElementById("adicionarTabelaBtn");
            const componentesTable = document.getElementById("componentesTable");
            const tbody = componentesTable.querySelector("tbody");
            const dataSpan = document.getElementById("data");

            document.getElementById("buscarNISBtn").addEventListener("click", function() {
                const nis = nisInput.value;
                if (dataList[nis]) {
                    nomeSpan.textContent = dataList[nis].nomeRf;
                    nisSpan.textContent = nis;
                    cpfSpan.textContent = dataList[nis].cpfRf;
                } else {
                    nomeSpan.textContent = '';
                    nisSpan.textContent = nis;
                    cpfSpan.textContent = '';
                }
            });

            adicionarTabelaBtn.addEventListener("click", function() {
                const nisTabela = nisTabelaInput.value;
                const dadosPessoa = dataList[nisTabela];
                const nome = dadosPessoa ? dadosPessoa.nomeRf : "";
                const dataNascimento = dadosPessoa ? dadosPessoa.dataNsc : "";
                const ocupacao = prompt("Informe a ocupação:");
                const rendaMensal = prompt("Informe a renda bruta mensal:");

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${nome}</td>
                    <td>${dataNascimento}</td>
                    <td>${ocupacao}</td>
                    <td>${rendaMensal}</td>
                    <td><button class="removerBtn" type="button">Remover</button></td>
                `;

                tbody.appendChild(row);
                nisTabelaInput.value = "";
            });

            tbody.addEventListener("click", function(event) {
                if (event.target.classList.contains("removerBtn")) {
                    event.target.parentElement.parentElement.remove()
                }
            })

            const currentDate = new Date().toLocaleDateString("pt-BR")
            dataSpan.textContent = currentDate;

        </script>
        <script src="/TechSUAS/js/cadastro_unico.js"></script>

    </div>
</body>

</html>