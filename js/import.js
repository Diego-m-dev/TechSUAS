// const { title } = require("process");

document.getElementById('processCSV').addEventListener('click', () => {
  const fileInput = document.getElementById('arquivoCSV')
  const tableSelect = document.getElementById('csvTable').value

  if (!fileInput.files.length || !tableSelect) {
      Swal.fire({
        icon: "warning",
        title: "Opss!",
        text:"Selecione uma tabela e/ou um arquivo CSV.",
      })
      return
  }

  Swal.fire({
    title: 'PROCESSANDO...',
    text: 'Por favor, aguarde! Os dados estão sendo processados.',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading() // Exibe o ícone de carregamento
    },
  })
  const file = fileInput.files[0]
  const reader = new FileReader()

  
  reader.onload = function (e) {
      const content = e.target.result
      const rows = content.split('\n').map(row => row.split(';'))

      // // Pré-visualização dos dados
      // const previewTable = document.getElementById('previewTable')
      // previewTable.innerHTML = '' // Limpar tabela anterior

      // rows.forEach((row, index) => {
      //     const tr = document.createElement('tr')
      //     row.forEach(cell => {
      //         const td = document.createElement(index === 0 ? 'th' : 'td')
      //         td.textContent = cell
      //         tr.appendChild(td)
      //     })
      //     previewTable.appendChild(tr)
      // })

      console.log(rows)

      // Exibe mensagem de confirmação

      Swal.fire({
        icon: "warning",
        title: "DADOS PROCESSADOS",
        text: "Os dados foram processados com sucesso, deseja enviar?",
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed){

                // Remove a primeira linha (cabeçalho) antes de armazenar os dados
      const dataWithoutHeader = rows.slice(1)

      // Armazena os dados processados em uma variável global
      window.csvData = { table: tableSelect, rows: dataWithoutHeader }
      enviarCSV()
        }
      })

  }

  reader.readAsText(file)
})



function enviarCSV() {
  if (!window.csvData) {
    Swal.fire({
      icon: 'error',
      title: 'Erro',
      text: 'Processe o arquivo CSV primeiro.',
    });
    return;
  }

  const data = window.csvData;
  const batchSize = 1000; // Tamanho do lote
  const totalRows = data.rows.length;
  let currentIndex = 0;

  function sendBatch() {
    const batch = data.rows.slice(currentIndex, currentIndex + batchSize);

    if (batch.length === 0) {
      Swal.fire({
        icon: 'success',
        title: 'IMPORTAÇÃO CONCLUÍDA',
        text: 'Todos os dados foram enviados com sucesso!',
      }).then(() => {
        window.location.href = '/TechSUAS/views/geral/atualizar_tabela';
      });
      return;
    }

    Swal.update({
      title: 'Enviando dados...',
      text: `Enviando lote de ${currentIndex + 1} a ${
        currentIndex + batch.length
      } de ${totalRows} linhas.`,
    });

    fetch('/TechSUAS/controller/geral/importar.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ table: data.table, rows: batch }),
    })
      .then(response => response.json())
      .then(result => {
        if (result.success) {
          currentIndex += batchSize;
          sendBatch(); // Envia o próximo lote
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: `Erro no lote ${currentIndex + 1}: ${result.error}`,
          });
        }
      })
      .catch(error => {
        Swal.fire({
          icon: 'error',
          title: 'Erro',
          text: `Erro durante o envio do lote: ${error.message}`,
        });
        console.error('Erro:', error);
      });
  }

  Swal.fire({
    title: 'Iniciando envio em lotes...',
    text: 'Aguarde enquanto os dados estão sendo processados.',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  sendBatch(); // Inicia o envio em lotes
}