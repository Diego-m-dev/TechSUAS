<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';

    $municipio = $_SESSION['municipio'];

    if ($municipio == "SÃO BENTO DO UNA") {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_sbu.php';
    } elseif ($municipio == "NOVA MAMORÉ") {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_novaMamore.php';
    } elseif ($municipio == "OSASCO") {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_osasco.php';
    }
?>
