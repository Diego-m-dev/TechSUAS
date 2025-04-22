<?php
require_once 'config.php'; // Importa a conexão com os bancos

$tabelas = ["concessao_historico", /*"concessao_itens", "concessao_tbl", "descricao_tecnica", "historico_concessao"*/];

foreach ($tabelas as $tabela) {
    echo "Mesclando tabela: $tabela...<br>";

    // Busca todos os registros do primeiro banco
    $sql = "SELECT * FROM $tabela";
    $stmt = $pdo1->query($sql);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dados as $linha) {
        // Gerando uma query dinâmica com base nos campos da tabela
        $colunas = implode(", ", array_keys($linha));
        $valores = ":" . implode(", :", array_keys($linha));

        $sqlInsert = "INSERT INTO $db2.$tabela ($colunas) VALUES ($valores) 
                      ON DUPLICATE KEY UPDATE ";

        // Criando a parte dinâmica para atualizar registros duplicados
        $updates = [];
        foreach ($linha as $coluna => $valor) {
            $updates[] = "$coluna = VALUES($coluna)";
        }
        $sqlInsert .= implode(", ", $updates);

        $stmtInsert = $pdo2->prepare($sqlInsert);
        $stmtInsert->execute($linha);
    }

    echo "Tabela $tabela mesclada com sucesso!<br>";
}
?>
