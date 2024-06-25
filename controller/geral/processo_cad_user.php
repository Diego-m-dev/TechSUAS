<?php
require 'secret.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/png">
  <link rel="stylesheet"  type="text/css" href="/TechSUAS/css/geral/style-processo.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  <title>Cadastro Salvo</title>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf_coord = $_POST['cpf'];
    $funcao = $_POST['funcao'];
    $senha_hashed = password_hash($mddrRfc1nkKKKdsad56, PASSWORD_DEFAULT);
    $user_name = $_POST['nome_user'];
    $user_maiusc = strtoupper($user_name);
    $setor = $_POST['setor'];

    $email = $_POST['email'];
    $nomeUsuario = gerarNomeUsuario($user_name);

    // Verifica se o nome de usuário já existe no banco de dados
    $verifica_usuario = $conn_1->prepare("SELECT usuario FROM operadores WHERE usuario = ?");
    $verifica_usuario->bind_param("s", $nomeUsuario);
    $verifica_usuario->execute();
    $verifica_usuario->store_result();

    if ($verifica_usuario->num_rows > 0) {
        // Se o nome de usuário já está em uso, exibe uma mensagem e redirecione de volta ao login
?>
<script>
  Swal.fire({
  icon: "info",
  title: "JÁ CADASTRADO",
  text: "Nome de usuário já em uso. Por favor, consulte o SUPORTE DDV",
  confirmButtonText: 'OK',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "/TechSUAS/views/geral/cadastro_user";
    }
  })
</script>
<?php
exit();
    }

    if ($_SESSION['setor'] == "SUPORTE") {
        // Busca o id do setor na tabela setores baseado no cpf do responsável
        $stmt_munic = $pdo_1->prepare("SELECT id FROM sistemas WHERE cpf = :cpf_coord");
        $stmt_munic->bindValue(":cpf_coord", $cpf_coord);
        $stmt_munic->execute();

        if ($stmt_munic->rowCount() != 0) {
            $dados_munic = $stmt_munic->fetch(PDO::FETCH_ASSOC);
            $municipio_id = $dados_munic['id'];
        } else {
            // Trate o caso em que o município não foi encontrado
            die("Sistema não encontrado.");
        }
    } else {
        $municipio = $cpf_coord;
        $municipio_id = $_SESSION['sistema_id'];
    }
    
    // Caso o Nome do Usuário seja unico será adicionado ao SQL
    $smtp = $conn_1->prepare("INSERT INTO operadores (municipio, nome, usuario, senha, setor, funcao, email, acesso, sistema_id) VALUES (?,?,?,?,?,?,?,?,?)");

    // Verifica se a preparação foi bem-sucedida
    if ($smtp === false) {
        die('Erro na preparação SQL: ' . $conn_1->error);
    }
    $acesso = "1";
    $smtp->bind_param("sssssssss", $municipio, $user_maiusc, $nomeUsuario, $senha_hashed, $setor, $funcao, $email, $acesso, $municipio_id);

    if ($smtp->execute()) {
        if ($_SESSION['setor'] == "SUPORTE") {
            ?>
        <script>
            Swal.fire({
            icon: "success",
            title: "CADASTRADO",
            text: "Cadastro realizado com sucesso!",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/suporte/municipios";
                }
            })
        </script>
            <?php
} else {
            ?>
        <script>
            Swal.fire({
            icon: "success",
            title: "CADASTRADO",
            text: "Cadastro realizado com sucesso!",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/geral/cadastro_user";
                }
            })
        </script>
            <?php
}
    } else {
        echo "ERRO no envio dos DADOS: " . $smtp->error;
    }
    $smtp->close();
    $conn_1->close();
}

function gerarNomeUsuario($user_name)
{
    $nomes = explode(" ", $user_name);
    $nomeUsuario = strtolower($nomes[0] . "." . end($nomes));
    return $nomeUsuario;
}
?>
</body>
</html>