<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

function processFile($filePath) {
  global $conn;

  $file = fopen($filePath, 'r');
  if ($file) {
      $horariosPorNis = []; // Armazena os horários por NIS e data

      while (($line = fgets($file)) !== false) {
          // Extrai os dados da linha do arquivo
          $registro_completo = trim($line); // Código completo do registro
          $registro = substr($line, 0, 10);
          $data = substr($line, 10, 8);
          $hora = substr($line, 18, 4);
          $nis = ltrim(substr($line, 22, 12), '0');

          if (strlen($data) !== 8) {
            echo "Erro: formato de data inválido ($data) na linha: $line<br>";
            continue;
          }

          $data_formatada = DateTime::createFromFormat('dmY', $data)->format('Y-m-d');
          $hora_formatada = DateTime::createFromFormat('Hi', $hora)->format('H:i');

          if (!isset($horariosPorNis[$nis])) {
              $horariosPorNis[$nis] = [];
          }
          $horariosPorNis[$nis][$data_formatada][] = [
              'hora' => $hora_formatada,
              'registro_completo' => $registro_completo
          ];
      }
      fclose($file);

      foreach ($horariosPorNis as $nis => $dias) {
          foreach ($dias as $data => $horarios) {
              processarCalculoHoras($nis, $data, $horarios, $conn);
          }
      }
  } else {
      echo "Erro ao abrir o arquivo.";
  }
}

function processarCalculoHoras($nis, $data, $horarios, $conn) {
  usort($horarios, function($a, $b) {
      return strtotime($a['hora']) - strtotime($b['hora']);
  });

  $entrada = $horarios[0]['hora'] ?? null;
  $pausa = $horarios[1]['hora'] ?? null;
  $volta = $horarios[2]['hora'] ?? null;
  $saida = $horarios[3]['hora'] ?? null;

  $registro_ponto = $horarios[0]['registro_completo']; // Usando o primeiro registro completo como referência para evitar duplicação

  // Verifica se o registro já existe na tabela `calculo_horas`
  $sql_check = "SELECT COUNT(*) FROM calculo_horas WHERE registro_ponto = ?";
  $stmt_check = $conn->prepare($sql_check);
  $stmt_check->bind_param('s', $registro_ponto);
  $stmt_check->execute();
  $stmt_check->bind_result($count);
  $stmt_check->fetch();
  $stmt_check->close();

  if ($count > 0) {
      echo "Registro já existe para o código: $registro_ponto. Ignorando duplicado.<br>";
      return;
  }

  // Determina o dia da semana em português
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
                      dif_hora_entrada, dif_hora_pausa, dif_hora_volta, dif_hora_saida, registro_ponto)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt_insert = $conn->prepare($sql_insert);
      $stmt_insert->bind_param(
          'issssssssss',
          $nis, $data, $entrada, $pausa, $volta, $saida, 
          $dif_entrada, $dif_pausa, $dif_volta, $dif_saida, $registro_ponto
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

$filePath = $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/controller/txt/AFD00014003750209621.txt';
if (file_exists($filePath)) {
  processFile($filePath);
} else {
  echo "Arquivo não encontrado: $filePath<br>";
}
$conn->close();

?>