<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
?>


<!DOCTYPE html>
<html>

<head>
    <title>Termo de Responsabilidade</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/tr.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
</head>

<body>
    <div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único</span><span id="dataHora"></span>

        </div>
    </div>
    <div class="container">
        <h1 class="center">ANEXO II - TERMO DE RESPONSABILIDADE</h1>
        <form id="declarationForm">
            <label for="cpfInput">CPF:</label>
            <input type="text" id="cpfInput" name="cpfInput" placeholder="Digite o CPF">
            <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
            <br>
            <p class="paragraph">Eu, <span id="nomeContainer"><span id="nome" class="editable-field" contenteditable="true"></span></span>, CPF: <span id="cpf" class="editable-field" contenteditable="true"></span>, NIS: <span id="nis"></span>, declaro, sob as penas da lei, que moro sem nenhuma outra pessoa da minha família no domicílio de endereço: <span id="enderecoContainer"><span id="endereco" class="editable-field" contenteditable="true"></span></span>, indicado no Cadastro Único.</p>
            <p class="paragraph">Declaro ter clareza de que:</p>
            <ul>
                <li class="topic">É crime de falsidade ideológica, de acordo com o art. 299 do Código Penal, deixar de declarar informações ou prestar informações falsas para o Cadastro Único, com o objetivo de participar ou de se manter no Programa Bolsa Família ou em qualquer outro programa social.</li>
                <li class="topic">É de responsabilidade do Responsável pela Unidade Familiar apresentar dados referentes a TODAS as pessoas da sua família, conforme art. 3°, inciso I, do Decreto nº 11.016, de 29 de março de 2022.</li>
                <li class="topic">A qualquer tempo poderei ser convocado pelo município ou por órgãos federais de controle e fiscalização, para avaliar se as informações que prestei ao Cadastro Único estão de acordo com a realidade.</li>
                <li class="topic">A prestação de informações falsas ao Programa Bolsa Família é motivo de cancelamento do benefício, e pode gerar processo administrativo para ressarcimento dos valores recebidos indevidamente, nos termos do art. 18 da Medida Provisória nº 1.164, de 2 de março de 2023. Pode também ocasionar processo penal e cível nos termos da legislação geral brasileira.</li>
            </ul>
            <div class="right">São Bento do Una - PE, <span id="data"></span>.</div>
            <br>
            <p class="center ass">______________________________________________________________<br>Assinatura do(a) Responsável pela Unidade Familiar</p>
        </form>

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

            function imprimirPagina() {
                window.print();
            }
            const currentDate = new Date();
            const formattedDate = `${currentDate.getDate()} de ${getMonthName(currentDate.getMonth())} de ${currentDate.getFullYear()}`;
            document.getElementById('data').textContent = formattedDate;

            function getMonthName(month) {
                const monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
                return monthNames[month];
            }
            const cpfInput = document.getElementById('cpfInput');
            const nomeSpan = document.getElementById('nome');
            const cpfSpan = document.getElementById('cpf');
            const nisSpan = document.getElementById('nis');
            const enderecoSpan = document.getElementById('endereco'); // Alterado

            function formatCPF(cpf) {
                const cleanedCPF = cpf.replace(/\D/g, '');
                return cleanedCPF.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            }

            function formatNIS(nis) {
                return nis.replace(/(\d{10})(\d{1})/, '$1-$2');
            }

            cpfInput.addEventListener('input', function() {
                const cpf = cpfInput.value;
                if (dataList.hasOwnProperty(cpf)) {
                    const data = dataList[cpf];
                    nomeSpan.textContent = data.nomeRf;
                    cpfSpan.textContent = cpf;
                    nisSpan.textContent = data.nis;
                    enderecoSpan.textContent = data.endereco; // Alterado
                    cpfSpan.textContent = formatCPF(cpf);

                    const currentDate = new Date();
                    const formattedDate = `${currentDate.getDate()}/${currentDate.getMonth() + 1}/${currentDate.getFullYear()}`;
                    dataSpan.textContent = formattedDate;
                } else {
                    nomeSpan.textContent = '';
                    cpfSpan.textContent = '';
                    nisSpan.textContent = '';
                    enderecoSpan.textContent = ''; // Alterado

                }
            });
        </script>
    </div>
</body>

</html>