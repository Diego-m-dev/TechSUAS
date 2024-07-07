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
  <link rel="stylesheet" href="./css/style_municipios.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="/TechSUAS/js/suporte.js"></script>
  <title>Cadastros Iniciais</title>
</head>

<body>
  <div class="img">
    <h1 class="titulo-com-imagem">
      <img class="titulo-com-imagem" src="./h1-cadastros_iniciais.svg" alt="Título com imagem">
    </h1>
  </div>
  <div class="container">
    <button id="btn_cadastrar_municipio">Cadastrar Município</button>
    <button id="btn_cadastrar_setor">Cadastrar setor</button>
    <button id="btn_cadastrar_sistema">Cadastrar sistema</button>
    <button id="btn_cadastrar_operador">Cadastrar operador</button>
    <button id="btn_cadastrar_bd">Base de Dados</button>


    <!--CADASTRO DE MUNICÍPIOS-->
    <div class="hideall">
      <div id="formCadMunicipio">
        <form action="/TechSUAS/suporte/controller/salva_mun.php" method="POST" id="form_municipio" class="esconde_form">
          <h2>Cadastro de Municípios</h2>
          <label for="">Código IBGE:</label>
          <input type="number" id="cod_ibge" name="cod_ibge" />

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
          <label for="">Nome do Município:</label>
          <input type="text" name="nome_mun" class="maiusculo" id="nome_mun" oninput="sempre_maiusculo(this)" />
          <label for="">CNPJ Prefeitura:</label>
          <input type="text" name="cnpj_prefeitura" id="cnpj_prefeitura" />
          <label for="">Nome Prefeito:</label>
          <input type="text" name="nome_prefeito" id="nome_prefeito" class="maiusculo" oninput="sempre_maiusculo(this)" />
          <label for="">Nome Vice-Prefeito:</label>
          <input type="text" name="nome_vice" id="nome_vice" class="maiusculo" oninput="sempre_maiusculo(this)" />

          <button type="submit">Cadastrar</button>
        </form>
        <hr>
      </div>

      <!--CADASTRO DE SETORES-->
      <form action="/TechSUAS/suporte/controller/salva_setor" method="POST" id="formCadSetor" class="esconde_form">
        <h2>Cadastro de Setores</h2>

        <div id="municipio-info"></div>
        <label for="cod_ibge_2">Código IBGE:</label>
        <input type="text" id="cod_ibge_2" name="cod_ibge_2" placeholder="Digite o código IBGE" onblur="buscarMunicipio()">
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

        <label for="responsavel">Responsável:</label>
        <input type="text" id="responsavel" name="responsavel" required>

        <label for="cpf_coord">CPF do Coordenador:</label>
        <input type="text" id="cpf_coord" name="cpf_coord" required>

        <button type="submit">Cadastrar</button>
      </form>
      <hr>

      <!--CADASTRO DE SISTEMA-->
      <form action="/TechSUAS/suporte/controller/salva_sys.php" method="POST" id="formCadSistemas" class="esconde_form">
        <h2>Cadastro de Sistemas</h2>

        <div id="responsavel-info"></div>

        <label for="cpf">CPF do Responsável</label>
        <input type="text" id="cpf" name="cpf" onblur="buscarResponsavel()" required>

        <label for="nome_sistema">Nome do Sistema:</label>
        <input type="text" id="nome_sistema" name="nome_sistema" required>

        <label for="data_aquisicao">Data de Aquisição:</label>
        <input type="date" id="data_aquisicao" name="data_aquisicao" required>

        <br><label for="validade">Validade:</label>
        <input type="number" id="validade" name="validade" required>

        <label for="secretaria">Secretaria:</label>
        <input type="text" id="secretaria" name="secretaria" required>

        <button type="submit">Cadastrar</button>
      </form>
      <hr>

      <!--CADASTRO DE OPERADORES-->
      <form action="/TechSUAS/controller/geral/processo_cad_user" method="POST" id="formCadoperador" class="esconde_form">
        <h2>Cadastro de Operadores</h2>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>

        <label>Nome completo:</label>
        <input type="text" class="nome" name="nome_user" placeholder="Sem Abreviação." required style="width: 300px;">

        <label>E-mail:</label>
        <input type="email" name="email" placeholder="Digite aqui seu e-mail." required style="width: 300px;">

        <br><label for="">Sistema:</label>
        <select name="sistema" required>
          <option value="" disabled selected hidden>Selecione</option>
          <?php

          $consultaSetores = $conn_1->query("SELECT nome_sistema FROM sistemas");

          // Verifica se há resultados na consulta
          if ($consultaSetores->num_rows > 0) {

            // Loop para criar as opções do select
            while ($system = $consultaSetores->fetch_assoc()) {
          ?>
              <option value="<?php echo $system['nome_sistema'] ?>"><?php echo $system['nome_sistema'] ?></option>
          <?php
            }
          }
          ?>
        </select>

        <label>Setor:</label>
        <select name="setor" required>
          <option value="" disabled selected hidden>Selecione</option>
          <?php

          $consultaSetores = $conn_1->query("SELECT instituicao, nome_instit FROM setores");

          // Verifica se há resultados na consulta
          if ($consultaSetores->num_rows > 0) {

            // Loop para criar as opções do select
            while ($setor = $consultaSetores->fetch_assoc()) {
              echo '<option value="' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '">' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '</option>';
            }
          }
          ?>
        </select>

        <label>Função: </label>
        <select name="funcao" id="funcao" required onchange="mostrarCampoTexto()">
          <option value="" disabled selected hidden>Selecione</option>
          <option value="1">Gestão</option>
          <option value="2">Tecnico(a)</option>
          <option value="3">Outros</option>
        </select>

        <input type="text" name="funcao_outros" id="funcao_outros" style="display: none;" placeholder="Digite a função">

        <button type="submit">Cadastrar</button>
      </form>
      <hr>

      <!-- BASE DE DADOS -->
      <form action="/TechSUAS/suporte/controller/bd" method="POST" class="esconde_form" id="form_bd">
        <input type="text" id="cod_ibge_3" name="cod_ibge_3" placeholder="Digite o código IBGE" onblur="buscarMunicipiobd()">
        <div id="municipio-infobd"></div>
        <label for="">Nome base de dados</label>
        <input type="text" name="nome_bd" />

        <label for="">Nome usuario</label>
        <input type="text" name="nome_user" />

        <label for="">Nome senha</label>
        <input type="text" name="senha_bd" />

        <button type="submit">salvar</button>
      </form>
    </div>
  </div>
  <script>
    $('#cpf').mask('000.000.000-00')
  </script>
</body>

</html>