<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
if ($_SESSION['funcao'] != '1') {
    echo '<script>window.history.back()</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/gestor.js"></script>

    <title>Filtros</title>
</head>
<body>
    <h1>CADASTROS ÚNICO <?php echo $cidade; ?></h1>
    <h3>FILTRO PESSOAS E FAMÍLIAS </h3>
    <button onclick="voltarFiltros()">Voltar</button>

    <label for="columns-select">Selecione as Colunas:</label>
    <select id="columns-select" multiple onchange="criarTabela([])">
        <option value="0">Código Familiar</option>
        <option value="1">Nome</option>
        <option value="2">NIS</option>
        <option value="3">Data de Nascimento</option>
        <option value="4">Idade</option>
        <option value="5">Renda Per Capita</option>
        <option value="6">Endereço</option>
        <option value="7">Status</option>
        <option value="8">Escola</option>
        <option value="9">PCD</option>
        <option value="10">Gênero</option>
        <option value="11">Parentesco</option>
        <option value="12">Telefone</option>
    </select>

    <br><br>
    <label for="cod_fam">Filtrar por Código Familiar:</label>
    <input type="text" id="cod_fam" onkeyup="aplicarFiltros()" />

<label for="filtro_status">Filtrar por Status:</label>
<select id="filtro_status" onchange="aplicarFiltros()">
    <option value="">Todos</option>
    <option value="ATUALIZADA">Atualizado</option>
    <option value="DESATUALIZADO">Desatualizado</option>
</select>

<label for="filtro-mh">Filtrar por Sexo:</label>
<select id="filtro-mh" onchange="aplicarFiltros()">
    <option value="">Todos</option>
    <option value="MULHER">MULHERES</option>
    <option value="HOMEM">HOMENS</option>
</select>

<label for="filtro-grupo">Filtrar por Escola:</label>
<input type="text" id="filtro-grupo" onchange="aplicarFiltros()" placeholder="Filtro por Escola"/>

<!--INPUT ESCONDIDOS PRA MANTER AS VARIÁVEIS DA FUNÇÃO aplicarFiltros FUNCIONANDO-->
<input type="hidden" id="filtro-other-grupo" value="" onkeyup="aplicarFiltros()">

<label for="filtro-idade">Filtrar por Idade:</label>
<input type="number" id="filtro-idade" onkeyup="aplicarFiltros()" placeholder="Filtro por idade"/>

<label for="filtro-parent">Filtrar por Parentesco:</label>
<select id="filtro-parent" onchange="aplicarFiltros()">
    <option value="">Filtro por parentesco</option>
    <option value="RESPONSAVEL FAMILIAR">RESPONSAVEL FAMILIAR</option>
    <option value="CONJUGE OU COMPANHEIRO">CONJUGE OU COMPANHEIRO</option>
    <option value="FILHO(A)">FILHO(A)</option>
    <option value="ENTEADO(A)">ENTEADO(A)</option>
    <option value="NETO(A) OU BISNETO(A)">NETO(A) OU BISNETO(A)</option>
    <option value="PAI OU MÃE">PAI OU MÃE</option>
    <option value="SOGRO(A)">SOGRO(A)</option>
    <option value="IRMÃO OU IRMÃ">IRMÃO OU IRMÃ</option>
    <option value="GENRO OU NORA">GENRO OU NORA</option>
    <option value="OUTROS PARENTES">OUTROS PARENTES</option>
    <option value="NÃO PARENTE">NÃO PARENTE</option>
</select>


    <div id="result-count"></div>

    <div id="tabela-dinamica"></div>

    <button onclick="filtroCriaIdos()">Filtrar Dados</button>
</body>
</html>
