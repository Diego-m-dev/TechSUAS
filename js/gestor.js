//CADASTRO DE NOVO MUNICIPIO
$(document).ready(function () {
  $('#cnpj_prefeitura').mask('00.000.000/0000-00')
  $('.hideall').hide()
  $('#btn_cadastrar_municipio').click(function () {
    $('#formCadMunicipio').show()
  })
})

$(document).ready(function() {
  $('#columns-select').select2({
      placeholder: "Selecione as Colunas",
      allowClear: true
  })
})

function sempre_maiusculo(elemento) {
  // Converte o texto do campo para maiúsculas
  elemento.value = elemento.value.toUpperCase();
}


//BOTÕES DA TELA DE AREA DO GESTOR
$(document).ready(function () {
  $('#simples').hide()
  $('#beneficio').hide()
  $('#entrevistadores').hide()

  $('#btn_familia').click(function () {
    $('#simples').show()
    $('#beneficio').hide()
    $('#entrevistadores').hide()
    $('#btn_benef').hide()
    $('#btn_entrevistadores').hide()
  })
  $('#btn_benef').click(function () {
    $('#beneficio').show()
    $('#simples').hide()
    $('#entrevistadores').hide()
  })
  $('#btn_entrevistadores').click(function () {
    $('#beneficio').hide()
    $('#simples').hide()
    $('#entrevistadores').show()
  })
})

//BOTÕES PARA FILTROS
$(document).ready(function () {
  $('.filters-container').hide()
  $('.table-container').hide()

  $('#btn_gepetees').click(function () {
    $('.filters-container').show()
    $('.table-container').show()
    $('#btn_gepetees').hide()
  })
})

var dados = []; // Variável global para armazenar os dados da tabela

// Função para criar a tabela dinamicamente
function criarTabela() {
    var columnsSelect = document.getElementById('columns-select');
    var selectedColumns = [];
    for (var i = 0; i < columnsSelect.options.length; i++) {
        if (columnsSelect.options[i].selected) {
            selectedColumns.push(columnsSelect.options[i].value);
        }
    }

    var table = '<table class="table-bordered"><thead><tr>';
    selectedColumns.forEach(function(columnIndex) {
        table += '<th>' + columnsSelect.options[columnIndex].text + '</th>';
    });
    table += '</tr></thead><tbody>';

    dados.forEach(function(row) {
        table += '<tr>';
        selectedColumns.forEach(function(columnIndex) {
            table += '<td>' + row[columnIndex] + '</td>';
        });
        table += '</tr>';
    });

    table += '</tbody></table></div>';

    $('#tabela-dinamica').html(table);
}

// Função para buscar dados e atualizar a tabela
function filterGPTE() {
    fetch("/TechSUAS/views/cadunico/area_gestao/filtro_gpte")
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição: ' + response.status)
            }
            return response.json()
        })
        .then(data => {
            console.log('Dados recebidos', data)
            dados = data // Armazena os dados recebidos globalmente
            criarTabela() // Chama a função para criar a tabela com os dados recebidos
        })
        .catch(error => {
            console.log('Erro ao buscar dados:', error)
        })
}

function filtroCriaIdos() {
  const button = document.getElementById('filtroCriaIdosButton');
  if (!button) {
    console.error('Botão não encontrado.');
    return;
  }

  const loadingHtml = `
    <div id="loadingSpinner" style="text-align: center;">
      <i class="fas fa-spinner fa-spin" style="font-size: 24px; margin-bottom:10px;"></i><br>
      <p>Carregando...</p>
    </div>
  `;

  Swal.fire({
    html: loadingHtml,
    width: '400px',
    showConfirmButton: false,
    allowOutsideClick: false
  });

  // Desabilita o botão para evitar múltiplos cliques
  button.disabled = true;

  fetch("/TechSUAS/views/cadunico/area_gestao/filtro_idoso_crianca")
    .then(response => {
      if (!response.ok) {
        throw new Error('Erro na requisição: ' + response.status);
      }
      return response.json();
    })
    .then(data => {
      console.log('Dados recebidos', data);
      dados = data; // Armazena os dados recebidos globalmente
      criarTabela(); // Chama a função para criar a tabela com os dados recebidos
      Swal.close(); // Fecha o modal de carregamento
    })
    .catch(error => {
      console.error('Erro ao buscar dados:', error);
      Swal.fire('Erro!', 'Houve um problema ao carregar os dados.', 'error');
    })
    .finally(() => {
      // Reabilita o botão após carregar os dados ou em caso de erro
      button.disabled = false;
    });
}


// Função para aplicar filtros na tabela
function aplicarFiltros() {
  var filtroStatus = document.getElementById('filtro_status').value
  var filtroGrupo = document.getElementById('filtro-grupo').value
  var filtroOtherGrupo = document.getElementById('filtro-other-grupo').value
  var filtroParent = document.getElementById('filtro-parent').value
  var filtroSexo = document.getElementById('filtro-mh').value
  var cod_fam = document.getElementById('cod_fam').value
  var filtroIdade = document.getElementById('filtro-idade').value

  var dadosFiltrados = dados.filter(function(row) {
    return (filtroStatus === '' || (row[7] && row[7].toLowerCase().includes(filtroStatus.toLowerCase()))) &&
      (filtroGrupo === '' || (row[8] && row[8].toLowerCase().includes(filtroGrupo.toLowerCase()))) && 
      (cod_fam === '' || (row[0] && row[0].toLowerCase().includes(cod_fam.toLowerCase()))) && 
      (filtroOtherGrupo === '' || (row[9] && row[9].toLowerCase().includes(filtroOtherGrupo.toLowerCase()))) &&
      (filtroSexo === '' || (row[10] && row[10].toLowerCase().includes(filtroSexo.toLowerCase()))) &&
      (filtroParent === '' || (row[11] && row[11].toLowerCase().includes(filtroParent.toLowerCase()))) &&
      (filtroIdade === '' || (row[4] && row[4] === filtroIdade))
  })

  criarTabelaFiltrada(dadosFiltrados)
}


// Função para criar a tabela filtrada
function criarTabelaFiltrada(dadosFiltrados) {
    var columnsSelect = document.getElementById('columns-select')
    var selectedColumns = []
    for (var i = 0; i < columnsSelect.options.length; i++) {
        if (columnsSelect.options[i].selected) {
            selectedColumns.push(columnsSelect.options[i].value)
        }
    }

    var table = '<table class="table-bordered"><thead><tr>'
    selectedColumns.forEach(function(columnIndex) {
        table += '<th>' + columnsSelect.options[columnIndex].text + '</th>'
    })
    table += '</tr></thead><tbody>'

    dadosFiltrados.forEach(function(row) {
        table += '<tr>'
        selectedColumns.forEach(function(columnIndex) {
            table += '<td>' + row[columnIndex] + '</td>'
        })
        table += '</tr>'
    })

    table += '</tbody></table>'

    $('#tabela-dinamica').html(table)
    //mostra a quantidade de resltado
    document.getElementById('result-count').textContent = 'Total de resultados: ' + dadosFiltrados.length;
}

//DIRECIONAMENTO PARA FILTRAR OS CADASTROS DOS GRUPOS POPULACIONAIS TRADICIONAIS E ESPECIFICOS
function filtroGPTE() {
  Swal.fire({
    icon: "info",
    title: "ATENÇÃO",
    html: `
    <p>As informações presentes na sua base de dados refletem o conteúdo extraído do CECAD.</p>
    <p>Recomendamos sempre atualizar o seu banco de dados com os arquivos mais recentes disponíveis no CECAD.</p>
    <p>Os desenvolvedores do sistema não se responsabilizam por dados incorretos ou desatualizados.</p>
    `,
    confirmButtonText: "OK"
  }).then((result) => {
    window.location.href = "/TechSUAS/views/cadunico/area_gestao/filtro_familias_gpte"
  })
}

//DIRECIONAMENTO PARA FILTRAR OS CADASTROS COM INDICATIVO DE TRABALHO INFANTIL
function filtroTrabInf() {
  Swal.fire({
    icon: "info",
    title: "ATENÇÃO",
    html: `
    <p>As informações presentes na sua base de dados refletem o conteúdo extraído do CECAD.</p>
    <p>Recomendamos sempre atualizar o seu banco de dados com os arquivos mais recentes disponíveis no CECAD.</p>
    <p>Os desenvolvedores do sistema não se responsabilizam por dados incorretos ou desatualizados.</p>
    `,
    confirmButtonText: "OK"
  }).then((result) => {
    window.location.href = "/TechSUAS/views/cadunico/area_gestao/filtro_trabalho_infantil"
  })
}

function filtroGeral() {
  Swal.fire({
    icon: "info",
    title: "ATENÇÃO",
    html: `
    <p>As informações presentes na sua base de dados refletem o conteúdo extraído do CECAD.</p>
    <p>Recomendamos sempre atualizar o seu banco de dados com os arquivos mais recentes disponíveis no CECAD.</p>
    <p>Os desenvolvedores do sistema não se responsabilizam por dados incorretos ou desatualizados.</p>
    `,
    confirmButtonText: "OK"
  }).then((result) => {
    window.location.href = "/TechSUAS/views/cadunico/area_gestao/filtro_geral"
  })
}

function voltarFiltros() {
  window.location.href = "/TechSUAS/views/cadunico/area_gestao/filtros"
}

function unipessoal() {
  fetch("/TechSUAS/controller/cadunico/area_gestor/list_unip")
    .then(response => {
      if (!response.ok) {
        throw new Error('Erro na requisição: ' + response.status)
      }
      return response.json()
    })
    .then(data => {
      console.log('Dados recebidos', data)
      criarTabelaUnip(data); // Chama a função para criar a tabela com os dados recebidos
    })
    .catch(error => {
      console.log('Erro ao buscar dados:', error)
    })
}

function criarTabelaUnip(dados) {
  // Criar a tabela dinamicamente
  let table = '<table class="table-bordered">'
  table += '<thead>'
  table += '<tr>'
  table += '<th>Públicos</th>'
  table += '<th>Quantidade</th>'
  table += '<th>Visualizar</th>'
  table += '</tr>'
  table += '</thead>'
  table += '<tbody>'

  dados.forEach(dado => {
    table += '<tr>'
    table += `<td>${dado.inc_unip}</td>`
    table += `<td>${dado.quantidade}</td>`
    table += `<td><form action="/TechSUAS/views/cadunico/area_gestao/show_publicos" method="POST">
    <input type="hidden" name="unip" value="${dado.in_inconsistencia_uni}"/>
    <button type="submit">
        <i class="fa fa-eye"></i>
    </button>
    </form></td>`
    table += '</tr>'
  })

  table += '</tbody>'
  table += '</table>'

  // Mostrar o SweetAlert com a tabela
  Swal.fire({
    title: 'LISTA AVERIGUAÇÃO UNIPESSOAL',
    html: table,
    width: '800px', // Largura da janela SweetAlert
    showCloseButton: true,
    showConfirmButton: false
  });
}
