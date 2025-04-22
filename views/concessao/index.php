<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_conc.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Concessão - TechSUAS</title>
</head>

<body>

    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/concessao/h1-concessao.svg" alt="Titulocomimagem">
        </h1>
    </div>
        <div class="apelido">
            <h3>Bem-vindo (a)
                <?php echo $_SESSION['apelido']; ?>.
            </h3>
        </div>
        <div class="container">
            <div class="menu">
                <nav>
<?php
  if ($_SESSION['funcao'] == '1') {
?>
      <div class="btn">
        <a class="menu-button" href="/TechSUAS/views/geral/cadastro_user">
          Cadastrar Operador
        </a>
      </div>
<?php
  }
?>
                    <div class="btn">
                        <a class="menu-button" id="cadastrar_contrato" onclick="location.href='cadastro_pessoa';">
                            <span class="material-symbols-outlined">
                            person_add
                            </span>
                            Cadastrar Responsável
                        </a>
                    </div>
                    <div class="btn">
                        <a class="menu-button" id="cadastrar_contrato" onclick="location.href='cadastro_item';">
                            <span class="material-symbols-outlined">
                            add_box
                            </span>
                            Cadastrar Itens
                        </a>
                    </div>
                    <div class="btn">
                        <a class="menu-button" id="cadastrar_contrato" onclick="window.location.href='consultar'">
                            <span class="material-symbols-outlined">
                            content_paste_search
                            </span>
                            Consultar Concessão
                        </a>
                    </div>
                    <div class="btn">
                        <a class="menu-button" id="cadastrar_contrato" onclick="location.href='gerar_form';">
                            <span class="material-symbols-outlined">
                            inventory
                            </span>
                            Gerar Formulário 
                        </a>
                    </div>
                    <div class="btn">
                        <a class="menu-button" id="cadastrar_contrato" onclick="location.href='gerar_relatorio';">
                            <span class="material-symbols-outlined">
                            inventory
                            </span>
                            Gerar Relatório
                        </a>
                    </div>
                </nav>
            </div>
            <div class="mural">
        <h4><span class="material-symbols-outlined">campaign</span>Mural de Avisos</h4>

        </div>

        </div>

        <footer><img src="/TechSUAS/img/geral/footer.svg" alt=""></footer>
        <div class="drop-all">
            <div class="menu-drop">
                <button class="logout" type="button" name="drop">
                    <span class="material-symbols-outlined">
                        Settings
                    </span>
                    <div class="drop-content">
                        <a title="Sair" href='/TechSUAS/config/logout' ;>
                            <span title="Sair" class="material-symbols-outlined">logout</span>
                        </a>
                        <a title="Alterar Usuário" href='/TechSUAS/views/geral/conta' ;>
                            <span class="material-symbols-outlined">manage_accounts</span>
                        </a>
                        <?php
if ($_SESSION['funcao'] == '0') {
    ?> <a title="Suporte" href='/TechSUAS/suporte/' ;>
        <span class="material-symbols-outlined">rule_settings</span>
    </a> <?php
exit();
}
$conn_1->close();
?>
        </div>

</body>

</html>