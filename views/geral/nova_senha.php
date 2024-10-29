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
                    window.location.href = '/login';
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
</head>
<body>
    <form method="POST">
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" name="nova_senha" id="nova_senha" required>
        <button type="submit">Redefinir Senha</button>
    </form>
</body>
</html>
