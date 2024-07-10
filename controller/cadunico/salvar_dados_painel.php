<!DOCTYPE html>
<html lang="pt-br">
s
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <title>Salvando</title>
</head>

<body>
    <?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/models/cadunico/submit_model.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $cod_familiar_fam = $_POST['cod_fam'];
        $data_entrevista = $_POST['data_entrevista'];
        $sit_beneficio = $_POST['sit_beneficio'];
        $resumo = $_POST['resumo'];
        $tipo_documento = implode(', ', $_POST['tipo_documento']);
        $operador = $_SESSION['nome_usuario'];

        if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
            $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
            $arquivo_nome = $_FILES['arquivo']['name'];
            $arquivo_tamanho = $_FILES['arquivo']['size'];
            $arquivo_tipo = $_FILES['arquivo']['type'];

            function getMimeType($filename)
            {
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
                switch ($extension) {
                    case 'pdf':
                        return 'application/pdf';
                    case 'jpg':
                    case 'jpeg':
                        return 'image/jpeg';
                    default:
                        return 'application/octet-stream';
                }
            }
            $arquivo_mime = getMimeType($arquivo_nome);

            $arquivo_binario = file_get_contents($arquivo_tmp);

            $model = new CadastroModel($conn);
            $cadastro_adicionado = $model->adicionarCadastro(
                $cod_familiar_fam,
                $data_entrevista,
                $tipo_documento,
                $arquivo_binario,
                $arquivo_tamanho,
                $arquivo_nome,
                $arquivo_mime,
                $resumo,
                $sit_beneficio,
                $operador
            );
            if ($cadastro_adicionado) {
                echo "Cadastro adicionado com sucesso.";
            } else {
                echo "Erro ao adicionar o cadastro.";
            }
        } else {
            echo "Erro no upload do arquivo.";
        }

        $conn->close();
    }

    ?>

</body>

</html>