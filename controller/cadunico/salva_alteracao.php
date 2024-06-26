<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/TechSUAS/css/suporte/style-alt-user.css">
    <link rel="website icon" type="image/png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <title>Sala do Usuário</title>
    <style>
        .edicao {
            display: none;
        }
    </style>
</head>
<body>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nm = $_POST['nome'];
    $ap = $_POST['apelido'];
    $tele= $_POST['tele'];
    $email1 = $_POST['email'];
    $cg = $_POST['cargo'];
    $idcg = $_POST['idcargo'];
    $ibge = empty($_POST['ibge']) ? "" : $_POST['ibge'];

    $sql = "SELECT * FROM municipios WHERE cod_ibge = '$ibge'";
    $sql_query = $conn_1->query($sql) or die("Erro ". $conn_1->error);

    if ($sql_query->num_rows != 0) {
        $bd = $sql_query->fetch_assoc();

        $nmbd = $bd['nome_bd'];
        $userbd = $bd['usuario'];
        $shbd = $bd['senha_bd'];

        $stmt = $conn_1->prepare("UPDATE municipios SET nome_bd=?, usuario=?, senha_bd=? WHERE id=?");
        $id = 4; // Supondo que você esteja sempre atualizando o registro com id 4
        $stmt->bind_param("sssi", $nmbd, $userbd, $shbd, $id);

        if ($stmt->execute()) {
          ?>
  <script>
    Swal.fire({
      icon: "success",
      title: "SALVO",
      text: "Os dados foram alterados com sucesso.",
      confirmButtonText: "OK"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "/TechSUAS/config/back"
      }
    })
  </script>
<?php
        }
        $stmt->close();
    }

    $stmt = $conn_1->prepare("UPDATE operadores SET nome=?, apelido=?, telefone=?, email=?, cargo=?, id_cargo=? WHERE usuario=?");
    $stmt->bind_param("sssssss", $nm, $ap, $tele, $email1, $cg, $idcg, $_SESSION['user_name']); // Supondo que 'user_name' está na sessão

    if ($stmt->execute()) {
?>
  <script>
    Swal.fire({
      icon: "success",
      title: "SALVO",
      text: "Os dados foram alterados com sucesso.",
      confirmButtonText: "OK"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "/TechSUAS/config/back"
      }
    })
  </script>
<?php
        exit();
    } else {
        echo "Erro na atualização das informações: " . $stmt->error;
    }

    $stmt->close();
}
?>  
</body>
</html>