<?php
// Conecte-se ao seu banco de dados MySQL usando as credenciais adequadas.
$host = '89.117.7.52';
$usuario = 'u198416735_techsuas';
$senha = 'GNoY;y#6Dv6#';
$banco = 'u198416735_tachsuas';
$port = 3306;

$raiz_dom = "/TechSUAS/";

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
    } else {
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

// Executando a consulta
//$sql_pedido_agua->execute();

if ($sql_pedido_agua->execute()) {

    echo "Pedido salvo com sucesso!";
    
    // Envio para o WhatsApp
    $mensagem = "⚠️ Novo pedido ⚠️\nTipo: $tipo\nLocal: $local\nQuantidade: $quantidade\nObrigado!🤝";

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
