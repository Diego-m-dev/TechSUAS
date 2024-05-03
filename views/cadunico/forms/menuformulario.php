<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSUAS - Formulários</title>
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/menu_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png" >
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
</head>
<body>
  <header>
    <h1 class="titulo-com-imagem">
        <img src="/TechSUAS/img/cadunico/forms/h1-formularios.svg" alt="Titulocomimagem">
    </h1>
  </header>
  <nav>
    <a type="button" id="btn_residencia">
      <i class="fas fa-home icon"></i> Termo de Declaração de Residência
    </a>

    <a href="Termo_declaracao" target="_blank">
      <i class="fas fa-file-invoice-dollar icon"></i> Termo de Declaração de Renda
    </a>

    <a href="Ficha_de_Exclusão_de_Familia" target="_blank">
      <i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Familia
    </a>

    <a href="Ficha_de_Exclusão_de_Pessoa" target="_blank">
      <i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Pessoa
    </a>

    <a href="/TechSUAS/config/back.php">
      <i class="fas fa-arrow-left"></i> Voltar ao menu
    </a>
  </nav>  
<script>
$('#btn_residencia').click(function () {
    Swal.fire({
        title: "INFORME O CPF",
        html: `
      <form method="POST" action="termo_responsabilidade" id="form_residencia">
        <label> CPF:
          <input type="text" name="cpf_residencia"/>
        </label>
      </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
    if (result.isConfirmed) {
      const form = document.getElementById("form_residencia")
      form.submit()
    }
  })
})
</script>
<script src="/TechSUAS/js/cpfvalid.js"></script>
</body>
</html>