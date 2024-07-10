<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';


header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON

if (isset($_POST['codfam'])) {
    $codfamiliar = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);

    $response = array('encontrado' => false);

    $stmt_tudo = "SELECT * FROM fichario WHERE codfam LIKE '$ajustando_cod'";
    $sql_query = $conn->query($stmt_tudo) or die("ERRO ao consultar !" . $conn->error);

    if ($sql_query->num_rows > 0) {
            $dados_tudo = $sql_query->fetch_assoc();
            $armario = $dados_tudo['arm_gav_pas'];
            $id_fic = $dados_tudo['id'];

        echo json_encode(array('encontrado' => true, 'armario' => $armario));
    } else {
        http_response_code(404);
        echo json_encode(array('encontrado' => false, 'error' => 'Nenhum resultado encontrado.'));
    }
}
$conn->close();