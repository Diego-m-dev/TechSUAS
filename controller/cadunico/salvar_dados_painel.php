<?php
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/');
include_once BASE_PATH . 'config/sessao.php';
include_once BASE_PATH . 'config/conexao.php';
include_once BASE_PATH . 'models/cadunico/submit_model.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificação de variáveis recebidas via POST
    if (isset($_POST['cod_fam']) && !empty($_POST['cod_fam'])) {
        $cod_familiar_fam = $conn->real_escape_string($_POST['cod_fam']);
    } else {
        echo "<script>alert('Código do familiar não foi fornecido.');</script>";
        exit();
    }

    $data_entrevista = $conn->real_escape_string($_POST['data_entrevista_hoje']);
    $sit_beneficio = $conn->real_escape_string($_POST['sit_beneficio']);
    $resumo = $conn->real_escape_string($_POST['resumo']);
    $tipo_documento = implode(', ', array_map('htmlspecialchars', $_POST['tipo_documento'])); 
    $operador = $_SESSION['nome_usuario'];

    // Verifica duplicidade
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cadastro_forms WHERE cod_familiar_fam = ? AND data_entrevista = ? AND tipo_documento = ?");
    $stmt->bind_param("sss", $cod_familiar_fam, $data_entrevista, $tipo_documento);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'DUPLICIDADE',
                text: 'Esse documento já existe',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/TechSUAS/views/cadunico/dashboard';
                }
            });
        </script>";
        exit();
    }

    // Upload do arquivo
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
        $arquivo_nome = $_FILES['arquivo']['name'];
        $arquivo_tamanho = $_FILES['arquivo']['size'];

        // Validação de tamanho de arquivo
        if ($arquivo_tamanho > 10485760) { // 10 MB
            echo "<script>alert('Arquivo excede o limite de tamanho permitido.');</script>";
            exit();
        }

        // Validar a extensão do arquivo
        $extensao = strtolower(pathinfo($arquivo_nome, PATHINFO_EXTENSION));
        $extensoes_permitidas = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
        if (!in_array($extensao, $extensoes_permitidas)) {
            echo "<script>alert('Extensão de arquivo inválida.');</script>";
            exit();
        }

        // Lê o conteúdo do arquivo
        $arquivo_binario = file_get_contents($arquivo_tmp);

        // Identifica o tipo MIME
        function getMimeType($filename) {
            $mime_types = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            return $mime_types[$extension] ?? 'application/octet-stream';
        }
        $arquivo_mime = getMimeType($arquivo_nome);

        // Garantir que apenas o nome do arquivo seja salvo, sem caminho
        $arquivo_nome = basename($arquivo_nome); // Remove o caminho e mantém apenas o nome do arquivo

        // Salva no banco de dados usando a Model
        $model = new CadastroModel($conn);
        $cadastro_adicionado = $model->adicionarCadastro(
            $cod_familiar_fam,
            $data_entrevista,
            $tipo_documento, 
            $arquivo_binario,
            $arquivo_tamanho,
            $arquivo_nome, // Nome do arquivo correto
            $arquivo_mime,
            $resumo, 
            $sit_beneficio,
            $operador
        );

        if ($cadastro_adicionado) {
            echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: 'Cadastro adicionado com sucesso!',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/TechSUAS/views/cadunico/dashboard';
                    }
                });
            </script>";
        } else {
            echo "<script>alert('Erro ao adicionar o cadastro.');</script>";
        }
    } else {
        echo "<script>alert('Erro no upload do arquivo.');</script>";
    }

    $conn->close();
}
?>
