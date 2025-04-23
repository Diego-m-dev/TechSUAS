<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');
$response = array('alteracao' => false);

if (isset($_POST['lc_cadastro'])) {
    
    $lc_cadastro = $_POST['lc_cadastro'];
    $_SESSION['acao_cadu'] = true;
    $_SESSION['guiche'] = $lc_cadastro;

    if ($_SESSION['acao_cadu'] === true) {
        $response = array('alteracao' => true, 'guiche' => $lc_cadastro);
    }
}
echo json_encode($response);
$conn->close();