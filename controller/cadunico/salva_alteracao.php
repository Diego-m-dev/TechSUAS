<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nm = $_POST['nome'];
    $ap = $_POST['apelido'];
    $tele= $_POST['tele'];
    $email1 = $_POST['email'];
    $cg = $_POST['cargo'];
    $idcg = $_POST['idcargo'];

    $smtp = $conn->prepare("UPDATE usuarios SET nome=?, apelido=?, telefone=?, email=?, cargo=?, id_cargo=? WHERE usuario=?");
    $smtp->bind_param("sssssss", $nm, $ap, $tele, $email1, $cg, $idcg, $user_name);
    if ($smtp->execute()) {

        // Atualização bem-sucedida, redirecione para a SALA DO USUÁRIO
        echo "<script language='javascript'>window.alert('Dados alterados com sucesso.');
        setTimeout(function() {
            window.history.back(); // Volta para a página anterior
        }, 500);
        </script>";
    exit();
    } else {
        echo "Erro na atualização das informações: " . $smtp->error;
    }

    $smtp->close();

}
