<?php
// Configurações do banco
$host = 'srv1898.hstgr.io';
$usuario_bd = "u444556286_sbu";
$senha_bd = "@ddvSBU33";
$banco = "u444556286_sbu";
$port = 3306;

// Caminho do arquivo de log
$logFile = __DIR__ . '/debug_upload.txt';
function log_debug($msg) {
    global $logFile;
    file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] " . $msg . PHP_EOL, FILE_APPEND);
}

log_debug("=== Nova requisição recebida ===");
log_debug("POST: " . print_r($_POST, true));
log_debug("FILES: " . print_r($_FILES, true));

header('Content-Type: application/json');

// Token de segurança
define('TOKEN_SEGURANCA', '#uploadTech@2025!'); // Alterar para algo seguro

// Verificação do token
$token = $_POST['token'] ?? $_REQUEST['token'] ?? null;
if ($token !== TOKEN_SEGURANCA) {
    http_response_code(403);
    echo json_encode(['erro' => 'Acesso não autorizado.']);
    log_debug("Falha na autenticação: token inválido.");
    exit;
}

// Conexão com o banco usando apenas PDO
try {
    $pdo = new PDO("mysql:dbname=$banco;host=$host;port=$port", $usuario_bd, $senha_bd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    ]);
    log_debug("Conexão PDO estabelecida com sucesso.");
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/erro_detalhado.txt', $e->getMessage());
    http_response_code(500);
    echo json_encode(['erro' => 'Erro na conexão com o banco: ' . $e->getMessage()]);
    log_debug("Erro na conexão com o banco: " . $e->getMessage());
    exit;
}

$response = ['salvo' => false];

try {
    // Validar campos obrigatórios
    $campos = ['cod_fam', 'data_entrevista_hoje', 'sit_beneficio', 'tipo_documento'];
    foreach ($campos as $campo) {
        if (empty($_POST[$campo])) {
            throw new Exception("Campo obrigatório '$campo' está faltando.");
        }
    }

    // Preparar variáveis
    $cpf_limpo = preg_replace('/\D/', '', $_POST['cod_fam']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);
    $data_entrevista = $_POST['data_entrevista_hoje'];

    $sit_beneficio_map = [
        1 => 'APENAS UPLOAD',
        2 => 'BENEFICIO NORMALIZADO',
        3 => 'NÃO TEM BENEFÍCIO',
        4 => 'FIM DE RESTRIÇÃO ESPECIFICA',
        5 => 'CANCELADO',
        6 => 'BLOQUEADO'
    ];
    $sit_beneficio = $sit_beneficio_map[$_POST['sit_beneficio']] ?? null;

    $tipo_doc_maps = [
        1 => 'Cadastro',
        2 => 'Atualização',
        3 => 'Assinatura',
        4 => 'Fichas exclusão',
        5 => 'Relatórios',
        6 => 'Parecer visitas',
        7 => 'Documento externo',
        8 => 'Termos'
    ];
    $tipo_doc = $tipo_doc_maps[$_POST['tipo_documento']] ?? null;

    $obs_familia = $_POST['resumo'] ?? '';
    $operador = $_POST['operador'] ?? 'FORMA AUTOMATICA';

    // Validação de arquivo
    if (empty($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Falha no upload do arquivo.");
    }

    $ext = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));
    if ($ext !== 'pdf') {
        throw new Exception("Apenas arquivos PDF são permitidos.");
    }

    // Verificar duplicidade usando apenas PDO
    $stmt_dp = $pdo->prepare("SELECT COUNT(*) FROM cadastro_forms 
                              WHERE cod_familiar_fam = :cod AND data_entrevista = :data AND tipo_documento = :tipo");
    $stmt_dp->execute([':cod' => $ajustando_cod, ':data' => $data_entrevista, ':tipo' => $tipo_doc]);
    if ($stmt_dp->fetchColumn() > 0) {
        throw new Exception("Já existe um registro com esses dados.");
    }

    // Upload
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/upload_cad/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
        log_debug("Diretório criado: $uploadDir");
    }

    $novoNome = uniqid("upload_", true) . ".pdf";
    $caminhoCompleto = $uploadDir . $novoNome;

    if (!move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminhoCompleto)) {
        throw new Exception("Erro ao salvar o arquivo no servidor.");
    }

    $caminho_arquivo = '/TechSUAS/upload_cad/' . $novoNome;

    // Inserção no banco
    $stmt = $pdo->prepare("INSERT INTO cadastro_forms 
        (cod_familiar_fam, data_entrevista, obs_familia, tipo_documento, sit_beneficio, operador, caminho_arquivo)
        VALUES (:cod_familiar, :data_entrevista, :obs_familia, :tipo_documento, :sit_beneficio, :operador, :caminho_arquivo)");

    $stmt->execute([
        ':cod_familiar' => $ajustando_cod,
        ':data_entrevista' => $data_entrevista,
        ':obs_familia' => $obs_familia,
        ':tipo_documento' => $tipo_doc,
        ':sit_beneficio' => $sit_beneficio,
        ':operador' => $operador,
        ':caminho_arquivo' => $caminho_arquivo
    ]);

    $response['salvo'] = true;
    $response['mensagem'] = 'Upload e inserção bem-sucedidos.';
    echo json_encode($response);

    log_debug("Upload e inserção bem-sucedidos. Arquivo: $caminho_arquivo");
    $pdo = null;

} catch (Exception $e) {
    file_put_contents(__DIR__ . '/erro_detalhado.txt', $e->getMessage());
    http_response_code(400);
    $response['erro'] = $e->getMessage();
    echo json_encode($response);
    log_debug("Erro: " . $e->getMessage());
}