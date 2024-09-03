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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="/TechSUAS/js/cadastro_unico.js"></script>
  <title>Painel do Entrevistador - TechSUAS</title>
</head>

<body>
  <div class="img">
    <h1 class="titulo-com-imagem">
      <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/h1-painel_entrevistador.svg" alt="Título com imagem">
    </h1>
  </div>
  <div class="tudo">
    <div class="container">
    <form id="cadastroForm" enctype="multipart/form-data">
        <div class="ocult2">
          <div id="codfamiliar_print" class="ocult"></div>
          <div id="data_entrevista" class="ocult"></div>
          <div id="familia_show" class="ocult"></div>
        </div>

        <!--FORMULARIO PARA IDENTIFICAÇÃO DA ENTREVISTA-->
        <div class="bloc">
          <div class="bloc1">
            <div>
              <label for="codfamiliar">Código familiar:</label>
              <input type="text" name="cod_fam" id="codfamiliar" onblur="buscarDadosFamily()" required />
            </div>
            <div id="cont_data">
              <label for="data_entrevista">Data da Entrevista:</label>
              <input type="date" id="data_entrevista" name="data_entrevista">
            </div>
            <div id="data_entre" class="ocult"></div>
          </div>

          <div>
            <button id="solicitaFormButton" type="button" onclick="formPedidos()">Acompanhamento de Pedidos</button>
          </div>

          <div>
            <button id="solicitaFormButton" type="button" onclick="solicitaForm()">Solicitações de Formulários</button>
          </div>
        </div>


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
              <option value="NÃO TEM BENEFÍCIO">NÃO TEM BENEFÍCIO</option>
            </select>
          </div>
          <div class="observ">
            <div><label for="resumo">Observação:</label></div>
            <div><textarea name="resumo" id="resumo" placeholder="Se houve alguma observação durante a entrevista registre-a."></textarea></div>
          </div>
          <br><input type="hidden" name="tipo_documento_hidden" id="tipo_documento_hidden" value=".pdf">
        </div>

        <!--FORMULÁRIO PARA UPLOAD DOS ARQUIVOS-->
        <div class="upload">
          <div>
            <label for="tipo_documento">Tipo de Documento:</label>
            <br>
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
            <br>
          </div>
          <div class="upl">
            <label for="arquivo">Arquivo:</label>
            <input type="file" id="arquivo" name="arquivo" required>
            <label for="" class="coment">Arraste ou selecione o arquivo</label>
          </div>
        </div>
        <div class="btn">
          <button type="submit">Cadastrar</button>
          <div id="success-icon" style="display: none;">
            <span class="material-symbols-outlined">
              check
            </span>
          </div>
          <br><button type="button" onclick="voltaMenu()"><i class="fas fa-arrow-left"></i>Voltar ao menu</button>
        </div>
      </form>

    </div>

    <div class="btns_tudo">

      <!--BOTÕES PARA FÁCIL ACESSO AOS FORMULÁRIO E DECLARAÇÕES-->
      <div class="btns">
        <div><label for="">Botões de fácil acesso:</label></div>
        <div class="nav">
          <div class=bloco1>
            <nav>

              <a type="button" id="btn_residencia">
                <i class="fas fa-home icon"></i> Termo de Declaração de Residência
              </a>


              <a type="button" id="btn_dec_renda">
                <i class="fas fa-file-invoice-dollar icon"></i> Termo de Declaração de Renda
              </a>


              <a type="button" id="btn_fc_familia">
                <i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Familia
              </a>


              <a type="button" id="btn_fc_pessoa">
                <i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Pessoa
              </a>

            </nav>
          </div>
          <div class="bloco2">
            <nav>
              <a type="button" id="btn_dec_cad">
                <i class="material-symbols-outlined">assignment_add</i> Declaração Cadastro Único
              </a>


              <a type="button" id="btn_encamnhamento">
                <i class="material-symbols-outlined">export_notes</i> Encaminhamentos
              </a>


              <a type="button" id="btn_des_vol">
                <i class="material-symbols-outlined">contract_delete</i> Desligamento Voluntário
              </a>


              <a type="button" id="btn_troca">
                <i class="material-symbols-outlined">quick_reference</i> Troca de RF - C.E.F.
              </a>
            </nav>
          </div>
        </div>
      </div>
      <div class="btns">
        <div><label for="">Links de fácil acesso:</label></div>
        <div class="nav">
          <div class=bloco1>
            <nav>

              <a href="https://www.beneficiossociais.caixa.gov.br" target="_blank">SIBEC</a>

              <a href="http://cadastrounico.caixa.gov.br" target="_blank" class="cadunico">CADASTRO ÚNICO</a>

              <a href="https://cecad.cidadania.gov.br/painel03.php" target="_blank" class="cecad">CECAD</a>

            </nav>
          </div>
          <div class="bloco2">
            <nav>
              <a href="https://cadunico.dataprev.gov.br/portal/" target="_blank" class="pcadunico">PORTAL CADASTRO ÚNICO</a>

              <a href="https://falemds.centralit.com.br/formulario/" target="_blank" class="pcadunico">FORMULÁRIO ELETRÔNICO DO MDS</a>

              <a href="https://www.mds.gov.br/mds-sigpbf-web/carregarTelaLogin.jsf;jsessionid=fdL4CJM3HzqgPmqgvb3i9aKrL02hrOuEBCb9dQo9.susigpbfpd01" target="_blank" class="sigpbf">SIGPBF</a>

            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
      $(document).ready(function() {
      $('#cadastroForm').on('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        // Cria um objeto FormData com os dados do formulário
        var formData = new FormData(this);

        $.ajax({
          url: '/TechSUAS/controller/cadunico/salvar_dados_painel', // URL para onde os dados serão enviados
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            // Exibe o alerta de sucesso usando SweetAlert2
            Swal.fire({
              title: 'Sucesso!',
              text: 'Os dados foram cadastrados com sucesso.',
              icon: 'success',
              confirmButtonText: 'Ok'
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload(); // Recarrega a página atual
              }
            });
          },
          error: function(xhr, status, error) {
            // Exibe uma mensagem de erro se algo der errado
            Swal.fire({
              title: 'Erro!',
              text: 'Ocorreu um erro ao tentar cadastrar os dados.',
              icon: 'error',
              confirmButtonText: 'Ok'
            });
          }
        });
      });
    });
    document.addEventListener('DOMContentLoaded', function() {
      const targets = [
        document.getElementById('codfamiliar_print'),
        document.getElementById('data_entrevista'),
        document.getElementById('familia_show'),
        document.getElementById('data_entre')
      ];

      // Função para alternar visibilidade
      function toggleVisibility(target) {
        const ocult2 = document.querySelector('.ocult2');
        if (target.innerHTML.trim() !== '') {
          target.classList.remove('ocult');
          target.classList.add('visible');
          ocult2.classList.remove('ocult'); // Mostra a div ocult2 se houver conteúdo
        } else {
          target.classList.remove('visible');
          target.classList.add('ocult');
          if (Array.from(targets).every(t => t.innerHTML.trim() === '')) {
            ocult2.classList.add('ocult'); // Oculta a div ocult2 se todos os alvos estiverem vazios
          }
        }
      }

      targets.forEach(target => {
        // Observador de mutações para monitorar mudanças no conteúdo
        const observer = new MutationObserver(function(mutationsList) {
          for (const mutation of mutationsList) {
            if (mutation.type === 'childList') {
              toggleVisibility(target);
            }
          }
        });

        // Configurações do observer: observar mudanças nos filhos da div
        const config = {
          childList: true,
          subtree: true
        };

        // Inicia o observer
        observer.observe(target, config);

        // Verificação inicial para o caso de a div já ter conteúdo no carregamento
        toggleVisibility(target);
      });
    });
  </script>

</body>

</html>