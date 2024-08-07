<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

if(!isset($_SESSION )){
    session_start();
}
    $data_hoje = date('d/m/Y H:i');
    $user_name = $_SESSION['user_usuario'];

$sql = $pdo_1->prepare("SELECT * FROM operadores WHERE usuario = :user_usuario");
$sql->execute(array(':user_usuario' => $user_name));

if ($sql->rowCount() > 0) {

    $dados = $sql->fetch(PDO::FETCH_ASSOC);
    $id_user = $dados['id'];
    $usu = $dados['usuario'];
    $nome = $dados['nome'];
    $apelido = $dados['apelido'];
    $cpf = $dados['cpf'];
    $setor = $dados['setor'];
    $funcao = $dados['funcao'];
    if ($funcao == 1){
        $func = "Coordenação";
    }elseif($funcao == 2){
        $func = "Tecnico";
    }else{
        $func = null;
    }
    $dtNasc = $dados['dt_nasc'];
    $telefone = $dados['telefone'];
    $email = $dados['email'];
    $cargo = $dados['cargo'];
    $idcargo = $dados['id_cargo'];

}

?>
