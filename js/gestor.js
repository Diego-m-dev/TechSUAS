//CADASTRO DE NOVO MUNICIPIO
$(document).ready(function () {
  $('#cnpj_prefeitura').mask('00.000.000/0000-00')
  $('.hideall').hide()
  $('#btn_cadastrar_municipio').click(function () {
    $('#formCadMunicipio').show()
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

    var table = '<table><thead><tr>';
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

    table += '</tbody></table>';

    $('#tabela-dinamica').html(table);
}

// Função para buscar dados e atualizar a tabela
function filterGPTE() {
    fetch("/TechSUAS/views/cadunico/area_gestao/filtro_gpte")
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
        })
        .catch(error => {
            console.log('Erro ao buscar dados:', error);
        });
}

function filtroCriaIdos() {
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
      })
      .catch(error => {
          console.log('Erro ao buscar dados:', error);
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
    const filtroIdade = document.getElementById('filtro-idade').value.trim()

    var dadosFiltrados = dados.filter(function(row) {
        return (filtroStatus === '' || row[7].toLowerCase().includes(filtroStatus.toLowerCase())) &&
              (filtroGrupo === '' || row[8].toLowerCase().includes(filtroGrupo.toLowerCase())) && 
              (cod_fam === '' || row[0].toLowerCase().includes(cod_fam.toLowerCase())) && 
              (filtroOtherGrupo === '' || row[9].toLowerCase().includes(filtroOtherGrupo.toLowerCase())) &&
              (filtroSexo === '' || row[10].toLowerCase().includes(filtroSexo.toLowerCase())) &&
              (filtroParent === '' || row[11].toLowerCase().includes(filtroParent.toLowerCase())) &&
              (filtroIdade === '' || row[4].includes(filtroIdade.toLowerCase()))

    });

    criarTabelaFiltrada(dadosFiltrados);
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

    var table = '<table><thead><tr>'
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

function filtroCriIdo() {
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
    window.location.href = "/TechSUAS/views/cadunico/area_gestao/filtro_familia_idosos_criancas"
  })
}

function voltarFiltros() {
  window.location.href = "/TechSUAS/views/cadunico/area_gestao/filtros"
}