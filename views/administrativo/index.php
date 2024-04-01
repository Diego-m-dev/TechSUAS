<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="/TechSUAS/css/administrativo/style_menu.css">
    <title>Administrativo</title>
</head>
<body>
<div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/administrativo/h1-adm.svg" alt="Titulocomimagem">
        </h1>
</div>
<div class="apelido">    
        <h3>Bem-vindo (a)
            <?php echo $apelido; ?>.
        </h3> 
    </div> 
        <div class="container">
            <nav>
            <div class="btn">
                    <a class="menu-button" id="cadastrar_empresa" onclick="window.location.href='/TechSUAS/views/administrativo/cadastro_empresa'">
                        <span class="material-symbols-outlined">
                        contract_edit
                        </span>
                        Cadastrar Empresas
                    </a>
                </div>
                <div class="btn">
                    <a class="menu-button" id="cadastrar_contrato" onclick="window.location.href='/TechSUAS/views/administrativo/cadastro_contrato'">
                        <span class="material-symbols-outlined">
                        contract_edit
                        </span>
                        Cadastrar Contratos
                    </a>
                </div>
                <div class="btn">
                    <a class="menu-button" id="cadastrar_contrato" onclick="window.location.href='/Suas-Tech/suas/views/adm/contratos'">
                        <span class="material-symbols-outlined">
                        contract
                        </span>
                        Consultar Contratos
                    </a>
                </div>
                <div class="btn">
                    <a class="menu-button" id="cadastrar_contrato" onclick="window.location.href='#'">
                        <span class="material-symbols-outlined">
                        move_up
                        </span>
                        Apostilamento
                    </a>
                </div>
            </nav>
            
        </div>
        <footer><img src="/TechSUAS/img/geral/footer.svg" alt=""></footer>
        <div class="drop-all">
            <div class="menu-drop">
                <button class="logout" type="button" name="drop">
                    <span class="material-symbols-outlined">
                        Settings
                    </span>
                    <div class="drop-content">
                        <a title="Sair" href='../../../config/logout.php' ;>
                            <span title="Sair" class="material-symbols-outlined">logout</span>
                        </a>
                        <a title="Alterar Usuário" href='../../../cras/views/conta.php' ;>
                            <span class="material-symbols-outlined">manage_accounts</span>
                        </a>
                        <?php
if ($nivel == 'suport') {
    ?> <a title="Suporte" href='/Suas-Tech/acesso_suporte/index.php' ;>
                                <span class="material-symbols-outlined">rule_settings</span>
                            </a> <?php
exit();
}
?>
        </div>

</body>
</html>

