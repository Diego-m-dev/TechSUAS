function editarArquivo(id, dataEntre, tipo_doc, cod_fam) {

  // formatando a data
    let partesData = dataEntre.split("/");
    let dataFormatada = partesData.length === 3 ? `${partesData[2]}-${partesData[1]}-${partesData[0]}` : "";
  
  Swal.fire({
    title: 'EDITAR ARQUIVO',
    html: `
      <p><label>${id}</label></p>
    <input id="codfam" type="number" name="codfam" placeholder="Código Familiar Aqui" value="${cod_fam}"/><br><br>
    <label>
    Data da Entrevista:
    <input id="dataEntre" type="date" name="dataEntre" value="${dataFormatada}"/>
    </label><br><br>
            <select name="tipo_documento" id="tipo_documento" required>
              <option value="" disabled selected hidden>Selecione o tipo</option>
              <option value="Cadastro" ${tipo_doc === 'Cadastro' ? 'selected' : ''}>Cadastro</option>
              <option value="Atualização" ${tipo_doc === 'Atualização' ? 'selected' : ''}>Atualização</option>
              <option value="Assinatura" ${tipo_doc === 'Assinatura' ? 'selected' : ''}>Assinatura</option>
              <option value="Fichas exclusão" ${tipo_doc === 'Fichas exclusão' ? 'selected' : ''}>Fichas exclusão</option>
              <option value="Relatórios" ${tipo_doc === 'Relatórios' ? 'selected' : ''}>Relatórios</option>
              <option value="Parecer visitas" ${tipo_doc === 'Parecer visitas' ? 'selected' : ''}>Parecer visitas</option>
              <option value="Documento externo" ${tipo_doc === 'Documento externo' ? 'selected' : ''}>Documento externo</option>
              <option value="Termos" ${tipo_doc === 'Termos' ? 'selected' : ''}>Termos</option>
            </select>
    `,
    showCancelButton: true,
    confirmButtonText: 'Enviar',
    cancelButtonText: 'Cancelar'
  }).then((result7) => {
    if (result7.isConfirmed) {

      var tipo_documento = Swal.getPopup().querySelector('#tipo_documento')
      var dataEntre = Swal.getPopup().querySelector('#dataEntre')
      var codfam = Swal.getPopup().querySelector('#codfam')

      $.ajax({
        type: 'POST',
        url: '/TechSUAS/controller/cadunico/edit_file_bd.php',
        data: {
          tipo_documento: tipo_documento.value,
          dataEntre: dataEntre.value,
          codfam: codfam.value,
          id: id
        },
        dataType: 'json',
        success: function(response) {
          if (response.concluido) {
            Swal.fire({
            icon: 'success',
            text: response.resposta
            })
            buscarDadosFamily()
          }

        }
      })

    } else {
      Swal.fire("Operação cancelada", "", "info")
    }
  })
}

function certo(idzinho) {
    $.ajax({
        type: 'POST',
        url: '/TechSUAS/controller/cadunico/editarUP.php',
        data: {
            idzinho: idzinho
        },
        dataType: 'json',
        success: function(response) {
            if (response.salvo) {
                  Swal.fire({
                      toast: true,
                      position: 'top-end',
                      icon: 'success',
                      title: response.resposta,
                      showConfirmButton: false,
                      timer: 2000,
                      timerProgressBar: true
                  })
                .then((soul) => {
                    if (soul.isConfirmed) {

                        window.location.href = '/TechSUAS/views/cadunico/upload_c_erro'
                    } else {
                        window.location.href = '/TechSUAS/views/cadunico/upload_c_erro'
                    }
                })
            } else {
                Swal.fire("Erro ao salvar", response.mensagem, "error")
            }
        }
    })
}

function excluir_arquivos() {
  fetch('/TechSUAS/controller/cadunico/buscar_arq_mais5years.php')
  .then(response => response.json())
  .then(data => {
    if (data.recebido) {
      let table = `
        <table border="1">
          <tr>
            <th>Código Familiar</th>
            <th>Data Entrevista</th>
            <th>Tipo Documento</th>
            <th>visualizar</th>
          </tr>
      `;

      data.arquivos.forEach(arquivo => {
        var dataForm = 
        table += `
          <tr>

            <td>${arquivo.cod_familiar_fam}</td>
            <td>${arquivo.data_entrevista}</td>
            <td>${arquivo.tipo_documento}</td>
            <td>
                              <a id="printArquivo" href="${arquivo_show.caminho_arquivo}" target="_blank" style="color: green; font-size: 16px; margin-right: 18px;">
                  <i class="fa fa-download"></i>
                </a>
            </td>
          </tr>
        `;
      });

      table += '</table>';

      Swal.fire({
        title: 'Deseja excluir todos os arquivos listados abaixo?',
        html: table,
        showCancelButton: true,
        confirmButtonText: 'Excluir',
        cancelButtonText: 'Cancelar'
      }).then(result => {
        if (result.isConfirmed) {
          const ids = data.arquivos.map(a => a.id)
          enviarIdsParaOutraTela(ids)
        }
      })

    } else {
      Swal.fire("Erro ao excluir!", data.msg, "error");
    }
  })
}

function enviarIdsParaOutraTela(ids) {
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '/TechSUAS/controller/cadunico/manipular_ids.php'; // a tela que vai receber

  ids.forEach(id => {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'ids[]'; // array de IDs
    input.value = id;
    form.appendChild(input);
  });

  document.body.appendChild(form);
  form.submit();
}

function mostrarPDF(seq, caminho) {
    const linha = document.getElementById('linhaPDF_' + seq);
    const iframe = document.getElementById('iframePDF_' + seq);

    if (linha.style.display === 'none') {
        iframe.src = caminho;
        linha.style.display = 'table-row';
    } else {
        linha.style.display = 'none';
        iframe.src = ''; // Limpa para não continuar carregando
    }
}

function copiarTexto(el) {
  const texto = el.closest('td').querySelector('pre').innerText
  navigator.clipboard.writeText(texto).then(() => {
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: 'Texto copiado',
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    })
  }, () => {
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: 'Erro ao copiar, tente novamente mais tarde',
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    })
  })
}
