<?php
// Configurações do banco
$host = 'srv1898.hstgr.io';
$usuario_bd = "u444556286_sbu";
$senha_bd = "@ddvSBU33";
$banco = "u444556286_sbu";
$port = 3306;

// Token de autenticação
define('TOKEN_CORRETO', '#uploadTech@2025!');

header("Content-Type: application/json");

// Verificar método e token
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["erro" => "Método não permitido."]);
    exit;
}

if (($_POST['token'] ?? '') !== TOKEN_CORRETO) {
    http_response_code(403);
    echo json_encode(["erro" => "Token inválido."]);
    exit;
}

// Conexão
try {
    $conn = new mysqli($host, $usuario_bd, $senha_bd, $banco, $port);
    if ($conn->connect_error) {
        throw new Exception("Erro ao conectar: " . $conn->connect_error);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Erro na conexão: " . $e->getMessage()]);
    exit;
}

// Captura dos campos
$cpf = $conn->real_escape_string($_POST['num_cpf_pessoa'] ?? '');
$campos = [
    "cod_familiar_fam",
    "dta_entrevista_fam",
    "dat_atual_fam",
    "vlr_renda_media_fam",
    "nom_localidade_fam",
    "nom_tip_logradouro_fam",
    "nom_titulo_logradouro_fam",
    "nom_logradouro_fam",
    "num_logradouro_fam",
    "des_complemento_fam",
    "des_complemento_adic_fam",
    "num_cep_logradouro_fam",
    "nom_pessoa",
    "dta_nasc_pessoa",
    "cod_parentesco_rf_pessoa",
    "qtde_meses_desat_cat",
    "nom_entrevistador_fam",
    "num_cpf_entrevistador_fam"
];

$valores = [];
foreach ($campos as $campo) {
    $valores[$campo] = $conn->real_escape_string($_POST[$campo] ?? '');
}

// Verificar existência do CPF
$check_sql = "SELECT num_cpf_pessoa FROM tbl_tudo WHERE num_cpf_pessoa = '$cpf'";
$result = $conn->query($check_sql);

if ($result && $result->num_rows > 0) {
    // Atualizar
    $set = [];
    foreach ($valores as $campo => $valor) {
        $set[] = "$campo = '$valor'";
    }
    $update = "UPDATE tbl_tudo SET " . implode(", ", $set) . " WHERE num_cpf_pessoa = '$cpf'";

    if ($conn->query($update)) {
        echo json_encode(["salvo" => true, "mensagem" => "Atualizado com sucesso."]);
    } else {
        echo json_encode(["erro" => "Erro ao atualizar: " . $conn->error]);
    }
} else {
    // Inserir
    $cols = implode(", ", array_merge(["num_cpf_pessoa"], array_keys($valores)));
    $vals = implode(", ", array_map(fn($v) => "'$v'", array_merge([$cpf], array_values($valores))));
    $insert = "INSERT INTO tbl_tudo ($cols) VALUES ($vals)";

    if (!$conn->query($insert)) {
        http_response_code(400);
        echo json_encode([
            "erro" => "Erro ao inserir",
            "detalhe_sql" => $conn->error,
            "query" => $insert
        ]);
        exit;
    }
}
$conn->close();
?>