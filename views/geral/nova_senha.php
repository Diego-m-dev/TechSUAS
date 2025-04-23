<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';

// Verifica se o token foi passado como parâmetro na URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consulta o banco para encontrar o usuário com o token
    $stmt = $conn_1->prepare("SELECT * FROM operadores WHERE token_recuperacao = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o token é válido
    if ($result->num_rows > 0) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nova_senha'])) {
            // Valida e atualiza a senha
            $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_BCRYPT);

            // Atualiza a senha e remove o token de recuperação
            $stmt_update = $conn_1->prepare("UPDATE operadores SET senha = ?, token_recuperacao = NULL WHERE token_recuperacao = ?");
            $stmt_update->bind_param("ss", $nova_senha, $token);
            $stmt_update->execute();

            echo "<script>
                    alert('Senha redefinida com sucesso!');
                    window.location.href = '/';
                  </script>";
            exit();
        }
    } else {
        echo "Token inválido ou expirado.";
        exit();
    }
} else {
    echo "Token não fornecido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/TechSUAS/css/geral/p-acesso.css">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <link rel="icon" href="" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div id="position-form">
        <form method="POST">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" name="nova_senha" id="nova_senha" required>
            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
</body>
</html>
