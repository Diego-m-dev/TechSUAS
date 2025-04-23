function relatorios() {
  window.location.href = '/TechSUAS/views/cadunico/area_gestao/relatorio'
}

function relatorio_entrevistadores() {
  window.location.href = '/TechSUAS/views/cadunico/area_gestao/relatorio_entrevistadores'
}

function filtro_cadastros() {
  window.location.href = '/TechSUAS/views/cadunico/filtro_geral_cad'
}

//BOTÕES DA TELA DE AREA DO GESTOR
$(document).ready(function () {


  $('#btn_entrevistadores').click(function () {
    $('#beneficio').hide();
    $('#simples').hide();

    const button = $('#btn_entrevistadores');
    if (!button) {
      console.error('Botão não encontrado.');
      return;
    }

    const loadingHtml = `
      <div id="loadingSpinner" style="text-align: center;">
        <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
        <p>Carregando...</p>
      </div>
    `

    Swal.fire({
      html: loadingHtml,
      width: '400px',
      showConfirmButton: false,
      allowOutsideClick: false
    })

    button.prop('disabled', true);

    fetch("/TechSUAS/controller/cadunico/area_gestor/lista_entrevistadores.php")
      .then(response => {
        if (!response.ok) {
          throw new Error('Erro na requisição: ' + response.status);
        }
        return response.json()
      })
      .then(data => {
        console.log('Dados recebidos', data)

        let tableHtml = `
          <div style="overflow-x:auto; max-height: 400px;">
            <table border="1" width="100%" style="table-layout: auto; white-space:nowrap;">
              <thead>
                <tr>
                  <th style="position: sticky; top: 0; background: white; z-index: 1; padding:10px;">Entrevistador</th>
                  <th style="position: sticky; top: 0; background: white; z-index: 1; padding:10px;">Quantidade total</th>
                  <th style="position: sticky; top: 0; background: white; z-index: 1; padding:10px;">Ação</th>
                </tr>
              </thead>
              <tbody>
        `;

        data.forEach(item => {
          tableHtml += `
            <tr>
              <td>${item.nom_entrevistador_fam}</td>
              <td>${item.quantidade_total}</td>
              <td>
                <form action="/TechSUAS/controller/cadunico/area_gestor/detalhe_entrevistador.php" method="post">
                  <input type="hidden" name="detalhe" value="${item.nom_entrevistador_fam}">
                  <button type="submit">Detalhes</button>
                </form>
              </td>
            </tr>
          `
        })

        tableHtml += `
              </tbody>
            </table>
          </div>
        `

        Swal.fire({
          html: tableHtml,
          width: '850px',
          showCloseButton: true,
          customClass: {
            closeButton: 'my-custom-close-button'
          }
        });
      })
      .catch(error => {
        console.error('Erro ao buscar dados:', error);
        Swal.fire('Erro!', 'Houve um problema ao carregar os dados.', 'error');
      })
      .finally(() => {
        button.prop('disabled', false);
      });
  });
});


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

//FUNÇÃO PARA FILTRAR OS GPTE
function filterGPTE() {
  fetch("/TechSUAS/views/cadunico/area_gestao/filtro_gpte")
    .then(response => {
      if (!response.ok) {
        throw new Error('Erro na requisição: ' + response.status)
      }
      return response.json()
    })
    .then(data => {

      function renderTable(filteredData) {
        const tableBody = document.getElementById('dataBody');
        tableBody.innerHTML = '';
        filteredData.forEach(row => {
          const tr = document.createElement('tr');
          for (let i = 0; i < 4; i++) {
            const td = document.createElement('td');
            td.textContent = row[i];
            tr.appendChild(td);
          }
          tableBody.appendChild(tr);
        });
      }

      function filterData() {
        const nameFilter = document.getElementById('nameFilter').value.toLowerCase();
        const startDateFilter = document.getElementById('startDateFilter').value;
        const endDateFilter = document.getElementById('endDateFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        const codigoFamiliar = document.getElementById('codigoFamiliar').value;

        const filteredData = data.filter(row => {
          const nameMatches = nameFilter ? row[1].toLowerCase().includes(nameFilter) : true;
          const dateMatches = startDateFilter && endDateFilter ? (row[3] >= startDateFilter && row[3] <= endDateFilter) : true;
          const statusMatches = statusFilter ? row[2] == statusFilter : true;
          const codigoFamiliarMatches = codigoFamiliar ? row[0] == codigoFamiliar : true;

          return nameMatches && dateMatches && statusMatches && codigoFamiliarMatches;
        });

        // Atualiza a contagem de resultados
        document.getElementById('resultCount').textContent = `Total de resultados: ${filteredData.length}`;

        // Renderiza a tabela com os dados filtrados
        renderTable(filteredData);
      }

      renderTable(data);

      console.log('Dados recebidos', data)
    })
    .catch(error => {
      console.log('Erro ao buscar dados:', error)
    })
}

function atualizar() {
  window.location.reload()
}

$(document).ready(function () {
  $('#btn_residencia').click(function () {
    Swal.fire({
      title: "Selecione a Opção",
      showCancelButton: true,
      showDenyButton: true,
      confirmButtonText: 'Unipessoal',
      denyButtonText: 'Família',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Se Unipessoal for selecionado
        Swal.fire({
          title: "TERMO DE RESPONSABILIDADE",
          html: `
                    <h6>para unipessoal</h6>
                    <h4>INFORME O CPF</h4>
                    <form method="POST" action="/TechSUAS/views/cadunico/forms/termo_responsabilidade_uni.php" id="form_residencia_uni">
                        <label> CPF:
                            <input type="text" id="cpf_declar" name="cpf_residencia"/>
                        </label>
                    </form>
                    `,
          showCancelButton: true,
          confirmButtonText: 'Enviar',
          cancelButtonText: 'Cancelar',
          didOpen: () => {
            $('#cpf_declar').mask('000.000.000-00')
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const form = document.getElementById("form_residencia_uni")
            form.submit()
          }
        })
      } else if (result.isDenied) {
        // Se Família for selecionado
        Swal.fire({
          title: "TERMO DE RESPONSABILIDADE",
          html: `
                    <h6>para famílias com duas pessoas ou mais</h6>
                    <h4>INFORME O CPF</h4>
                    <form method="POST" action="/TechSUAS/views/cadunico/forms/termo_responsabilidade.php" id="form_residencia_familia">
                        <label> CPF:
                            <input type="text" id="cpf_declar" name="cpf_residencia"/>
                        </label>
                    </form>
                    `,
          showCancelButton: true,
          confirmButtonText: 'Enviar',
          cancelButtonText: 'Cancelar',
          didOpen: () => {
            $('#cpf_declar').mask('000.000.000-00')
          }
        }).then((result) => {
          if (result.isConfirmed) {
            const form = document.getElementById("form_residencia_familia")
            form.submit()
          }
        })
      }
    })
  })
  /* FORMULARIO RERNDA */
  $('#btn_dec_renda').click(function () {
    Swal.fire({
      title: "TERMO DE DECLARAÇÃO",
      html: `
            <h4>INFORME O CPF</h4>
            <form method="POST" action="/TechSUAS/views/cadunico/forms/Termo_declaracao" id="form_dec_renda">
                <label> CPF:
                    <input type="text" id="cpf_declar" name="cpf_declar"/>
                </label>
            </form>
            `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
      didOpen: () => {
        $('#cpf_declar').mask('000.000.000-00')
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_dec_renda")
        form.submit()
      }
    })
  })

  $('#btn_fc_familia').click(function () {
    Swal.fire({
      title: "FICHA DE EXCLUSÃO DE FAMILIA",
      html: `
            <h4>INFORME O NIS</h4>
            <form method="POST" action="/TechSUAS/views/cadunico/forms/ficha_exc_familia" id="form_fc_pessoa">
                <label> NIS:
                    <input type="text" name="nis_exc_pessoa"/>
                </label>
            </form>
            `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_fc_pessoa")
        form.submit()
      }
    })
  })

  $('#btn_fc_pessoa').click(function () {
    Swal.fire({
      title: "FICHA DE EXCLUSÃO DE PESSOA",
      html: `
            <h4>INFORME O NIS</h4>
            <form method="POST" action="/TechSUAS/views/cadunico/forms/ficha_exc_pessoa" id="form_fc_pessoa">
                <label> NIS:
                    <input type="text" name="nis_exc_pessoa"/>
                </label>
            </form>
            `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_fc_pessoa")
        form.submit()
      }
    })
  })
})

function voltarAoMenu() {
  window.history.back()
}

function imprimirPagina() {
  window.print()
}

function adicionarLinha() {
  var tabela = document.getElementById("tabela_membros");
  var novaLinha = tabela.insertRow(); // Adiciona uma nova linha ao final

  // Cria células para a nova linha
  var celula1 = novaLinha.insertCell(0);
  var celula2 = novaLinha.insertCell(1);
  var celula3 = novaLinha.insertCell(2);
  var celula4 = novaLinha.insertCell(3);
  var celula5 = novaLinha.insertCell(4);

  // Adiciona conteúdo às células
  celula1.innerHTML = '<span class="editable-field" contenteditable="true"></span>';
  celula2.innerHTML = '<span class="editable-field" contenteditable="true"></span>';
  celula3.innerHTML = '<span class="editable-field" contenteditable="true"></span>';
  celula4.innerHTML = 'R$ <span class="editable-field" contenteditable="true">,00</span>';
  celula5.innerHTML = '<button onclick="removerLinha(this)">X</button>';
}

function removerLinha(botao) {
  var linha = botao.parentNode.parentNode; // Encontra a linha do botão
  var tabela = linha.parentNode; // Encontra a tabela
  tabela.removeChild(linha); // Remove a linha
}

//função para apresentar dados da família na tela de registrar família
function consultarFamilia() {
  var codfam = $('#codfamiliar').val();

  // Limpar mensagens existentes
  $('#nome').text('');
  $('#titulo_tela').text('');
  $('#data_visita').html(''); // Use html('') para limpar todo o conteúdo

  if (codfam === '') {
    $('#nome').text('Sem o código familiar não pode concluir a tarefa.');
    return; // Corrigido para usar return
  }

  $.ajax({
    type: 'POST',
    url: '/TechSUAS/controller/cadunico/parecer/busca_visita.php',
    data: {
      codfam: codfam
    },
    dataType: 'json',
    success: function (response) {
      if (response.encontrado) {
        if (response.nome) {
          $('#nome').text('NOME: ' + response.nome);
          $('#titulo_tela').text('VISITA(S) REALIZADA(S):');
        } else {
          $('#nome').text('O código familiar digitado não existe no banco de dados atual');
        }
        if (response.visitas) {
          var visitas = response.visitas;
          var visitasHtml = '';

          visitas.forEach(function (visita) {
            var acao;
            if (visita.acao == 1) {
              acao = "ATUALIZAÇÃO REALIZADA";
            } else if (visita.acao == 2) {
              acao = "NÃO LOCALIZADO";
            } else if (visita.acao == 3) {
              acao = "FALECIMENTO DO RESPONSÁVEL FAMILIAR";
            } else if (visita.acao == 4) {
              acao = "A FAMÍLIA RECUSOU ATUALIZAR";
            } else if (visita.acao == 5) {
              acao = "ATUALIZAÇÃO NÃO REALIZADA";
            } else {
              acao = "";
            }
            visitasHtml += '<div class="visita">'
            visitasHtml += '<span>Data da Visita: ' + visita.data + '</span><br>'
            visitasHtml += '<span>Ação: ' + acao + '</span><br>'
            visitasHtml += '<span>Entrevistador: ' + visita.entrevistador + '</span><br>'
            visitasHtml += '</div><br>'
          });
          $('#data_visita').html(visitasHtml);
        } else if (response.data_visita) {
          $('#data_visita').text(response.data_visita);
        }
      }
    }
  });
}


//função para salvar dados da visita a família
$(document).ready(function () {
  $('#imprimir_parecer').click(function () {
    //imprimirParecer()
  })
})

//FUNÇÃO PARA IMPRIMIR QUANDO HOUVER REGISTRO NO TBL TUDO PRIMEIRA FASE NA TELA PRINT_VISITA EM SEGUIDA UMA REQUISIÇÃO AJAX PARA SALVAR QUALQUER ALTERAÇÃO QUE FOR FEITA NO CODIGO FAMILIAR 


function imprimirParecer() {
  window.print()

  setTimeout(function () {

    var dados = {
      id_visita: document.getElementById("id_visita").innerText,
      numero_parecer: document.getElementById("numero_parecer").innerText,
      ano_parecer: document.getElementById("ano_parecer").innerText,
      codigo_familiar: document.getElementById("codigo_familiar").innerText,
      data_entrevista: document.getElementById("data_entrevista").innerText,
      renda_per_capita: document.getElementById("renda_per_capita").innerText,
      localidade: document.getElementById("localidade").innerText,
      tipo: document.getElementById("tipo").innerText,
      titulo: document.getElementById("titulo").innerText,
      nome_logradouro: document.getElementById("nome_logradouro").innerText,
      numero_logradouro: document.getElementById("numero_logradouro").innerText,
      complemento_numero: document.getElementById("complemento_numero").innerText,
      complemento_adicional: document.getElementById("complemento_adicional").innerText,
      cep: document.getElementById("cep").innerText,
      referencia_localizacao: document.getElementById("referencia_localizacao").innerText,
      situacao: document.getElementById("situacao").innerText,
      resumo_visita: document.getElementById("resumo_visita").innerText
    }

    var membrosFamilia = []
    var membros = document.querySelectorAll('.parentesco')
    membros.forEach(function (membro, index) {
      var membroData = {
        parentesco: membro.innerText,
        nome_completo: document.querySelectorAll('.nome_completo')[index].innerText,
        nis: document.querySelectorAll('.nis')[index].innerText,
        data_nascimento: document.querySelectorAll('.data_nascimento')[index].innerText
      };
      membrosFamilia.push(membroData)
    });
    dados.membros_familia = membrosFamilia

    $.ajax({
      url: '/TechSUAS/controller/cadunico/parecer/salvar_dados_visita.php',
      type: 'POST',
      data: JSON.stringify(dados),
      contentType: 'application/json',
      success: function (response) {
        Swal.fire({
          icon: "success",
          title: "SALVO",
          text: "Dados salvos com sucesso!",
          confirmButtonText: 'OK',
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/TechSUAS/views/cadunico/area_gestao/index"
          }
        })
      },
      error: function (xhr, status, error) {
        console.error('Erro ao salvar os dados:', error)
        console.log('Resposta do servidor:', xhr.responseText)
      }
    })
  }, 300)
}
//FUNÇÃO PARA SALVAR QUAIQUER ALTERAÇÃO NO CÓDIGO
function salvaCodigoEditado() {
  var conteudo = {
    alterado_codigo: document.getElementById("codigo_familiar").innerText,
    id_para_alterar: document.getElementById("id_visita").innerText
  }

  $.ajax({
    url: "/TechSUAS/controller/cadunico/parecer/salvar_alt_parecer.php",
    type: "POST",
    data: JSON.stringify(conteudo),
    contentType: 'application/json',
    success: function (response) {
      console.log(response)
    }
  })
}

//FUNÇÃO PARA IMPRIMIR QUANDO NÃO HOUVER REGISTRO NO TBL_TUDO
function imprimirParecerPARTE() {
  window.print()

  setTimeout(function () {
    var dados = {
      id_visita: document.getElementById("id_visita").innerText,
      numero_parecer: document.getElementById("numero_parecer").innerText,
      ano_parecer: document.getElementById("ano_parecer").innerText,
      codigo_familiar: document.getElementById("codigo_familiar").innerText,
      data_entrevista: document.getElementById("data_entrevista").innerText,
      renda_per_capita: document.getElementById("renda_per_capita").innerText,
      localidade: document.getElementById("localidade").innerText,
      tipo: document.getElementById("tipo").innerText,
      titulo: document.getElementById("titulo").innerText,
      nome_logradouro: document.getElementById("nome_logradouro").innerText,
      numero_logradouro: document.getElementById("numero_logradouro").innerText,
      complemento_numero: document.getElementById("complemento_numero").innerText,
      complemento_adicional: document.getElementById("complemento_adicional").innerText,
      cep: document.getElementById("cep").innerText,
      referencia_localizacao: document.getElementById("referencia_localizacao").innerText,
      situacao: document.getElementById("situacao").innerText,
      resumo_visita: document.getElementById("resumo_visita").innerText
    }

    var membrosFamilia = []
    var membros = document.querySelectorAll('.parentesco')
    membros.forEach(function (membro, index) {
      var membroData = {
        parentesco: membro.innerText,
        nome_completo: document.querySelectorAll('.nome_completo')[index].innerText,
        nis: document.querySelectorAll('.nis')[index].innerText,
        data_nascimento: document.querySelectorAll('.data_nascimento')[index].innerText
      };
      membrosFamilia.push(membroData)
    });
    dados.membros_familia = membrosFamilia

    $.ajax({
      url: '/TechSUAS/controller/cadunico/parecer/salvar_dados_visita.php',
      type: 'POST',
      data: JSON.stringify(dados),
      contentType: 'application/json',
      success: function (response) {
        Swal.fire({
          icon: "success",
          title: "SALVO",
          text: "Dados salvos com sucesso!",
          confirmButtonText: 'OK',
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/TechSUAS/views/cadunico/visitas/buscarvisita";
          }
        })
      },
      error: function (xhr, status, error) {
        console.error('Erro ao salvar os dados:', error)
        console.log('Resposta do servidor:', xhr.responseText)
      }
    })
  }, 300)
}

/*
DECLARAÇÃO DE INSCRITO NO CADASTRO UNICO - FUNÇÕES PARA A TELA 

*/

$(document).ready(function () {
  $('#btn_dec_cad').click(function () {
    Swal.fire({
      title: "DECLARAÇÃO DO CADASTRO ÚNICO",
      html: `
            <p>É importante conferir as informações no CadÚnico e SIBEC para certificar-se da situação recente da família.</p><br> 
            <h4>INFORME O CPF</h4>
            <form method="POST" action="/TechSUAS/views/cadunico/declaracoes/dec_cadunico" id="form_familia">
                <label> CPF:
                    <input id="cpf_dec_cad" type="text" name="cpf_dec_cad"/>
                </label>
            </form>
            `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
      didOpen: () => {
        $('#cpf_dec_cad').mask('000.000.000-00')
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_familia");
        form.target = "_blank";
        form.submit();
      }
    });
  });
});




function voltar() {
  window.location.href = "/TechSUAS/views/cadunico/declaracoes/index"
}

function voltarMenu() {
  window.location.href = "/TechSUAS/views/cadunico/index"
}

function printWithFields() {
  window.print()
}

/*
DESLIGAMENTO VOLUNTÁRIO - FUNÇÕES PARA A TELA
*/

$(document).ready(function () {
  $('#btn_des_vol').click(function () {
    Swal.fire({
      title: "DECLARAÇÃO DE DESLIGAMENTO VOLUNTÁRIO",
      html: `
            <h4>INFORME O CPF</h4>
            <form method="POST" action="/TechSUAS/views/cadunico/declaracoes/desligamento_voluntario" id="form_familia">
                <label> CPF:
                    <input id="cpf_dec_cad" type="text" name="cpf_dec_cad"/>
                </label>
            </form>
            `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
      didOpen: () => {
        $('#cpf_dec_cad').mask('000.000.000-00')
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_familia")
        form.submit()
      }
    })
  })
})

/*
TROCA DE RF - FUNÇÕES PARA A TELA
*/

$(document).ready(function () {
  $('#btn_troca').click(function () {
    Swal.fire({
      title: "TROCA DE RF - C.E.F.",
      html: `
            <form method="POST" action="/TechSUAS/views/cadunico/declaracoes/novo_rf_pbf" id="form_familia">
                    <h4>INFORME O NIS DO RF ANTERIOR</h4>                    
                <label>
                    <input id="nis_tc_old" type="text" name="nis_tc_old" maxlength="11" placeholder="NIS do antigo RF"/>
                </label><br><br><hr>
                    <h4>INFORME O NIS DO NOVO RF</h4>
                <label>
                    <input id="nis_tc_new" type="text" name="nis_tc_new" maxlength="11" placeholder="NIS do novo RF"/>
                </label>
            </form>
            `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
      didOpen: () => {
        $('#cpf_dec_cad').mask('000.000.000-00')
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_familia")
        form.submit()
      }
    })
  })
})

/*
ENCAMINHAMENTOS - FUNÇÕES PARA A TELA
*/

$(document).ready(function () {
  $('#btn_encamnhamento').click(function () {
    Swal.fire({
      title: "ENCAMINHAMENTOS",
      html: `
            <form method="POST" action="/TechSUAS/views/cadunico/declaracoes/encaminhamento" id="form_familia">
            <h4>Por favor, preencha as informações abaixo</h4>
                <label>
                    CPF: <input id="cpf_dec_cad" type="text" name="cpf_dec_cad" placeholder="Digite o cpf aqui"/> 
                </label>
            </form>
            `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
      didOpen: () => {
        $('#cpf_dec_cad').mask('000.000.000-00')
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_familia")
        form.submit()
      }
    })
  })
})

// FUNÇÃO EMPREGADA NO BOTÃO DE IMPRIMIR DE ENCAMINHAMENTO

function printWithFields_preper() {
  var hide_show = $('#inputText').val();
  var setor = $('#setor').val();
  var retorna = setor == "3" ? $('#inputOutro').val() : setor;

  $('#mostrarText').text(hide_show);
  $('#mostrarDest').text(`Ao(A) responsável por ${retorna}`);
  $('.esconder').hide();

  window.print();
}

//FUNÇÃO DA TELA DASHBOARD ENTREVISTADOR

function buscarDadosFamily() {
  // Limpa o campo de exibição e conteúdo da tabela
  $('#codfamiliar_print').text('')
  $('#familia_show').html('')
  $('#arquivo_show').html('')


  // Obtém o código de família e formata
  var familia = $("#codfamiliar").val()
  let cpfLimpo = familia.replace(/\D/g, '')
  let ajustandoCod = cpfLimpo.padStart(11, '0').replace(/^(\d{9})(\d{2})$/, '$1-$2')

  if (familia.trim() === '') {
    // Se o campo estiver vazio, foca nele novamente
    $("#codfamiliar").focus()
    return
  }

  // Faz a requisição AJAX para buscar os dados da família
  $.ajax({
    type: 'POST',
    url: '/TechSUAS/controller/cadunico/busca_family.php',
    data: {
      codfam: ajustandoCod // Envia o código formatado
    },
    dataType: 'json',
    success: function (response) {
      // console.log(response)
      if (response.encontrado) {
        // Se a família foi encontrada, exibe os dados
        $('#codfamiliar_print').html(`<span style="font-size: 10px;">Código Familiar:</span> <span style="font-size: 16px;"><strong>${ajustandoCod}</strong></span> => <span style="font-size: 10px;">Ultima Atualização:</span> <span style="font-size: 16px;"><strong>${response.data_entrevista}</strong></span> => <span style="font-size: 10px;">Fichário:</span> <span style="font-size: 16px;"><strong>${response.fichario}</strong></span>.`)

        if (response.dados_familia) {
          var dados_familiap = response.dados_familia
          var visitasHtml = ''
          visitasHtml += '<table class="tabelinha">'
          visitasHtml += '<tr><th colspan="3">COMPOSIÇÃO FAMILIAR</th></tr>'
          visitasHtml += '<tr><th>NIS</th><th>NOME</th><th>PARENTESCO</th></tr>'
          dados_familiap.forEach(function (familia_show) {
            visitasHtml += '<tr>'
            visitasHtml += '<td><span>' + familia_show.nis_atual + '</span></td>'
            visitasHtml += '<td><span>' + familia_show.nome + '</span></td>'
            visitasHtml += '<td><span>' + familia_show.parentesco + '</span></td>'
            visitasHtml += '</tr>'
          })

          visitasHtml += '</table>'
          $('#familia_show').html(visitasHtml)
        }

      } else {
        $('#codfamiliar_print').html('<span style="color: red;"><strong>' + `Não foi encontrado nenhuma informação referente ao código ${ajustandoCod}` + ' <strong></span>')
        $('#familia_show').html('') // Limpa a tabela se não encontrar dados
      }

      if (response.arquivos === "Nenhum arquivo encontrado.") {
        $('#arquivo_show').html('<span style="color: red;"><strong>Nenhum arquivo encontrado.</strong></span>')
      } else {
        console.log(response.arquivos)
        var arquivo = response.arquivos
        var linkHtml = ''
        linkHtml += '<table class="tabelinha">'
        linkHtml += '<tr><th colspan="4">ARQUIVOS SALVOS</th></tr>'
        linkHtml += '<tr><th>DATA ENTREVISTA</th><th>TIPO</th><th>AÇÕES</th></tr>'
        arquivo.forEach(function (arquivo_show) {
          linkHtml += '<tr>'
          linkHtml += '<td><span>'+ arquivo_show.data_entrevista +'</span></td>'
          linkHtml += '<td><span>'+ arquivo_show.tipo_documento +'</span></td>'
          linkHtml += `<td id="td_btn">
                    <input type="hidden" id="caminho_id" value="${arquivo_show.caminho_arquivo}"> 
                          <a id="printArquivo" href="${arquivo_show.caminho_arquivo}" target="_blank" style="color: green; font-size: 16px; margin-right: 18px;">
                            <i class="fa fa-download"></i>
                          </a>
                          <a id="editarArquivo" onclick="editarArquivo('${arquivo_show.id}', '${arquivo_show.data_entrevista}', '${arquivo_show.tipo_documento}')">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a id="excluirArquivo" onclick="excluirArquivo('${arquivo_show.id}', '${arquivo_show.caminho_arquivo}')" style="color: red; margin-left: 18px;">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                      </td>`
          linkHtml += '</tr>'
        })
        linkHtml += '</table>'
        $('#arquivo_show').html(linkHtml)
      }
    }
  })
}

function editarArquivo(id, dataEntre, tipo_doc) {

  var cod_fam = document.querySelector('input#codfamiliar').value

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

function excluirArquivo(delet, caminho_id ) {
  Swal.fire({
    title: 'Excluir arquivo',
    text: 'Você tem certeza que deseja excluir o arquivo?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sim',
    cancelButtonText: 'Não'
  }).then((resultQ) => {
    if (resultQ.isConfirmed) {
      $.ajax({
        type: 'POST',
        url: '/TechSUAS/controller/cadunico/exclui_file_server.php',
        data: {
          id: delet,
          caminho: caminho_id
        },
        dataType: 'json',
        success: function (response) {
          Swal.fire({
            title: response.title,
            text: response.mensagem,
            icon: response.icon,
            confirmButtonText: 'OK'
          }).then((resultT) => {
            if (resultT.isConfirmed) {
              location.reload();
            }
          })
        }
      })
    } else {
      Swal.fire("Operação cancelada", "", "info")
    }
  })
  var caminho_id = document.getElementById('caminho_id').value
}

$(document).ready(function () {
  fetch('/TechSUAS/controller/cadunico/buscar_ultimo.php')
  .then(response => response.json())
  .then(response => {
    if (response.encontrado) {
      $('#ultimo_registro').html(response.concatenado)
    }

  })
})


//FUNÇÃO PARA MUDAR DE SELECT PARA INPUT 

function mostrarCampoTexto() {
  var select = document.getElementById("setor")
  var campoTexto = document.getElementById("inputOutro")

  if (select.value === "3") {
    // Se a opção 'Outros' for selecionada, mostra o campo de texto
    campoTexto.style.display = "block"
    select.style.display = "none"
  } else {
    // Caso contrário, oculta o campo de texto
    campoTexto.style.display = "none"
  }
}

function recuperarSenha() {
  window.location.href = "/TechSUAS/views/geral/recuperar_senha"
}

function toggleDetails(id) {
  const details = document.getElementById(id);
  const button = details.previousElementSibling;
  if (details.style.display === "none" || details.style.display === "") {
    details.style.display = "block";
    button.textContent = "-";
  } else {
    details.style.display = "none";
    button.textContent = "+";
  }
}

// ====  DASH-GESTOR-REQUEST ==== //
/*
function loadDashboardData() {
  document.getElementById('cadastros-atualizados').textContent = "120";
  document.getElementById('cadastros-pendentes').textContent = "45";
  document.getElementById('cadastros-sem-cpf').textContent = "10";
  document.getElementById('num-beneficiarios').textContent = "2500";
  document.getElementById('visitas-realizadas').textContent = "300";
  document.getElementById('total-atendimentos').textContent = "500";
}
document.addEventListener('DOMContentLoaded', loadDashboardData);
*/

//FUNÇÃO DE BUSCAR O FICHARIO

function buscaFicharo() {
  window.location.href = "/TechSUAS/views/fichario/allFichario"
}

function mapaFicharo() {
  Swal.fire({
    title:'ATENÇÃO',
    html:`
    <p>A.00 = Armários e seu respectivo número</p>
    <p>G.00 = Gavetas e seu respectivo número</p>
    <p>P.000 = Pastas e seu respectivo número</p>
    <p>Os P.000 na cor <span class="red_text">VERMELHA</span> representam pastas ocupadas</p>
    `,
    confirmButtonText: "OK"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "/TechSUAS/views/fichario/mapa_fichario"
    }
  })
}

function printTiq() {
  window.location.href = "/TechSUAS/controller/fichario/print_etiqueta"
}

function verFichario() {
  window.location.href = "/TechSUAS/views/fichario/ficharios"
}

function cadastroFichario() {
  window.location.href = "/TechSUAS/views/fichario/cadastrar_fichario"
}

function voltaMenu() {
  window.location.href = "/TechSUAS/views/cadunico/index"
}

function solicitaForm() {
  const button = document.getElementById('solicitaFormButton');
  const loadingHtml = `
    <div id="loadingSpinner" style="text-align: center;">
      <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
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

  console.log("Iniciando solicitação de formulários...");
  fetch('/TechSUAS/controller/recepcao/get_solicitacoes.php')
    .then(response => {
      console.log("Recebendo resposta...");
      if (!response.ok) {
        throw new Error('Erro na resposta do servidor');
      }
      return response.json();
    })
    .then(data => {
      console.log("Dados recebidos:", data);
      let tableRows = '';

      if (data.length > 0) {
        data.forEach(row => {
          tableRows += `
            <tr data-id="${row.id}">
              <td>${row.cpf}</td>
              <td>${row.nome}</td>
              <td>${row.cod_fam}</td>
              <td>${row.nis}</td>
              <td>${row.tipo}</td>
              <td>${row.status}</td>
              <td><i class='fas fa-check-circle check-icon' data-id='${row.id}'></i></td>
            </tr>
          `;
        });
      } else {
        tableRows = "<tr><td colspan='7'>Nenhum registro encontrado com status pendente.</td></tr>";
      }

      Swal.fire({
        html: `
          <h2>ENTREVISTAS SOLICITADAS</h2>
          <div style="overflow-x:auto; max-height: 400px;">
              <table border="1" width="100%" style="table-layout: fixed;">
              <thead>
                  <tr>
                      <th style="width: 14%;">CPF</th>
                      <th style="width: 14%;">Nome</th>
                      <th style="width: 14%;">Código Familiar</th>
                      <th style="width: 14%;">NIS</th>
                      <th style="width: 14%;">TIPO</th>
                      <th style="width: 14%;">STATUS</th>
                      <th style="width: 14%;">AÇÕES</th>
                  </tr>
              </thead>
              <tbody id="solicitacoesTableBody">
                ${tableRows}
              </tbody>
              </table>
          </div>
        `,
        width: '1000px',
        didOpen: () => {
          document.querySelectorAll('.check-icon').forEach(icon => {
            icon.addEventListener('click', (event) => {
              const id = event.target.dataset.id;
              const novo_status = 'PRONTO';

              Swal.fire({
                title: 'Você tem certeza?',
                text: 'Você deseja marcar esta entrevista como completa?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, marcar como completa',
                cancelButtonText: 'Cancelar',
              }).then((result) => {
                if (result.isConfirmed) {
                  fetch('/TechSUAS/controller/recepcao/atualizar_status.php', {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&novo_status=${novo_status}`
                  })
                  .then(response => {
                    if (!response.ok) {
                      throw new Error('Erro na resposta do servidor ao atualizar status');
                    }
                    return response.text();
                  })
                  .then(result => {
                    if (result === 'success') {
                      Swal.fire('Sucesso!', 'O status foi atualizado.', 'success');
                      const row = document.querySelector(`tr[data-id="${id}"]`);
                      if (row) {
                        row.remove(); // Remove a linha da tabela
                      }
                    } else {
                      Swal.fire('Erro!', 'Houve um problema ao atualizar o status.', 'error');
                    }
                  })
                  .catch(error => {
                    console.error('Erro ao atualizar status:', error);
                    Swal.fire('Erro!', 'Houve um problema ao atualizar o status.', 'error');
                  });
                }
              });
            });
          });
        }
      });
    })
    .catch(error => {
      console.error('Erro ao carregar solicitações:', error);
      Swal.fire('Erro!', 'Houve um problema ao carregar as solicitações.', 'error');
    })
    .finally(() => {
      // Reabilita o botão após carregar os dados ou em caso de erro
      button.disabled = false;
    });
}
$(document).ready(function () {
  $('#btn_filtrar').click(function () {

    const loadingHtml = `
    <div id="loadingSpinner" style="text-align: center;">
      <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
      <p>Carregando...</p>
    </div>
   `;

    Swal.fire({
      html: loadingHtml,
      width: '400px',
      showConfirmButton: false,
      allowOutsideClick: false
    })

    fetch("/TechSUAS/views/cadunico/area_gestao/filtro_idoso_crianca")
    .then(response => {
      if (!response.ok) {
        throw new Error('Erro na requisição: ' + response.status);
      }
      return response.json();
    })
    .then(data => {
      // console.log('Dados recebidos', data);
      dados = data; // Armazena os dados recebidos globalmente
      // Carrega os dados na tabela
      carregarDados(dados)
    })
    .catch(error => {
      console.error('Erro ao buscar dados:', error);
      Swal.fire('Erro!', 'Houve um problema ao carregar os dados.', 'error');
    })
  })
})

function carregarDados(data) {
  Swal.fire({
    title: 'FILTROS',
    html: `
    <h1>EM MANUTENÇÃO</h1>
    `,
  showCancelButton: true,
  confirmButtonText: 'OK',
  cancelButtonText: 'Cancelar',
  didOpen: () => {
      document.getElementById('cod_fam').addEventListener('input', function () {
        cod_fam = document.getElementById('cod_fam').value
        resultadoFiltro = document.getElementById('resultadoFiltro')
      })
    }
  })
}


$(document).ready(function (){
  $('#btn_beneficios').click(function () {
    Swal.fire({
      title: "SITUAÇÃO DO BENEFÍCIO",
      html: `
            <h4>INFORME O NIS</h4>
            <form method="POST" action="/TechSUAS/controller/cadunico/dashboard/sit_beneficio" id="form_dec_renda">
                <label> NIS:
                    <input type="text" id="cpf_declar" name="cpf_declar"/>
                </label>
            </form>
            `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
      didOpen: () => {
        
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_dec_renda")
        form.submit()
      }
    })
  })
})

function peixinho() {
  window.location.href = "/TechSUAS/peixe/logado/index"
}

function uploads() {
  fetch("/TechSUAS/controller/cadunico/area_gestor/uploads_sem_fam.php")
      .then(response => {
        if (!response.ok) {
          throw new Error('Erro na requisição: ' + response.status);
        }
        return response.json()
      })
      .then(salvo => {
        console.log(salvo)
      })
}

function areaVisitas() {
  window.location.href = "/TechSUAS/views/cadunico/visitas/index"
}

function filtroFamilia() {
  alert("Em desenvolvimento!")
}

function atendimento_acao_cadu() {
    Swal .fire({
      title: 'AÇÃO CADUNICO MAIS PERTO DE VOCÊ',
      html: `
      <label>Selecione um guichê</label>
        <select id="lc_cadastro" class="form-select" name="lc_cadastro" autocomplete="off" required>
          <option value="" data-default disabled selected>Selecione</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
      </select>
      `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
    })
    .then((result) => {
      if (result.isConfirmed) {
        const lc_cadastro = document.getElementById('lc_cadastro').value

        $.ajax({
          type: 'POST',
          url: '/TechSUAS/controller/cadunico/dashboard/atendimento_acao_cadu.php',
          data: {
            lc_cadastro: lc_cadastro
            },
          dataType: 'json',
          success: function(responsavel) {
            if (responsavel.alteracao === true) {
              location.reload()
            } else {
              alert('Erro ao enviar ação')
            }
          }
        })
      } else {
        Swal.fire('Ação cancelada', '', 'info')
      }
    })
}

function chamaProximo(acaoCadu) {
  fetch("/TechSUAS/acao_cadu/controller/busca_proximo.php")
    .then(revil => {
      if (!revil.ok) {
        throw new Error('Erro na requisição: ' + revil.status);
      }
      return revil.json();
    })
    .then(dados => {
      // Ordena: prioridade primeiro, depois por ordem de chegada
      dados.sort((a, b) => {
        if (a.tipo === "PRIORIDADE" && b.tipo !== "PRIORIDADE") return -1;
        if (a.tipo !== "PRIORIDADE" && b.tipo === "PRIORIDADE") return 1;
        return new Date(a.created_at) - new Date(b.created_at);
      })

      // Monta as linhas da tabela
      const linhasTabela = dados.map(dado => `
        <tr>
          <td>${dado.programa}</td>
          <td>${dado.tipo}</td>
          <td><strong>${dado.senha}</strong></td>
          <td>
            <button class="chamar-btn" title="Chamar"
              data-senha="${dado.senha}"
              data-id="${dado.id}" 
              data-guiche="${acaoCadu}" 
              data-cod="${dado.cod_familiar_fam}" 
              data-nome="${dado.nom_pessoa?.replace(/"/g, '&quot;') ?? ''}">
              <i class="fas fa-bullhorn"></i>
            </button>

            <button id="presente" title="Presente" onclick="alterarStatus(${dado.id}, '${dado.nom_pessoa?.replace(/"/g, '&quot;') ?? ''}', '${dado.cod_familiar_fam}', '${dado.senha}', this)">
              <i class="fas fa-check-circle"></i>
            </button>

            <button id="ausente" title="Cancelar" onclick="alterarStatus(${dado.id}, '${dado.nom_pessoa?.replace(/"/g, '&quot;') ?? ''}', '${dado.cod_familiar_fam}', '${dado.senha}', this)">
              <i class="fas fa-user-slash"></i>
            </button>
          </td>
        </tr>
      `).join('')

      // Monta a tabela completa
      const tabelaHTML = `
        <div style="overflow-x:auto;">
          <table style="width:100%; border-collapse: collapse;">
            <thead>
              <tr style="background-color: #eee;">
                <th style="padding: 8px; border: 1px solid #ccc;">PROGRAMA</th>
                <th style="padding: 8px; border: 1px solid #ccc;">TIPO</th>
                <th style="padding: 8px; border: 1px solid #ccc;">SENHA</th>
                <th style="padding: 8px; border: 1px solid #ccc;">AÇÃO</th>
              </tr>
            </thead>
            <tbody>
              ${linhasTabela}
            </tbody>
          </table>
        </div>
      `

      // Exibe no SweetAlert2
      Swal.fire({
        title: 'Fila de Atendimento',
        html: tabelaHTML,
        width: '800px',
        showConfirmButton: false
      })
      // Adiciona evento aos botões
        document.querySelectorAll('.chamar-btn').forEach(btn => {
          btn.addEventListener('click', () => {
            const senha = btn.getAttribute('data-senha')
            const id = btn.dataset.id
            const guiche = btn.dataset.guiche
            const cod = btn.dataset.cod
            const nome = btn.dataset.nome
            chamarPainel(senha, id, guiche, cod, nome)
          })
        })

    })
    .catch(error => {
      Swal.fire('Erro', error.message, 'error')
    })
}

function alterarStatus(id, nom_pessoa, cod_familiar_fam, senha, button) {

  let acao_efeito = (button.id === "ausente") ? "AUSENTE" : "PRESENTE"

  $.ajax({
    type: "POST",
    url: "/TechSUAS/acao_cadu/controller/alterar_dados_2.php",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({
      acao: acao_efeito,
      id: id
    }),
    success: function(data) {
      
      console.log('Resposta do servidor:', data);
      if (data.status === 'sucesso') {
        document.getElementById('codfamiliar').value = cod_familiar_fam;
        let mensagem;
        if (!nom_pessoa) {
          mensagem = `Não encontrei o nome, chame pela: <strong>${senha}</strong>`;
        } else {
          mensagem = `<p><strong>${nom_pessoa}</strong></p><p>Senha: <strong>${senha}</strong></p>`;
        }
    
        Swal.fire({
          icon: 'success',
          title: 'PRÓXIMO',
          html: mensagem,
        });
    
        $('#codfamiliar').focus();
      }
    },
    error: function(xhr, status, error) {
      console.error('Erro AJAX:', status, error);
      console.log('Resposta completa:', xhr.responseText);
    }
  })
}

// Função que será chamada ao clicar em "Chamar" (pode ser ajustada depois)
function chamarPainel(senha, id, acaoCadu, cod_familiar_fam, nom_pessoa) {
  console.log("Chamando ID:", id, "Ação CADU:", acaoCadu)
  
  $.ajax({
    type: "POST",
    url: "/TechSUAS/acao_cadu/controller/alterar_dados.php",
    dataType: "json",
    contentType: "application/json",
    data: JSON.stringify({
      id: id,
      guiche: acaoCadu
    }),
    success: function(data) {
      if (data.status === 'sucesso') {

        if (!nom_pessoa) {
          var nomePainel = ''

        } else {
          var nomePainel = nom_pessoa
        }

        const socket = new WebSocket("wss://painel-chamadas-production.up.railway.app")
        socket.onopen = () => {
          socket.send(JSON.stringify({
            senha: senha,
            nome: nomePainel,
            guiche: acaoCadu
          }))
          socket.close()
        }

      }
    }
  })
}
