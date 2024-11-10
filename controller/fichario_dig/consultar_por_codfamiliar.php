<?php
if (isset($_POST['codFamiliar'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

    $codfamiliar = $conn->real_escape_string($_POST['codFamiliar']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codFamiliar']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);


    // Consultar nome do responsável na tabela tbl_tudo
    $consulta_nome = $conn->prepare("SELECT nom_pessoa FROM tbl_tudo WHERE cod_familiar_fam = ? AND cod_parentesco_rf_pessoa = 1");
    $consulta_nome->bind_param("s", $ajustando_cod);
    $consulta_nome->execute();
    $resultado_nome = $consulta_nome->get_result();
    $nomeResponsavel = $resultado_nome->fetch_assoc()['nom_pessoa'] ?? 'Nome não encontrado';

    // Consultar dados de cadastro na tabela cadastro_forms
    $consulta = $conn->prepare("SELECT * FROM cadastro_forms WHERE cod_familiar_fam = ?");
    $consulta->bind_param("s", $ajustando_cod);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        echo json_encode([
            'status' => 'success',
            'codFamiliar' => $ajustando_cod,
            'responsavel' => $nomeResponsavel
        ]);

        while ($row = $resultado->fetch_assoc()) {
            echo json_encode (["<tr>
                    <td>{$row['data_entrevista']}</td>
                    <td>{$row['tipo_documento']}</td>
                    <td>{$row['nome_arquivo']}</td>
                    <td>" . round($row['tamanho'] / 1024, 2) . " KB</td>
                    <td><a href='/TechSUAS/controller/fichario_dig/download.php?id={$row['id']}'><i class='fas fa-download'></i></a></td>

                </tr>"]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Nenhum resultado encontrado'
        ]);
    }

    $consulta->close();
    $conn->close();
}
