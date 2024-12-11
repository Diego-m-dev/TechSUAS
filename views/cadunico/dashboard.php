<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png" />
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/style-painel_entrevistador.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="/TechSUAS/js/cadastro_unico.js"></script>

  <title>Painel do Entrevistador - TechSUAS</title>
</head>

<body>

  <h1></h1>
  <div class="tudo">
    <div class="container">
      <form id="cadastroForm" enctype="multipart/form-data" method="POST"
        action="/TechSUAS/controller/cadunico/salvar_dados_painel">

        <!-- Identificação da Entrevista -->
        <div class="bloc">
          <div class="bloc1">
            <div>
              <label for="codfamiliar">Código familiar:</label>
              <input type="text" maxlength="11" name="cod_fam" id="codfamiliar"
                oninput="buscarDadosFamily(); tratarCodigo();" required />
            </div>
            <div id="cont_data">
              <label for="data_entrevista">Data da Entrevista:</label>
              <input type="date" id="data_entrevista_hoje" name="data_entrevista_hoje">
            </div>
            <div id="data_entrevista_hoje-oculta" class="ocult"></div>
          </div>
          <div>
            <button id="solicitaFormButton" type="button" onclick="solicitaForm()">Solicitações de Formulários</button>
          </div>
        </div>

        <!-- Situação do Benefício e Observações -->
        <div class="bloc2">
          <div class="situacao">
            <label for="sit_beneficio">Selecione a situação do benefício:</label>
            <select name="sit_beneficio" id="sit_beneficio" required>
              <option value="" disabled selected hidden>Escolha</option>
              <option value="APENAS UPLOAD">APENAS UPLOAD</option>
              <option value="BENEFICIO NORMALIZADO">BENEFÍCIO NORMALIZADO</option>
              <option value="NÃO TEM BENEFÍCIO">NÃO TEM BENEFÍCIO</option>
              <option value="FIM DE RESTRIÇÃO ESPECIFICA">FIM DE RESTRIÇÃO ESPECIFICA</option>
              <option value="CANCELADO">CANCELADO</option>
              <option value="BLOQUEADO">BLOQUEADO</option>
            </select>
          </div>
          <div class="observ">
            <div><label for="resumo">Observação:</label></div>
            <div><textarea name="resumo" id="resumo"
                placeholder="Se houve alguma observação durante a entrevista registre-a."></textarea></div>
          </div>
          <input type="hidden" name="tipo_documento_hidden" id="tipo_documento_hidden" value=".pdf">
        </div>

        <!-- Upload de Arquivos -->
        <div class="upload">
          <div>
            <label for="tipo_documento">Tipo de Documento:</label>
            <select name="tipo_documento[]" id="tipo_documento" multiple required>
              <option value="" disabled hidden>Selecione o(s) tipo(s)</option>
              <option value="Cadastro">Cadastro</option>
              <option value="Atualização">Atualização</option>
              <option value="Assinatura">Assinatura</option>
              <option value="Fichas exclusão">Fichas exclusão</option>
              <option value="Relatórios">Relatórios</option>
              <option value="Parecer visitas">Parecer visitas</option>
              <option value="Documento externo">Documento externo</option>
            </select>
          </div>
          <div class="upl">
            <label for="arquivo">Arquivo:</label>
            <input type="file" id="arquivo" name="arquivo" required onchange="mostrarNomeArquivo()">
            <span id="nomeArquivo" hidden></span>
            <label for="" class="coment">Arraste ou selecione o arquivo</label>
          </div>

        </div>

        <div class="btn">
          <button type="submit">Cadastrar</button>
          <div id="success-icon" style="display: none;">
            <span class="material-symbols-outlined">check</span>
          </div>
          <button type="button" onclick="voltaMenu()"><i class="fas fa-arrow-left"></i> Voltar ao menu</button>
        </div>
      </form>
    </div>

    <!-- Botões de acesso rápido -->
    <div class="btns_tudo">
      <div class="btns">
        <div><label for="">Botões de fácil acesso:</label></div>
        <div class="nav">
          <div class="bloco1">
            <nav>
              <a type="button" id="btn_residencia"><i class="fas fa-home icon"></i> Termo de Declaração de
                Residência</a>
              <a type="button" id="btn_dec_renda"><i class="fas fa-file-invoice-dollar icon"></i> Termo de Declaração de
                Renda</a>
              <a type="button" id="btn_fc_familia"><i class="fas fa-user-minus icon"></i> Ficha de Exclusão de
                Familia</a>
              <a type="button" id="btn_fc_pessoa"><i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Pessoa</a>
            </nav>
          </div>
          <div class="bloco2">
            <nav>
              <a type="button" id="btn_dec_cad"><i class="material-symbols-outlined">assignment_add</i> Declaração
                Cadastro Único</a>
              <a type="button" id="btn_encamnhamento"><i class="material-symbols-outlined">export_notes</i>
                Encaminhamentos</a>
              <a type="button" id="btn_des_vol"><i class="material-symbols-outlined">contract_delete</i> Desligamento
                Voluntário</a>
              <a type="button" id="btn_troca"><i class="material-symbols-outlined">quick_reference</i> Troca de RF -
                C.E.F.</a>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php $conn_1->close(); ?>

  <script>
    // Exibe o nome do arquivo após o upload
    function mostrarNomeArquivo() {
      var inputFile = document.getElementById('arquivo');
      var nomeArquivo = document.getElementById('nomeArquivo');
      var inputCodFam = document.getElementById('codfamiliar');

      if (inputFile.files && inputFile.files[0]) {
        var fileName = inputFile.files[0].name;
        nomeArquivo.textContent = 'Arquivo selecionado: ' + fileName;
        nomeArquivo.style.display = 'block';
        inputCodFam.value = fileName;
        tratarCodigo();
      } else {
        nomeArquivo.style.display = 'none';
        inputCodFam.value = '';
      }
    }

    function tratarCodigo() {
      var campo = document.getElementById('codfamiliar');
      var valor = campo.value;
      valor = valor.replace(/\D/g, '');
      if (valor.length > 11) valor = valor.substring(0, 11);
      campo.value = valor;
    }

    $(document).ready(function () {
      $('#cadastroForm').on('submit', function (event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        // Captura os dados do formulário
        var formData = new FormData(this);

        // Configuração do AJAX
        $.ajax({
          url: $(this).attr('action'), // URL do backend
          type: $(this).attr('method'), // Método HTTP (POST)
          data: formData, // Dados do formulário
          processData: false, // Necessário para envio de arquivos
          contentType: false, // Impede que o jQuery defina o cabeçalho `Content-Type`
          beforeSend: function () {
            Swal.fire({
              icon: 'info',
              title: 'Aguarde...',
              text: 'Enviando os dados...',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });
          },
          success: function (response) {
            // Feedback ao usuário após sucesso
            Swal.fire({
              icon: 'success',
              title: 'Sucesso!',
              text: 'Os dados foram enviados com sucesso!',
            });

            // Opcional: Limpar o formulário após envio
            $('#cadastroForm')[0].reset();
          },
          error: function (xhr, status, error) {
            // Exibe mensagem de erro detalhada
            Swal.fire({
              icon: 'error',
              title: 'Erro ao enviar os dados!',
              text: `Status: ${xhr.status} - ${xhr.statusText}`,
            });
            console.error('Erro:', xhr.responseText || error);
          },
        });
      });
    });

  </script>

</body>

</html>