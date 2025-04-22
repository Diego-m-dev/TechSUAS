<?php
    $host = 'srv1898.hstgr.io';
    $usuario_bd = 'u444556286_sbu';
    $senha_bd = '@ddvSBU33';
    $banco = 'u444556286_sbu';
    $port = 3306;


$raiz_dom = "/TechSUAS/";
date_default_timezone_set('America/Sao_Paulo');

try {
    // Conexão PDO
    $pdo = new PDO("mysql:dbname=$banco;host=$host;port=$port", $usuario_bd, $senha_bd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
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