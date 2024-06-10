<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>MSG do CAD</title>
</head>

<body>
<?php
// Recebe os dados do pedido
$tipo = $_POST['nis_liga'];

$sql_dados = "SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = '$tipo'";
$sql_query = $conn->query($sql_dados) or die("ERRO ao consultar !" . $conn - error);

// Executando a consulta
//$sql_pedido_agua->execute();

if ($sql_query->num_rows == 0) {
    echo "Erro ao salvar o pedido: " . $conn->error;
} else {
        $dados = $sql_query->fetch_assoc();
        
            $tel_oito = str_pad(substr($dados['num_tel_contato_1_fam'], -8), 9, "9", STR_PAD_LEFT);
            $numeroWhatsapp = $dados['num_ddd_contato_1_fam'] == 0 ? "" : "+55". $dados['num_ddd_contato_1_fam'] . $tel_oito;
    
    // Envio para o WhatsApp
    $mensagem = "ESTRUTURAR A MENSAGEM";

    //= "+5581994145401"; Substitua pelo número do WhatsApp da empresa
    $mensagemEncoded = urlencode($mensagem);
    $url = "https://api.whatsapp.com/send?phone=$numeroWhatsapp&text=$mensagemEncoded";
    
    // JavaScript para abrir o WhatsApp em uma nova aba
    echo "<script>window.open('$url', '_blank');</script>";
?>
    <script>
        Swal.fire({
            icon: "success",
            confirmButtonText: "OK",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/TechSUAS/views/cadunico/msn_cad/index"
            }
        })
    </script>
<?php
}

$conn->close();
?>

</body>
</html>