<?php
// Inclua seus arquivos de configuração e qualquer outra coisa necessária
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se os parâmetros foram recebidos corretamente
    if (isset($_POST['ano']) && isset($_POST['mes_pg'])) {
        $ano = $_POST['ano'];
        $mes_pg = $_POST['mes_pg'];

        // Prepare a consulta para obter as concessões com base nos filtros
        $consulta = "SELECT * FROM concessao_historico WHERE ano = ? AND MES_PAGO = ?";
        $stmt = $conn->prepare($consulta);
        $stmt->bind_param("ss", $ano, $mes_pg);
        $stmt->execute();
        $result = $stmt->get_result();

        // Array para armazenar as concessões encontradas
        $concessoes = array();

        // Array para armazenar as características únicas encontradas
        $caracteristicas = array();

        // Percorra os resultados e armazene-os no array de concessões
        while ($row = $result->fetch_assoc()) {
            $concessoes[] = $row;
            // Adicione a característica à lista se ainda não estiver presente
            if (!in_array($row['CARACTERISTICA'], $caracteristicas)) {
                $caracteristicas[] = $row['CARACTERISTICA'];
            }
        }

        // Calcule a soma das características
        $somaCaracteristicas = array();
        foreach ($caracteristicas as $caracteristica) {
            $soma = 0;
            foreach ($concessoes as $concessao) {
                if ($concessao['CARACTERISTICA'] === $caracteristica) {
                    // Remova a parte do valor que não é numérica
                    $valorNumerico = str_replace(['R$', ',', ' '], '', $concessao['VALOR']);
                    // Some o valor numérico à soma
                    $soma += (float) $valorNumerico;
                }
            }
            // Adicione a soma ao array de soma de características
            $somaCaracteristicas[$caracteristica] = $soma;
        }

        // Prepare o array de resposta
        $response = array(
            'concessoes' => $concessoes,
            'caracteristicas' => $caracteristicas,
            'soma' => $somaCaracteristicas
        );

        // Retorne a resposta como JSON
        echo json_encode($response);
    } else {
        // Se os parâmetros não foram recebidos corretamente, retorne um erro
        echo json_encode(array('error' => 'Parâmetros incompletos'));
    }
} else {
    // Se a solicitação não for POST, retorne um erro
    echo json_encode(array('error' => 'Método de solicitação incorreto'));
}
?>