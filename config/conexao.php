<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

if (isset($_SESSION['municipio'])) {
    $host = '89.117.7.52';
    $usuario_bd = $_SESSION['user_bd'];
    $senha_bd = $_SESSION['pass_bd'];
    $banco = $_SESSION['nome_bd'];
    $port = 3306;
} else {
    exit();
}

$raiz_dom = "/TechSUAS/";
date_default_timezone_set('America/Sao_Paulo');

try {
    // Conexão PDO
    $pdo = new PDO("mysql:dbname=$banco;host=$host;port=$port", $usuario_bd, $senha_bd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Conexão mysqli
    $conn = new mysqli($host, $usuario_bd, $senha_bd, $banco, $port);

    // Verifique a conexão mysqli.
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Operações com PDO e mysqli aqui

} catch (Exception $e) {
    error_log($e->getMessage(), 3, '/path/to/your/logs/error.log');
    die("Erro ao conectar com o banco de dados! Por favor, tente novamente mais tarde.");
}