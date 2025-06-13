<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

  $data5yearsago = new DateTime();
  $data5yearsago->modify('-5 years');
  $data5yearsagoFormatada = $data5yearsago->format('Y-m-d');
    $stmt_up_5 = $pdo->prepare("SELECT id FROM cadastro_forms WHERE data_entrevista < :data5yearsago");
    $stmt_up_5->bindValue(":data5yearsago", $data5yearsagoFormatada);
    $stmt_up_5->execute();

  $stmt_up = $pdo->prepare("SELECT c.id
    FROM cadastro_forms c
    LEFT JOIN tbl_tudo t ON t.cod_familiar_fam = c.cod_familiar_fam
    WHERE t.cod_familiar_fam IS NULL AND c.certo != 1 AND (c.operador = :operador OR c.operador = :cpfOperador)
    GROUP BY c.id
    ORDER BY c.criacao ASC
    ");
    $cpf_limpo = preg_replace('/\D/', '', $_SESSION['cpf']);
    $operador = $_SESSION['nome_usuario'];
    $stmt_up->execute(array(
      'operador' => $operador,
      'cpfOperador' => $cpf_limpo
    ));

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
  <!-- Botão de menu flutuante -->
  <button class="menu-toggle" onclick="toggleMenu()" aria-label="Abrir/Fechar menu">☰</button>
  
  <div class="conteiner">
    <!-- Título discreto -->
    <h1 class="page-title">PAINEL DO ENTREVISTADOR</h1>
    
    <?php 
    if ($stmt_up->rowCount() > 0) {
      ?>
    <a id="notification" onclick="notification()" aria-label="Notificações importantes">
      <span class="material-symbols-outlined">
        notification_important
      </span>
    </a>
      <?php
    } elseif ($stmt_up_5->rowCount() > 0 && $_SESSION['funcao'] == 1) {
      ?>
    <a id="notification" onclick="notification_5years()" aria-label="Notificações importantes">
      <span class="material-symbols-outlined">
        notification_important
      </span>
    </a>
      <?php
    } else {
      # code...
    }
    ?>

    <form id="cadastroForm" enctype="multipart/form-data">

      <!--FORMULARIO PARA IDENTIFICAÇÃO DA ENTREVISTA-->
        <div class="bloc">
          <div class="bloc1">
            <div class="form-group">
              <label for="arquivo">Arquivo:</label>
              <input type="file" id="arquivo" name="arquivo" accept="application/pdf" onchange="exibir()" required>
            </div>
            
            <div class="form-group">
              <label for="codfamiliar">Código familiar:</label>
              <input type="text" name="cod_fam" id="codfamiliar" onchange="buscarDadosFamily()" required />
            </div>
            
            <div class="form-group">
              <label for="data_entrevista">Data da Entrevista:</label>
              <input type="date" id="data_entrevista_hoje" name="data_entrevista_hoje">
            </div>
            
            <div class="form-group">
              <label for="sit_beneficio">Situação do benefício:</label>
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
            
            <div class="form-group">
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
          </div>

          <div class="ocult2">
            <div id="codfamiliar_print" class="ocult"></div>
            <div id="familia_show" class="ocult"></div>
            <div id="arquivo_show"></div>
            <div class="pdf-container">
              <iframe id="pdfViewer" width="100%" height="300px"></iframe>
            </div>
          </div>
        </div><!-- Fecha a div bloc -->
        
        <!-- Área de observação com exibição condicional -->
        <div class="observ">
          <div class="observ-header" onclick="toggleObservacao()">OBSERVAÇÃO</div>
          <div class="observ-content" id="observ-content">
            <textarea name="resumo" id="resumo" placeholder="Se houve alguma observação durante a entrevista registre-a."></textarea>
          </div>
        </div> <!-- Fecha a div observ -->

        <div id="ultimas_feita" class="fadeIn"></div>

        <div class="bloc">
          <div class="btn">
            <button type="submit">Cadastrar</button>
            <div id="success-icon" style="display: none;">
              <span class="material-symbols-outlined">check</span>
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

    <!-- Ícone para últimos registros -->
    <div class="registro-icon" aria-label="Ver últimos registros">
      <span class="material-symbols-outlined">history</span>
    </div>
    
    <!-- Conteúdo dos últimos registros (aparece no hover) -->
    <div id="ultimo_registro"></div>

<!-- Menu Lateral -->
<div id="sidebar" class="sidebar">
  <h3>MENU</h3>

  <nav>
    <button class="section-btn" onclick="toggleSection('declaracoes')">Fichas e Declarações</button>
    <div id="declaracoes" class="section-content">
      <a id="btn_residencia"><i class="fas fa-home icon"></i>Declaração de Residência</a>
      <a id="btn_dec_renda"><i class="fas fa-file-invoice-dollar icon"></i>Declaração de Renda</a>
      <a id="btn_fc_familia"><i class="fas fa-user-minus icon"></i>Exclusão de Família</a>
      <a id="btn_fc_pessoa"><i class="fas fa-user-minus icon"></i>Exclusão de Pessoa</a>
    </div>
  </nav>

  <nav>
    <button class="section-btn" onclick="toggleSection('termos')">Documentos</button>
    <div id="termos" class="section-content">
      <a id="btn_dec_cad"><i class="material-symbols-outlined">assignment_add</i> Declaração do Cadastro Único</a>
      <a id="btn_encamnhamento"><i class="material-symbols-outlined">export_notes</i> Encaminhamentos</a>
      <a id="btn_des_vol"><i class="material-symbols-outlined">contract_delete</i> Desligamento Voluntário</a>
      <a id="btn_troca"><i class="material-symbols-outlined">quick_reference</i> Troca de RF - C.E.F.</a>
      <a id="relatorio_entrevistador"><i class="material-symbols-outlined">analytics</i>Relatório Mensal</a>
    </div>
  </nav>

  <nav>
    <button class="section-btn" onclick="toggleSection('visitas')">Visitas</button>
    <div id="visitas" class="section-content">
      <a href="/TechSUAS/views/cadunico/visitas/buscarvisita"><span class="material-symbols-outlined">description</span>Gerar Relatórios</a>
      <a href="/TechSUAS/views/cadunico/visitas/visitas_para_fazer"><span class="material-symbols-outlined">family_restroom</span>Buscar Famílias (ano,mes,localidade)</a>
      <a href="/TechSUAS/views/cadunico/visitas/visitas_para_fazer_data"><span class="material-symbols-outlined">filter_alt</span>Filtrar Famílias - Visitas</a>
      <a id="registrar_visita" onclick="registrarVisita()"><span class="material-symbols-outlined">checkbook</span>Registrar Visitas</a>
      <a id="visitas_agendadas" onclick="visitasAgendades()"><span class="material-symbols-outlined">calendar_month</span>Visitas Agendadas</a>
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
    <button class="btn_separado" type="button" onclick="voltaMenu()">Menu navegação</button>
    <button class="btn_separado" type="button" onclick="peixinho()">Cadastro Peixe</button>
    <button class="btn_separado" type="button" id="solicitaFormButton" onclick="solicitaForm()">Solicitar Formulário</button>
  </nav>

  <nav>
    <button class="section-btn" onclick="toggleSection('formularios')">ATIVIDADE EXTERNA</button>
    <div id="formularios" class="section-content">
      <a id="btn_atendimento_acao" onclick="atendimento_acao_cadu()">
        <i class="material-symbols-outlined">assignment_add</i>
        Atendimento
      </a>
      <a id="btn_control_playlist" onclick="abrirConfiguradorPlaylist()">
        <i class="material-symbols-outlined">playlist_play</i> Playlist YouTube
      </a>
    </div>
  </nav>
</div>

  </div>

  <div class="drop-all">
    <div class="menu-drop">
        <button class="logout" type="button" name="drop">
            <span class="material-symbols-outlined">settings</span>
        </button>
        <div class="drop-content">
            <a title="Sair" href="/TechSUAS/config/logout">
                <span title="Sair" class="material-symbols-outlined">logout</span>
            </a>
            <a title="Alterar Usuário" href="/TechSUAS/views/geral/conta">
                <span class="material-symbols-outlined">manage_accounts</span>
            </a>
            <?php if ($_SESSION['funcao'] == '0') { ?>
                <a title="Suporte" href="/TechSUAS/config/back">
                    <span class="material-symbols-outlined">rule_settings</span>
                </a>
            <?php } ?>
        </div>
    </div>
</div>

  <?php
  $conn_1->close();
  $conn->close();
  ?>
  <script>
    // Função para exibir o PDF quando um arquivo for selecionado
    function exibir() {
      const fileInput = document.getElementById("arquivo");
      const file = fileInput.files[0]; // Obtém o arquivo selecionado

      if (file && file.type === "application/pdf") {
        const fileURL = URL.createObjectURL(file); // Cria uma URL temporária para o arquivo
        document.getElementById("pdfViewer").src = fileURL; // Define a URL no iframe
        document.getElementById("pdfViewer").style.display = "block"; // Exibe o iframe
        
        // Exibe a div ocult2 quando um arquivo é selecionado
        document.querySelector('.ocult2').classList.remove('ocult');
      } else if (file) {
        alert("Por favor, selecione um arquivo PDF.");
        document.getElementById("pdfViewer").style.display = "none"; // Esconde o iframe se não for PDF
      }
    }

    // Função para alternar o menu lateral
    function toggleMenu() {
      document.getElementById("sidebar").classList.toggle("active");
    }

    // Função para alternar seções do menu
    function toggleSection(sectionId) {
      var section = document.getElementById(sectionId);
      if (section.style.display === "block") {
        section.style.display = "none";
      } else {
        section.style.display = "block";
      }
    }
    
    // Função para alternar a visibilidade do campo de observação
    function toggleObservacao() {
      const header = document.querySelector('.observ-header');
      const content = document.getElementById('observ-content');
      
      header.classList.toggle('active');
      content.classList.toggle('active');
    }

    // Configurações ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
      // Menu começa fechado por padrão (não ativa o sidebar)
      
      // Configura a data atual no campo de data
      const today = new Date();
      const formattedDate = today.toISOString().split('T')[0];
      document.getElementById('data_entrevista_hoje').value = formattedDate;
      
      // Observador para os elementos que mostram dados
      const targets = [
        document.getElementById('codfamiliar_print'),
        document.getElementById('familia_show')
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
          
          // Verifica se há um PDF exibido
          const pdfViewer = document.getElementById('pdfViewer');
          const hasPdf = pdfViewer.style.display === 'block' && pdfViewer.src;
          
          // Só oculta a div ocult2 se não houver conteúdo em nenhum alvo e não houver PDF
          if (Array.from(targets).every(t => t.innerHTML.trim() === '') && !hasPdf) {
            ocult2.classList.add('ocult');
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

    // Configuração do formulário AJAX
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
                  location.reload() // Recarrega a página atual
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
              text: `Ocorreu um erro ao tentar cadastrar os dados. ${xhr} - ${status} - ${error}`,
              icon: 'error',
              confirmButtonText: 'Ok'
            })
          }
        })
      })
    })
  </script>

</body>
</html>
