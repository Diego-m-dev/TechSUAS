// const { title } = require("process")

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



// Variável global para armazenar os dados da tabela
var dados = []

// Variáveis de controle de paginação
let paginaAtual = 1
let totalPaginas = 1
let limite = 100 // Quantidade de registros por página

// Função para aplicar os filtros e carregar a tabela
function aplicarFiltrosForm(event) {
      $('#noResult').text('')
      $('#pagina-atual').text('')
      $('#result-count').text('')
  const button = document.getElementById('filtroCriaIdosButton');
  if (!button) {
    console.error('Botão não encontrado.')
    return
  }

  // Exibe o spinner de carregamento
  const loadingHtml = `
    <div id="loadingSpinner" style="text-align: center;">
      <i class="fas fa-spinner fa-spin" style="font-size: 24px; margin-bottom:10px;"></i><br>
      <p>Carregando...</p>
    </div>
  `
  Swal.fire({
    html: loadingHtml,
    width: '400px',
    showConfirmButton: false,
    allowOutsideClick: false
  })

  // Desabilita o botão para evitar múltiplos cliques
  button.disabled = true

  if (event) event.preventDefault() // Evitar o refresh da página ao enviar o formulário

  // Captura os valores dos campos de filtro
  let cod_fam = document.getElementById('cod_fam').value
  let nome_pessoa = document.getElementById('nome_pessoa').value
  let cpf_pess = document.getElementById('cpf_pess').value
  let nis_pessoa_atual = document.getElementById('nis_pessoa_atual').value
  let dat_nasc = document.getElementById('dat_nasc').value
  let endereco = document.getElementById('endereco').value
  let status_atualizacao = document.getElementById('status_atualizacao').value
  const idadeMin = document.getElementById('idade_min').value
  const idadeMax = document.getElementById('idade_max').value
  let escola = document.getElementById('escola').value
  let parentesco = document.getElementById('parentesco').value

  // Montar a URL com os filtros e a página atual
  let url = `/TechSUAS/controller/cadunico/filtro_geral_cad?pagina=${paginaAtual}&limite=${limite}`

  // Acrescentar os filtros à URL se existirem
  if (cod_fam) url += `&cod_fam=${cod_fam}`
  if (nome_pessoa) url += `&nome_pessoa=${nome_pessoa}`
  if (nis_pessoa_atual) url += `&nis_pessoa_atual=${nis_pessoa_atual}`
  if (dat_nasc) url += `&dat_nasc=${dat_nasc}`
  if (endereco) url += `&endereco=${endereco}`
  if (status_atualizacao) url += `&status_atualizacao=${status_atualizacao}`
  if (idadeMin) url += `&idadeMin=${idadeMin}`
  if (idadeMax) url += `&idadeMax=${idadeMax}`
  if (cpf_pess) url += `&cpf_pess=${cpf_pess}`
  if (escola) url += `&escola=${escola}`
  if (parentesco) url += `&parentesco=${parentesco}`

  // Fazer a requisição via fetch
  fetch(url)
    .then(response => response.json())
    .then(data => {
      console.log('Dados filtrados recebidos:', data)
      dados = data

      // Atualiza o número total de páginas e a página atual
      totalPaginas = data.total_paginas
      paginaAtual = data.pagina_atual

      // Chama a função para atualizar a tabela e a paginação
      criarTabelaGeral()
      atualizarPaginacao()
      Swal.close() // Fecha o modal de carregamento
    })
    .catch(error => {
      console.error('Erro ao aplicar filtros:', error)
    })
    .finally(() => {
      // Reabilita o botão após carregar os dados ou em caso de erro
      button.disabled = false
    })
}

// Função para mudar a página (próxima/anterior)
function mudarPagina(direcao) {
  let novaPagina = paginaAtual + direcao;

  // Verifica se a nova página está dentro dos limites
  if (novaPagina >= 1 && novaPagina <= totalPaginas) {
    paginaAtual = novaPagina;
    aplicarFiltrosForm();  // Faz a requisição para a nova página
  }
}

// Função para atualizar os controles de paginação
function atualizarPaginacao() {
  document.getElementById('pagina-atual').textContent = `Página ${paginaAtual} de ${totalPaginas}`;

  // Desabilita ou habilita os botões de navegação conforme a página atual
  document.getElementById('previous-page').disabled = (paginaAtual === 1);
  document.getElementById('next-page').disabled = (paginaAtual === totalPaginas);
}

// Inicializa a primeira carga de dados
aplicarFiltrosForm();


function criarTabelaGeral() {
  let tabela = document.getElementById('tabelaGeral')
  let thead = tabela.querySelector('thead')
  let tbody = tabela.querySelector('tbody')
  let resultCount = document.getElementById('noResult')

  // Limpa o cabeçalho e o corpo da tabela anterior
  thead.innerHTML = '';
  tbody.innerHTML = '';

  // Verificar se a variável 'dados' está vazia ou se não há dados
  if (!dados.dados || dados.dados.length === 0) {
    resultCount.textContent = 'Nenhuma infomação foi encontrada! Consulte no CadÚnico.'
    return // Interrompe a execução se não houver dados
  }

  // Obtenha as opções selecionadas no select
  let selectedOptions = Array.from(document.getElementById('columns-select').selectedOptions).map(option => option.value);

  // Criar o cabeçalho da tabela com base nas colunas selecionadas
  let headerRow = document.createElement('tr');
  selectedOptions.forEach(coluna => {
      let th = document.createElement('th');
      switch (parseInt(coluna)) {
          case 0: th.textContent = 'Código Familiar'; break;
          case 1: th.textContent = 'Nome'; break;
          case 2: th.textContent = 'NIS'; break;
          case 3: th.textContent = 'Data de Nascimento'; break;
          case 4: th.textContent = 'Idade'; break;
          case 5: th.textContent = 'Renda Total'; break;
          case 6: th.textContent = 'Endereço'; break;
          case 7: th.textContent = 'Status'; break;
          case 8: th.textContent = 'Escola'; break;
          case 9: th.textContent = 'PCD'; break;
          case 10: th.textContent = 'Gênero'; break;
          case 11: th.textContent = 'Parentesco'; break;
          case 12: th.textContent = 'Telefone'; break;
          case 13: th.textContent = 'Fichário'; break;
          case 14: th.textContent = 'Ultima Atualização'; break;
      }
      headerRow.appendChild(th)
  })
  thead.appendChild(headerRow)

  // Criar as linhas de dados com base nas colunas selecionadas
  dados.dados.forEach(item => {
      let row = document.createElement('tr');
      selectedOptions.forEach(coluna => {
          let cell = document.createElement('td');
          switch (parseInt(coluna)) {
              case 0: cell.textContent = item.cod_familiar_fam; break;
              case 1: cell.textContent = item.nom_pessoa; break;
              case 2: cell.textContent = item.num_nis_pessoa_atual; break;
              case 3: cell.textContent = item.dta_nasc_pessoa; break;
              case 4: cell.textContent = item.idade; break;
              case 5: cell.textContent = item.vlr_renda_total_fam; break;
              case 6: cell.textContent = item.endereco; break;
              case 7: cell.textContent = item.status_atualizacao; break;
              case 8: cell.textContent = item.nom_escola_memb; break;
              case 9: cell.textContent = item.cod_deficiencia_memb; break;
              case 10: cell.textContent = item.cod_sexo_pessoa; break;
              case 11: cell.textContent = item.parentesco; break;
              case 12: cell.textContent = item['CONCAT(\'(\',t.num_ddd_contato_1_fam, \')\', \' \', t.num_tel_contato_1_fam)']; break;
              case 13: cell.textContent = item.localizacao_arquivo; break;
              case 14: cell.textContent = item.dat_atual_fam; break;
          }
          row.appendChild(cell)
      })
      tbody.appendChild(row)
  })

  document.getElementById('result-count').textContent = 'Total de resultados: ' + dados.total_registros
}




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
      (filtro_renda_per === '' || (row[15] !== null && row[15] !== undefined && parseFloat(row[15]) < filtro_renda_per_num)) &&
      (filtroanoatual === '' || (row[14] && row[14] === filtroanoatual)) &&
      (filtro_mes === '' || (row[16] && row[16] === filtro_mes)) &&
      (filtroIdade === '' || (row[4] && row[4] === filtroIdade)) &&
      (filtrocpf === '' || (row[13] && row[13] === filtrocpf))
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


function semrf() {
  fetch("/TechSUAS/controller/cadunico/area_gestor/semrf")
  .then(response => {
    if (!response.ok) {
      throw new Error('Erro na requisição: ' + response.status)
    }
    return response.json()
  })
  .then(data => {
    console.log('Dados recebidos', data)
    criarTabelasemrf(data); // Chama a função para criar a tabela com os dados recebidos
  })
  .catch(error => {
    console.log('Erro ao buscar dados:', error)
  })
}


function criarTabelasemrf(dados) {
  // Criar a tabela dinamicamente
  let table = '<table class="table-bordered">'
  table += '<thead>'
  table += '<tr>'
  table += '<th>Código Familiar</th>'
  table += '<th>NOME</th>'
  table += '<th>Visualizar</th>'
  table += '</tr>'
  table += '</thead>'
  table += '<tbody>'

  dados.forEach(dado => {
    table += '<tr>'
    table += `<td>${dado.cod_familiar_fam}</td>`
    table += `<td>${dado.nom_pessoa}</td>`
    table += `<td><form action="/TechSUAS/controller/cadunico/parecer/visitas_does" method="POST">
    <input type="hidden" name="excluir[]" value="${dado.num_nis_pessoa_atual}"/>
    <button type="submit">
        <i class="fa fa-eye"></i>
    </button>
    </form></td>`
    table += '</tr>'
  })

  table += '</tbody>'
  table += '</table>'

  Swal.fire({
    icon: 'info',
    title: 'ATENÇÃO',
    text: 'Antes de qualquer ação dentro deste sistema, orientamos que seja consutado o V7.',
    confirmButtonText: "OK"
  }).then((result) => {
      // Mostrar o SweetAlert com a tabela
    Swal.fire({
      title: 'CADASTROS SEM RF',
      html: table,
      width: '800px', // Largura da janela SweetAlert
      showCloseButton: true,
      showConfirmButton: false
    })
  })
}

function excluir() {
  
  fetch("/TechSUAS/controller/cadunico/area_gestor/excluir")
  .then(response => {
    if (!response.ok) {
      throw new Error('Erro na requisição: ' + response.status)
    }
    return response.json()
  })
  .then(data => {
    console.log('Dados recebidos', data)
    criarTabelaExcluir(data); // Chama a função para criar a tabela com os dados recebidos
  })
  .catch(error => {
    console.log('Erro ao buscar dados:', error)
  })

}

function criarTabelaExcluir(dados) {

  Swal.fire({
    title: 'FILTRE POR ANO',
    html: `
      <input type="number" id="ano_escolhido" name="ano_escolhido" placeholder="Digite o ano" class="swal2-input" />
    `,
    showCancelButton: true,
    confirmButtonText: 'Filtrar',
    cancelButtonText: 'Cancelar',
    preConfirm: () => {
      const anoSelecionado = document.getElementById('ano_escolhido').value
      if (!anoSelecionado) {
        Swal.showValidationMessage('Por favor, insira um ano válido')
        return null
      }
      return anoSelecionado
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const anoSelecionado = result.value

      // Filtrar os dados com base no ano selecionado
      const dados_filtro = dados.filter(dado => {
        const anoAtual = new Date(dado.dat_atual_fam).getFullYear()
        return anoAtual == anoSelecionado
      })

      // Criar a tabela dinamicamente
      let table = '<table class="table-bordered">'
      table += '<thead>'
      table += '<tr>'
      table += '<th>Código Familiar</th>'
      table += '<th>NOME</th>'
      table += '<th>Visualizar</th>'
      table += '</tr>'
      table += '</thead>'
      table += '<tbody>'

      dados_filtro.forEach(dado => {
        table += '<tr>'
        table += `<td>${dado.cod_familiar_fam}</td>`
        table += `<td>${dado.nom_pessoa}</td>`
        table += `<td><form action="/TechSUAS/controller/cadunico/parecer/visitas_does" method="POST">
          <input type="hidden" name="excluir[]" value="${dado.num_nis_pessoa_atual}"/>
          <button type="submit">
              <i class="fa fa-eye"></i>
          </button>
          </form></td>`
        table += '</tr>'
      })

      table += '</tbody>'
      table += '</table>'

      // Exibir SweetAlert com a tabela
      Swal.fire({
        title: 'CADASTROS SEM RF',
        html: table,
        width: '800px', // Largura da janela SweetAlert
        showCloseButton: true,
        showConfirmButton: false
      })
    }
  })
}
