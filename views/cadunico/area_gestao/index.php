<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/cadunico/area_gestor/gestor.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <script src="/TechSUAS/js/gestor.js"></script>

    <title>Área do Gestor - TechSUAS</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/area_gestor/h1-area_gestor.svg" alt="Título com imagem">
        </h1>
    </div>
    <div class="container">
        <div class="cont-btns">
            <div class="header_cont_buttom">
                <h2> MENU DE GESTÃO </h2>
            </div>
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
                    <button class="menu-button" onclick="location.href='/TechSUAS/views/cadunico/visitas/accompany_visits';">
                        <span class="material-symbols-outlined">
                            preview
                        </span>
                        Acompanhar Visitas
                    </button>
                </div>

                <div class="bt">
                    <button class="menu-button" onclick=voltarMenu()>
                        Voltar ao menu
                        <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="mural_stats">
            <h2>PENDENCIAS GERAIS</h2>

            <div class="cont-a">
                <button class="menu-button" onclick="unipessoal()">LISTA DO PUBLICO UNIPESSOAL</button>
                <a href="#" class="modal-trigger">CADASTROS ATUALIZADOS COM DATAS DIVERGENTES</a>
                <a href="#" class="modal-trigger">CADASTROS SEM RESPONSAVEL FAMILIAR </a>
                <a href="#" class="modal-trigger">CADASTROS SEM CPF </a>
                <a href="#" class="modal-trigger">VISITAS RELIZADAS SEM RELATORIO</a>
                <a href="#" class="modal-trigger">AVERIGUAÇÕES (UNIPESSOAIS - RENDA - P3)</a>
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="myModal" class="modal">

            <div class="container_modal">
                <div class="header-title">
                    <h1 id="modalTitle">Famílias unipessoais com upload</h1>
                    <span class="close">&times;</span>
                </div>
                <div class="header">
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <p id="modalDescription"></p>

                </div>
                <div class="body-cont">
                    <div class="search-results">
                        <h2>Resultado da pesquisa</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Código familiar</th>
                                    <th>Endereço</th>
                                    <th>Nome do RUF</th>
                                    <th>CPF do RUF</th>
                                    <th>Tipo de RUF</th>
                                    <th>Estado Cadastral</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>156644304</td>
                                    <td>COLONIA - SITIO COLONIA, 2001</td>
                                    <td>ZENILDA FERREIRA RODRIGUES</td>
                                    <td>769.190.134-87</td>
                                    <td>Responsável Familiar</td>
                                    <td>
                                        <button class="action">Cadastrado</button>
                                    </td>
                                    <td>
                                        <button class="action">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination">
                        <div class="page-item">
                            <a href="#">&lt;</a>
                        </div>
                        <div class="page-item active">
                            <a href="#">1</a>
                        </div>
                        <div class="page-item">
                            <a href="#">&gt;</a>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button class="close">Voltar</button>
                </div>

            </div>
        </div>

        <!-- CADASTROS Formulário para filtrar informações do cadastro
        <form method="post" id="simples">
            <label for="">NOME:</label>
            <input type="text" name="nome_pessoa" />
            <label for="">Código Familiar</label>
            <input type="text" name="codigo_familia">
            <button type="submit" name="btn_filtro_familia">Buscar</button>
        </form> -->

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
                                    echo $entrevis; ?>
                                </td>
                                <td><?php echo $linha['soma_entrev_cad']; ?></td>
                                <td><a href="resultado?nome_entrevistador=<?php echo $linha['nom_entrevistador_fam']; ?>">Filtrar</a>
                                </td>
                            </tr>

                        <?php } ?>
                    </table>
                <?php }
            } else {
                $smtp_filtros = "SELECT COUNT(*) AS soma_entrev_cad, nom_entrevistador_fam 
        FROM tbl_tudo 
        WHERE nom_entrevistador_fam LIKE '%$entrevistador%'
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
                                <td><?php echo $linha['nom_entrevistador_fam']; ?></td>
                                <td><?php echo $linha['soma_entrev_cad']; ?></td>
                                <td><a href="resultado?nome_entrevistador=<?php echo $linha['nom_entrevistador_fam']; ?>">Filtrar</a>
                                </td>
                            </tr>

                        <?php } ?>
                    </table>
        <?php }
            }
        }
        ?>
    </div>
    <script>
        $(document).ready(function() {
            $('#btn_benef').on('click', function() {
                $('#simples').hide();
                $('#beneficio').show();
                $('#entrevistadores').hide();
            });

            $('#btn_entrevistadores').on('click', function() {
                $('#simples').hide();
                $('#beneficio').hide();
                $('#entrevistadores').show();
            });
        });

        var modal = document.getElementById("myModal");
        var closeButtons = document.querySelectorAll(".close");
        var modalTriggers = document.querySelectorAll(".modal-trigger");


        modalTriggers.forEach(function(trigger) {
            trigger.addEventListener("click", function(event) {
                event.preventDefault();
                document.getElementById("modalTitle").innerText = this.innerText;
                document.getElementById("modalDescription").innerText = "Descrição para " + this.innerText;
                modal.style.display = "block";
            });
        });


        closeButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                modal.style.display = "none";
            });
        });

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>