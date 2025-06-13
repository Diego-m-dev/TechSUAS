<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

$operador = $_SESSION['nome_usuario'];

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('encontrado' => false); // Inicialmente definido como não encontrado

    try {
      $data5yearsago = new DateTime();
			$data5yearsago->modify('-5 years');
  		$data5yearsagoFormatada = $data5yearsago->format('Y-m-d');
        $stmt = $pdo->prepare("SELECT c.id,
                                    c.cod_familiar_fam,
                                    DATE_FORMAT(c.data_entrevista, '%d/%m/%Y') AS data_entrevista,
                                    c.tipo_documento,
                                    c.caminho_arquivo,
                                    c.operador,
                                    c.sit_beneficio
                            FROM cadastro_forms c
                            LEFT JOIN tbl_tudo t ON t.cod_familiar_fam = c.cod_familiar_fam
                            WHERE (t.cod_familiar_fam IS NULL AND c.certo != 1) OR (c.data_entrevista < :data5yearsago)
                                GROUP BY c.id
                                ORDER BY c.criacao ASC
        ");
    $stmt->execute(array(':data5yearsago' => $data5yearsagoFormatada));

    $dadosFicharios = array();

        if ($stmt->rowCount() > 0) {
            $response['encontrado'] = true;

            while ($registros = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $dadosFicharios [] = array(
                    'id' => $registros['id'],
                    'cod_familiar_fam' => $registros['cod_familiar_fam'],
                    'data_entrevista' => $registros['data_entrevista'],
                    'tipo_documento' => $registros['tipo_documento'],
                    'caminho_arquivo' => $registros['caminho_arquivo'],
                    'operador' => $registros['operador'],
                    'sit_beneficio' => $registros['sit_beneficio']
                );
            }
            $response['dadosFich'] = $dadosFicharios;
            echo json_encode($response);
    
        } else {
            $response['encontrado'] = false;
            $response['msg'] = 'O correu um erro ao buscar os dados';
            echo json_encode($response);

        }

    } catch (Exception $e) {
        echo json_encode(['msg' => "Erro: " . $e->getMessage()]);
    }

// Fechando conexão corretamente**
$pdo_1 = null;
$pdo = null;