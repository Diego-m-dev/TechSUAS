<?php
$host = '89.117.7.52';
$usuario = 'u198416735_root';
$senha = '@Tech2024';
$banco = 'u198416735_cadunico_test';
$port = 3306;

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

  echo "conexão com sucesso";
  // Verifique a conexão.
  if ($conn->connect_error) {
    throw new Exception("Falha na conexão com o banco de dados: " . $conn->connect_error);
  }
} catch (Exception $e) {
  error_log($e->getMessage(), 3, '/path/to/your/logs/error.log');
  die("Erro ao conectar com o banco de dados! Por favor, tente novamente mais tarde.");
}
