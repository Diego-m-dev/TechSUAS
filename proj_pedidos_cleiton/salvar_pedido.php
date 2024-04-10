<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';


// Recebe os dados do pedido
$tipo = $_POST['tipo'];
$local = $_POST['local'];
$quantidade = $_POST['quantidade'];
$data = date('Y-m-d H:i:s');

// Envio para o WhatsApp
$mensagem = "Novo pedido:\nTipo: $tipo\nLocal: $local\nQuantidade: $quantidade";
$numeroWhatsapp = "87991718722"; // Substitua pelo número do WhatsApp da empresa
$mensagemEncoded = urlencode($mensagem);
$url = "https://api.whatsapp.com/send?phone=$numeroWhatsapp&text=$mensagemEncoded";

// Redireciona para o WhatsApp
header("Location: $url");

// Insere os dados na tabela de pedidos
$sql = "INSERT INTO pedidos (data, tipo, local, quantidade) VALUES ('$data', '$tipo', '$local', '$quantidade')";

if ($conn->query($sql) === TRUE) {
    echo "Pedido salvo com sucesso!";
} else {
    echo "Erro ao salvar o pedido: " . $conn->error;
}

$conn->close();
?>
