<?php
    if ($_SESSION['name_sistema'] != "CONCESSAO" && $_SESSION['funcao'] != "0") {
        echo "VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSA TELA.";
        exit();
    }
?>