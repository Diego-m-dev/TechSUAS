<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
if ($_SESSION['setor'] != "SUPORTE") {
    echo "VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR AQUI!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/suporte.js"></script>
    <title>Suporte</title>
</head>

<body>
    <h1>MUNICÍPIOS</h1>
    <button id="btn_cadastrar_municipio">Cadastrar Novo</button>
    <button id="btn_cadastrar_sistema">Cadastrar sistema</button>
    <button id="btn_cadastrar_setor">Cadastrar setor</button>
    <button id="btn_cadastrar_operador">Cadastrar operador</button>

    <body>
        <!--CADASTRO DE MUNICÍPIOS-->
<div class="hideall">
  <div id="formCadMunicipio">
    <h2>Cadastro de Municípios</h2>
    <form action="cadastrar_municipio.php" method="POST">
    Código IBGE:
    <input type="number" id="cod_ibge" name="cod_ibge"/>

    <select name="uf" id="uf" required>
      <option value="" disabled selected hidden>Selecione o estado</option>
      <option value="AC">Acre</option>
      <option value="AL">Alagoas</option>
      <option value="AP">Amapá</option>
      <option value="AM">Amazonas</option>
      <option value="BA">Bahia</option>
      <option value="CE">Ceará</option>
      <option value="DF">Distrito Federal</option>
      <option value="ES">Espírito Santo</option>
      <option value="GO">Goiás</option>
      <option value="MA">Maranhão</option>
      <option value="MT">Mato Grosso</option>
      <option value="MS">Mato Grosso do Sul</option>
      <option value="MG">Minas Gerais</option>
      <option value="PA">Pará</option>
      <option value="PB">Paraíba</option>
      <option value="PR">Paraná</option>
      <option value="PE">Pernambuco</option>
      <option value="PI">Piauí</option>
      <option value="RJ">Rio de Janeiro</option>
      <option value="RN">Rio Grande do Norte</option>
      <option value="RS">Rio Grande do Sul</option>
      <option value="RO">Rondônia</option>
      <option value="RR">Roraima</option>
      <option value="SC">Santa Catarina</option>
      <option value="SP">São Paulo</option>
      <option value="SE">Sergipe</option>
      <option value="TO">Tocantins</option>
    </select>
    Nome do Município:
    <input type="text" name="nome_mun" class="maiusculo" id="nome_mun" oninput="sempre_maiusculo(this)" />
    CNPJ Prefeitura:
    <input type="text" name="cnpj_prefeitura" id="cnpj_prefeitura"/>
    Nome Prefeito:
    <input type="text" name="nome_prefeito" id="nome_prefeito" class="maiusculo"  oninput="sempre_maiusculo(this)" />
    Nome Vice-Prefeito:
    <input type="text" name="nome_vice" id="nome_vice" class="maiusculo"  oninput="sempre_maiusculo(this)" />

        <button type="submit">Cadastrar</button>
    </form><hr>
    </div>

        <!--CADASTRO DE SETORES-->
        <h2>Cadastro de Setores</h2>
    <form action="cadastrar_setor.php" method="POST" id="formCadSetor">
        <label for="cod_contrato">Código do Contrato:</label>
        <input type="text" id="cod_contrato" name="cod_contrato" required>

        <label for="instituicao">Instituição:</label>
        <input type="text" id="instituicao" name="instituicao" required>

        <label for="nome_instit">Nome da Instituição:</label>
        <input type="text" id="nome_instit" name="nome_instit" required>

        <label for="rua">Rua:</label>
        <input type="text" id="rua" name="rua">

        <label for="numero">Número:</label>
        <input type="text" id="numero" name="numero">

        <label for="bairro">Bairro:</label>
        <input type="text" id="bairro" name="bairro" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="cod_instit">Código da Instituição:</label>
        <input type="text" id="cod_instit" name="cod_instit" required>

        <label for="responsavel">Responsável:</label>
        <input type="text" id="responsavel" name="responsavel" required>

        <label for="cpf_coord">CPF do Coordenador:</label>
        <input type="text" id="cpf_coord" name="cpf_coord" required>

        <label for="municipio_id">ID do Município:</label>
        <input type="number" id="municipio_id" name="municipio_id" required>

        <button type="submit">Cadastrar</button>
    </form><hr>

        <!--CADASTRO DE SISTEMA-->
    <h2>Cadastro de Sistemas</h2>
    <form action="cadastrar_sistema.php" method="POST" id="formCadSistemas">
        <label for="nome_sistema">Nome do Sistema:</label>
        <input type="text" id="nome_sistema" name="nome_sistema" required>

        <label for="data_aquisicao">Data de Aquisição:</label>
        <input type="text" id="data_aquisicao" name="data_aquisicao" required>

        <label for="setores_id">ID do Setor:</label>
        <input type="number" id="setores_id" name="setores_id" required>

        <label for="secretaria">Secretaria:</label>
        <input type="text" id="secretaria" name="secretaria" required>

        <label for="responsavel">Responsável:</label>
        <input type="text" id="responsavel" name="responsavel" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>

        <button type="submit">Cadastrar</button>
    </form><hr>

        <!--CADASTRO DE OPERADORES-->
        <h2>Cadastro de Operadores</h2>
    <form action="cadastrar_operador.php" method="POST" id="formCadoperador">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" required>

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label for="nivel">Nível:</label>
        <input type="text" id="nivel" name="nivel" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>

        <label for="setor">Setor:</label>
        <input type="text" id="setor" name="setor" required>

        <label for="funcao">Função:</label>
        <input type="number" id="funcao" name="funcao" required>

        <label for="dt_nasc">Data de Nascimento:</label>
        <input type="date" id="dt_nasc" name="dt_nasc" required>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo" required>

        <label for="id_cargo">ID do Cargo:</label>
        <input type="text" id="id_cargo" name="id_cargo" required>

        <label for="acesso">Acesso:</label>
        <input type="text" id="acesso" name="acesso" required>

        <label for="sistema_id">ID do Sistema:</label>
        <input type="number" id="sistema_id" name="sistema_id" required>

        <button type="submit">Cadastrar</button>
    </form><hr>
</div>
</body>
</html>