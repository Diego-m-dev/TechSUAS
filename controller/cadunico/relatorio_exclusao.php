<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

    $ids = $_POST['ids'];
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM cadastro_forms WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $arquivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Nenhum dado recebido.");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Relatório de Exclusão de Arquivos CadÚnico</title>
  <style>
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid black; padding: 8px; text-align: left; }
    h2 { text-align: center; }
    .assinatura { margin-top: 50px; }
  </style>
</head>
<body>
  <h2>Relatório de Exclusão de Arquivos - CadÚnico</h2>
  <p>Com base no Art. 2º da Portaria nº 177, arquivos com mais de 5 anos estão sendo excluídos conforme política de retenção de dados.</p>

  <table>
    <tr>
      <th>ID</th>
      <th>Código Familiar</th>
      <th>Data Entrevista</th>
      <th>Tipo Documento</th>
      <th>Arquivo</th>
    </tr>
    <?php foreach ($arquivos as $arquivo): ?>
    <tr>
      <td><?= htmlspecialchars($arquivo['id']) ?></td>
      <td><?= htmlspecialchars($arquivo['cod_familiar_fam']) ?></td>
      <td><?= htmlspecialchars($arquivo['data_entrevista']) ?></td>
      <td><?= htmlspecialchars($arquivo['tipo_documento']) ?></td>
      <td><?= htmlspecialchars($arquivo['caminho_arquivo']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>

    <div class="cidade_data">
        <?php echo $cidade; ?><?php echo $data_formatada_extenso; ?>.
    </div>
    
    <div class="assinatura">
        <p class="signature-line"></p>
        <p><?php echo $_SESSION['nome_usuario']; ?><br><?php echo $_SESSION['id_cargo']; ?></p>
    </div>

  <form method="POST" action="excluir_arquivos_definitivamente.php">
    <?php foreach ($ids as $id): ?>
      <input type="hidden" name="ids[]" value="<?= htmlspecialchars($id) ?>">
    <?php endforeach; ?>
    <button type="submit">Confirmar e Excluir</button>
  </form>

  <button onclick="window.print()">Imprimir Relatório</button>
</body>
</html>
