<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/config/conexao.php';

if(!isset($_SESSION )){
    session_start();
}
    $data_hoje = date('d/m/Y H:i');
$user_name = $_SESSION['user_usuario'];

$sql = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :user_usuario");
$sql->execute(array(':user_usuario' => $user_name));

if ($sql->rowCount() > 0) {

    $dados = $sql->fetch(PDO::FETCH_ASSOC);
    $id_user = $dados['id'];
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
    $nivel = $dados['nivel'];
}

?>
<!--Inclua as variáveis PHP no script JavaScript-->
<script>
    var id_user = <?php echo json_encode($id_user); ?>
    var nome = <?php echo json_encode($nome); ?>
    var apelido = <?php echo json_encode($apelido); ?>
    var cpf = <?php echo json_encode($cpf); ?>
    var setor = <?php echo json_encode($setor); ?>
    var func = <?php echo json_encode($func); ?>
    var dtNasc = <?php echo json_encode($dtNasc); ?>
    var telefone = <?php echo json_encode($telefone); ?>
    var email = <?php echo json_encode($email); ?>
    var cargo = <?php echo json_encode($cargo); ?>
    var idcargo = <?php echo json_encode($idcargo); ?>
    var nivel = <?php echo json_encode($nivel); ?>
</script>