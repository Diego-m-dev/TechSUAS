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
  var codIBGE = document.querySelector('input#codIBGE').value;

  $.ajax({
    type: 'POST',
    url: '/TechSUAS/suporte/controller/buscaSystem.php',
    data: {
      codIBGE: codIBGE 
    },
    dataType: 'json',

    success: function (result) {
      if (result.encontrado) {
        var setorSelect = document.querySelector('select[name="setor"]');
        setorSelect.innerHTML = '<option value="" disabled selected hidden>Selecione</option>';

  
        var option = document.createElement('option');
        option.value = `${result.instituicao} - ${result.nomeInstituicao}`; 
        option.textContent = `${result.instituicao} - ${result.nomeInstituicao}`; 
        option.dataset.id = result.id;
        setorSelect.appendChild(option);

        
        setorSelect.addEventListener('change', function () {
          var idSetor = setorSelect.options[setorSelect.selectedIndex].dataset.id; 
          console.log("ID do setor selecionado:", idSetor);
          buscarSistemaPorSetor(idSetor); 
        });
      } else {
        alert('Nenhum setor encontrado para este município IBGE.');
      }
    },
    error: function () {
      alert('Erro ao buscar os setores. Verifique o código IBGE.');
    }
  });
}

function buscarSistemaPorSetor() {
  var setorSelect = document.querySelector('select[name="setor"]');
  var idSetor = setorSelect.options[setorSelect.selectedIndex].dataset.id;
  if (!idSetor) {
    alert("Selecione um setor válido!");
    return;
  }

  $.ajax({
    type: 'POST',
    url: '/TechSUAS/suporte/controller/buscaSystemPorSetor.php', 
    data: { idSetor: idSetor }, 
    dataType: 'json',
    success: function (sistemas) {
      var sistemaSelect = document.querySelector('select[name="sistema"]');
      sistemaSelect.innerHTML = '<option value="" disabled selected hidden>Selecione</option>';

      if (sistemas.length > 0) {
        sistemas.forEach(function (sistema) {
          var option = document.createElement('option');
          option.value = sistema.id;
          option.textContent = sistema.nome_sistema; 
          sistemaSelect.appendChild(option);
        });
      } else {
        alert("Nenhum sistema encontrado para este setor.");
      }
    },
    error: function () {
      alert("Erro ao buscar os sistemas. Tente novamente.");
    }
  });
}


