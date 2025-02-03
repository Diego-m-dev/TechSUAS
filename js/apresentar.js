

function alt_limite() {
  var cpf_resp = document.getElementById('cpf_r').value
  var nome = document.getElementById('nome').value

  Swal.fire({
    title: `ALTERAR A QUANTIDADE DE CONCESSÕES PARA ${nome}`,
    html:`
    <form method="POST" action="/TechSUAS/controller/concessao/alterar_limites" id="form_fc_pessoa">
      <label>Disponibilizar:</label>
        <input type="hidden" id="cpf_resp" name="cpf_resp" value="${cpf_resp}"/>
        <input type="number" id="limiter" name="limiter" />
    </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Enviar',

    preConfirm: () => {
      var limiter = document.querySelector('input#limiter').value
      if (!limiter) {
        Swal.showValidationMessage("É obrigatório preencher o campo Disponibilizar.")
        return false
      }
    }
  })
  .then((result) => {
    if (result.isConfirmed) {
      var limiter = document.getElementById('limiter').value
      var cpf_resp = document.getElementById('cpf_resp').value

      $.ajax({
        url: "/TechSUAS/controller/concessao/alterar_limites.php",
        type: 'POST',
        data: {
          cpf_resp: cpf_resp,
          limiter: limiter
        },
        dataType: 'json',
        success: function (response) {
          if (response.encontrado) {
            Swal.fire({
              icon: 'success',
              title: 'DADOS ALTERADOS',
              text: 'O limite de concessão foi alterado com sucesso!',
              confirmButtonText: 'OK'
            })
            .then((result) => {
              window.location.reload()
            })
          } else {
            alert ("ERRO - Contacte o Suporte")
          }
        }
      })
    }
  })
}

function alt_dados_pessoais() {
  
}