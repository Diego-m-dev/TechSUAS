<?php
session_set_cookie_params(['httponly' => true]);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_index_cad.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/suporte.js"></script>
</head>
<body>
<?php
require_once "conexao_acesso.php";
session_start();
session_regenerate_id(true);

$usuario = $_POST['usuario'];
$senha_login = $_POST['senha'];

$stmt_login = $pdo_1->prepare("SELECT * FROM operadores WHERE usuario = :usuario");
$stmt_login->bindValue(":usuario", $usuario);
$stmt_login->execute();

$dados = $stmt_login->fetch(PDO::FETCH_ASSOC);
if ($dados && is_array($dados) && array_key_exists('setor', $dados)) {
    if (password_verify($senha_login, $dados['senha'])) {
        $_SESSION['estilo'] = $dados['municipio']. "-". $dados['name_sistema'];
        
        $_SESSION['nome_bd'] = $dados['nome_bd'];
        $_SESSION['user_bd'] = $dados['user_bd'];
        $_SESSION['pass_bd'] = $dados['pass_bd'];

        $_SESSION['name_sistema'] = $dados['name_sistema'];
        $_SESSION['sistema_id'] = $dados['sistema_id'];
        $_SESSION['user_usuario'] = $dados['usuario'];
        $_SESSION['cargo_usuario'] = $dados['cargo'];
        $_SESSION['municipio'] = $dados['municipio'];
        $_SESSION['nome_usuario'] = $dados['nome'];
        $_SESSION['id_cargo'] = $dados['id_cargo'];
        $_SESSION['apelido'] = $dados['apelido'];
        $_SESSION['funcao'] = $dados['funcao'];
        $_SESSION['acesso'] = $dados['acesso'];
        $_SESSION['setor'] = $dados['setor'];
        $_SESSION['cpf'] = $dados['cpf'];

        if ($dados['acesso'] == 1) {
            header("location:/TechSUAS/views/geral/primeiro_acesso");
            exit();
        }

            if ($_SESSION['funcao'] == "0") {
                require_once "conexao.php";
                $sql_tbl_tudo = "SELECT cod_familiar_fam FROM tbl_tudo";
                $sql_tbl_tudo_query = $conn->query($sql_tbl_tudo);
                if ($sql_tbl_tudo_query->num_rows == 0) {
?>
          <script>
            Swal.fire({
              icon: "warning",
              title: "ATENÇÃO",
              html: `
              <p>O seu banco de dados está vazio, aperte em OK e faça a importação do arquivo CSV extraído do CECAD 2.0.</p>
              <p>Se ainda não extraiu <a href="https://cecad.cidadania.gov.br/painel03.php">clique aqui</a>. </p>
              `,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = "/TechSUAS/views/geral/atualizar_tabela"
              }
            })
          </script>
          <?php
          } else {
            header("location:/TechSUAS/suporte/index");
            exit();
          }


        } elseif ($_SESSION['funcao'] == "1" && $_SESSION['name_sistema'] == "CADUNICO") {
        require_once "conexao.php";
          $sql_tbl_tudo = "SELECT cod_familiar_fam FROM tbl_tudo";
          $sql_tbl_tudo_query = $conn->query($sql_tbl_tudo);
          if ($sql_tbl_tudo_query->num_rows == 0) {
    ?>
                <script>
                Swal.fire({
                  icon: "warning",
                  title: "ATENÇÃO",
                  html: `
                  <p>O seu banco de dados está vazio, aperte em OK e faça a importação do arquivo CSV extraído do CECAD 2.0.</p>
                  <p>Se ainda não extraiu <a href="https://cecad.cidadania.gov.br/painel03.php">clique aqui</a>. </p>
                  `,
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/geral/atualizar_tabela"
                  }
                })
                </script>
                <?php
                } else {
                    header("location:/TechSUAS/views/cadunico/index");
                    exit();
                }


            } elseif ($_SESSION['funcao'] == "1" && $_SESSION['name_sistema'] == "CONCESSAO"){
              header("location:/TechSUAS/views/concessao/index");
              exit();


            }elseif ($_SESSION['funcao'] == "3") {

              if ($_SESSION['name_sistema'] == "CONCESSAO"){
                header("location:/TechSUAS/views/concessao/index");
                exit();
              } elseif ($_SESSION['name_sistema'] == "CADUNICO") {
                header("location:/TechSUAS/views/cadunico/index");
                exit();
              } else {
                header("location:/TechSUAS/views/recpcao/index");
                exit();
              }

            } else {

?>
              <script>
                Swal.fire({
                  icon: "error",
                  title: "SEM PERMISSIONAMENTO"
                  text: "Solicite ao suporte acesso ao sistema <?php echo $_SESSION['name_sistema']; ?>",
                  confirmButtonText: "OK"
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/index"
                  }
                })
              </script>
              <?php
            }
        
            } else {
        ?>
        <script>
        Swal.fire({
          icon: "error",
          title: "ERRO",
          text: "Senha ou nome de usuário incorreto!",
          confirmButtonText: "OK",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/TechSUAS/index"
          }
        })
        </script>
        <?php
          }
        } else {
            ?>
        <script>
        Swal.fire({
          icon: "error",
          title: "ERRO",
          text: "Senha ou nome de usuário incorreto!",
          confirmButtonText: "OK",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/TechSUAS/"
          }
        })
        </script>
<?php
}
?>
</body>
</html>
