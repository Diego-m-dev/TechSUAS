<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        td {
            vertical-align: top;
        }

        /* Força o estilo da pasta ocupada a prevalecer */
        .ocupada {
            color: red !important; /* Muda a cor da fonte para vermelho */
        }

        th {
          font-size: 16px;
          position: sticky;
          top: 0;
          background-color: #ffffff;
          border-radius: 3px;
          }

          th, td {
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
        }

        /* Cor azul claro para armários pares */
        .par {
            background-color: #e3e1e1; /* Um azul claro suave */
        }

        /* Cor branca para armários ímpares */
        .impar {
            background-color: #ffffff; /* Branco */
        }

    </style>

    <title>Mapa - TechSUAS</title>

    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/visitas_pend.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
<script>
  // Função para buscar as pastas ocupadas
  function buscarPastasOcupadas() {
    return fetch("/TechSUAS/controller/fichario/pastas_ocupadas") // Altere a URL para o endpoint correto
      .then(response => {
        if (!response.ok) {
          throw new Error('Erro na requisição: ' + response.status)
        }
        return response.json()
      })
  }

  // Função para buscar os dados de todas as pastas
  function unipessoal() {
    fetch("/TechSUAS/controller/fichario/mapa_fichario")
      .then(response => {
        if (!response.ok) {
          throw new Error('Erro na requisição: ' + response.status)
        }
        return response.json()
      })
      .then(dadosFichario => {
        console.log('Dados fichario recebidos:', dadosFichario)
        return buscarPastasOcupadas().then(pastasOcupadas => {
          console.log('Pastas ocupadas recebidas:', pastasOcupadas)
          criarTabelaFichario(dadosFichario, pastasOcupadas) // Chama a função para criar a tabela com os dados recebidos
        })
      })
      .catch(error => {
        console.log('Erro ao buscar dados:', error)
      })
  }

  // Função para criar a tabela com base nos dados
  function criarTabelaFichario(dadosFichario, pastasOcupadas) {
    const armarios = {}

    // Agrupa os dados de armários, gavetas e pastas
    dadosFichario.forEach(item => {
      const arm = String(item.arm)
      const gav = String(item.gav)
      const pas = String(item.pas)

      if (!armarios[arm]) {
        armarios[arm] = {}
      }

      if (!armarios[arm][gav]) {
        armarios[arm][gav] = []
      }

      armarios[arm][gav].push(pas)
    })

    const tabela = document.createElement('table')
    tabela.border = '1'

    const headerRow = document.createElement('tr')

    // Cria as colunas para cada armário com 4 gavetas
    Object.keys(armarios).forEach((arm, index) => {
      const armarioHeader = document.createElement('th')
      armarioHeader.colSpan = '4';  // Aqui assumimos 4 gavetas por armário
      armarioHeader.innerText = `A.${arm}`
      armarioHeader.className = index % 2 === 0 ? 'par' : 'impar' // Aplica classe baseada no índice
      headerRow.appendChild(armarioHeader)
    })

    tabela.appendChild(headerRow)

    // Cria uma segunda linha para os cabeçalhos das gavetas
    const gavetaHeaderRow = document.createElement('tr')
    Object.keys(armarios).forEach((arm, index) => {
      Object.keys(armarios[arm]).forEach(gav => {
        const gavetaHeader = document.createElement('th')
        gavetaHeader.innerText = `G.${gav}`
        gavetaHeader.className = index % 2 === 0 ? 'par' : 'impar' // Aplica classe baseada no índice
        gavetaHeaderRow.appendChild(gavetaHeader)
      })
    })

    tabela.appendChild(gavetaHeaderRow)

    // Criar linhas para cada pasta e preencher as células corretas
    const maxPastasPorGaveta = Math.max(...Object.keys(armarios).map(arm =>
      Math.max(...Object.keys(armarios[arm]).map(gav => armarios[arm][gav].length))
    ))

    for (let i = 0; i < maxPastasPorGaveta; i++) {
      const pastaRow = document.createElement('tr')

      Object.keys(armarios).forEach((arm, index) => {
        Object.keys(armarios[arm]).forEach(gav => {
          const pastaColuna = document.createElement('td')
          const pastaAtual = armarios[arm][gav][i]

          if (pastaAtual) {
            pastaColuna.innerText = `P.${pastaAtual}`
            pastaColuna.className = index % 2 === 0 ? 'par' : 'impar' // Aplica classe baseada no índice

            // Verifica se a pasta está ocupada
            const ocupada = pastasOcupadas.some(item => 
              String(item.arm).trim() === arm && 
              String(item.gav).trim() === gav && 
              String(item.pas).trim() === pastaAtual.trim()
            )

            if (ocupada) {
              pastaColuna.classList.add('ocupada')
            }
          }

          pastaRow.appendChild(pastaColuna)
        })
      })

      tabela.appendChild(pastaRow)
    }

    // Adiciona a tabela ao corpo da página
    document.body.appendChild(tabela)
}

  // Inicia a função para carregar os dados
  unipessoal()
</script>
</body>
</html>
