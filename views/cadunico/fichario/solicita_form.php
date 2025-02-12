<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrevistas Solicitadas - TechSUAS</title>
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/fichario/style_solicita_form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/fichario/h1-solicita_form.svg" alt="Título com imagem">
        </h1>
    </div>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Código Familiar</th>
                    <th>NIS</th>
                    <th>TIPO</th>
                    <th>STATUS</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta SQL para selecionar apenas registros com status "pendente"
                $sql = "SELECT * FROM solicita WHERE status = 'pendente'";
                $result = $conn->query($sql);

                // Verifica se há registros retornados
                if ($result->num_rows > 0) {


                    // Loop através dos resultados e exiba cada registro em uma linha da tabela
                    while ($row = $result->fetch_assoc()) {

                        if ($row['tipo'] == 1) {
                            $tipo = "NIS";
                        } elseif ($row['tipo'] == 3) {
                            $tipo = "ENTREVISTA";
                        } elseif ($row['tipo'] == 2
) {
                            $tipo = "DECLARAÇÃO CAD";
                        }

                        echo "<tr>";
                        echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['cod_fam'] . "</td>";
                        echo "<td>" . $row['nis'] . "</td>";
                        echo "<td>" . $tipo . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td><i class='fas fa-check-circle check-icon' data-id='" . $row['id'] . "'></i></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum registro encontrado com status pendente.</td></tr>";
                }

                // Feche a conexão com o banco de dados
                $conn->close();
                ?>
            </tbody>
        </table>
        <div>
        <a href="/TechSUAS/views/cadunico/fichario/index">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.check-icon').click(function() {
                var id = $(this).data('id');
                // Requisição AJAX para atualizar o status
                $.ajax({
                    url: '/TechSUAS/controller/recepcao/atualizar_status.php',
                    type: 'POST',
                    data: {
                        id: id,
                        novo_status: 'feito'
                    },
                    success: function(response) {
                        // Atualiza a linha na tabela após a atualização
                        if (response.trim() == 'success') {
                            location.reload(); // Atualiza a página após o sucesso
                        } else {
                            alert('Erro ao atualizar o status.');
                        }
                    },
                    error: function() {
                        alert('Erro ao conectar com o servidor.');
                    }
                });
            });
        });
    </script>

</body>

</html>