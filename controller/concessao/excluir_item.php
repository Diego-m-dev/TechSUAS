<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o array 'excluir' foi enviado
    if (isset($_POST['excluir']) && is_array($_POST['excluir'])) {

        // Inicializa uma string para armazenar as mensagens de exclusão
        $mensagensExclusao = "";

        // Loop através dos IDs a serem excluídos
        foreach ($_POST['excluir'] as $id) {
            // Declarações preparadas para evitar SQL injection
            $sql = "DELETE FROM concessao_itens WHERE id_itens_conc = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Executa a exclusão
            if ($stmt->execute()) {
                $mensagensExclusao .= "Registro com ID $id excluído com sucesso.";
            } else {
                $mensagensExclusao .= "Erro ao excluir o registro com ID $id. ";
            }

        }
        echo "<script>
                alert('$mensagensExclusao');
                window.location.href = '/TechSUAS/views/concessao/index';
            </script>";

        } else {
            echo "Nenhum registro selecionado para exclusão.";
        }
} else {
    echo "Acesso inválido ao script de exclusão.";
}

// Fechar conexão
$conn->close();