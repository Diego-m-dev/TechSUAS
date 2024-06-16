<?php
// Conecte-se ao seu banco de dados MySQL usando as credenciais armazenadas em variáveis de ambiente.
$host = getenv('DB_HOST') ?:'localhost';
$usuario = getenv('DB_USER') ?: 'root';
$senha = getenv('DB_PASS') ?: '';
$banco = getenv('DB_NAME') ?: 'cadunico';
$port = getenv('DB_PORT') ?: 3306;

$raiz_dom = "/TechSUAS/";

date_default_timezone_set('America/Sao_Paulo');

try {
    $pdo = new PDO("mysql:dbname=$banco;host=$host;port=$port", $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    // conexão mysql para o backup
    $conn = new mysqli($host, $usuario, $senha, $banco, $port);

    // Verifique a conexão.
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }
} catch (Exception $e) {
    error_log($e->getMessage(), 3, '/path/to/your/logs/error.log');
    die("Erro ao conectar com o banco de dados! Por favor, tente novamente mais tarde.");
}
?>
