<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

function processFile($filePath) {
  global $conn;

  $file = fopen($filePath, 'r');
  if ($file) {
      echo "Arquivo aberto com sucesso.<br>";
      $horariosPorNis = [];

      while (($line = fgets($file)) !== false) {
          echo "Processando linha: $line<br>";
          
          $registro = substr($line, 0, 10);
          $data = substr($line, 10, 8);
          $hora = substr($line, 18, 4);
          $nis = ltrim(substr($line, 22, 12), '0');

          if (strlen($data) !== 8) {
              echo "Erro: formato de data inválido ($data) na linha: $line<br>";
              continue;
          }

          $data_formatada = DateTime::createFromFormat('dmY', $data);
          if (!$data_formatada) {
              echo "Erro ao formatar a data: $data na linha: $line<br>";
              continue;
          } else {
              $data_formatada = $data_formatada->format('Y-m-d');
              echo "Data formatada: $data_formatada<br>";
          }

          if (strlen($hora) !== 4) {
              echo "Erro: formato de hora inválido ($hora) na linha: $line<br>";
              continue;
          }

          $hora_formatada = DateTime::createFromFormat('Hi', $hora);
          if (!$hora_formatada) {
              echo "Erro ao formatar a hora: $hora na linha: $line<br>";
              continue;
          } else {
              $hora_formatada = $hora_formatada->format('H:i');
              echo "Hora formatada: $hora_formatada<br>";
          }

          if (!isset($horariosPorNis[$nis])) {
              $horariosPorNis[$nis] = [];
          }
          $horariosPorNis[$nis][$data_formatada][] = $hora_formatada;
      }
      fclose($file);
      echo "Arquivo processado com sucesso.<br>";

      foreach ($horariosPorNis as $nis => $dias) {
          foreach ($dias as $data => $horarios) {
              processarCalculoHoras($nis, $data, $horarios, $conn);
          }
      }
  } else {
      echo "Erro ao abrir o arquivo.<br>";
  }
}

function processarCalculoHoras($nis, $data, $horarios, $conn) {
    usort($horarios, function($a, $b) {
        return strtotime($a) - strtotime($b);
    });

    $entrada = $horarios[0] ?? null;
    $pausa = $horarios[1] ?? null;
    $volta = $horarios[2] ?? null;
    $saida = $horarios[3] ?? null;

    // Obtém o dia da semana e mapeia para o formato em português
    $diaSemanaIngles = (new DateTime($data))->format('D');
    $diasSemana = [
        'Sun' => 'dom',
        'Mon' => 'seg',
        'Tue' => 'ter',
        'Wed' => 'qua',
        'Thu' => 'qui',
        'Fri' => 'sex',
        'Sat' => 'sab'
    ];
    $diaSemanaPortugues = $diasSemana[$diaSemanaIngles] ?? '';

    // Busca os horários programados na `carga_horaria` usando o dia da semana em português
    $sql = "SELECT * FROM carga_horaria WHERE nis = ? AND dia_semana = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $nis, $diaSemanaPortugues);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $horario_programado = $resultado->fetch_assoc();

    if ($horario_programado) {
        // Calcula as diferenças
        $dif_entrada = calcularDiferencaHoras($entrada, $horario_programado['hora_entrada']);
        $dif_pausa = calcularDiferencaHoras($pausa, $horario_programado['hora_pausa']);
        $dif_volta = calcularDiferencaHoras($volta, $horario_programado['hora_volta']);
        $dif_saida = calcularDiferencaHoras($saida, $horario_programado['hora_saida']);
        
        // Insere os dados na tabela `calculo_horas`
        $sql_insert = "INSERT INTO calculo_horas (nis, data_registro, hora_entrada, hora_pausa, hora_volta, hora_saida,
                        dif_hora_entrada, dif_hora_pausa, dif_hora_volta, dif_hora_saida)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param(
            'isssssssss',
            $nis, $data, $entrada, $pausa, $volta, $saida, 
            $dif_entrada, $dif_pausa, $dif_volta, $dif_saida
        );
        $stmt_insert->execute();
    } else {
        echo "Nenhum horário programado encontrado para NIS $nis no dia $diaSemanaPortugues ($data).<br>";
    }
}

function calcularDiferencaHoras($hora_real, $hora_programada) {
  if (!$hora_real || !$hora_programada) return null;
  $hora_real_dt = new DateTime($hora_real);
  $hora_programada_dt = new DateTime($hora_programada);
  $intervalo = $hora_programada_dt->diff($hora_real_dt);
  return $intervalo->format('%H:%I:%S');
}

$filePath = $_post['DOCUMENT_ROOT'];
if (file_exists($filePath)) {
  processFile($filePath);
} else {
  echo "Arquivo não encontrado: $filePath<br>";
}
$conn->close();

?>