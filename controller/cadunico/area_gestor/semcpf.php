<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Função para executar consulta SQL e retornar os resultados
function executeQuery($conn, $query) {
    $result = $conn->query($query);
    if (!$result) {
        die("ERRO na consulta: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// SQL para buscar os dados
$solicitacao_sql = "SELECT
    cod_familiar_fam, nom_pessoa, num_nis_pessoa_atual
    FROM tbl_tudo
    WHERE num_cpf_pessoa = ''
    ORDER BY nom_localidade_fam ASC, nom_tip_logradouro_fam ASC, nom_logradouro_fam ASC, num_logradouro_fam
";

// Executar consulta
$dados_unipessoal = executeQuery($conn, $solicitacao_sql);

// Configurar o cabeçalho como JSON
header('Content-Type: application/json');

// Retornar os dados como JSON
echo json_encode($dados_unipessoal);

// Fechar a conexão com o banco de dados
$conn->close();
?>