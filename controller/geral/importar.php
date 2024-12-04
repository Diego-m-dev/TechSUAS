<?php
// Configuração do banco de dados
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

$pdo->exec("DELETE FROM `tbl_tudo`;");
$pdo->exec("ALTER TABLE `tbl_tudo` AUTO_INCREMENT = 1;");

// Obtém os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('debug_log.txt', print_r($data, true));


if (!$data || !isset($data['table']) || !isset($data['rows'])) {
    echo json_encode(['success' => false, 'error' => 'Dados inválidos.']);
    exit;
}

$table = 'tbl_tudo';
$rows = $data['rows'];

try {
  $pdo->exec("SET @IGNORE_TEMP_TRIGGERS = 1;"); // Desativa os gatilhos temporariamente
  $pdo->beginTransaction();

  // Obter a estrutura da tabela (colunas)
  $stmt = $pdo->query("DESCRIBE tbl_tudo");
  $tableColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);

  // Remover a coluna `id` se ela for AUTO_INCREMENT
  if (in_array('id', $tableColumns)) {
      $tableColumns = array_filter($tableColumns, function ($column) {
          return $column !== 'id';
      });
  }

  $columnsCount = count($tableColumns);
  $columns = implode(',', $tableColumns);

  // Criação da tabela temporária
  $tempTable = "temp_tbl_tudo";
  $pdo->exec("
      CREATE TEMPORARY TABLE `$tempTable` LIKE `tbl_tudo`;
  ");

  // Inserir dados na tabela temporária
  $placeholders = implode(',', array_fill(0, $columnsCount, '?'));
  $tempInsertQuery = "INSERT INTO `$tempTable` ($columns) VALUES ($placeholders)";
  $stmt = $pdo->prepare($tempInsertQuery);

  foreach ($rows as $row) {
      // Certificar que o número de valores corresponde ao número de colunas
      $row = array_slice($row, 0, $columnsCount);
      if (count($row) < $columnsCount) {
          // Preencher valores ausentes com NULL se houver menos valores que colunas
          $row = array_pad($row, $columnsCount, null);
      }
      $stmt->execute($row);
  }


  // Inserir dados da tabela temporária na tabela principal, evitando duplicidade
  $pdo->exec("
      INSERT INTO `tbl_tudo` ($columns)
      SELECT $columns FROM `$tempTable`
      ON DUPLICATE KEY UPDATE
      `tbl_tudo`.`id` = `tbl_tudo`.`id`;
  ");

  // Excluir a tabela temporária
  $pdo->exec("DROP TEMPORARY TABLE `$tempTable`;");

  $pdo->commit();
  echo json_encode(['success' => true, 'message' => 'Dados processados e enviados com sucesso!']);
} catch (Exception $e) {
  $pdo->rollBack();
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
  $pdo->exec("SET @IGNORE_TEMP_TRIGGERS = 0;"); // Reativa os gatilhos
}
