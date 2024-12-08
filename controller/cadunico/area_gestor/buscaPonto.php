<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON


if (isset($_POST['nis_servidor'])) {
    $nis_servidor = $_POST['nis_servidor'];
    $mes_servidor = $_POST['mes_servidor'];
    $ano_servidor = $_POST['ano_servidor'];

    // Consulta única para obter dados da família e a data da entrevista do responsável familiar
    $stmt = "SELECT DATE_FORMAT(data_registro, '%d/%m/%Y') AS data_registro,
                IFNULL(hora_entrada, '') AS hora_entrada,
                IFNULL(hora_pausa, '') AS hora_pausa,
                IFNULL(hora_volta, '') AS hora_volta,
                IFNULL(hora_saida, '') AS hora_saida,
                IFNULL(registro_ponto, '') AS registro_ponto,
                IFNULL(nis, '') AS nisEntre
              FROM calculo_horas
              WHERE nis = '$nis_servidor' AND YEAR(data_registro) = '$ano_servidor' AND MONTH(data_registro) = '$mes_servidor'
              ORDER BY data_registro ASC";
    
    $result = $conn->query($stmt);
    $dados = $result->fetch_all(MYSQLI_ASSOC);

              // Retorna a resposta JSON com base no valor de 'encontrado'
          if ($dados) {
            $response = true;
          } else {
            $response = false;
          }

          echo json_encode([
            'response' => $response,
            'dados_servidor' => $dados
          ]);


      } else {
    http_response_code(400);
    echo json_encode(array('error' => 'Parâmetro "codfam" não recebido.'));
}
