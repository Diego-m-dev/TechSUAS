<?php
// Configuração do banco de dados
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Limpar a tabela 'tbl_tudo'
    $plasdfe = $pdo->prepare("TRUNCATE tbl_tudo");
    $plasdfe->execute();

// Obtém os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('debug_log.txt', print_r($data, true), FILE_APPEND);

if (!$data || !isset($data['table']) || !isset($data['rows'])) {
    echo json_encode(['success' => false, 'error' => 'Dados inválidos ou faltando.']);
    exit;
}

$table = 'tbl_tudo';
$rows = $data['rows'];

try {
    // Inicia uma transação
    $pdo->exec("SET @IGNORE_TEMP_TRIGGERS = 1;"); // Desativa os gatilhos temporariamente
    $pdo->beginTransaction();

    // Obter a estrutura da tabela (colunas)
    $stmt = $pdo->query("DESCRIBE $table");
    $tableColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Remover a coluna `id` se ela for AUTO_INCREMENT
    if (in_array('id', $tableColumns)) {
        $tableColumns = array_filter($tableColumns, function ($column) {
            return $column !== 'id';
        });
    }

    $columnsCount = count($tableColumns);
    $columns = implode(',', $tableColumns);
    $placeholders = implode(',', array_fill(0, $columnsCount, '?'));

    // Inserir os dados recebidos no banco de dados
    $query = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";
    $stmt = $pdo->prepare($query);

    foreach ($rows as $row) {
        // Certificar que o número de valores corresponde ao número de colunas
        $row = array_slice($row, 0, $columnsCount);
        if (count($row) < $columnsCount) {
            $row = array_pad($row, $columnsCount, null); // Preencher valores ausentes com NULL
        }
        $stmt->execute($row);
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Lote processado com sucesso!']);
} catch (Exception $e) {
    $pdo->rollBack();
    file_put_contents('debug_log.txt', "Erro: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $pdo->exec("SET @IGNORE_TEMP_TRIGGERS = 0;"); // Reativa os gatilhos
}