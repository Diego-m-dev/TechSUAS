<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <script src="/TechSUAS/js/cadastro_unico.js"></script>
  <title>Recuperar senha - TechSUAS</title>
</head>
<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao_acesso.php';

if (empty($_POST['cpf_user'])) {
  // Se o CPF não foi enviado via POST, mostrar o formulário para inserir o CPF
  ?>
  <script>
    Swal.fire({
      title: "RECUPERAR SENHA",
      html: `
      <form method="POST" action="/TechSUAS/views/geral/recuperar_senha" id="form_familia">
        <label>
          <input id="cpf_user" type="text" name="cpf_user" placeholder="Informe seu CPF"/>
        </label>
      </form>
      `,
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
      didOpen: () => {
        $('#cpf_user').mask('000.000.000-00');
      }
    }).then((result) => {
      if (result.isConfirmed) {
        const form = document.getElementById("form_familia");
        form.submit();
      } else {
        window.location.href = '/';
      }
    });
  </script>
  <?php
} else {
  // Se o CPF foi enviado via POST, processar a recuperação de senha
  $cpf_user = $_POST['cpf_user'];

  // Verificar se o CPF existe no banco de dados
  $stmt = $conn_1->prepare("SELECT * FROM operadores WHERE cpf = ?");
  $stmt->bind_param("s", $cpf_user);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    // CPF não encontrado, exibir mensagem de erro
    ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Erro',
        text: 'CPF não encontrado.'
      }).then(() => {
        window.location.href = '/TechSUAS/views/geral/recuperar_senha';
      });
    </script>
    <?php
    exit();
  }

  // CPF encontrado, gerar token único para recuperação de senha
  $dados = $result->fetch_assoc();
  $email = $dados['email'];
  // Gerar token de recuperação
  $token = bin2hex(random_bytes(32)); // Gera um token de 64 caracteres hexadecimais (32 bytes)

  // Atualizar o banco de dados com o token de recuperação
  $stmt = $conn_1->prepare("UPDATE operadores SET token_recuperacao = ? WHERE cpf = ?");
  $stmt->bind_param("ss", $token, $cpf_user);
  $stmt->execute();

  // Preparar o email de recuperação com o link contendo o token
  $to = $email;
  $subject = 'Recuperação de Senha';
  $message = "Olá,\n\n";
  $message .= "Você está recebendo este email porque uma solicitação de recuperação de senha foi feita para sua conta.\n\n";
  $message .= "Para redefinir sua senha, clique no link abaixo:\n";
  $message .= "http://localhost/nova_senha.php?token=$token\n\n";
  $message .= "Se você não fez essa solicitação, ignore este email.\n\n";
  $message .= "Atenciosamente,\n";
  $message .= "Equipe de Suporte.\n";

  $headers = 'From: cadunico@tech-suas.com' . "\r\n" .
            'Reply-To: cadunico@tech-suas.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

  // Enviar o email
  if (mail($to, $subject, $message, $headers)) {
    ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Sucesso',
        text: 'Um link de recuperação foi enviado para o seu email.'
      }).then(() => {
        window.location.href = '/';
      });
    </script>
    <?php
  } else {
    ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Erro',
        text: 'Erro ao enviar email de recuperação.'
      }).then(() => {
        window.location.href = '/';
      });
    </script>
    <?php
  }
}
?>
</body>
</html>
