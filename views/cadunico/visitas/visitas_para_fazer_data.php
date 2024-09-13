<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

$sql_ano = "SELECT DISTINCT YEAR(dat_atual_fam) AS ano FROM tbl_tudo ORDER BY ano DESC";
$result_sql_ano = $conn->query($sql_ano);

if (!$result_sql_ano) {
    die("ERRO ao consultar! " . $conn->error);
}

$anos = [];
while ($d = $result_sql_ano->fetch_assoc()) {
    $anos[] = $d['ano'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Filtro Visitas - TechSUAS</title>

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/visitas_pend.css">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/area_gestor/filtro_geral.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/entrevistadores.js"></script>

</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/cadunico/visitas/h1-visitas_pend.svg" alt="NoImage">
        </h1>
    </div>

    <div class="container">
        <div class="blocs">
            <div class="bloc">
                <div class="bloc1">
                    <label for="columns-select">Selecione as Colunas:</label>
                    <select id="columns-select" multiple onchange="criarTabela([])">
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
                    </select>
                </div>
                <div>
                    <div>
                        <label for="">Nome:</label>
                        <input type="text" id="nome_pess" onkeyup="aplicarFiltros()" />
                    </div>
                    <div>
                        <label for="cod_fam">Código Familiar:</label>
                        <input type="text" id="cod_fam" onkeyup="aplicarFiltros()" />
                    </div>
                    <label for="renda_per">Renda Per Capita:</label>
                    <input type="number" id="renda_per" onkeyup="aplicarFiltros()">

                    <div>
                        <label for="filtro_status">Status:</label>
                        <select id="filtro_status" onchange="aplicarFiltros()">
                            <option value="">Todos</option>
                            <option value="ATUALIZADA">Atualizado</option>
                            <option value="DESATUALIZADO">Desatualizado</option>
                        </select>
                        <div>
                            <label for="filtro-mh">Sexo:</label>
                            <select id="filtro-mh" onchange="aplicarFiltros()">
                                <option value="">Todos</option>
                                <option value="MULHER">MULHERES</option>
                                <option value="HOMEM">HOMENS</option>
                            </select>
                        </div>
                    </div>
                </div>


            </div>
            <div class="bloc2">
                    <div>
                        <label for="cpf_pess">CPF:</label>
                        <input type="text" id="cpf_pess" onkeyup="aplicarFiltros()" />
                    </div>
                <div>
                    <label for="filtro-grupo">Escola:</label>
                    <input type="text" id="filtro-grupo" onchange="aplicarFiltros()" placeholder="Filtro por Escola" />
                </div>

                <div>
                    <!--INPUT ESCONDIDOS PRA MANTER AS VARIÁVEIS DA FUNÇÃO aplicarFiltros FUNCIONANDO-->
                    <input type="hidden" id="filtro-other-grupo" value="" onkeyup="aplicarFiltros()">
                </div>

                <div>
                    <label for="filtro-idade">Idade:</label>
                    <input type="number" id="filtro-idade" onkeyup="aplicarFiltros()" placeholder="Filtro por idade" />
                </div>

                <label for="ano_atual">Filtro por data:</label>
                <select id="filtro_mes" onchange="aplicarFiltros()">
                  <option value="">Mês</option>
                  <option value="1">Janeiro</option>
                  <option value="2">Fevereiro</option>
                  <option value="3">Março</option>
                  <option value="4">Abril</option>
                  <option value="5">Maio</option>
                  <option value="6">Junho</option>
                  <option value="7">Julho</option>
                  <option value="8">Agosto</option>
                  <option value="9">Setembro</option>
                  <option value="10">Outubro</option>
                  <option value="11">Novembro</option>
                  <option value="12">Dezembro</option>
                </select>
                <select id="filtro_ano" onchange="aplicarFiltros()">
                  <option value="">Ano</option>
<?php
  foreach ($anos_atual as $ano) {
    echo "<option value'$ano'>$ano</option>";
  }
?>
                </select>

                <div>
                    <label for="filtro-parent">Parentesco:</label>
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
                </div>
            </div>
        </div>
        <div class="btns">
            <div>
            <button id="filtroCriaIdosButton" onclick="filtroCriaIdos()">Buscar Dados</button>
                <button onclick="window.location.href='/TechSUAS/views/cadunico/area_gestao/filtro_geral'">Limpar dados</button>
            </div>
            <div><button onclick="voltarFiltros()">Voltar</button></div>
        </div>

        <div id="result-count"></div>

        <div id="tabela-dinamica"></div>

          <div>
            <button id="enviarNISButton" onclick="enviarNIS()">Imprimir</button>
          </div>
      <form id="formEnviarNIS" method="POST" action="/TechSUAS/controller/cadunico/parecer/visitas_print">
        <input type="hidden" name="nis_selecionados" id="nisSelecionadosInput" value="">
      </form>
  </div>
    <script>
      $(document).ready(function () {
        $('#cpf_pess').mask('000.000.000-00')
      })
    </script>
    
    <?php
      $conn_1->close();
    ?>
</body>

</html>