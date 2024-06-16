<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

  <title>Salvando</title>
</head>

<body>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php'; // Ajuste o caminho conforme necessário

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se há erros no upload do arquivo
    if ($_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
        die("Erro no upload do arquivo. Código de erro: " . $_FILES['arquivo']['error']);
    }

    $cod_familiar_fam = $_POST['cod_fam'];
    $data_entrevista = $_POST['data_entrevista'] == "" ? date('Y-m-d') : $_POST['data_entrevista'];
    $tipo_documento = implode(", ", $_POST['tipo_documento']); // Converte array para string, se necessário
    $tipo_arquivo = '.pdf';
    $arquivo = file_get_contents($_FILES['arquivo']['tmp_name']); // Lê o conteúdo do arquivo
    
    $tamanho = $_FILES['arquivo']['size'];
    $verificado = 0;

    // Prepara a declaração SQL
    $stmt = $conn->prepare("INSERT INTO cadastro_forms (cod_familiar_fam, data_entrevista, tipo_documento, tipo_arquivo, arquivo, tamanho, verificado, obs_familia, sit_beneficio, operador) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verifica se a preparação da declaração teve êxito
    if ($stmt === false) {
        die('Erro na preparação da declaração SQL: ' . $conn->error);
    }

    // Faz o binding dos parâmetros e executa a declaração
    $stmt->bind_param("ssssssisss", 
        $cod_familiar_fam, 
        $data_entrevista, 
        $tipo_documento, 
        $tipo_arquivo, 
        $arquivo, 
        $tamanho, 
        $verificado, 
        $_POST['resumo'], 
        $_POST['sit_beneficio'], 
        $_SESSION['nome_usuario']
    );

    // Executa a declaração SQL
    if ($stmt->execute()) {
?>
  <script>
    Swal.fire({
      icon: "success",
      title: "SALVO",
      text: "Os dados foram salvos com sucesso!",
      confirmButtonText: "OK"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "/TechSUAS/views/cadunico/dashboard"
      }
    })
  </script>
<?php
    } else {
        echo "Erro ao cadastrar formulário: " . $stmt->error;
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>