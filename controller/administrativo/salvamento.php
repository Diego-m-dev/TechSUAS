<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>

<?php

$data_registro = date('d-m-Y');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['btn_contrato'])) {
        $stmt_contrato = $conn->prepare("INSERT INTO tabela_contrato (data_assinatura, vigencia, num_contrato, nome_empresa, razao_social, cnpj, num_contato, data_registro, email_emp, valor_contrato) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $stmt_contrato->bind_param('ssssssssss', $_POST['data_assinatura'], $_POST['vigencia'], $_POST['num_contrato'], $_POST['nome_empresa'], $_POST['razao_social'], $_POST['cnpj'], $_POST['num_contato'], $data_registro, $_POST['email_emp'], $_POST['valor_contrato']);

        if ($stmt_contrato->execute()) {
            ?>
            <script>
            Swal.fire({
            icon: "success",
            title: "SALVO",
            text: "Dados do contrato salvo com sucesso!",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/administrativo/cadastro_contrato";
                }
            });
</script>
<?php
        } else {
            echo "ERRO no envio dos DADOS: " . $stmt_contrato->error;
        }
    } else {
        $num_contrato = $_POST['num_contrato'];
        $stmt = $pdo->prepare("SELECT * FROM tabela_contrato WHERE num_contrato = :num_contrato");
        $stmt->execute(array(':num_contrato' => $num_contrato));

        if ($stmt->rowCount() > 0) {
// Pessoa encontrada
            $dados_atende = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_contrato = $dados_atende['id_contrato'];
        } else {
            ?>
<script>
    Swal.fire({
    icon: "error",
    title: "NÃO ENCONTRADO",
    text: "Nenhum contrato com esse número!",
    confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/TechSUAS/views/administrativo/cadastro_contrato";
        }
    });
    </script>
<?php
exit();
        }
// Pega os arrays do formulário
        $num_item = $_POST['num_item'];
        $nome_produto = $_POST['nome_produto'];
        $quantidade = $_POST['quantidade'];
        $valor_unitario = $_POST['valor_unitario'];
        $valor_total = $_POST['valor_total'];

        $stmt_itens = $conn->prepare("INSERT INTO tabela_itens (id_contrato, num_item, nome_produto, quantidade, valor_unitario, valor_total) VALUES (?, ?, ?, ?, ?, ?)");

        // Verifica se a preparação foi bem-sucedida
        if ($stmt_itens === false) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        // Vincula os parâmetros usando bind_param
        $stmt_itens->bind_param('issddd', $id_contrato, $num_item_i, $nome_produto_i, $quantidade_i, $valor_unitario_i, $valor_total_i);

        for ($i = 0; $i < count($nome_produto); $i++) {
            // Define os valores das variáveis
            $num_item_i = $num_item[$i];
            $nome_produto_i = $nome_produto[$i];
            $quantidade_i = $quantidade[$i];
            $valor_unitario_i = $valor_unitario[$i];
            $valor_total_i = $valor_total[$i];

            // Executa a instrução SQL
            if ($stmt_itens->execute() == false) {
                die("Erro na execução da consulta: " . $stmt_itens->error);
            } else {
                ?>
                <script>
    Swal.fire({
    icon: "success",
    title: "SALVO",
    text: "Itens salvos com sucesso!",
    confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/TechSUAS/views/administrativo/cadastro_contrato";
        }
    });
    </script>
            </body>
                <?php
                }
        }

    }
}
