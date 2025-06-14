<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/visitas/visitas_pend.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="/TechSUAS/js/entrevistadores.js"></script>
    <script src="/TechSUAS/js/gestor.js"></script>
    

</head>
<body>
    <?php
    if (!isset($_GET['ano_select'])) {
    ?>
        <p>Selecione ao menos o ano.</p>
        <p>Antes de realizar a visita domiciliar, é crucial consultar cadastro de cada família no sistema V7.</p>
    <?php
    } else {
    ?>
        <form action="/TechSUAS/controller/cadunico/parecer/visitas_does" method="POST">
          <input type="hidden" id="nisSelecionadosInput" name="nisSelecionadosInput">
            <div class="tabela">
                <table border="1">
                    <th class="btn_impr"><button type="submit" id="print">imprimir</button>
                      <td> <button type="button" id="comunic" onclick="comunicado()">gerar comunicado</button> </td>
                    </th>
                    
                    <tr class="titulo">
                        <th class="check">
                            <label class="urg">
                                <input type="checkbox" id="selecionarTodos">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th class="cabecalho">CÓDIGO FAMILIAR</th>
                        <th class="cabecalho">NOME</th>
                        <th class="cabecalho">DATA ATUALIZAÇÃO</th>
                        <th class="cabecalho">BAIRRO</th>
                        <th class="cabecalho">RUA</th>
                        <th class="cabecalho">VISITA FEITA POR</th>
                    </tr>
                    <?php
                    $sql_cod = $conn->real_escape_string($_GET['ano_select']);
                    $sqli_cod = $conn->real_escape_string($_GET['localidade']);
                    
                    if (empty($_GET['mes_select'])) {
                        $sql_dados = "SELECT t.cod_familiar_fam, t.num_nis_pessoa_atual, t.nom_pessoa, t.dat_atual_fam, t.nom_localidade_fam, t.nom_tip_logradouro_fam, t.nom_titulo_logradouro_fam, t.nom_logradouro_fam, t.num_logradouro_fam,
                            vis.entrevistador AS visfeit
                            FROM tbl_tudo t
                            LEFT JOIN visitas_feitas vis ON t.cod_familiar_fam = vis.cod_fam
                            WHERE t.dat_atual_fam LIKE '%$sql_cod%' 
                            AND t.nom_localidade_fam LIKE '%$sqli_cod%' 
                            AND t.cod_parentesco_rf_pessoa = 1
                            ORDER BY t.nom_localidade_fam ASC, t.num_logradouro_fam ASC";
                    } else {
                        $sqlm_cod = $_GET['mes_select'];
                        $sql_dados = "SELECT t.cod_familiar_fam, t.num_nis_pessoa_atual, t.nom_pessoa, t.dat_atual_fam, t.nom_localidade_fam, t.nom_tip_logradouro_fam, t.nom_titulo_logradouro_fam, t.nom_logradouro_fam, t.num_logradouro_fam,
                            vis.entrevistador AS visfeit
                            FROM tbl_tudo t
                            LEFT JOIN visitas_feitas vis ON t.cod_familiar_fam = vis.cod_fam
                            WHERE t.dat_atual_fam LIKE '%$sql_cod%' 
                            AND t.nom_localidade_fam LIKE '%$sqli_cod%' 
                            AND MONTH(t.dat_atual_fam) = '$sqlm_cod' 
                            AND t.cod_parentesco_rf_pessoa = 1
                            ORDER BY t.nom_localidade_fam ASC, t.num_logradouro_fam ASC";
                    }

                    $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn->error);

                    if ($sql_query->num_rows == 0) {
                    ?>
                        <tr class="resultado">
                            <td colspan="7">Nenhum resultado encontrado...</td>
                        </tr>
                    <?php
                    } else {
                        $num_result = $sql_query->num_rows;
                        if ($num_result == 1) {
                    ?>
                            <h5>Foi encontrado <?php echo $num_result; ?> resultado.</h5>
                        <?php
                        } else {
                        ?>
                            <h5>Foram encontrados <?php echo $num_result; ?> resultados.</h5>
                        <?php
                        }
                        $seq = 1;
                        while ($dados = $sql_query->fetch_assoc()) {
                        ?>
                            <tr class="resultado">
                                <td class="check">
                                    <label class="urg">
                                        <input type="checkbox" name="excluir[]" data-nis="<?php echo $dados['num_nis_pessoa_atual']; ?>" value="<?php echo $dados['num_nis_pessoa_atual']; ?>">
                                        <span class="checkmark"></span>
                                    </label>
                                </td>
                                <td class="resultado"><?php echo $dados['cod_familiar_fam']; ?></td>
                                <td class="resultado"><?php echo $dados['nom_pessoa']; ?></td>
                                <td class="resultado"><?php
                                                        $data = $dados['dat_atual_fam'];
                                                        if (!empty($data)) {
                                                            $formatando_data = DateTime::createFromFormat('Y-m-d', $data);
                                                            if ($formatando_data) {
                                                                $data_formatada = $formatando_data->format('d/m/Y');
                                                                echo $data_formatada;
                                                            } else {
                                                                echo "Data inválida.";
                                                            }
                                                        } else {
                                                            echo "Data não fornecida.";
                                                        }
                                                        ?></td>
                                <td class="resultado"><?php echo $dados["nom_localidade_fam"]; ?></td>
                                <td class="resultado"><?php
                                                        echo $dados["nom_tip_logradouro_fam"] . ' ';
                                                        echo $dados["nom_titulo_logradouro_fam"] == "" ? "" : $dados["nom_titulo_logradouro_fam"] . ' ';
                                                        echo $dados["nom_logradouro_fam"] . ', ';
                                                        echo $dados["num_logradouro_fam"] == "0" ? "S/N" : $dados["num_logradouro_fam"];
                                                        ?></td>
                                <td class="resultado"><?php echo $dados['visfeit'] === 'NÃO' ? 'NÃO' : $dados['visfeit']; ?></td>
                            </tr>
                        <?php
                            $seq++;
                        }
                    }
                    $conn->close();
                    ?>
                </table>
            </div>
        </form>
    <?php
    }
    ?>
    <script>
        document.getElementById('selecionarTodos').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[name="excluir[]"]')
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked
            }
        })
    </script>
</body>
</html>
