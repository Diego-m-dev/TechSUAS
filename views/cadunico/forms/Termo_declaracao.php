<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/config/sessao.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termo de delcaração de renda</title>
    <link rel="stylesheet" href="../../css/formularios/td.css">
    <script src="../../js/bd_td.js"></script>
    <link rel="website icon" type="png" href="../../img/logo.png">
</head>

<body>
    <div class="container">
        <h1 class="center1">ANEXO I MODELO DE TERMO DE DECLARAÇÃO</h1>
        <form id="declarationForm">
            <label for="nisInput">NIS:</label>
            <input type="text" id="nisInput" placeholder="Digite o NIS">
            <button type="button" id="buscarNISBtn">Buscar</button>
            <br>
            <p class="paragraph">Eu, <span id="nomeContainer"><span id="nome" class="editable-field"
                        contenteditable="true"></span></span>, NIS: <span id="nis"></span>, CPF: <span id="cpf"></span>,
                declaro, sob as penas da lei, que todas as pessoas listadas abaixo moram no meu domicílio e possuem o
                seguinte rendimento total detalhado para cada pessoa, incluindo remuneração de doação, de trabalho ou de
                outras fontes:</p>
            <p class="paragraph"><strong>RELAÇÃO DOS COMPONENTES DA UNIDADE FAMILIAR MORADORES DO DOMICÍLIO:</strong></p>
            <label for="nisTabelaInput">NIS:</label>
            <input type="text" id="nisTabelaInput" placeholder="Digite o NIS">
            <button type="button" id="adicionarTabelaBtn">Adicionar à Tabela</button>
            <table id="componentesTable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Ocupação</th>
                        <th>Renda Bruta Mensal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
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
            <p class="right">São Bento do Una - PE, <span id="data"></span>.</p>
            <p class="center">______________________________________________________________<br>Assinatura do Responsável
                pela Unidade Familiar</p>
        </form>

        <script>
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
                event.target.parentElement.parentElement.remove();
            }
        });

        const currentDate = new Date().toLocaleDateString("pt-BR");
        dataSpan.textContent = currentDate;
        
        function imprimirPagina() {
    window.print();
}
        </script>
    </div>
</body>

</html>