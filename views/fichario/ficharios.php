<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/TechSUAS/css/fichario_dig/style_arquivo.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/fichario.js"></script>

    <title>Fichário - TechSUAS</title>
</head>

<body>
    <div class="conteiner-arm">
        <form action="" method="POST">
          <label for="arm">ARMÁRIO</label>
            <a href="/TechSUAS/views/fichario/form_fichario"><i class="fas fa-arrow-left"></i>Voltar</a>
              <select name="arm" id="arm" required onchange="mudaArmario()">
                <option value="" disabled selected hidden>00</option>
                <?php
                $sql_ficharios = "SELECT arm FROM ficharios GROUP BY arm ORDER BY arm, pas";
                $sql_ficharios_query = $conn->query($sql_ficharios) or die("Erro na conexão " . $conn->error);
                if ($sql_ficharios_query->num_rows > 0) {
                    while ($fichario = $sql_ficharios_query->fetch_assoc()) {
                        echo '<option value="' . $fichario['arm'] . '">' . $fichario['arm'] . '</option>';
                    }
                }
                $conn_1->close();
                ?>
              </select>
        </form>
    </div>
    <div id="tabela-container"></div>
</body>

</html>
