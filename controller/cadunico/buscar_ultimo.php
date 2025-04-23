<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/models/cadunico/submit_model.php';

$operador = $_SESSION['nome_usuario'];

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

$response = array('salvo' => false); // Inicialmente definido como não encontrado

    try {

        // Inserir dados no banco de dados
        $stmt = $pdo->prepare("SELECT cod_familiar_fam, DATE_FORMAT(data_entrevista, '%d/%m/%Y') AS data_entrevista, tipo_documento 
        FROM cadastro_forms
        WHERE operador = :operador
        AND DATE(criacao) = CURDATE()
        ORDER BY criacao DESC
        LIMIT 1
    ");
    $stmt->bindParam(':operador', $operador, PDO::FETCH_ASSOC);
    $stmt->execute( );

    $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registros) {
            $response['encontrado'] = true;
            $response['concatenado'] = '<table id="table_last">
            <tr>
                <th>Ultimo registro:</th>
            </tr>' . '
            <tr>
                <td id="li1"><li>Código familiar: <strong>' . $registros['cod_familiar_fam'] . '</strong></li></td></tr>
            <tr>
                <td id="li1"><li>Data da Entrevista: <strong>' . $registros['data_entrevista'] . '</strong> </li></td></tr>
            <tr>
                <td id="li1"><li>Tipo: <strong>' . $registros['tipo_documento'] . '</strong></li></td>
            </tr>
        </table>';

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