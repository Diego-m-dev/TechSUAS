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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="/TechSUAS/js/cadastro_unico.js"></script>

  <title>Painel do Entrevistador - TechSUAS</title>
</head>

<body>
  <div class="conteiner">
    <form id="cadastroForm" enctype="multipart/form-data">

        <!--FORMULARIO PARA IDENTIFICAÇÃO DA ENTREVISTA-->
        <div class="bloc">
          <div class="bloc1">
  
            <label for="arquivo">Arquivo:</label>
            <input type="file" id="arquivo" name="arquivo" accept="application/pdf" onchange="exibir()" required>
<hr>
              <label for="codfamiliar">Código familiar:</label>
              <input type="text" name="cod_fam" id="codfamiliar" onchange="buscarDadosFamily()" required />
<hr>
              <label for="data_entrevista">Data da Entrevista:</label>
              <input type="date" id="data_entrevista_hoje" name="data_entrevista_hoje">
<hr>
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
<hr>
              <label for="tipo_documento">Tipo de Documento:</label>
            <select name="tipo_documento" id="tipo_documento" required>
              <option value="" disabled selected hidden>Selecione o tipo</option>
              <option value="Cadastro">Cadastro</option>
              <option value="Atualização">Atualização</option>
              <option value="Assinatura">Assinatura</option>
              <option value="Fichas exclusão">Fichas exclusão</option>
              <option value="Relatórios">Relatórios</option>
              <option value="Parecer visitas">Parecer visitas</option>
              <option value="Documento externo">Documento externo</option>
              <option value="Termos">Termos</option>
            </select>

        </div>

        <div class="ocult2">
          <div id="codfamiliar_print" class="ocult"></div>
          <div id="familia_show" class="ocult"></div>
          <div id="arquivo_show" class="ocult"></div>
          <div>
            <iframe id="pdfViewer" width="100%" height="100px" style="display: none;"></iframe>
          </div>
        </div>


      </div><!-- Fecha a div bloc -->
        <div class="observ">
            <label for="resumo">Observação:</label>
              <div><textarea name="resumo" id="resumo" placeholder="Se houve alguma observação durante a entrevista registre-a."></textarea></div>
        </div> <!-- Fecha a div observ -->

        <div id="ultimas_feita"></div>

        <div class="bloc">
          <div class="btn">
              <button type="submit">Cadastrar</button>
            <div id="success-icon" style="display: none;">
              <span class="material-symbols-outlined">
                check
              </span>
            </div> <!-- Fecha a div success-icon -->
          </div> <!-- Fecha a div btn -->
          <div class="btn">
        <?php
        if ($_SESSION['acao_cadu'] === true) {

          ?>
          <script>
                const acaoCadu = "<?php echo $_SESSION['guiche']; ?>";
          </script>
            <button type="button" onclick="chamaProximo(acaoCadu)">Chamar</button>
          <?php
        }
        ?>
      </div> <!-- Fecha a div btn -->

        </div> <!-- Fecha a div bloc -->
      </form>
    </div> <!-- Fecha a div container -->

    <div id="ultimo_registro"></div>

<!-- Menu Lateral -->
<div id="sidebar" class="sidebar">
  <h3>AÇÃO RÁPIDA:</h3>
  <button class="close-btn" onclick="toggleMenu()">☰</button>

  <nav>
    <button class="section-btn" onclick="toggleSection('declaracoes')">Fichas e Declarações</button>
    <div id="declaracoes" class="section-content">
      <a id="btn_residencia"><i class="fas fa-home icon"></i> Declaração de Residência</a>
      <a id="btn_dec_renda"><i class="fas fa-file-invoice-dollar icon"></i> Declaração de Renda</a>
      <a id="btn_fc_familia"><i class="fas fa-user-minus icon"></i> Exclusão de Família</a>
      <a id="btn_fc_pessoa"><i class="fas fa-user-minus icon"></i> Exclusão de Pessoa</a>
    </div>
  </nav>

  <nav>
    <button class="section-btn" onclick="toggleSection('termos')">Documentos</button>
    <div id="termos" class="section-content">
      <a id="btn_dec_cad"><i class="material-symbols-outlined">assignment_add</i> Declaração do Cadastro Único</a>
      <a id="btn_encamnhamento"><i class="material-symbols-outlined">export_notes</i> Encaminhamentos</a>
      <a id="btn_des_vol"><i class="material-symbols-outlined">contract_delete</i> Desligamento Voluntário</a>
      <a id="btn_troca"><i class="material-symbols-outlined">quick_reference</i> Troca de RF - C.E.F.</a>
    </div>
  </nav>

  <nav>
    <button class="section-btn" onclick="toggleSection('links')">Links Úteis</button>
    <div id="links" class="section-content">
      <a href="https://www.beneficiossociais.caixa.gov.br" target="_blank">SIBEC</a>
      <a href="http://cadastrounico.caixa.gov.br" target="_blank">Cadastro Único</a>
      <a href="https://cecad.cidadania.gov.br/painel03.php" target="_blank">CECAD</a>
      <a href="https://cadunico.dataprev.gov.br/portal/" target="_blank">Portal Cadastro Único</a>
      <a href="https://falemds.centralit.com.br/formulario/" target="_blank">Formulário Eletrônico do MDS</a>
      <a href="https://www.mds.gov.br/mds-sigpbf-web/carregarTelaLogin.jsf" target="_blank">SIGPBF</a>
    </div>
  </nav>

  <nav>
    <button class="btn_separado" id="btn_beneficios">Pendências</button>
    <button class="btn_separado" onclick="filtroFamilia()">Filtros Famílias</button>
  </nav>

  <nav>
    <br><button class="btn_separado" type="button" onclick="voltaMenu()">Menu navegação</button>
    <br><button class="btn_separado" type="button" onclick="peixinho()" style="margin-top: 3px;">Cadastro Peixe</button>
    <br><button class="btn_separado" type="button" id="solicitaFormButton" onclick="solicitaForm()">Solicitar Formulário</button>
    <br><button class="btn_separado" type="button" onclick="areaVisitas()">Visitas</button>
  </nav>

  <nav>
    <button class="section-btn" onclick="toggleSection('formularios')">ATIVIDADE EXTERNA</button>
    <div id="formularios" class="section-content">
      <a id="btn_atendimento_acao" onclick="atendimento_acao_cadu()"><i class="material-symbols-outlined">assignment_add</i>Atendimento</a>
    </div>
  </nav>
</div>

  </div>
  <?php
  $conn_1->close();
  $conn->close();
  ?>
  <script>

function exibir() {
    const fileInput = document.getElementById("arquivo");
    const file = fileInput.files[0]; // Obtém o arquivo selecionado

    if (file && file.type === "application/pdf") {
        const fileURL = URL.createObjectURL(file); // Cria uma URL temporária para o arquivo
        document.getElementById("pdfViewer").src = fileURL; // Define a URL no iframe
        document.getElementById("pdfViewer").style.display = "block"; // Exibe o iframe
    } else {
        alert("Por favor, selecione um arquivo PDF.");
        document.getElementById("pdfViewer").style.display = "none"; // Esconde o iframe se não for PDF
    }
}

  function toggleMenu() {
    document.getElementById("sidebar").classList.toggle("active");
  }

  function toggleSection(sectionId) {
    var section = document.getElementById(sectionId);
    if (section.style.display === "block") {
      section.style.display = "none";
    } else {
      section.style.display = "block";
    }
  }



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
            if (response.salvo) {
              Swal.fire({
                title: 'Sucesso!',
                text: response.mensagem,
                icon: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload(); // Recarrega a página atual
                }
              })
            } else {
              Swal.fire({
                title: 'Erro!',
                text: response.msg,
                icon: 'error',
                confirmButtonText: 'Ok'
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload(); // Recarrega a página atual
                }
              })
            }
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
        document.getElementById('familia_show')
      ]

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