<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Concessão</title>
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_consultar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/concessao.js"></script>

</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/concessao/h1-consulta.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <div id="parte_dos_simbolos">
        <div>
            <select name="tipo_busca" id="tipo_busca" style="text-align: center;">
                <option value="cpf">CPF</option>
                <option value="num_form">Nº Formulário</option>
            </select>
        </div>
        <div class="forms">
        <div>
            <form method='POST' id="cpf_inpu">
                <label>CPF Responsável:</label>
                <input type="text" id="cpf" name="cpf_resp">
                <button type="submit" id="btn_busca_cpf">BUSCAR</button>
                <a href = "/TechSUAS/config/back"><i class="fas fa-arrow-left"></i> Voltar ao menu</a>
            </form>
        </div>
        <div>
            <form method='POST' id="num_form_inpu" style="display: none;">
                <label>Nº Formulário:</label>
                <input type="text" id="num_form" name="num_form">
                <button type="submit" id="btn_busca_num_form">BUSCAR</button>
                <a href = "/TechSUAS/config/back"><i class="fas fa-arrow-left"></i> Voltar ao menu</a>
            </form>
        </div>
</div>

        <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['num_form'])) {
        $sql_cpf_resp = $conn->real_escape_string($_POST['cpf_resp']);

        $sql_dados_num_form = "SELECT * FROM concessao_tbl WHERE cpf_pessoa LIKE '$sql_cpf_resp'";
        $sql_query = $conn->query($sql_dados_num_form) or die("ERRO ao consultar !" . $conn - error);

        if ($sql_query->num_rows == 0) {
            ?>
                <script>
                    Swal.fire({
                        icon: "info",
                        title: "NÃO ENCONTRADO",
                        text: "Não existe nenhum formulário com esse CPF: <?php echo $_POST['cpf_resp']; ?> !",
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/TechSUAS/views/concessao/consultar";
                        }
                    });
                </script>
            <?php
} else {

            $dados = $sql_query->fetch_assoc();
            $id_hist_conc = $dados['id_concessao'];

            echo '<p> O(A) Responsável <b>' . $dados['nome'] . '</b> tem os seguintes formulários...</p>';

            // Consulta dos historico relacionados ao responsáveis
            $form = $conn->real_escape_string($id_hist_conc);
            $dados_form = "SELECT * FROM concessao_historico WHERE id_concessao LIKE '$form' ORDER BY num_form DESC";
            $form_query = $conn->query($dados_form) or die("ERRO ao consultar!" . $conn - error);

            ?>
                <table width="650px" border="1">
                    <tr>
                        <th>Nº DO FORMULÁRIO</th>
                        <th>NOME BENEFICIÁRIO</th>
                        <th>CONCESSÃO</th>
                        <th>VALOR</th>
                        <th>MÊS DE PAGAMENTO</th>
                        <th>REGISTRO</th>
                        <th>SITUAÇÃO</th>
                        <th>AÇÃO</th>
                    </tr>
                    <?php

            while ($dados_hist_form = $form_query->fetch_assoc()) {
?>
                <tr>
                    <td><?php echo $dados_hist_form['num_form'] . '/' . $dados_hist_form['ano_form']; ?></td>
                    <td><?php echo $dados_hist_form['nome_benef']; ?></td>
                    <td><?php echo $dados_hist_form['nome_item']; ?></td>
                    <td><?php echo 'R$ ' . $dados_hist_form['valor_total']; ?></td>
                    <td><?php echo $dados_hist_form['mes_pag']; ?></td>
                    <td><?php echo $dados_hist_form['data_registro']; ?></td>
                    <td><?php echo $dados_hist_form['situacao_concessao']; ?></td>
                    <td>
                        <form action="/TechSUAS/views/concessao/editar_conc" method="post" style="display:inline;">
                            <input type="hidden" name="id_concessao" value="<?php echo $dados_hist_form['id_hist']; ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </td>
                </tr>
<?php
}
        }
    } else {
        $sql_num_form = $conn->real_escape_string($_POST['num_form']);

        $sql_dados_num_form = "SELECT * FROM concessao_historico WHERE num_form LIKE '$sql_num_form'";
        $sql_query = $conn->query($sql_dados_num_form) or die("ERRO ao consultar !" . $conn - error);

        if ($sql_query->num_rows == 0) {
            ?>
                    <script>
                        Swal.fire({
                            icon: "info",
                            title: "NÃO ENCONTRADO",
                            text: "Não existe nenhum formulário com o número: <?php echo $_POST['num_form']; ?> !",
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/TechSUAS/views/concessao/consultar";
                            }
                        });
                    </script>
                <?php
} else {

            $dados = $sql_query->fetch_assoc();
            $id_hist_conc = $dados['num_form'];

            echo '<p> Formulário nº <b>' . $dados['num_form'] . '/' . $dados['ano_form'] . '</b>.</p>';

            // Consulta dos historico relacionados ao responsáveis
            $form = $conn->real_escape_string($id_hist_conc);
            $dados_form = "SELECT * FROM concessao_historico WHERE num_form LIKE '$form'";
            $form_query = $conn->query($dados_form) or die("ERRO ao consultar!" . $conn - error);

?>
    <table width="650px" border="1">
        <tr>
            <th>Nº DO FORMULÁRIO</th>
            <th>NOME BENEFICIÁRIO</th>
            <th>CONCESSÃO</th>
            <th>VALOR</th>
            <th>MÊS DE PAGAMENTO</th>
            <th>REGISTRO</th>
            <th>SITUAÇÃO</th>
            <th>AÇÃO</th>
        </tr>
<?php

while ($dados_hist_form = $form_query->fetch_assoc()) {
    ?>
        <tr>
            <td><?php echo $dados_hist_form['num_form'] . '/' . $dados_hist_form['ano_form']; ?></td>
            <td><?php echo $dados_hist_form['nome_benef']; ?></td>
            <td><?php echo $dados_hist_form['nome_item']; ?></td>
            <td><?php echo 'R$ ' . $dados_hist_form['valor_total']; ?></td>
            <td><?php echo $dados_hist_form['mes_pag']; ?></td>
            <td><?php echo $dados_hist_form['data_registro']; ?></td>
            <td><?php echo $dados_hist_form['situacao_concessao']; ?></td>
            <td>
                <form action="/TechSUAS/views/concessao/editar_conc" method="post" style="display:inline;">
                    <input type="hidden" name="id_concessao" value="<?php echo $dados_hist_form['id_hist']; ?>">
                    <button type="submit">Editar</button>
                </form>
            </td>
        </tr>
    <?php
}
        }
    }
}
?>
    </div>
</body>
<script>
document.getElementById("tipo_busca").addEventListener("change", function() {
    var tipoSelecionado = this.value
    if (tipoSelecionado === "cpf") {
        document.getElementById("cpf_inpu").style.display = "block"
        document.getElementById("num_form_inpu").style.display = "none"
    } else if (tipoSelecionado === "num_form") {
        document.getElementById("cpf_inpu").style.display = "none"
        document.getElementById("num_form_inpu").style.display = "block"
    }
})
</script>


</html>