<?php
// Conecte-se ao seu banco de dados MySQL usando as credenciais adequadas.
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'test';
$port = 3306;

$raiz_dom= "/TechSUAS/";

date_default_timezone_set('America/Sao_Paulo');
try {
$pdo = new PDO("mysql:dbname=$banco;host=$host", "$usuario", "$senha");
//conexao mysql para o backyp
$conn = mysqli_connect($host, $usuario, $senha, $banco);
} catch (Exception $e) {
echo "Erro ao conectar com o banco de dados! ".$e;
}

// Verifique a conexão.
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $mysqli->connect_error);
}else{
    
}
?>