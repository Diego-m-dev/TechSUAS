<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_POST['arm'])) {

  $arm = $_POST['arm'];

  $stmt_ficha = $pdo->prepare("SELECT pas, gav, arm FROM ficharios WHERE arm = :arm ORDER BY gav, pas");
  $stmt_ficha->execute(array(':arm' => $arm));
  
  if ($stmt_ficha->rowCount() != 0) {
    $response['encontrado'] = true;
    while ($dados_ficha = $stmt_ficha->fetch(PDO::FETCH_ASSOC)) {

      $arm = $dados_ficha['arm'];
      $gav = $dados_ficha['gav'];
      $pasta = $dados_ficha['pas'];

      $arm_gav_pas = sprintf("%02d - %02d - %02d", $arm, $gav, $pasta);
      $sql_codfam = "SELECT codfam FROM fichario WHERE arm_gav_pas = '$arm_gav_pas'";
      $sql_codfam_query = $conn->query($sql_codfam) or de("Erro " . $conn - error);

      if ($sql_codfam_query->num_rows > 0) {
        $dados_codfam = $sql_codfam_query->fetch_assoc();
        $codfam_1 = $dados_codfam['codfam'];
        $cpf_limpo = preg_replace('/\D/', '', $codfam_1);
        $ajustando_cod = str_pad($cpf_limpo, 11,'0',STR_PAD_LEFT);
    
          $sql_tudo = "SELECT cod_familiar_fam FROM tbl_tudo WHERE cod_familiar_fam = '$ajustando_cod' AND cod_parentesco_rf_pessoa = 1";
          $sql_tudo_query = $conn->query($sql_tudo) or die("Erro na preparação COD: Y909X");
          if ($sql_tudo_query->num_rows > 0) {
            $dados_tudo = $sql_tudo_query->fetch_assoc();
            $codfam = $dados_tudo['cod_familiar_fam'];
          } else {
            $codfam = "V7 - " . $codfam_1 . " - V7";
          }

      } else {
        $codfam = '';
      }


      $response['pastas'][] = array(
        'pasta' => $dados_ficha['pas'],
        'gaveta' => $dados_ficha['gav'],
        'codfam' => $codfam
      );
    }
  }
        echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "codfam" não recebido.'));
}
$conn->close();