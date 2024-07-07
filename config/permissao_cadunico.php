<?php
if ($_SESSION['funcao'] == "0"){

} else {
    if ($_SESSION['name_sistema'] != "CADUNICO" && $_SESSION['funcao'] != "0") {
    echo "VOCÊ NÃO TEM PERMISSÃO PARA ACESSAR ESSA TELA.";
      echo $_SESSION['name_sistema'];
    exit();
    }
}


