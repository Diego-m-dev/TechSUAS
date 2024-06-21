<?php
// Conecte-se ao seu banco de dados MySQL usando as credenciais adequadas.
$host = '89.117.7.52';
$usuario = 'u198416735_suporte_ddv';
$senha = '#Tech2024';
$banco = 'u198416735_ddv_cont';
$port = 3306;

$raiz_dom= "/TechSUAS/";

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
}
?>
