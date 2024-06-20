<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
if ($_SESSION['funcao'] != '1') {
    echo '<script>window.history.back()</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/cadunico/area_gestor/gestor.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <title>Área do Gestor</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/h1-area_gestor.svg" alt="Título com imagem">
        </h1>
    </div>
    <div class="container">
        <!-- <div class="cont-btns">
            <div class="btns">
                <div class="bt">
                    <button type="button" class="menu-button" id="btn_benef">
                        <span class="material-symbols-outlined">quick_reference_all</span> Consultar Benefício
                    </button>
                </div>

                <div class="bt">
                    <button type="button" class="menu-button" id="btn_entrevistadores">
                        <span class="material-symbols-outlined">group</span>
                        Entrevistadores
                    </button>
                </div>
                <div class="bt">
                    <button type="button" class="menu-button"
                        onclick="window.location.href = '/TechSUAS/views/cadunico/area_gestao/index';">
                        <span class="material-symbols-outlined">frame_reload</span>
                        Atualizar
                    </button>
                </div>
                <div class="bt">
                    <button class="menu-button" onclick="location.href='/TechSUAS/views/cadunico/area_gestao/filtros';">
                        <span class="material-symbols-outlined">
                            search_insights</span>
                        Consultar Famílias
                    </button>

                </div>
                <div class="bt">

                    <button class="menu-button" onclick="location.href='/TechSUAS/views/geral/atualizar_tabela';">
                        <span class="material-symbols-outlined">
                            library_add
                        </span>
                        Importar Banco de Dados
                    </button>
                </div>
                <div class="bt">


                    <button class="menu-button"
                        onclick="location.href='/TechSUAS/views/cadunico/visitas/accompany_visits';">
                        <span class="material-symbols-outlined">
                            preview
                        </span>
                        Acompanhar Visitas
                    </button>
                </div>
            </div>
        </div> -->
        <div class="mural_stats">
            <div class="header">
                <h1>Estatisticas Geral - Cadunico (cidade)</h1>
            </div>
            <div class="row">

                <div class="card">
                    <div class="card-header">
                        <p>CADASTROS NO MUNICIPIO:</p>
                    </div>

                    <div class="card-content">
                        <div class="card-value">
                            <p>CADASTROS DATA DIVERGENTE:</p>
                            <p>CADASTROS SEM CPF:</p>
                            <p>CADASTROS SEM RF:</p>
                        </div>
                    </div>
                    <span> icon </span>
                </div>
                <div class="card">
                    <div class="card-header">
                        <p>FAMILIAS COM BENEFÍCIOS:</p>
                    </div>

                    <div class="card-content">
                        <div class="card-value">
                            <p>UNIPESSOAIS:</p>
                            <p>PENDENCIAS:</p>
                            <p>VALE GAS:</p>
                            <p>PBF</p>
                        </div>
                    </div>
                    <span> icon </span>
                </div>

                <div class="card">
                    <div class="card-header">
                        TOTAL DE VISITAS:
                    </div>

                    <div class="card-content">
                        <div class="card-value">
                            <p>PUBLICO 3:</p>
                            <p>AV RENDA:</p>
                            <p>REVISAO:</p>
                            <p>EXCLUSAO:</p>
                        </div>
                    </div>
                    <span> icon </span>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        INDICADOR 5
                    </div>

                    <div class="card-content">
                        <div class="card-value">
                            xxxx
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        INDICADOR 6
                    </div>

                    <div class="card-content">
                        <div class="card-value">
                            xxxx
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        INDICADOR 7
                    </div>

                    <div class="card-content">
                        <div class="card-value">
                            xxxx
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        INDICADOR 8

                        <div class="card-content">
                            <div class="card-value">
                                xxxx
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- CADASTROS Formulário para filtrar informações do cadastro-->
        <form method="post" id="simples">
            <label for="">NOME:</label>
            <input type="text" name="nome_pessoa" />
            <label for="">Código Familiar</label>
            <input type="text" name="codigo_familia">
            <button type="submit" name="btn_filtro_familia">Buscar</button>
        </form>

        <!-- BENEFÍCIOS Formulário para filtrar informações do beneficiário-->
        <form action="" method="post" id="beneficio">
            <label for="">NIS:</label>
            <input type="text" name="nis_benef" />
            <button type="submit" name="btn_filtro_benef">Buscar</button>
        </form>

        <!-- ENTREVISTADORES Formulário para filtrar Entrevistadores -->
        <form action="" method="post" id="entrevistadores">
            <label for="">
                NOME Entrevistador(a):
                <input type="text" name="nome_entrev" />
            </label>
            <button type="submit" name="btn_filtro_entrev">Buscar</button>
        </form>

        <?php

        if (!isset($_POST['btn_filtro_familia']) && !isset($_POST['btn_filtro_benef']) && !isset($_POST['btn_filtro_entrev'])) {
        } elseif (isset($_POST['btn_filtro_familia']) && !isset($_POST['btn_filtro_benef']) && !isset($_POST['btn_filtro_entrev'])) {

            //TRATANDO OS DADOS DA FAMILIA
            if (isset($_POST['nome_pessoa'])) {
                $filtro = $conn->real_escape_string($_POST['nome_pessoa']);

                $smtp_filtro = $conn->prepare("SELECT * FROM tbl_tudo
        WHERE nom_pessoa LIKE '%$filtro%'");
                $smtp_filtro->execute();
                $resultado = $smtp_filtro->get_result(); // Obter o resultado da consulta
                $dados_filtros = $resultado->fetch_all(MYSQLI_ASSOC); // Obter todas as linhas como uma matriz associativa
        
            } elseif (isset($_POST['codigo_familia'])) {
                $filtro = $conn->real_escape_string($_POST['codigo_familia']);
            } else {
                // Se nenhum dos campos estiver definido, você pode definir um valor padrão para $filtro ou tomar outra ação adequada.
            }
            $smtp_filtros = $conn->prepare("SELECT COUNT(*) AS totais_cadastro
                                    FROM tbl_tudo
                                    WHERE cod_parentesco_rf_pessoa = 1");
            $smtp_filtros->execute();

            $result = $smtp_filtros->get_result();
            $dados_filtro = $result->fetch_all(MYSQLI_ASSOC);



            if (!empty($dados_filtro)) {
                // A contagem total estará na primeira linha da matriz
                $total_cadastros = $dados_filtro[0]['totais_cadastro'];
                echo "Total de famílias cadastradas: $total_cadastros";
            } else {
                echo "Nenhum resultado encontrado.";
            }
        } elseif (!isset($_POST['btn_filtro_familia']) && !isset($_POST['btn_filtro_benef']) && isset($_POST['btn_filtro_entrev'])) {

            //TRATANDO COM OS ENTREVISTADORES
            $entrevistador = $_POST['nome_entrev'];
            if ($entrevistador == "") {
                $smtp_filtros = "SELECT COUNT(*) AS soma_entrev_cad, nom_entrevistador_fam 
        FROM tbl_tudo 
        WHERE cod_parentesco_rf_pessoa = 1 
        GROUP BY nom_entrevistador_fam 
        ORDER BY nom_entrevistador_fam ASC";

                $resultado_entrev = $conn->query($smtp_filtros);

                if ($resultado_entrev->num_rows > 0) {

                    ?>
                    <table border="1">
                        <tr>
                            <th>Entrevistador</th>
                            <th>Quantidade total</th>
                            <th>Ação</th>
                        </tr>
                        <?php
                        while ($linha = $resultado_entrev->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php $entrev = $linha['nom_entrevistador_fam'];
                                if ($entrev == null) {
                                    $entrevis = "Origem Cadastro: APP";
                                } else {
                                    $entrevis = $linha['nom_entrevistador_fam'];
                                }
                                echo $entrevis;
                                ?></td>
                                <td><?php echo $linha['soma_entrev_cad']; ?></td>
                                <td>
                                    <form action="/TechSUAS/controller/cadunico/area_gestor/detalhe_entrevistador" method="post"
                                        style="display:inline;">
                                        <input type="hidden" name="detalhe" value="<?php echo $linha['nom_entrevistador_fam']; ?>">
                                        <button type="submit" target="_blank">VER</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                }
            }
        } elseif (!isset($_POST['btn_filtro_familia']) && isset($_POST['btn_filtro_benef']) && !isset($_POST['btn_filtro_entrev'])) {

            //BENEFÍCIOS
            echo $_POST['nis_benef'];
        }

        ?>
    </div>
</body>

</html>