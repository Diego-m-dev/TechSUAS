document.addEventListener("DOMContentLoaded", function () {
  var cpfInput = $("#cpf")
  var telefoneInput = $("#telefone")
  var tit_ele = $("#tit_ele")
  var nis_pessoa = $("#nis_pessoa")


  // Aplicar máscara para CPF
  cpfInput.mask('000.000.000-00')
  //Aplica máscara para o telefone
  telefoneInput.mask('(00) 0.0000-0000')

  tit_ele.mask('0000-0000-0000')
  nis_pessoa.mask('000000000-00')

  let check_iO = document.getElementById('i')
  let quant_mesO = document.getElementById('quant_mes')

  check_iO.addEventListener("change", function () {
    if (this.checked) {
      quant_mesO.value = ""
      quant_mesO.disabled = true
    } else {
      quant_mesO.disabled = false
    }
  })

  quant_mesO.addEventListener("input", function () {
    if (this.value.trim() !== "") {
      check_iO.checked = false
      check_iO.disabled = true

    } else {
      check_iO.disabled = false

    }
  })


  form.addEventListener("submit", function (event) {
    event.preventDefault() //evita o envio padrão

    const form = document.getElementById('form')
    const quant_mes = document.getElementById('quant_mes')
    const check_i = document.getElementById('i')

    let mensagemErro = []

    if (quant_mes.value.trim() === "" && !check_i.checked) {
      mensagemErro.push("Informe a quantidade de meses ou marque a opção 'Não especificado'.")
    }

    if (mensagemErro.length > 0) {
      Swal.fire({
        icon: 'error',
        title: 'ERRO NO FORMULÁRIO',
        text: mensagemErro.join("\n")
      })
      return
    }

    let dados = {}
    let inputs = document.querySelectorAll(".salve_resp")

    inputs.forEach(input => {
      dados[input.name] = input.value
    })

    console.log(dados)

    salvar_responsavel(dados)

  })

})

function salvar_responsavel(dados) {

fetch('/TechSUAS/controller/concessao/salvar_responsavel.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(dados)
})
.then(response => response.json())
.then(data => {
  if (data.success) {
    Swal.fire({
      icon: 'success',
      title: 'DADOS SALVO',
      text: 'Os dados foram salvos com sucesso!'
    }).then(() => {
      window.location.href = '/TechSUAS/views/concessao/gerar_form'
    })
  } else {
    Swal.fire({
      icon: 'error',
      title: 'ERROR',
      text: data.error || 'Houve um problema ao salvar os dados.'
    })
  }
})
.catch(error => {
  console.log('Erro: ', error)
  Swal.fire({
    icon: 'error',
    title: 'Erro!',
    text: 'Erro ao conectar com o servidor.',
  })
})

}