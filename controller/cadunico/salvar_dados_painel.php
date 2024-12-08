<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/models/cadunico/submit_model.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $cod_familiar_fam = $conn->real_escape_string($_POST['cod_fam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['cod_fam']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

    $data_entrevista = $_POST['data_entrevista_hoje'];
    $sit_beneficio = $_POST['sit_beneficio'];
    $resumo = $_POST['resumo']; 
    $tipo_documento = implode(', ', $_POST['tipo_documento']); // Certifique-se de que o tipo_documento esteja em formato correto
    $operador = $_SESSION['nome_usuario'];

    // Verifica duplicação
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cadastro_forms WHERE cod_familiar_fam = ? AND data_entrevista = ? AND tipo_documento = ?");
    $stmt->bind_param("sss", $ajustando_cod, $data_entrevista, $tipo_documento);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
?>
<script>
  Swal.fire({
    icon: 'warning',  // Corrigido o nome do ícone
    title: 'DUPLICIDADE',
    text: 'Esse documento já existe',
    confirmButtonText: 'OK',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '/TechSUAS/views/cadunico/dashboard';
    }
  });
</script>
<?php
        exit();
    } else {
        if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
            $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
            $arquivo_nome = $_FILES['arquivo']['name'];
            $arquivo_tamanho = $_FILES['arquivo']['size'];
            $arquivo_tipo = $_FILES['arquivo']['type'];

            function getMimeType($filename) {
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                switch ($extension) {
                    case 'pdf':
                        return 'application/pdf';
                    case 'jpg':
                    case 'jpeg':
                        return 'image/jpeg';
                    default:
                        return 'application/octet-stream';
                }
            }

            $arquivo_mime = getMimeType($arquivo_nome);
            $arquivo_binario = file_get_contents($arquivo_tmp);

            $model = new CadastroModel($conn);
            $cadastro_adicionado = $model->adicionarCadastro(
                $ajustando_cod,
                $data_entrevista,
                $tipo_documento, 
                $arquivo_binario,
                $arquivo_tamanho,
                $arquivo_nome,
                $arquivo_mime,
                $resumo, 
                $sit_beneficio,
                $operador 
            );

            if ($cadastro_adicionado) {
                echo "<script>alert('Cadastro adicionado com sucesso.');</script>";
            } else {
                echo "<script>alert('Erro ao adicionar o cadastro.');</script>";
            }
        } else {
            echo "<script>alert('Erro no upload do arquivo.');</script>";
        }
    }
  $conn->close();
}
?>