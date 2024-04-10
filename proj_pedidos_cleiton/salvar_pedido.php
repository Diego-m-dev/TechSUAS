<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Recebe os dados do pedido
$tipo = $_POST['tipo'];
$local = $_POST['local'];
$quantidade = $_POST['quantidade'];
$data = date('Y-m-d H:i:s');

// Insere os dados na tabela de pedidos
$sql = "INSERT INTO pedidos (data, tipo, local, quantidade) VALUES ('$data', '$tipo', '$local', '$quantidade')";

if ($conn->query($sql) === TRUE) {
    echo "Pedido salvo com sucesso!";
    
    // Envio para o WhatsApp
    $mensagem = "⚠ Novo pedido ⚠\nTipo: $tipo\nLocal: $local\nQuantidade: $quantidade\nObrigado!🤝";

    $numeroWhatsapp = "+5581999840989"; // Substitua pelo número do WhatsApp da empresa
    $mensagemEncoded = urlencode($mensagem);
    $url = "https://api.whatsapp.com/send?phone=$numeroWhatsapp&text=$mensagemEncoded";
    
    // JavaScript para abrir o WhatsApp em uma nova aba
    echo "<script>window.open('$url', '_blank');</script>";
    
    // JavaScript para redirecionar de volta para a página inicial após um breve intervalo
    echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 3000);</script>"; // Redireciona após 3 segundos
    
} else {
    echo "Erro ao salvar o pedido: " . $conn->error;
}

$conn->close();
?>
