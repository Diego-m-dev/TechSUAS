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
    if (isset($_POST['nome_empresa'])) {

        // Verifica se a empesa já existe no banco de dados
        $verifica_empresa = $conn->prepare("SELECT cnpj FROM contrato_empresa WHERE cnpj = ?");
        $verifica_empresa->bind_param("s", $_POST['cnpj']);
        $verifica_empresa->execute();
        $verifica_empresa->store_result();

        if ($verifica_empresa->num_rows > 0) {
?>
            <script>
                Swal.fire({
                icon: "info",
                title: "JÁ EXISTE",
                text: "CNPJ já cadastrado.",
                confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/TechSUAS/views/administrativo/cadastro_empresa";
                    }
                })
            </script>
<?php
            exit();
        }

        $stmt_empresa = $conn->prepare("INSERT INTO contrato_empresa (cnpj, nome, razao, endereco, contato, email, representante, contato_representante, segmento, operador, data_cadastro) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt_empresa->bind_param('sssssssssss', $_POST['cnpj'], $_POST['nome_empresa'], $_POST['razao_social'], $_POST['endereco'], $_POST['num_contato'], $_POST['email_emp'], $_POST['nom_representante'], $_POST['contato_representante'], $_POST['segmento'], $nome, $data_registro);

        if ($stmt_empresa->execute()) {
            ?>
            <script>
            Swal.fire({
            icon: "success",
            title: "SALVO",
            text: "Dados salvo com sucesso!",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/administrativo/cadastro_empresa";
                }
            })
</script>
<?php
} else {
            echo "ERRO no envio dos DADOS: " . $stmt_empresa->error;
        }
    } elseif (isset($_POST['cnpj_contrato'])) {
        $ano_vigencia = $_POST['ano_vigencia'];
        $mes_vigencia = $_POST['vigencia'];
        $vigencia = $mes_vigencia . '/' . $ano_vigencia;

        $cnpj_contrato = $_POST['cnpj_contrato'];
        $stmt_busca = $pdo->prepare("SELECT * FROM contrato_empresa WHERE cnpj = :cnpj");
        $stmt_busca->execute(array(':cnpj' => $cnpj_contrato));

                // Verifica se a empesa já existe no banco de dados
                $verifica_contrato = $conn->prepare("SELECT num_contrato FROM contrato_tbl WHERE num_contrato = ?");
                $verifica_contrato->bind_param("s", $_POST['num_contrato']);
                $verifica_contrato->execute();
                $verifica_contrato->store_result();
        
                if ($verifica_contrato->num_rows > 0) {
        ?>
                    <script>
                        Swal.fire({
                        icon: "info",
                        title: "JÁ EXISTE",
                        text: "Contrato já cadastrado.",
                        confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/TechSUAS/views/administrativo/cadastro_contrato";
                            }
                        })
                    </script>
        <?php
                    exit();
                }



        if ($stmt_busca->rowCount() > 0) {
// Pessoa encontrada
            $dados_emp_busca = $stmt_busca->fetch(PDO::FETCH_ASSOC);
            $id_empresa = $dados_emp_busca['id_empresa'];
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
            window.location.href = "/TechSUAS/views/administrativo/cadastro_empresa";
        }
    });
    </script>
<?php
exit();
        }
        if ($_POST['fiscal'] == "") {
            $fiscal = "Sem fiscal";
        } else {
            $fiscal = $_POST['fiscal'];
        }

        $stmt_contrato = $conn->prepare("INSERT INTO contrato_tbl (id_empresa, num_contrato, data_assinatura, vigencia, fiscal, valor, tipo_material, operador, data_cadastro) VALUES(?,?,?,?,?,?,?,?,?)");
        if (!$stmt_contrato) {
            die('Erro ao preparar a consulta: ' . $conn->error);
        }
        $stmt_contrato->bind_param('sssssssss', $id_empresa, $_POST['num_contrato'], $_POST['data_assinatura'], $vigencia, $fiscal, $_POST['valor_contrato'], $_POST['tipo_material'], $nome, $data_registro);

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
    } elseif (isset($_POST['btn_itens'])) {
        $num_contrato = $_POST['num_contrato'];
        $stmt_id_contrato = $pdo->prepare("SELECT * FROM contrato_tbl WHERE num_contrato = :num_contrato");
        $stmt_id_contrato->execute(array(':num_contrato' => $num_contrato));

        if ($stmt_id_contrato->rowCount() > 0) {
            $dados_atende = $stmt_id_contrato->fetch(PDO::FETCH_ASSOC);
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

        $stmt_itens = $conn->prepare("INSERT INTO contrato_itens (id_contrato, cod_produto, nome_produto, quantidade, valor_uni, valor_total, operador, data_cadastro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Verifica se a preparação foi bem-sucedida
        if ($stmt_itens === false) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        // Vincula os parâmetros usando bind_param
        $stmt_itens->bind_param('issdddss', $id_contrato, $num_item_i, $nome_produto_i, $quantidade_i, $valor_unitario_i, $valor_total_i, $nome_i, $data_registro_i);

        for ($i = 0; $i < count($nome_produto); $i++) {
            // Define os valores das variáveis
            $num_item_i = $num_item[$i];
            $nome_produto_i = $nome_produto[$i];
            $quantidade_i = $quantidade[$i];
            $valor_unitario_i = $valor_unitario[$i];
            $valor_total_i = $valor_total[$i];
            $nome_i = $nome[$i];
            $data_registro_i = $data_registro[$i];

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
    })
    </script>
            </body>
                <?php
}
        }
    }
} else {
    echo "Não recebeu nenhum dado!";
}
?>
</body>
</html>