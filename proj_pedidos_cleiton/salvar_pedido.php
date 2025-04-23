<?php
// Conecte-se ao seu banco de dados MySQL usando as credenciais adequadas.
$host = 'srv1898.hstgr.io';
$usuario = 'u444556286_pedidos';
$senha = 'wW1234(o';
$banco = 'u444556286_pedidos';
$port = 3306;

date_default_timezone_set('America/Sao_Paulo');

try {
    // Adicione a porta à string DSN
    $pdo = new PDO("mysql:dbname=$banco;host=$host;port=$port", "$usuario", "$senha", array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));

    // Conexão MySQLi para o backup
    $conn = mysqli_connect($host, $usuario, $senha, $banco, $port);
    
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }
} catch (Exception $e) {
    echo "Erro ao conectar com o banco de dados! " . $e->getMessage();
    exit();
}

// Recebe os dados do pedido
$tipo = $_POST['tipo'];
$local = $_POST['local'];
$quantidade = $_POST['quantidade'];
$data = date('Y-m-d H:i:s');

// Insere os dados na tabela de pedidos
$sql_pedido_agua = $pdo->prepare("INSERT INTO pedidos (data, tipo, local, quantidade) VALUES (:data, :tipo, :local, :quantidade)");

// Vinculando valores aos parâmetros
$sql_pedido_agua->bindParam(':data', $data);
$sql_pedido_agua->bindParam(':tipo', $tipo);
$sql_pedido_agua->bindParam(':local', $local);
$sql_pedido_agua->bindParam(':quantidade', $quantidade);

if ($sql_pedido_agua->execute()) {
    // Mensagem de sucesso
    $msg = "Pedido salvo com sucesso!";
    
    // Envio para o WhatsApp
    $mensagem = "⚠️ Novo pedido ⚠️\nTipo: $tipo\nLocal: $local\nQuantidade: $quantidade\nObrigado!🤝";

    // Define o número do WhatsApp com base no tipo de pedido
    if ($tipo === "Gás") {
        $numeroWhatsapp = "5581999840989"; // Número para pedidos do tipo GÁS
    } else {
        $numeroWhatsapp = "558197059133"; // Número padrão
    }

    $mensagemEncoded = urlencode($mensagem);
    $url = "https://api.whatsapp.com/send?phone=$numeroWhatsapp&text=$mensagemEncoded";
    
    // JavaScript para abrir o WhatsApp em uma nova aba
    echo "<script>window.open('$url', '_blank');</script>";
    
    // Redireciona para a página inicial após salvar o pedido, incluindo a mensagem
    echo "<script>setTimeout(function(){ window.location.href = 'index.php?msg=$msg'; }, 30000);</script>";
} else {
    // Caso de erro na execução
    echo "Erro ao salvar o pedido: " . $conn->error;
}

$conn->close();
?>
