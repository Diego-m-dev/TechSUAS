
// Função para criar a tabela dinamicamente
function criarTabela() {
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

  dados.forEach(function(row) {
      table += '<tr>'
      selectedColumns.forEach(function(columnIndex) {
          table += '<td>' + row[columnIndex] + '</td>'
      })
      table += '</tr>'
  })

  table += '</tbody></table></div>'

  $('#tabela-dinamica').html(table)
}

var dados = []; // Variável global para armazenar os dados da tabela

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

  fetch("/TechSUAS/controller/cadunico/filtro_visita")
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
  var filtroOtherGrupo = document.getElementById('filtro-other-grupo').value
  var filtroStatus = document.getElementById('filtro_status').value
  var filtroParent = document.getElementById('filtro-parent').value
  var filtro_renda_per = document.getElementById('renda_per').value
  var filtronome_pess = document.getElementById('nome_pess').value
  var filtroanoatual = document.getElementById('filtro_ano').value
  var filtroIdade = document.getElementById('filtro-idade').value
  var filtroGrupo = document.getElementById('filtro-grupo').value
  var filtro_mes = document.getElementById('filtro_mes').value
  var filtroSexo = document.getElementById('filtro-mh').value
  var filtrocpf = document.getElementById('cpf_pess').value
  var cod_fam = document.getElementById('cod_fam').value

  // Converter filtro_renda_per para número
  var filtro_renda_per_num = parseFloat(filtro_renda_per)

  // Limpar CPF e remover zeros à esquerda
  filtrocpf = filtrocpf.replace(/\D/g, '')
  filtrocpf = filtrocpf.replace(/^0+/, '')

  var dadosFiltrados = dados.filter(function(row) {
    return (filtroStatus === '' || (row[7] && row[7].toLowerCase().includes(filtroStatus.toLowerCase()))) &&
      (filtroGrupo === '' || (row[8] && row[8].toLowerCase().includes(filtroGrupo.toLowerCase()))) && 
      (cod_fam === '' || (row[0] && row[0].toLowerCase().includes(cod_fam.toLowerCase()))) && 
      (filtroOtherGrupo === '' || (row[9] && row[9].toLowerCase().includes(filtroOtherGrupo.toLowerCase()))) &&
      (filtroSexo === '' || (row[10] && row[10].toLowerCase().includes(filtroSexo.toLowerCase()))) &&
      (filtroParent === '' || (row[11] && row[11].toLowerCase().includes(filtroParent.toLowerCase()))) &&
      (filtronome_pess === '' || (row[1] && row[1].toLowerCase().includes(filtronome_pess.toLowerCase()))) &&
      (filtro_renda_per === '' || (row[15] !== null && row[15] !== undefined && parseFloat(row[15]) > filtro_renda_per_num)) &&
      (filtroanoatual === '' || (row[14] && row[14] === filtroanoatual)) &&
      (filtro_mes === '' || (row[16] && row[16] === filtro_mes)) &&
      (filtroIdade === '' || (row[4] && row[4] === filtroIdade)) &&
      (filtrocpf === '' || (row[13] && row[13] === filtrocpf))
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

  // Iniciar a tabela com o cabeçalho e incluir a coluna do checkbox
  var table = `
    <table class="table-bordered">
      <thead>
        <tr>
          <th class="check">
            <label class="urg">
              <input type="checkbox" id="selecionarTodos">
              <span class="checkmark"></span>
            </label>
          </th>
  `

  // Adicionar as colunas selecionadas no cabeçalho
  selectedColumns.forEach(function (columnIndex) {
    table += '<th>' + columnsSelect.options[columnIndex].text + '</th>'
  })
  table += '</tr></thead><tbody>'

  // Adicionar as linhas da tabela
  dadosFiltrados.forEach(function (row, rowIndex) {
    table += '<tr>'

    // Adicionar a coluna de checkbox, vinculada ao valor do NIS (row[2])
    table += `
      <td class="check">
        <label class="urg">
          <input type="checkbox" class="linha-checkbox" data-nis="${row[2]}" data-row-index="${rowIndex}">
          <span class="checkmark"></span>
        </label>
      </td>
    `

    // Adicionar os dados nas colunas selecionadas
    selectedColumns.forEach(function (columnIndex) {
      table += '<td>' + row[columnIndex] + '</td>'
    })
    table += '</tr>'
  })

  table += '</tbody></table>'

  // Inserir a tabela no HTML
  $('#tabela-dinamica').html(table)

  // Mostrar a quantidade de resultados
  document.getElementById('result-count').textContent = 'Total de resultados: ' + dadosFiltrados.length

  // Adicionar funcionalidade de selecionar todos
  $('#selecionarTodos').on('change', function () {
    $('.linha-checkbox').prop('checked', this.checked)
  })
}

function enviarNIS() {
  // Captura todos os checkboxes que estão marcados
  var checkboxes = document.querySelectorAll('.linha-checkbox:checked');
  var nisSelecionados = [];

  // Itera sobre os checkboxes e captura o atributo data-nis
  checkboxes.forEach(function (checkbox) {
      nisSelecionados.push(checkbox.getAttribute('data-nis'));
  });

  // Verifica se algum NIS foi selecionado
  if (nisSelecionados.length === 0) {
      alert('Por favor, selecione pelo menos um NIS.');
      return;
  }

  // Passa os NIS selecionados para o campo hidden do formulário
  document.getElementById('nisSelecionadosInput').value = JSON.stringify(nisSelecionados);

  // Submete o formulário
  document.getElementById('formEnviarNIS').submit();
}

function voltarFiltros() {
  window.location.href = "/TechSUAS/views/cadunico/visitas/index"
}