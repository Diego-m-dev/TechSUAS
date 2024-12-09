<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');

$resposta = array('entregue' => false);

if (isset($_POST['nis_servidor']) && isset($_POST['horarios'])) {
    $nis_servidor = $_POST['nis_servidor'];
    $horarios = json_decode($_POST['horarios'], true); // Decodifica o JSON

    try {
        // Inicia uma transação
        $pdo->beginTransaction();

        // Prepara a instrução SQL para inserção
        $stmt = $pdo->prepare("INSERT INTO carga_horaria (nis, dia_semana, hora_entrada, hora_pausa, hora_volta, hora_saida, horas_diaria) 
                                VALUES (:nis, :dia_semana, :hora_entrada, :hora_pausa, :hora_volta, :hora_saida, :horas_diaria)");

        // Loop para inserir cada registro de horário
        foreach ($horarios as $horario) {
            $stmt->execute([
                ':nis' => $nis_servidor,
                ':dia_semana' => $horario['dia_semana'],
                ':hora_entrada' => $horario['hora_entrada'] ?: null,
                ':hora_pausa' => $horario['hora_pausa'] ?: null,
                ':hora_volta' => $horario['hora_volta'] ?: null,
                ':hora_saida' => $horario['hora_saida'] ?: null,
                ':horas_diaria' => $horario['horas_diaria'] ?: null
            ]);
        }

        // Confirma a transação
        $pdo->commit();
        $resposta['entregue'] = true;
    } catch (PDOException $e) {
        // Em caso de erro, desfaz a transação e retorna o erro
        $pdo->rollBack();
        $resposta['error'] = 'Erro ao salvar os dados: ' . $e->getMessage();
    }

    echo json_encode($resposta);
} else {
    echo json_encode(['error' => 'Dados incompletos']);
}
