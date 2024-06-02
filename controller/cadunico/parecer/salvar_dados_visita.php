<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Capture os dados da requisição POST
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Erro ao decodificar JSON: ' . json_last_error_msg());
        }

        // Extrair dados do JSON
        $id_visita = $data['id_visita'];
        $numero_parecer = $data['numero_parecer'];
        $ano_parecer = $data['ano_parecer'];
        $codigo_familiar = $data['codigo_familiar'];

        //Limpando o código familiar para salvar apenas os números
            $limpando_codigo_familiar = preg_replace('/\D/', '', $codigo_familiar);
            $codigo_familiar_formatado = ltrim($limpando_codigo_familiar, '0');

        $data_entrevista = $data['data_entrevista'];
        $renda_per_capita = $data['renda_per_capita'];
        $localidade = $data['localidade'];
        $tipo = $data['tipo'];
        $titulo = $data['titulo'];
        $nome_logradouro = $data['nome_logradouro'];
        $numero_logradouro = $data['numero_logradouro'];
        $complemento_numero = $data['complemento_numero'];
        $complemento_adicional = $data['complemento_adicional'];
        $cep = $data['cep'];
        $referencia_localizacao = $data['referencia_localizacao'];
        $situacao = $data['situacao'];
        $resumo_visita = $data['resumo_visita'];
        $membros = $data['membros_familia']; // Supondo que membros seja um array de objetos

        // Iniciar transação
        $pdo->beginTransaction();

        // Inserir dados na tabela historico_parecer_visita
        $stmt = $pdo->prepare("INSERT INTO historico_parecer_visita (id_visitas, numero_parecer, ano_parecer, codigo_familiar, data_entrevista, renda_per_capita, localidade, tipo, titulo, nome_logradouro, numero_logradouro, complemento_numero, complemento_adicional, cep, referencia_localizacao, situacao, resumo_visita) VALUES (:id_visitas, :numero_parecer, :ano_parecer, :codigo_familiar, :data_entrevista, :renda_per_capita, :localidade, :tipo, :titulo, :nome_logradouro, :numero_logradouro, :complemento_numero, :complemento_adicional, :cep, :referencia_localizacao, :situacao, :resumo_visita)");

        $stmt->execute([
            ':id_visitas' => $id_visita,
            ':numero_parecer' => $numero_parecer,
            ':ano_parecer' => $ano_parecer,
            ':codigo_familiar' => $codigo_familiar_formatado,
            ':data_entrevista' => $data_entrevista,
            ':renda_per_capita' => $renda_per_capita,
            ':localidade' => $localidade,
            ':tipo' => $tipo,
            ':titulo' => $titulo,
            ':nome_logradouro' => $nome_logradouro,
            ':numero_logradouro' => $numero_logradouro,
            ':complemento_numero' => $complemento_numero,
            ':complemento_adicional' => $complemento_adicional,
            ':cep' => $cep,
            ':referencia_localizacao' => $referencia_localizacao,
            ':situacao' => $situacao,
            ':resumo_visita' => $resumo_visita,
        ]);

        // Obter o ID do parecer inserido
        $parecer_id = $pdo->lastInsertId();

        // Inserir dados na tabela membros_familia
        foreach ($membros as $membro) {
            $stmt_membro = $pdo->prepare("INSERT INTO membros_familia (parecer_id, parentesco, nome_completo, nis, data_nascimento) VALUES (:parecer_id, :parentesco, :nome_completo, :nis, :data_nascimento)");
            $stmt_membro->execute([
                ':parecer_id' => $parecer_id,
                ':parentesco' => $membro['parentesco'],
                ':nome_completo' => $membro['nome_completo'],
                ':nis' => $membro['nis'],
                ':data_nascimento' => $membro['data_nascimento'],
            ]);
        }

        // Commit da transação
        $pdo->commit();

        echo json_encode(['success' => true, 'message' => 'Dados salvos com sucesso']);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar os dados: ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido']);
}
?>
