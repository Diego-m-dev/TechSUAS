<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="../../../css/cadunico/msn/style_msn.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>MSG do CAD</title>
</head>

<body>
<div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/cadunico/h1-msg_cad.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">

        <form action="" method="post">
            <div>
                <label for="tipo">Código Familiar:</label>
                    <input type="text" id="cod_fam" name="cod_fam" />
                    <button type="submit">BUSCAR</button>
                    
            
        </form>
        <button class="impr" onclick="voltarAoMenu()"><i class="fas fa-arrow-left"></i>Voltar</button>
        </div>
        <?php
if (!isset($_POST['cod_fam'])) {

} else {
    $codigo = $_POST['cod_fam'];
    $sql_cod = $conn->real_escape_string($codigo);
    $sql_dados = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam LIKE '%$sql_cod%' OR nom_pessoa LIKE '%$sql_cod%' ";
    $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

    if ($sql_query->num_rows == 0) {
        echo $_POST['cod_fam']. " não encontrado!";
    } else {
?>
        <table border="1">
            <tr>
            <th>NOME</th>
            <th>NIS</th>
            <th>DATA DA ULTIMA ATUALIZAÇÃO</th>
            <th>TELEFONE 1</th>
            <th>TELEFONE 2</th>
            <th>AÇÃO</th>
            </tr>
        
<?php
        while ($dados = $sql_query->fetch_assoc()) {
?>
    <form action="salvar_pedido" method="POST">
        <tr>
            <td><?php echo $dados['nom_pessoa']; ?></td>
            <td><?php echo $dados['num_nis_pessoa_atual']; ?></td>
            <td><?php 
                $data = $dados['dat_atual_fam'] ?? '';

                if ($data) {
                    $formatando_data = DateTime::createFromFormat('Y-m-d', $data);
                    echo $dados_visita = $formatando_data ? $formatando_data->format('d/m/Y') : 'Data inválida.';
                } else {
                    echo 'Data não fornecida.';
                }

            ?></td>
            <td><?php
                $tel_oito = str_pad(substr($dados['num_tel_contato_1_fam'], -8), 9, "9", STR_PAD_LEFT);
            echo $dados['num_ddd_contato_1_fam'] == 0 ? "" : $dados['num_ddd_contato_1_fam'] . $tel_oito;
            ?></td>
            <td><?php
                $tel_oito_ = str_pad(substr($dados['num_tel_contato_2_fam'], -8), 9, "9", STR_PAD_LEFT);
            echo $dados['num_ddd_contato_2_fam'] == 0 ? "" : $dados['num_ddd_contato_2_fam'] . $tel_oito_;
            ?></td>
            <td>
                <form action="salvar_pedido" method="post" style="display:inline;">
                    <input type="hidden" name="nis_liga" value="<?php echo $dados['num_nis_pessoa_atual']; ?>">
                    <button type="submit">GERAR</button>
                </form>
            </td>
        </tr>
    </form>

<?php
    }
?>
        </table>

<?php
    }
}
?>
    </div>
    <script>
    $(document).ready(function (){
        $('#cod_fam').mask('000000000-00')
    })
        </script>
</body>

</html>
