function mudaArmario() {

  var armario = document.getElementById("arm").value

  $.ajax({
      type: 'POST',
      url: '/TechSUAS/controller/fichario/busca_fichario.php',
      data: {
          arm: armario
      },
      dataType: 'json',
      success: function(response) {
          if (response.encontrado) {
              var pastasPorGaveta = agruparPastasPorGaveta(response.pastas)
              criarTabela(pastasPorGaveta)
          }
      }
  })
}

function agruparPastasPorGaveta(pastas) {
  var pastasPorGaveta = {}

  pastas.forEach(function(pasta) {
      if (!pastasPorGaveta[pasta.gaveta]) {
          pastasPorGaveta[pasta.gaveta] = []
      }
      pastasPorGaveta[pasta.gaveta].push(pasta)
  })

  return pastasPorGaveta
}

function criarTabela(pastasPorGaveta) {
  var table = document.createElement('table')
  table.setAttribute('border', '1')
  var headerRow = document.createElement('tr')

  // Adicionar coluna de numeração
  var th = document.createElement('th')
  th.textContent = 'Pastas'
  headerRow.appendChild(th)

  // Criar cabeçalhos das colunas para cada gaveta
  for (var gaveta in pastasPorGaveta) {
      var th = document.createElement('th')
      th.textContent = 'Gaveta ' + gaveta
      headerRow.appendChild(th)
  }

  table.appendChild(headerRow)

  // Determinar o número máximo de pastas em qualquer gaveta para definir o número de linhas
  var maxPastas = 0
  for (var gaveta in pastasPorGaveta) {
      maxPastas = Math.max(maxPastas, pastasPorGaveta[gaveta].length)
  }

  // Criar linhas da tabela
  for (var i = 0; i < maxPastas; i++) {
      var row = document.createElement('tr')
      
      // Adicionar célula de numeração
      var numCell = document.createElement('td')
      numCell.textContent = i + 1
      row.appendChild(numCell)

      for (var gaveta in pastasPorGaveta) {
          var td = document.createElement('td')
          var pasta = pastasPorGaveta[gaveta][i]
          if (pasta) {
              td.textContent = pasta.codfam || '' // Mostrar codfam ou vazio se não existir
          }
          row.appendChild(td)
      }

      table.appendChild(row)
  }

  // Adicionar a tabela ao DOM
  var container = document.getElementById('tabela-container') // Certifique-se de ter um contêiner para a tabela
  container.innerHTML = ''
  container.appendChild(table)
}

// Exemplo de chamada inicial para teste (substitua pela chamada adequada no seu código)
document.addEventListener('DOMContentLoaded', function() {

  mudaArmario()

})