<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_POST['arm'])) {
  $arm = $_POST['arm'];

  // Consulta otimizada com JOIN para evitar múltiplas consultas dentro do loop
  $stmt_ficha = $pdo->prepare("SELECT 
      f.pas, f.gav, f.arm, 
      COALESCE(t.cod_familiar_fam, CONCAT('V7 - ', fich.codfam, ' - V7')) AS codfam
    FROM ficharios f

    LEFT JOIN (
      SELECT codfam, 
            CONVERT(arm_gav_pas USING utf8mb3) COLLATE utf8mb3_general_ci AS arm_gav_pas
      FROM fichario
    ) fich

    ON CONVERT(CONCAT(LPAD(f.arm, 2, '0'), ' - ', LPAD(f.gav, 2, '0'), ' - ', LPAD(f.pas, 3, '0')) USING utf8mb3) COLLATE utf8mb3_general_ci = fich.arm_gav_pas

    LEFT JOIN (
      SELECT cod_familiar_fam 
      FROM tbl_tudo 
      WHERE cod_parentesco_rf_pessoa = 1
    ) t 

    ON t.cod_familiar_fam = LPAD(REPLACE(fich.codfam, '\D', ''), 11, '0')
    WHERE f.arm = :arm
    ORDER BY f.gav, f.pas
  ");

  $stmt_ficha->execute(array(':arm' => $arm));

  $response = ['encontrado' => false, 'pastas' => []];

  if ($stmt_ficha->rowCount() != 0) {
    $response['encontrado'] = true;
    while ($dados_ficha = $stmt_ficha->fetch(PDO::FETCH_ASSOC)) {
      $response['pastas'][] = [
        'pasta' => $dados_ficha['pas'],
        'gaveta' => $dados_ficha['gav'],
        'codfam' => $dados_ficha['codfam']
      ];
    }
  }
  
  echo json_encode($response);
} else {
  http_response_code(400);
  echo json_encode(['error' => 'Parâmetro "arm" não recebido.']);
}
$conn->close();
