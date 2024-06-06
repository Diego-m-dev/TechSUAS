<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro Único</title>
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_index_cad.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
</head>

<body>
  <div class="img">
    <h1 class="titulo-com-imagem">
      <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/h1-menu.svg" alt="Título com imagem">
    </h1>
  </div>

  <div class="apelido">
    <h3>Bem-vindo(a) <?php echo $_SESSION['apelido']; ?>.</h3>
  </div>

  <div class="tudo">
    <div class="container">
      <div class="menu">
        <nav>
          <div class="formularios">
            <a class="menu-button" href="/TechSUAS/views/cadunico/forms/index">
              <span class="material-symbols-outlined">forms_add_on</span>
              Formulários
            </a>
          </div>

          <div class="parecer">
            <a class="menu-button" href="/TechSUAS/views/cadunico/visitas/index">
              <span class="material-symbols-outlined">location_away</span>
              Visitas
            </a>
          </div>

          <div class="visitas">
            <a class="menu-button" href="/TechSUAS/views/cadunico/folha/folha">
              <span class="material-symbols-outlined">request_quote</span>
              Folha de Pagamento
            </a>
          </div>

          <div class="folha">
            <a class="menu-button" href="/TechSUAS/views/cadunico/declaracoes/index">
              <span class="material-symbols-outlined">quick_reference_all</span>
              Declarações Cadastro Único
            </a>
          </div>

          <div class="folha">
            <a class="menu-button" href="/TechSUAS/views/cadunico/links">
              <span class="material-symbols-outlined">link</span>
              Links Úteis
            </a>
          </div>

          <div class="atendimento">
            <a class="menu-button" href="/TechSUAS/views/cadunico/msn_cad/index">
              <span class="material-symbols-outlined">contacts</span>
              Mensagens do CadÚnico
            </a>
          </div>

          <div class="peixe">
            <a class="menu-button" href="/TechSUAS/views/cadunico/area_gestao/index">
              <span class="material-symbols-outlined">person</span>
              Área do Gestor
            </a>
          </div>
        </nav>
      </div>
    </div>
  </div>

  <div class="calend">
    <div class="calendendario">
      <img class="calendario" src="/TechSUAS/img/cadunico/calend.svg" alt="Calendário">
    </div>
  </div>

  <footer>
    <img src="/TechSUAS/img/geral/footer.svg" alt="Rodapé">
  </footer>

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
        <?php if ($_SESSION['nivel_usuario'] == 'suport') { ?>
          <a title="Suporte" href="/TechSUAS/config/back">
            <span class="material-symbols-outlined">rule_settings</span>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

</body>

</html>
