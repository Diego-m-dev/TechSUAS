
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/models/cadunico/submit_model.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('salvo' => false); // Inicialmente definido como não encontrado


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Capturar dados do formulário
        $cod_familiar = $_POST['cod_fam'];
                    //Limpando o código familiar para salvar apenas os números
                    $cpf_limpo = preg_replace('/\D/', '', $_POST['cod_fam']);
                    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

        $data_entrevista = $_POST['data_entrevista_hoje'] ?? null;
        $sit_beneficio = $_POST['sit_beneficio'] ?? null;
        $obs_familia = $_POST['resumo'] ?? null;
        $tipo_doc = $_POST['tipo_documento'] ?? null;
        $operador = $_SESSION['nome_usuario'] ?? 'Desconhecido'; // Pegando usuário da sessão

        $stmt_dp = $conn->prepare("SELECT cod_familiar_fam, data_entrevista, tipo_documento 
        FROM cadastro_forms 
        WHERE cod_familiar_fam = ? AND data_entrevista = ? AND tipo_documento = ?");
            $stmt_dp->bind_param('sss', $ajustando_cod, $data_entrevista, $tipo_doc);
            $stmt_dp->execute();
            $stmt_dp->store_result();

            if ($stmt_dp->num_rows > 0) {
                $response['salvo'] = false;
                $response['msg'] = 'Já existe um cadastro com esses dados';
                echo json_encode($response);
                die(); // Para a execução do script corretamente
            }


        // Validar campos obrigatórios
        if (!$cod_familiar || !$data_entrevista || !$sit_beneficio) {
            throw new Exception("Preencha todos os campos obrigatórios.");
        }

        // Tratamento do upload de arquivo
        $caminho_arquivo = null;
        if (!empty($_FILES['arquivo']['name'])) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/upload_cad/'; // Pasta correta
            $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
            $novoNomeArquivo = uniqid() . '.' . $extensao;
            $caminhoCompleto = $uploadDir . $novoNomeArquivo;

            if ($_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Erro no upload: código " . $_FILES['arquivo']['error']);
            }

            if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
                throw new Exception("Diretório de upload inválido ou sem permissão: " . $uploadDir);
            }

            if (!move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminhoCompleto)) {
                throw new Exception("Erro ao mover o arquivo para o destino final.");
            }

            
            $caminho_arquivo = '/TechSUAS/upload_cad/' . $novoNomeArquivo; // Caminho salvo no banco
        }

        // Inserir dados no banco de dados
        $stmt = $pdo->prepare("INSERT INTO cadastro_forms 
            (cod_familiar_fam, data_entrevista, obs_familia, tipo_documento, sit_beneficio, operador, caminho_arquivo) 
            VALUES (:cod_familiar, :data_entrevista, :obs_familia, :tipo_documento, :sit_beneficio, :operador, :caminho_arquivo)");

        $stmt->execute([
            ':cod_familiar' => $ajustando_cod,
            ':data_entrevista' => $data_entrevista,
            ':obs_familia' => $obs_familia,
            ':sit_beneficio' => $sit_beneficio,
            ':operador' => $operador,
            ':tipo_documento' => $tipo_doc,
            ':caminho_arquivo' => $caminho_arquivo
        ]);

        $response['salvo'] = true;
        $response['mensagem'] = 'Formulário salvo com sucesso!';
        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(['msg' => "Erro: " . $e->getMessage()]);
    }
} else {
    echo "Acesso negado!";
}

$conn_1->close();
$conn->close();
?>
