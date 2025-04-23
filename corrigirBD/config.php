<?php
// Configuração do primeiro banco (Capoeiras)
$host1 = "89.117.7.52";
$db1 = "u198416735_capoeiras";
$user1 = "u198416735_capoeiras";
$pass1 = "@ddvCAP26";

// Configuração do segundo banco (SBU)
$host2 = "srv1898.hstgr.io";
$db2 = "u444556286_sbu";
$user2 = "u444556286_sbu";
$pass2 = "@ddvSBU33";

try {
    // Conexão com o primeiro banco (Capoeiras)
    $pdo1 = new PDO("mysql:host=$host1;dbname=$db1;charset=utf8mb4", $user1, $pass1);
    $pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Conexão com o segundo banco (SBU)
    $pdo2 = new PDO("mysql:host=$host2;dbname=$db2;charset=utf8mb4", $user2, $pass2);
    $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
