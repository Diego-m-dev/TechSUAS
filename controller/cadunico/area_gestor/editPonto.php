<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $nis = $_POST['nis_servidor'];  // Certifique-se de que o NIS é passado no formulário
    $entrada = $_POST['entre_h'] ?: null;
    $pausa = $_POST['pausa_h'] ?: null;
    $volta = $_POST['return_h'] ?: null;
    $saida = $_POST['saida_h'] ?: null;
    $justificativa = $_POST['justify'] ?: null;
    $data_just = $_POST['data']; // data que está sendo editada

    // Verifica se o NIS foi fornecido
    if (empty($nis)) {
        echo json_encode(['error' => 'NIS não fornecido']);
        exit;
    }

    // Busca o horário programado na tabela `carga_horaria`
    $diaSemanaIngles = (new DateTime($data_registro))->format('D');
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

        // Atualiza os dados na tabela `calculo_horas`
        $sql_update = "UPDATE calculo_horas SET hora_entrada = ?, hora_pausa = ?, hora_volta = ?, hora_saida = ?, dif_hora_entrada = ?, dif_hora_pausa = ?, dif_hora_volta = ?, dif_hora_saida = ?, justify = ? WHERE nis = ? AND data_registro = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param(
            'sssssssssss',
            $entrada, $pausa, $volta, $saida,
            $dif_entrada, $dif_pausa, $dif_volta, $dif_saida,
            $justificativa, $nis, $data_registro
        );

        $stmt_salva = $conn->prepare("INSERT INTO carga_justify(nis, data_just, justify) VALUE (?, ?, ?)");
        // Verifica se a preparação foi bem-sucedida
        if ($stmt_salva === false) {
          die('Erro na preparação SQL: ' . $conn->error);
        }
        $stmt_salva->bind_param('sss', $nis, $data_just, $justificativa);

        if ($stmt_salva->execute()) {
          echo json_encode(['success' => true, 'message' => 'Dados atualizados com sucesso']);
        } 

        if ($stmt_update->execute()) {
            echo json_encode(['success' => true, 'message' => 'Dados atualizados com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar os dados']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Horário programado não encontrado']);
    }
    $conn->close();
    // 08:14:00	13:05:00	14:03:00
} else {
    echo json_encode(['error' => 'Método de requisição inválido']);
    http_response_code(405); // Método não permitido
}

// Função para calcular a diferença entre horários
function calcularDiferencaHoras($hora_real, $hora_programada) {
    if (!$hora_real || !$hora_programada) return null;
    $hora_real_dt = new DateTime($hora_real);
    $hora_programada_dt = new DateTime($hora_programada);
    $intervalo = $hora_programada_dt->diff($hora_real_dt);
    return $intervalo->format('%H:%I:%S');
}
?>