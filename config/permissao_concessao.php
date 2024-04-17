<?php
    if ($_SESSION['setor'] != "CONCESSÃO" && $_SESSION['setor'] != "ADMINISTRATIVO E CONCESSÃO" && $_SESSION['setor'] != "SUPORTE") {
        echo "VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSA TELA.";
        exit();
    }
?>