<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';
// Obtém o timestamp atual
$timestamp = date('d/m/Y H:i');
$nome = $_SESSION['nome_usuario'];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Beneficiário Concessão - TechSUAS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_benef.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/concessao.js"></script>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="/TechSUAS/img/concessao/h1-cad_user.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <form method="POST" action="">
            <div>
                <label>BENEFICIÁRIO:</label>
                <input type="text" name="beneficio" required placeholder="Digite aqui, sem abreviação... " required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div>
                <label>NATURALIDADE:</label>
                <input type="text" name="naturalidade" placeholder="Digite aqui, sem abreviação... " required oninput="this.value = this.value.toUpperCase()">
            </div>
            <div>
                <label>NOME DA MÃE:</label>
                <input type="text" name="nome_mae_benef" required placeholder="Digite aqui, sem abreviação... " oninput="this.value = this.value.toUpperCase()">
            </div>
            <div>
                <label>RENDA MEDIA:</label>
                <input type="text" name="renda_media" id="renda_media" required>
            </div>
            <div>
                <label>ENDEREÇO:</label>
                <input type="text" name="endereco_resp" required placeholder="Rua nome da rua, XX - centro (referência)" oninput="this.value = this.value.toUpperCase()">
            </div>
            <div>
                <label>CPF:</label>
                <input type="text" class="cpf" name="cpf_beneficio" placeholder="Digite como no exemplo XXX.XXX.XXX-XX">
            </div>
            <div>
                <label>T.E:</label>
                <input type="text" id="tit_ele" name="te_beneficio" placeholder="Digite como no exemplo XXXX-XXXX-XXXX">
            </div>
            <div>
                <label>RG:</label>
                <input type="text" name="rg_beneficio">
            </div>
            <div>
                <label>PARENTESCO:</label>
                <select name="parentesco" id="parentesco" required>
                    <option value="" disabled selected hidden>Selecione</option>
                    <option value="UNIPESSOAL">Unipessoal</option>
                    <option value="CONJUGE">Conjuge</option>
                    <option value="FILHO(A)">Filho(a)</option>
                    <option value="ENTEADO(A)">Enteado(a)</option>
                    <option value="NETO OU BISNETO">Neto ou Bisneto</option>
                    <option value="PAI OU MAE">Pai ou Mae</option>
                    <option value="SOGRO(A)">Sogro(a)</option>
                    <option value="IRMAOS OU IRMA">Irmão ou Irmã</option>
                    <option value="GENRO OU NORA">Genro ou Nora</option>
                    <option value="OUTRO PARENTE">Outro Parente</option>
                    <option value="NAO PARENTE">Não Parente</option>
                </select>
            </div>
            <div>
                <label>CPF do RESPONSÁVEL:</label>
                <input type="text" class="cpf" name="cpf_resp" placeholder="Digite como no exemplo XXX.XXX.XXX-XX" required>
            </div>
            <div class="btn">
                <button type="submit">SALVAR</button>
                <a href="/TechSUAS/config/back" style="margin-left: 100px;">
                    <i class="fas fa-arrow-left"></i> Voltar ao menu
                </a>
            </div>
        </form>
    </div>
    <?php

// Obtém o timestamp atual
$timestamp = date('Y-m-d H:i:s'); // Formato mais adequado para MySQL
$nome = $_SESSION['nome_usuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['beneficio'])) {
    try {
        $cpf_resp = $_POST['cpf_resp'];
        $data_atual = date('Y');
        $qtd_conc = "SELECT COUNT(*) as total_registros FROM concessao_historico WHERE ano_form = :data_atual";
        
        $stmt_qtd = $pdo->prepare($qtd_conc);
        $stmt_qtd->bindParam(':data_atual', $data_atual, PDO::PARAM_INT);
        $stmt_qtd->execute();
        $result = $stmt_qtd->fetch(PDO::FETCH_ASSOC);

        $hoje_ = date('Y-m-d H:i:s');
        $num_form = $result['total_registros'] + 1;
        $situation = "EM PROCESSO";
        
        // Inserção na tabela `beneficiario`
        $stmt = $pdo->prepare('INSERT INTO beneficiario (beneficiario, naturalidade, nome_mae_benef, renda_media, endereco_resp, cpf_beneficio, te_beneficio, rg_beneficio, operador, data_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$_POST['beneficio'], $_POST['naturalidade'], $_POST['nome_mae_benef'], $_POST['renda_media'], $_POST['endereco_resp'], $_POST['cpf_beneficio'], $_POST['te_beneficio'], $_POST['rg_beneficio'], $nome, $timestamp]);

        // Verifica se existe o responsável na tabela `concessao_tbl`
        $sql_query_resp = $pdo->prepare("SELECT * FROM concessao_tbl WHERE cpf_pessoa = :cpf_resp");
        $sql_query_resp->bindParam(':cpf_resp', $cpf_resp, PDO::PARAM_STR);
        $sql_query_resp->execute();

        if ($sql_query_resp->rowCount() > 0) {
            $dados_resp = $sql_query_resp->fetch(PDO::FETCH_ASSOC);

            $smtp_conc = $pdo->prepare("INSERT INTO concessao_historico (id_concessao, num_form, ano_form, nome_resp, cpf_resp, nome_benef, cpf_benef, rg_benef, tit_benef, endereco, renda_media, data_registro, parentesco, operador, situacao_concessao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $smtp_conc->execute([$dados_resp['id_concessao'], $num_form, $data_atual, $dados_resp['nome'], $cpf_resp, $_POST['beneficio'], $_POST['cpf_beneficio'], $_POST['rg_beneficio'], $_POST['te_beneficio'], $_POST['endereco_resp'], $_POST['renda_media'], $hoje_, $_POST['parentesco'], $nome, $situation]);

            echo "<script>
                setTimeout(function() {
                    Swal.fire({
                        icon: 'success',
                        html: `<h1>SALVO</h1><p>Dados salvos com sucesso!</p>`,
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/TechSUAS/views/concessao/consultar';
                        }
                    });
                }, 300);
            </script>";
        } else {
          echo "<script>
          Swal.fire({
              icon: 'info',
              html: `<h1>RESPONSÁVEL NÃO CADASTRADO</h1>
              <p>Cadastre o Responsável!</p>`,
              confirmButtonText: 'OK',
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = '/TechSUAS/views/concessao/cadastro_pessoa';
              }
          });
      </script>";
        }
    } catch (Exception $e) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                html: `<h1>ERRO</h1><p>Erro no salvamento: " . $e->getMessage() . "</p>`,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/TechSUAS/concessao/index';
                }
            });
        </script>";
    }
}

$conn_1->close();
?>
    <script>
        $(document).ready(function() {
            $("#renda_media").mask('#.##0,00', {
                reverse: true
            })
            $(".cpf").mask("000.000.000-00")
            $("#tit_ele").mask("0000-0000-0000")
        })
    </script>
</body>

</html>