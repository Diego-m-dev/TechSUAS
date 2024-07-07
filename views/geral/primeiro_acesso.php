<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

if ($_SESSION['acesso'] == 0) {
  ?>
  <script>
    window.history.back()
  </script>
  <?php
  exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primeiro acesso</title>
    <link rel="stylesheet" href="/TechSUAS/css/geral/p-acesso.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/geral/h1-p-acesso.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <h3>Bem-vindo (a)
            <?php echo $_SESSION['nome_usuario']; ?>, esse é o seu primeiro acesso. Informe seus dados.
        </h3>
        <form method="post" action="/TechSUAS/controller/geral/dados_alterados.php">
            <div class="nome">
                <label>Nome Completo:</label>
                <input type="text" name="nome_comp" oninput="sempre_maiusculo(this)" placeholder="Digite seu nome completo." required>
            </div>
            <div class="nomesocial">
                <label>Nome Social/apelido:</label>
                <input type="text" name="apelido" oninput="sempre_maiusculo(this)" placeholder="" required>
            </div>
            <div class="cpf">
                <label>CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Apenas números." maxlength="14" required onblur="validarCPF(this)" required>
            </div>
            <div id="res" name="res"></div>
            <div class="dtnasc">
                <label>Data de Nascimento:</label>
                <input type="date" name="dt_nasc" required>
            </div>
            <div class="email">
                <label>E-mail:</label>
                <input type="email" name="email" placeholder="E-mail particular." required>
            </div>
            <div class="telefone">
                <label>Telefone:</label>
                <input type="text" id="telefone" name="telefone" placeholder="Exemplo: (xx) x xxxx-xxxx." required>
            </div>
            <div class="cargo">
                <label>Cargo:</label>
                <input type="text" name="cargo" oninput="sempre_maiusculo(this)" required>
            </div>
            <div class="idcargo">
                <label>Identificação do Cargo:</label>
                <input type="text" name="id_cargo" placeholder="Matricula ou Certificado." required>
            </div>
            <div class="senha">
                <label>Nova Senha:</label>
                    <input type="password" name="senha" id="senha" placeholder="Escolha uma nova senha." required>
                    <i class="far fa-eye" id="togglePassword"></i>
            </div>
            <div class="btn">
                <button type="submit">Concluir Cadastro</button>
            </div>

        </form>

    </div>

    <script src="/TechSUAS/js/personalise.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword')
    const senhaInput = document.getElementById('senha')

      togglePassword.addEventListener('click', function() {
          const type = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password'
          senhaInput.setAttribute('type', type)
          this.classList.toggle('fa-eye')
          this.classList.toggle('fa-eye-slash')
      })
    })
    </script>
</body>

</html>