//APRESENTA OS FORMULÁRIOS
$(document).ready(function () {
  $('.esconde_form').hide()
  $('#btn_cadastrar_municipio').click(function () {
    $('#form_municipio').show()
  })
  $('#btn_cadastrar_setor').click(function () {
    $('#formCadSetor').show()
  })
  $('#btn_cadastrar_sistema').click(function () {
    $('#formCadSistemas').show()
  })
  $('#btn_cadastrar_operador').click(function () {
    $('#formCadoperador').show()
  })
  $('#btn_cadastrar_bd').click(function () {
    $('#form_bd').show()
  })
})

function buscarMunicipio() {
  var cod_ibge_2 = document.getElementById('cod_ibge_2').value

  $.ajax({
    type: 'POST',
    url: "/TechSUAS/suporte/controller/busca.php",
    data: {
      cod_ibge_2: cod_ibge_2
    },
    dataType: 'json',
    success: function (resposta) {
      if (resposta.encontrado) {
        document.getElementById('municipio-info').innerText = 'Município: ' + resposta.municipio
      } else {
        console.log('Município não encontrado.')
        document.getElementById('municipio-info').innerText = 'Município não encontrado.'
      }
    },
    error: function (xhr, status, error) {
      console.error('Erro na requisição AJAX:', status, error)
      document.getElementById('municipio-info').innerText = 'Erro ao buscar município. Tente novamente.'
    }
  })
}
function buscarMunicipiobd() {
  var cod_ibge_3 = document.getElementById('cod_ibge_3').value;

  $.ajax({
    url: "/TechSUAS/suporte/controller/busca.php",
    type: 'POST',
    data: {
      cod_ibge_2: cod_ibge_3
    },
    dataType: 'json',
    success: function(resposta) {
      console.log(resposta);
      if (resposta.encontrado) {
        document.getElementById('municipio-infobd').innerText = 'Município: ' + resposta.municipio;
      } else {
        document.getElementById('municipio-infobd').innerText = 'Município não encontrado.';
      }
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
      document.getElementById('municipio-infobd').innerText = 'Erro ao buscar município. Tente novamente. ' + status + ' ' + error;
    }
  });
}

function buscarResponsavel() {
  var cpf = document.getElementById('cpf').value

  if (cpf.trim() == '') {
    alert('Por favor, insira um código cpf válido.')
    return
  }
  $.ajax({
    type: 'POST',
    url: "/TechSUAS/suporte/controller/busca.php",
    data: {
        cpf: cpf
    },
    dataType: 'json',
    success: function (resposta) {
        console.log(resposta); // Adicione este log para inspecionar a resposta
        if (resposta.encontrado) {
            document.getElementById('responsavel-info').innerText = 'Responsável: ' + resposta.municipio
        } else {
            document.getElementById('responsavel-info').innerText = 'Responsável não encontrado.'
        }
    },
    error: function (xhr, status, error) {
        console.error('Erro na requisição AJAX:', status, error)
        document.getElementById('responsavel-info').innerText = 'Erro ao buscar responsável. Tente novamente.'
    }
})
}


function mostrarCampoTexto() {
  var select = document.getElementById("funcao");
  var campoTexto = document.getElementById("funcao_outros");

  if (select.value == "3") {
      // Se a opção 'Outros' for selecionada, mostra o campo de texto
      campoTexto.style.display = "block";
  } else {
      // Caso contrário, oculta o campo de texto
      campoTexto.style.display = "none";
  }
}

function sempreMaiusculo() {

  var maiusculas = document.querySelector('input.maiusculo')

  maiusculas.value = maiusculas.value.toUpperCase()
  console.log(maiusculas.value)
}

function buscarSystem() {
  var codIBGE = document.querySelector('input#codIBGE').value

  $.ajax({
    type: 'POST',
    url: '/TechSUAS/suporte/controller/buscaSystem.php',
    data: {
      codfam: codIBGE // Envia o código formatado
    },
    dataType: 'json',

    success: function (result) {
      if (result.encontrado) {

      }
    }
  })
}