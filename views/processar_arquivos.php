<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

// Definir tamanho do lote (quantos registros serão processados por vez)
$lote = 100;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

// Diretório onde os arquivos serão salvos (garantindo que exista)
$diretorio = $_SERVER['DOCUMENT_ROOT'] . "/TechSUAS/upload_cad/";
if (!is_dir($diretorio)) {
    mkdir($diretorio, 0777, true);
}

// Buscar um lote de arquivos do banco
$query = $pdo->prepare("SELECT id, arquivo, nome_arquivo FROM cadastro_forms WHERE arquivo IS NOT NULL LIMIT :lote OFFSET :offset");
$query->bindValue(':lote', $lote, PDO::PARAM_INT);
$query->bindValue(':offset', $offset, PDO::PARAM_INT);
$query->execute();
$registros = $query->fetchAll(PDO::FETCH_ASSOC);

// Se não houver mais registros, finaliza a execução
if (empty($registros)) {
    echo "Todos os arquivos foram exportados com sucesso!";
    exit;
}

foreach ($registros as $registro) {
    $id = $registro['id'];
    $arquivo = $registro['arquivo']; // Correto
    $nome_original = $registro['nome_arquivo'];

    if (!empty($arquivo)) {
        // Criar um nome de arquivo seguro
        $nome_arquivo = "documento_" . $id . "_" . basename($nome_original);
        $caminho_completo = $diretorio . $nome_arquivo;

        // Salvar o arquivo no servidor
        file_put_contents($caminho_completo, $arquivo);

        // Caminho a ser salvo no banco (relativo ao site)
        $caminho_relativo = "/TechSUAS/upload_cad/" . $nome_arquivo;

        // Atualizar o banco para armazenar o caminho do arquivo
        $stmt = $pdo->prepare("UPDATE cadastro_forms SET caminho_arquivo = ? WHERE id = ?");
        $stmt->execute([$caminho_relativo, $id]);
    }
}

// Redireciona para processar o próximo lote
$novo_offset = $offset + $lote;
echo "Lote de $lote arquivos exportado! Processando próximo lote...<br>";
echo "<script>setTimeout(() => { window.location.href = '?offset=$novo_offset'; }, 2000);</script>";
?>
