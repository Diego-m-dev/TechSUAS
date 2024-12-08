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

function folhadeponto() {
    window.location.href = "/TechSUAS/views/cadunico/area_gestao/ponto_eletronico/folha_ponto"
}
function importeponto() {
  window.location.href = "/TechSUAS/views/cadunico/area_gestao/ponto_eletronico/ponto_eletronico"
}

function pontoEletrico() {
  window.location.href = "/TechSUAS/views/cadunico/area_gestao/ponto_eletronico/index"
}

function sempre_maiusculo(elemento) {
  // Converte o texto do campo para maiúsculas
  elemento.value = elemento.value.toUpperCase();
}

function mudainfocabecalho() {
  var entrevistador = document.getElementById('entrevistador').value
  $('#infoCabec').text(`NIS: ${entrevistador} `)
  $('#printButton').html("<button type='button' onclick='imprimirPagina()'>Imprimir</button>")
}

function justificativa() {
  Swal.fire({
    html: `
      <h2>Justificativa</h2>

        <label> DATA:
          <input type="date" name="dataAusencia" id="dataAusencia"/>
        </label>

        <label> NIS:
          <input type="text" name="nis_entrevistador" id="nis_entrevistador"/>
        </label>

        <label> Justificativa:
          <textarea id="justificativa" name="justificativa"></textarea>
        </label>

    `,

    showCancelButton: true,
    confirmButtonText: 'Enviar',
    cancelButtonText: 'Cancelar'

  }).then((result) => {
    if (result.isConfirmed) {

      var dataAusencia = document.getElementById('dataAusencia').value
      var nis_entrevistador = document.getElementById('nis_entrevistador').value
      var justificativa = document.getElementById('justificativa').value

      // console.log(`${dataAusencia} => ${nis_entrevistador} => ${justificativa}`)
      $.ajax({
        type: 'POST',
        url: '/TechSUAS/controller/cadunico/area_gestor/justify.php',
        data: {

          dataAusencia: dataAusencia,
          nis_entrevistador: nis_entrevistador,
          justificativa: justificativa

        },
        dataType: 'json',
        success: function (response) {
          console.log(response)
          if (response.salvo == true) {

            Swal.fire({
              icon: "success"
            })

          } else {

            Swal.fire({
              icon: "error"
            })

          }
        }
      })
    }
  })
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
      (filtro_renda_per === '' || (row[16] !== null && row[16] !== undefined && parseFloat(row[16]) < filtro_renda_per_num)) &&
      (filtroanoatual === '' || (row[15] && row[15] === filtroanoatual)) &&
      (filtro_mes === '' || (row[17] && row[17] === filtro_mes)) &&
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

function semcpf() {
  fetch("/TechSUAS/controller/cadunico/area_gestor/semcpf")
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



function cadastroCargaHoraria() {
  var cpf_servidor = document.getElementById('cpf_servidor').value

  $.ajax({
    type: 'POST',
    url: '/TechSUAS/controller/cadunico/area_gestor/carga_horaria.php',
    data: {
      cpf_servidor: cpf_servidor 
    },
    dataType: 'json',
    success: function (response) {
      console.log(response)
      if (response.encontrado) {
        Swal.fire({
          title: "CARGA HORÁRIA",
          html: `<p>Você pode cadastrar a carga horária de ${response.dados_servidor} abaixo:</p>
          
            <label> Carga horára diária:
              <select name="carga_hora_diaria" id="carga_hora_diaria" >
                <option value="" disabled selected hidden>Selecione</option>
                <option value="6">6 horas diária</option>
                <option value="8">8 horas diária</option>
                <option value="0">Plantão</option>
              </select>
                <input type="hidden" name="plantonista" id="plantonista" />
            </label>
            <input type="hidden" name="nis_servidor" id="nis_servidor" value="${response.nis_servidor}">
            <label>Horários:
    <table border="1">
      <tr>
        <th>Horários</th>
        <th>DOM <input type="checkbox" name="dom" value="domingo"></th>
        <th>SEG <input type="checkbox" name="seg" value="segunda"></th>
        <th>TER <input type="checkbox" name="ter" value="terça"></th>
        <th>QUA <input type="checkbox" name="qua" value="quarta"></th>
        <th>QUI <input type="checkbox" name="qui" value="quinta"></th>
        <th>SEX <input type="checkbox" name="sex" value="sexta"></th>
        <th>SAB <input type="checkbox" name="sab" value="sabado"></th>
      </tr>
      <tr>
        <td>1º</td>
        <td><input type="text" class="horas" name="primdom" id="primdom"></td>
        <td><input type="text" class="horas" name="primseg" id="primseg"></td>
        <td><input type="text" class="horas" name="primter" id="primter"></td>
        <td><input type="text" class="horas" name="primqua" id="primqua"></td>
        <td><input type="text" class="horas" name="primqui" id="primqui"></td>
        <td><input type="text" class="horas" name="primsex" id="primsex"></td>
        <td><input type="text" class="horas" name="primsab" id="primsab"></td>

      </tr>
      <tr>
        <td>2º</td>
        <td><input type="text" class="horas" name="segundom" id="segundom"></td>
        <td><input type="text" class="horas" name="segunseg" id="segunseg"></td>
        <td><input type="text" class="horas" name="segunter" id="segunter"></td>
        <td><input type="text" class="horas" name="segunqua" id="segunqua"></td>
        <td><input type="text" class="horas" name="segunqui" id="segunqui"></td>
        <td><input type="text" class="horas" name="segunsex" id="segunsex"></td>
        <td><input type="text" class="horas" name="segunsab" id="segunsab"></td>
      </tr>
      <tr>
        <td>3º</td>
        <td><input type="text" class="horas" name="tercdom" id="tercdom"></td>
        <td><input type="text" class="horas" name="tercseg" id="tercseg"></td>
        <td><input type="text" class="horas" name="tercter" id="tercter"></td>
        <td><input type="text" class="horas" name="tercqua" id="tercqua"></td>
        <td><input type="text" class="horas" name="tercqui" id="tercqui"></td>
        <td><input type="text" class="horas" name="tercsex" id="tercsex"></td>
        <td><input type="text" class="horas" name="tercsab" id="tercsab"></td>
      </tr>
      <tr>
        <td>4º</td>
        <td><input type="text" class="horas" name="quartdom" id="quartdom"></td>
        <td><input type="text" class="horas" name="quartseg" id="quartseg"></td>
        <td><input type="text" class="horas" name="quartter" id="quartter"></td>
        <td><input type="text" class="horas" name="quartqua" id="quartqua"></td>
        <td><input type="text" class="horas" name="quartqui" id="quartqui"></td>
        <td><input type="text" class="horas" name="quartsex" id="quartsex"></td>
        <td><input type="text" class="horas" name="quartsab" id="quartsab"></td>
      </tr>

      <tr>
        <td>H/d</td>
        <td><input type="number" name="horadiadom" id="horadiadom"></td>
        <td><input type="number" name="horadiaseg" id="horadiaseg"></td>
        <td><input type="number" name="horadiater" id="horadiater"></td>
        <td><input type="number" name="horadiaqua" id="horadiaqua"></td>
        <td><input type="number" name="horadiaqui" id="horadiaqui"></td>
        <td><input type="number" name="horadiasex" id="horadiasex"></td>
        <td><input type="number" name="horadiasab" id="horadiasab"></td>

      </tr>
    </table>
            </label>

          `,
          showCancelButton: true,
          confirmButtonText: 'Enviar',
          cancelButtonText: 'Cancelar',

          didOpen: () => {
            $('.horas').mask('00:00')
            
          }

        })
        .then((result) => {
            // const form_horario = document.getElementById("form_horario")
            // form_horario.submit()
          if (result.isConfirmed) {
            var nis_servidor = document.getElementById('nis_servidor').value
            
            // Captura todos os horários preenchidos na tabela
            var horarios = []
            var diasSemana = ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab']

            for (let i = 1; i <= 1; i++) { // Para cada linha (1º, 2º, 3º, 4º)
              diasSemana.forEach((dia) => {
                var entrada = document.getElementById(`prim${dia}`)?.value || null
                var pausa = document.getElementById(`segun${dia}`)?.value || null
                var volta = document.getElementById(`terc${dia}`)?.value || null
                var saida = document.getElementById(`quart${dia}`)?.value || null
                var horadia = document.getElementById(`horadia${dia}`)?.value || null
        
                // Adiciona cada linha de horários no array
                horarios.push({
                  dia_semana: dia,
                  hora_entrada: entrada,
                  hora_pausa: pausa,
                  hora_volta: volta,
                  hora_saida: saida,
                  horas_diaria: horadia
                })
              })
            }
            $.ajax({
              type: 'POST',
              url: '/TechSUAS/controller/cadunico/area_gestor/salvar_carga_horaria.php',
              data: {
                nis_servidor: nis_servidor,
                horarios: JSON.stringify(horarios) // Envia como JSON string
              },
              dataType: 'json',
              success: function (resposta) {
                console.log(resposta)
                if(resposta.entregue) {
                  Swal.fire ({
                    icon: "success",
                    title: "SALVO",
                    text: "Dados salvos com sucesso!",
                    confirmButtonText: 'OK'
                  }).then((resulti) =>{
                    if(resulti.isConfirmed){
                      window.location.href = "/TechSUAS/views/cadunico/area_gestao/index"
                    }
                  })
                }
              }
            })
          }
        })
      } else {
        Swal.fire({
          icon: "error",
          title: "ERRO"
        })
      }
    }
  })
}

function buscaPonto() {
  var nis_servidor = document.getElementById('entrevistador').value
  var mes_servidor = document.getElementById('calendario').value
  var ano_servidor = document.getElementById('ano').value

  $.ajax({
    type: 'POST',
    url: '/TechSUAS/controller/cadunico/area_gestor/buscaPonto.php',
    data:{
      nis_servidor: nis_servidor,
      mes_servidor: mes_servidor,
      ano_servidor: ano_servidor
    },
    dataType: 'json',
    success: function (response) {
      console.log(response.dados_servidor)
      if (response.dados_servidor) {
        var dados_totais = response.dados_servidor
        var dadosHTML = ''

        dadosHTML += "<button type='button' onclick='addHoras()'>Adicionar horário</button>"


        dadosHTML += "<table border='1'>"
        dadosHTML += "<tr>"
        dadosHTML += "<th>DATA</th>"
        dadosHTML += "<th>Entrada</th>"
        dadosHTML += "<th>Pausa</th>"
        dadosHTML += "<th>Retorno</th>"
        dadosHTML += "<th>Saída</th>"
        dadosHTML += "<th>Justificativa</th>"
        dadosHTML += "<th> </th>"
        dadosHTML += "<tr>"

        dados_totais.forEach(function (dadosEss){
          dadosHTML += `<tr>`
          dadosHTML += `<td> ${dadosEss.data_registro} </td>`
          dadosHTML += `<td> ${dadosEss.hora_entrada} </td>`
          dadosHTML += `<td> ${dadosEss.hora_pausa} </td>`
          dadosHTML += `<td> ${dadosEss.hora_volta} </td>`
          dadosHTML += `<td> ${dadosEss.hora_saida} </td>`
          dadosHTML += `<td> </td>`
          dadosHTML += `<td><input type='hidden' name='registro' id='registro' value='${dadosEss.registro_ponto}'/>
                            <input type='hidden' name='nisEntre' id='nisEntre' value='${dadosEss.nisEntre}'/>

                            <button type='button' onclick='editeHoras()'>Edit</button></td>`
          dadosHTML += `</tr>`
        })
        dadosHTML += "</table>"
        $('#informacoes').html(dadosHTML)
      }

    }
  })

}

function editeHoras() {
  var registro = document.getElementById('registro').value
  var nisEntre = document.getElementById('nisEntre').value
  console.log(nisEntre)
  Swal.fire({
    html: `<h3>CORRIGIR HORÁRIO</h3>
    <form method="POST" action="/TechSUAS/controller/cadunico/area_gestor/editPonto.php" id="form_editPonto">
      <label> Horárois:
        Entr.<input type="time" name="entre_h" placeholder="Entrada"/>
        Paus.<input type="time" name="pausa_h" placeholder="Pausa"/>
        Retu.<input type="time" name="return_h" placeholder="Retorno"/>
        Said.<input type="time" name="saida_h" placeholder="Saída"/>
      </label>
      <label> Justificativa:
        <input type="text" name="justify" placeholder="Justificativa"/>
        <input type="hidden" name="data">
      </label>
      <input type='hidden' name='nis' id='nis' value='${nisEntre}'/>
      <input type='hidden' name='nis' id='nis' value='${nisEntre}'/>
    </form>
    `
  }).then((result) =>{
    if (result.isConfirmed) {
      const form_editPonto = document.getElementById('form_editPonto')
      form_editPonto.submit()
    }
  })
}

function addHoras() {
  Swal.fire({
    html: `<h3>ADICIONAR HORÁRIO</h3>
    <form method="POST" action="/TechSUAS/views/cadunico/area_gestor/" id="form_fc_pessoa">
      <label>Data:
        <input type="date" name="data_registro"/>
      </label><br>
      <label> Horárois:
        Entr.<input type="time" name="entre_h" placeholder="Entrada"/>
        Paus.<input type="time" name="pausa_h" placeholder="Pausa"/>
        Retu.<input type="time" name="return_h" placeholder="Retorno"/>
        Said.<input type="time" name="saida_h" placeholder="Saída"/>
      </label>
      <label> Justificativa:
        <input type="text" name="justify" placeholder="Justificativa"/>
      </label>
    </form>
    `
  })
}