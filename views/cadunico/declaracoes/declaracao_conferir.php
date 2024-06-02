<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/controller/cadunico/declaracao/conferir.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/validar_cpf.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/TechSUAS/css/cadunico/declaracoes/style-dec-conf.css">
        <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
        <title>Conferir Declaração</title>
    </head>

<body>
        <h1>DECLARAÇÃO DO CADASTRO ÚNICO</h1>
        <h3>Confira se as informações estão corretas</h3>
        <form method="post" action="/TechSUAS/controller/cadunico/declaracao/con_doc">

        <?php
if ($sql->rowCount() > 0 && $sqli->rowCount() == 0) {
    echo "Código Familiar: " . $cod_familiar_formatado . "<br>";
    echo "CPF: " . $cpf_formatado . "<br>";
    echo "NIS: " . $nis_responsavel_formatado . "<br>";
    echo "Nome: " . $nom_pessoa . "<br>";
    echo "Noma da Mãe: " . $nom_mae_rf . "<br>";
    echo "Data da ultima atualização: " . $data_atualizada . "<br>";
    echo "Renda Per Capita: R$ " . $real_br_formatado . "<br>";
    ?>
    <br><input type="submit" name="btn-ip2" value="Imprimir">
    <?php

// Armazene a variável na sessão
    $_SESSION['dados_conferidos'] = array(
        'cpf_formatado' => $cpf_formatado,
        'nis_responsavel_formatado' => $nis_responsavel_formatado,
        'cod_familiar_formatado' => $cod_familiar_formatado,
        'nom_pessoa' => $nom_pessoa,
        'sexo' => $sexo,
        'sexoo' => $sexoo,
        'nom_mae_rf' => $nom_mae_rf,
        'status_cadastro' => $status_cadastro,
        'real_br_formatado' => $real_br_formatado,
        'sexooo' => $sexooo,
        'perfil' => $perfil,
        'data_atualizada' => $data_atualizada,
    );
} elseif ($sql->rowCount() > 0 && $sqli->rowCount() > 0) {
    echo "Código Familiar: " . $cod_familiar_formatado . "<br>";
    echo "CPF: " . $cpf_formatado . "<br>";
    echo "NIS: " . $nis_responsavel_formatado . "<br>";
    echo "Nome: " . $nom_pessoa . "<br>";
    echo "Noma da Mãe: " . $nom_mae_rf . "<br>";
    echo "Data da ultima atualização: " . $data_atualizada . "<br>";
    echo "Renda Per Capita: R$ " . $real_br_formatado . "<br>";

    ?>
    <br><input type="submit" name="btn-ip1" value="Imprimir">
    <?php

// Armazene a variável na sessão
    $_SESSION['dados_conferidos'] = array(
        'cpf_formatado' => $cpf_formatado,
        'nis_responsavel_formatado' => $nis_responsavel_formatado,
        'cod_familiar_formatado' => $cod_familiar_formatado,
        'nom_pessoa' => $nom_pessoa,
        'sexo' => $sexo,
        'sexoo' => $sexoo,
        'nom_mae_rf' => $nom_mae_rf,
        'status_cadastro' => $status_cadastro,
        'real_br_formatado' => $real_br_formatado,
        'sexooo' => $sexooo,
        'perfil' => $perfil,
        'recebendo' => $recebendo,
        'data_atuallizada' => $data_atualizada,
    );
} elseif ($sql->rowCount() == 0) {
    echo $semcadastro;
    ?>

<form method="post" action="con_doc.php">
                <?php

    $cpf_formatando = sprintf('%011s', $cpf_dec);
    $cpf_formatado = substr($cpf_formatando, 0, 3) . '.' . substr($cpf_formatando, 3, 3) . '.' . substr($cpf_formatando, 6, 3) . '-' . substr($cpf_formatando, 9, 2);

    ?>  

                <br><label>CPF: <?php echo $cpf_formatado; ?></label><br>
                <label>Nome: </label>
                <input type="text" name="nome_dec" oninput="sempre_maiusculo(this)" placeholder="Digite o nome completo" required><br>
                <label>Nome da Mãe: </label>
                <input type="text" name="nome_mae_dec" oninput="sempre_maiusculo(this)" placeholder="Digite o nome completo"required><br>

                <label><input type="radio" name="gender" value="male" required>
                    <span class="circle" style="background-color: dodgerblue;"></span> Homem</label>
                <label><input type="radio" name="gender" value="female">
                    <span class="circle" style="background-color: hotpink;"></span> Mulher</label>

                <br><br><input type="submit" name="btn-ip5" value="Imprimir">        
        </form>
        <?php
// Armazene a variável na sessão
    $_SESSION['dados_conferidos_s'] = array(
        'cpf_dec' => $cpf_dec,
    );
}

?>
        </form>
        <script src="/TechSUAS/js/personalise.js"></script>
    </body>
</html>