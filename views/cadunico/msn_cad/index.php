<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>MSG do CAD</title>
</head>

<body>
<div class="img">
        <h1 class="titulo-com-imagem">
            <img src="#" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">

        <form action="" method="post">
            <div>
                <label for="tipo">Código Familiar:</label>
                    <input type="text" id="cod_fam" name="cod_fam" />
                
            </div>
            <div>
                <button type="submit">Buscar</button>
            </div>
        </form>

        <?php

if (isset($_GET['msg'])) {
    echo "<p>{$_GET['msg']}</p>";
}
if (!isset($_POST['cod_fam'])) {

} else {
    $codigo = $_POST['cod_fam'];
    $sql_cod = $conn->real_escape_string($codigo);
    $sql_dados = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam LIKE '%$sql_cod%' OR nom_pessoa LIKE '%$sql_cod%' ";
    $sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

    if ($sql_query->num_rows == 0) {
        echo $_POST['cod_fam']. " não encontrado!";
    } else {
        while ($dados = $sql_query->fetch_assoc()) {

            echo "Nome: ". $dados['nom_pessoa']. " | NIS: ". $dados['num_nis_pessoa_atual']. "<br>";
            echo "Apelido/Nome Social: ". $dados['nom_apelido_pessoa']. " / ";
            echo "Data de Nascimento: ". $dados['dta_nasc_pessoa']. " / ";
            echo "Nome da Mãe: ". $dados['nom_completo_mae_pessoa']. " / ";
            echo "CPF: ". $dados['num_cpf_pessoa']. "<br>";
            //Contatos 
            echo "tel.1: ". $dados['num_ddd_contato_1_fam']. $dados['num_tel_contato_1_fam']. " / ";
            echo "tel.2: ". $dados['num_ddd_contato_2_fam']. $dados['num_tel_contato_2_fam']. "<br>";
        }
    }
}
?>
    </div>
    <footer><img src="footer.svg" alt=""></footer>
    <script>
    $(document).ready(function (){
        $('#cod_fam').mask('000000000-00')
    })
        </script>
</body>

</html>
