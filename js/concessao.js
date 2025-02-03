//const { error } = require("console")

document.addEventListener("DOMContentLoaded", function () {
  var cpfInput = $("#cpf")
  var nisInput = $("#nis")

  // Aplicar máscara para CPF
  cpfInput.mask('000.000.000-00')
  nisInput.mask('000.000.000-00')



  document.getElementById('cpf').addEventListener('input', function() {
    if (this.value.length === 14) {
      buscarResp()
    }
    return
  })
  document.getElementById('nis').addEventListener('input', function() {
    if (this.value.length === 14) {
      buscarBen()
    }
    return
  })

})


function buscarResp() {
  var cpf_resp = document.querySelector('input#cpf')

  $.ajax({
    url: '/TechSUAS/controller/concessao/busca_resp.php',
    type: 'POST',
    data: {
      cpf_resp: cpf_resp.value
    },
    dataType: 'json',
    success: function (response) {
      if (response.encontrado) {
        document.getElementById('nome_resp').innerHTML = `
        ${response.dados_resp.nome}, 
        Nascida(o): ${response.dados_resp.data_nasc}, 
        Filha(o): ${response.dados_resp.nome_mae}
        `
        document.getElementById('select_parentesco').innerHTML = `
                            <label>Parentesco</label>
                <select name="parentesco" id="parentesco" required>
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="UNIPESSOAL">Unipessoal</option>
                    <option value="CONJUGE">Conjuge</option>
                    <option value="FILHO(A)">Filho(a)</option>
                    <option value="ENTEADO(A)">Enteado(a)</option>
                    <option value="NETO OU BISNETO">Neto ou Bisneto</option>
                    <option value="PAI OU MAE">Pai ou Mae</option>
                    <option value="SOGRO(A)">Sogro(a)</option>
                    <option value="IRMAOS OU IRMA">Irmão ou Irmã</option>
                    <option value="GENRO OU NORA">Genro ou Nora</option>
                    <option value="OUTRO PARENTE">Outro Parente</option>
                    <option value="NAO PARENTE">Não Parente</option>
                </select>

        `
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'NÃO CADASTRADO',
          text: `O CPF: ${cpf_resp.value} não está cadastrado, deseja cadastrar?`,
          showCancelButton: true,
          confirmButtonText: 'SIM',
          cancelButtonText: 'NÃO'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: "CADASTRO ÚNICO",
              html: `
                    <form method="POST" action="/TechSUAS/views/concessao/cadastro_pessoa.php" id="form_familia">
                        <label>
                            <input id="cpf" type="text" name="cpf" maxlength="14" placeholder="NIS do antigo RF" value="${cpf_resp.value}"/>
                        </label><br><br>
                    </form>
                    `,
              showCancelButton: true,
              confirmButtonText: 'Enviar',
              cancelButtonText: 'Cancelar',
              didOpen: () => {
                $('#cpf').mask('000.000.000-00')
              }
            }).then((result) => {
              if (result.isConfirmed) {
                const form = document.getElementById("form_familia")
                form.submit()
              }
        
            })
          }
        })
      }
    }
  })
}

function buscarBen() {
  var nis_resp = document.querySelector('input#nis')

  $.ajax({
    url: '/TechSUAS/controller/concessao/busca_benef.php',
    type: 'POST',
    data: {
      nis_resp: nis_resp.value
    },
    dataType: 'json',
    success: function (success) {
      if (success.encontrado) {
        document.getElementById('nome_benef').innerHTML = `
        ${success.dados_benef.nome}, 
        Nascida(o): ${success.dados_benef.data_nasc}, 
        Filha(o): ${success.dados_benef.nome_mae} 
        ${success.dados_benef.feitos} - ${success.dados_benef.limite}
        `
          if (success.dados_benef.feitos === success.dados_benef.limite) {
            Swal.fire({
              icon: 'warning',
              title: 'LIMITE EXCEDIDO',
              text: "O limite de CONCESSÃO para esse beneficiário foi atingido!"
            })
            return false
          }
        
        document.getElementById('status_ben').innerHTML = success.dados_benef.salvo === NaN ? "" : success.dados_benef.salvo
        
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'NÃO CADASTRADO',
          text: `O CPF: ${nis_resp.value} não está cadastrado, deseja cadastrar?`,
          showCancelButton: true,
          confirmButtonText: 'SIM',
          cancelButtonText: 'NÃO'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: "CADASTRO ÚNICO",
              html: `
                    <form method="POST" action="/TechSUAS/views/concessao/cadastro_pessoa.php" id="form_familia">
                        <label>
                            <input id="cpf" type="text" name="cpf" maxlength="14" placeholder="NIS do antigo RF" value="${nis_resp.value}"/>
                        </label><br><br>
                    </form>
                    `,
              showCancelButton: true,
              confirmButtonText: 'Enviar',
              cancelButtonText: 'Cancelar',
              didOpen: () => {
                $('#cpf').mask('000.000.000-00')
              }
            }).then((result) => {
              if (result.isConfirmed) {
                const form = document.getElementById("form_familia")
                form.submit()
              }
        
            })
          }
        })
      }
    }
  })
}

function btn_avancar() {
  var cpf_R = document.getElementById('cpf')
  var cpf_B = document.getElementById('nis')
  var parentesco = document.getElementById('parentesco')

  if (cpf_B.value === "" || cpf_R.value === "" || parentesco.value === "") {
    alert("Todos os campos são obrigatórios!")
    return
  }

  fetch('/TechSUAS/controller/concessao/get_itens.php')
    .then(response => response.json())
    .then(itens => {

  var options = `<option value="" disabled selected hidden>Selecione</option>`

      itens.forEach(item => {
        options += `<option value="${item}">${item}</option>`
      })

  Swal.fire({
    title: "ITEM CONCEDIDO",
    html: `
      <form method="POST" action="/TechSUAS/controller/concessao/gerar_form" id="form_fc_pessoa">
          <input type="hidden" name="cpf_R" id="cpf_R" value="${cpf_R.value}" />
          <input type="hidden" name="cpf_B" id="cpf_B" value="${cpf_B.value}" />
          <input type="hidden" name="parentesco" id="parentesco" value="${parentesco.value}" />

        <label>Item: </label>
          <select name="itens_conc" id="itens_conc" required>
            ${options}
          </select>
            <label>Quantidade:</label>
              <input type="number" name="quant" id="quant">
            <label>Valor Unitário:</label>
              <input type="number" name="vlr_uni" id="vlr_uni">

              <strong> Total: </strong>
              <span id="resulta">R$ 0,00</span>
              <label>Mês de Pagamento:</label>
              <select name="mes_pg" id="mes_pg" required>
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="Janeiro">Janeiro</option>
                    <option value="Fevereiro">Fevereiro</option>
                    <option value="Março">Março</option>
                    <option value="Abril">Abril</option>
                    <option value="Maio">Maio</option>
                    <option value="Junho">Junho</option>
                    <option value="Julho">Julho</option>
                    <option value="Agosto">Agosto</option>
                    <option value="Setembro">Setembro</option>
                    <option value="Outubro">Outubro</option>
                    <option value="Novembro">Novembro</option>
                    <option value="Dezembro">Dezembro</option>
                </select>

      </form>
    `,
    showCancelButton: true,
    confirmButtonText: "Enviar",
    preConfirm: () => {
      var quant = document.getElementById('quant').value.trim()
      var vlrUni = document.getElementById('vlr_uni').value.trim()
      var itemSelecionado = document.getElementById('itens_conc').value.trim()
      var mesPagto = document.getElementById('mes_pg').value.trim()

      if (!quant || !vlrUni || !itemSelecionado || !mesPagto) {
        Swal.showValidationMessage("Todos os campos são obrigatórios!")
        return false
      }
    },
    didOpen: () => {

      var quantInput = document.getElementById('quant')
      var vlr_uniInput = document.getElementById('vlr_uni')
      var resultaSpan = document.getElementById('resulta')

      function calcularTotal() {
        var quant = parseFloat(quantInput.value) || 0
        var vlr_uni = parseFloat(vlr_uniInput.value) || 0
        var resulta = quant * vlr_uni
        resultaSpan.innerHTML = `R$ ${resulta.toFixed(2)}`
      }

      quantInput.addEventListener('input', calcularTotal)
      vlr_uniInput.addEventListener('input', calcularTotal)

    }
  }).then((resultado) => {
    if (resultado.isConfirmed) {
      var cpf_R = document.getElementById('cpf_R').value
      var cpf_B = document.getElementById('cpf_B').value
      var itens_conc = document.getElementById('itens_conc').value
      var quant = document.getElementById('quant').value
      var valorUni = document.getElementById('vlr_uni').value
      var parentesco = document.getElementById('parentesco').value
      var mes_pg = document.getElementById('mes_pg').value

      var multiQ_U = quant * valorUni

      $.ajax({
        url: '/TechSUAS/controller/concessao/gerar_formulario.php',
        type: 'POST',
        data: {
          cpf_B: cpf_B,
          cpf_R: cpf_R,
          itens_conc: itens_conc,
          quant: quant,
          valorUni: valorUni,
          multiQ_U: multiQ_U,
          mes_pg: mes_pg,
          parentesco: parentesco
        },
        dataType: 'json',
        success: function (parametro) {
          if (parametro.encontrado) {
            Swal.fire({
              icon: "success",
              title: "DADOS SALVOS",
              text: "Dados salvos com sucesso."
            }).then((resultou) => {
              window.location.href = `/TechSUAS/views/concessao/impressao_capa?cpf_R=${cpf_R}`
            })
          } else {
            Swal.fire({
              icon: "warning",
              title: "ATENÇÃO",
              text: "Limite de concessão excedido."
            }).then((resultou) => {
              window.location.href = `/TechSUAS/views/concessao/impressao_capa?cpf_R=${cpf_R}`
            })
          }
        }
      })

    }
  })
})
  .catch(error => console.error('Erro ao buscar os itens: ', error))
}

$(document).ready(function() {
    $('#btn_imprimir').click(function() {
        var idHist = $(this).attr('name')

        $.ajax({
            type: 'POST',
            url: '/TechSUAS/controller/concessao/print_conc.php',
            data: { id_hist: idHist },
            dataType: 'json', // Espera uma resposta JSON do servidor
            success: function (response) {
                if (response.encontrado) {
                    $('#conteiner_hide').hide()
                    $('#conteiner_show').show()
                    $('#num_form').text('Formulário: ' + response.num_form + '/' + response.ano_form)
                    $('#nome_resp').text(response.nome_resp)
                    $('#naturalidade_resp').text(response.naturalidade_resp)
                    $('#nome_m').text(response.nome_m)
                    $('#contato').text(response.contato)
                    $('#cpf_pessoa').text('CPF: ' + response.cpf_resp)
                    $('#tet_ili').text('T.E.: ' + response.tit_eleitor_pessoa)
                    $('#rg_pessoa').text('RG: ' + response.rg_pessoa)
                    $('#nis_pessoa').text('NIS: ' + response.nis_pessoa)
                    $('#nome_benef').text(response.nome_benef)
                    $('#munic_nasc').text(response.munic_nasc)
                    $('#nom_mae_pessoa').text(response.nom_mae_pessoa)
                    $('#renda_media').text(response.renda_media)
                    $('#endereco_conc').text(response.endereco)
                    $('#cpf_pessoa_b').text('CPF: ' + response.cpf_pessoa_b)
                    $('#tet_ili_b').text('T.E.: ' + response.tet_ili_b)
                    $('#rg_pessoa_b').text('RG: ' + response.rg_pessoa_b)
                    $('#nis_pessoa_b').text('NIS: ' + response.nis_pessoa_b)
                    $('#parentes').text('QUAL PARENTESCO O RESPONSÁVEL TEM COM O BENEFICIÁRIO?: ' + response.parentes)
                    $('#nome_item').text(response.nome_item)
                    $('#descricao').text(response.nome_item)
                    $('#qtd_item').text(response.qtd_item)
                    $('#valor_uni').text(response.valor_uni)
                    $('#valor_total').text(response.valor_total)
                    $('#local_data').text('São Bento do Una - PE ____ de _____________ de ' + response.local_data)
                    
                    window.print()

                    setTimeout(function() {
                        window.location.href = '/TechSUAS/views/concessao/index'
                    }, 300)
                } else {
                    console.error(response.error)
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Lida com erros, se houver
                console.error("AJAX Request Failed: " + textStatus, errorThrown)
            }
        })
        $('#css_link').attr('href', '/TechSUAS/css/concessao/style_impr_form.css')
    })
})
/*

*/
document.addEventListener('DOMContentLoaded', function () {
    // Obtém todos os campos de entrada de texto
    var camposTexto = document.querySelectorAll('input[type="text"]')

    // Adiciona um ouvinte de eventos de entrada a cada campo de texto
    camposTexto.forEach(function (campo) {
        campo.addEventListener('input', function () {
            // Converte o valor do campo para maiúsculas
            this.value = this.value.toUpperCase()
        })
    })
})

