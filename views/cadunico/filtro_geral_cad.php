<?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

  $stmt_escola = "SELECT nom_escola_memb FROM tbl_tudo GROUP BY nom_escola_memb ORDER BY nom_escola_memb ASC";
  $stmt_escola_query = $conn->query($stmt_escola);
  if (!$stmt_escola_query) {
    die("ERRO ao consultar! " . $conn->error);
  }

  $escola = [];
  while ($b = $stmt_escola_query->fetch_assoc()) {
    $escola[] = $b['nom_escola_memb'];
  }
  ?>
  <!DOCTYPE html>
  <html lang="pt-br">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
      <link rel="stylesheet" href="/TechSUAS/css/cadunico/filtroFamilia.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
      <script src="/TechSUAS/js/gestor.js"></script>
      <script src="/TechSUAS/js/cadastro_unico.js"></script>

      <title>Filtros Geral - TechSUAS</title>
  </head>

  <body>
    <div class="container">
        <h2>Filtros Gerais - Consultar Famílias</h2>
          <div class="filtro-header">
            <label for="columns-select">Selecione as Colunas:</label>
              <select id="columns-select" multiple>
                <option value="0">Código Familiar</option>
                <option value="1">Nome</option>
                <option value="2">NIS</option>
                <option value="3">Data de Nascimento</option>
                <option value="4">Idade</option>
                <option value="5">Renda Total</option>
                <option value="6">Endereço</option>
                <option value="7">Status</option>
                <option value="8">Escola</option>
                <option value="9">PCD</option>
                <option value="10">Gênero</option>
                <option value="11">Parentesco</option>
                <option value="12">Telefone</option>
                <option value="13">Fichário</option>
                <option value="14">Ultima Atualização</option>
              </select>
          </div>

        <form id="filtrosForm" onsubmit="aplicarFiltrosForm(event)">
            <div class="filtro-header">
                <div class="bloc">
                    <label for="cod_fam">Código Familiar:</label>
                    <input type="text" name="cod_fam" placeholder="Código Familiar" id="cod_fam">
                </div>
                <div class="bloc">
                    <label for="nome_pessoa">Nome da Pessoa:</label>
                    <input type="text" name="nome_pessoa" placeholder="Nome da Pessoa" id="nome_pessoa">
                </div>
                <div class="bloc">
                    <label for="nis_pessoa_atual">NIS:</label>
                    <input type="text" name="nis_pessoa_atual" placeholder="NIS" id="nis_pessoa_atual">
                </div>
                <div class="bloc">
                    <label for="cpf_pess">CPF:</label>
                    <input type="text" name="cpf_pess" placeholder="CPF" id="cpf_pess">
                </div>
            </div>

            <div class="filtro-header">
              <div class="bloc">
                <select name="parentesco" id="parentesco">
                  <option value="">Filtro por parentesco</option>
                  <option value="1">RESPONSAVEL FAMILIAR</option>
                  <option value="2">CONJUGE OU COMPANHEIRO</option>
                  <option value="3">FILHO(A)</option>
                  <option value="4">ENTEADO(A)</option>
                  <option value="5">NETO(A) OU BISNETO(A)</option>
                  <option value="6">PAI OU MÃE</option>
                  <option value="7">SOGRO(A)</option>
                  <option value="8">IRMÃO OU IRMÃ</option>
                  <option value="9">GENRO OU NORA</option>
                  <option value="10">OUTROS PARENTES</option>
                  <option value="11">NÃO PARENTE</option>
                  <option value="0">CADASTRO SEM RF</option>
                </select>
              </div>
            </div>

            <div class="filtro-header">
                <div class="bloc">
                    <label for="dat_nasc">Data de Nascimento:</label>
                    <input type="date" name="dat_nasc" id="dat_nasc">
                </div>
                <h3><span id="noResult"></span></h3>
              <div class="visto">
                  <h3>Intervalo de Data de Aniversário:</h3>
                <div class="bloc">
                    <label for="idade_min">Data de Nascimento Mínima:</label>
                    <input type="date" id="idade_min" name="idade_min">
                </div>
                <div class="bloc">
                    <label for="idade_max">Data de Nascimento Máxima:</label>
                    <input type="date" id="idade_max" name="idade_max">
                </div>
              </div>
            </div>

            <div class="filtro-header">
                <div class="bloc">
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" id="endereco" placeholder="Bairro, Rua etc.">
                </div>
                <div class="bloc">
                  <label for="escola">Escola:</label>
                  <input type="text" name="escola" id="escola" placeholder="Escola">
                </div>
                <div class="bloc">
                    <label for="status_atualizacao">Status:</label>
                    <select name="status_atualizacao" id="status_atualizacao">
                        <option value="">Todos</option>
                        <option value="0">Atualizado</option>
                        <option value="1">Desatualizado</option>
                    </select>
                </div>
            </div>

            <div class="btns">
                <button type="submit" id="filtroCriaIdosButton">Buscar</button>
                <button type="button" onclick="limparCampos()">Limpar Filtros</button>
            </div>
        </form>

        <div id="result-count"></div>
        <div id="pagination-controls">
            <button id="previous-page" onclick="mudarPagina(-1)">Anterior</button>
            <span id="pagina-atual"></span>
            <button id="next-page" onclick="mudarPagina(1)">Próxima</button>
        </div>
    </div>


      <table id="tabelaGeral" class="table-bordered">
        <thead>
          <!-- Cabeçalho da tabela será preenchido dinamicamente -->
        </thead>
        <tbody>
          <!-- Dados da tabela serão preenchidos dinamicamente -->
        </tbody>
      </table>

      <script>
        $(document).ready(function () {
          $('#cpf_pess').mask('000.000.000-00')
        })

        function limparCampos() {
          document.getElementById("filtrosForm").reset()
          $('#noResult').text('')
          $('#pagina-atual').text('')
          $('#result-count').text('')
        }
      </script>
  </body>

  </html>
<?php
  $conn_1->close();