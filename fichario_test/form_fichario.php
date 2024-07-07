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
    <link rel="stylesheet" href="style_conferir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Registro fichario</title>

</head>

<body>
    <h1>Salvar Fichario</h1>

    <form method="POST">
        <label for="codfam">
            Código Família:
            <input type="text" onblur="buscarFichario()" class="textosal" id="codfam" name="codfam" required>
        </label>
        <span id="armario"></span>
        <table>
            <tr>
                <th>Armário</th>
                <th>Gaveta</th>
                <th>Pasta</th>
            </tr>
            <tr>
                <td>
                    <input type="number" id="arm" name="arm" required>
                </td>
                <td>
                    <select name="gav" id="gav" required>
                        <option value="" disabled selected hidden>Selecione</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </td>
                <td>
                    <input type="number" id="pasta" name="pasta" required>
                </td>
            </tr>
        </table>

        <button type="submit" id="btn_salvar">Salvar</button>
        <button type="button" id="btn_reload" style="display: none;">Novo</button>
      </form>

      <button type="button" onclick="buscaFicharo()">FICHARIOS</button><br>
      <button type="button" onclick="printTiq()">IMPRIMIR ETIQUETA</button><br>
<script>
    $('#codfam').mask('000000000-00')

function buscarFichario() {
    var codfam = $('#codfam').val()

    // Remove todos os caracteres que não sejam números
    let cpfLimpo = codfam.replace(/\D/g, '');
    // Preenche com zeros à esquerda para garantir que tenha 11 dígitos
    let ajustandoCoda = cpfLimpo.padStart(11, '0');
    let ajustandoCod = ajustandoCoda.replace(/^(\d{9})(\d{2})$/, '$1-$2')

    $('#codfamiliar_print').text(ajustandoCod)

    $.ajax({
        type: 'POST',
        url: 'busca.php',
        data: {
            codfam: cpfLimpo
        },
        dataType: 'json',
        success: function (response) {
            if (response.encontrado){
                console.log(response.armario)
                $('#armario').text(`Cadastro já arquivado em ${response.armario}.`)
                $('#btn_salvar').hide()
                $('#btn_reload').show()
            } else {
                $('#armario').text(`Cadastro sem armário.`)
            }
        }
    })
}

$('#btn_reload').click(function () {
    window.location.href = "/TechSUAS/fichario_test/form_fichario"
})
</script>
<?php
if (isset($_POST['codfam']) && isset($_POST['arm']) && isset($_POST['gav']) && isset($_POST['pasta'])) {
    $codfam = $conn->real_escape_string($_POST['codfam']);
    $cpf_limpo = preg_replace('/\D/', '', $_POST['codfam']);
    $ajustando_cod = str_pad($cpf_limpo, 11, '0', STR_PAD_LEFT);
    $arm = $conn->real_escape_string($_POST['arm']);
    $gav = $conn->real_escape_string($_POST['gav']);
    $pasta = $conn->real_escape_string($_POST['pasta']);
    $operador = $_SESSION['nome_usuario'];

    $arm_gav_pas = sprintf("%02d - %02d - %02d", $arm, $gav, $pasta);
    
    $verifica_cadastro = $conn->prepare("SELECT cod_familiar_fam FROM tbl_tudo WHERE cod_familiar_fam = ?");
    $verifica_cadastro->bind_param("s", $ajustando_cod);
    $verifica_cadastro->execute();
    $verifica_cadastro->store_result();
    
    // Verifica se o nome de usuário já existe no banco de dados
$stmt = $conn->prepare("SELECT codfam FROM fichario WHERE arm_gav_pas = ?");
$stmt->bind_param("s", $arm_gav_pas);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($codfam);
    $stmt->fetch();
    ?>
    <script>
        Swal.fire({
            icon: "info",
            title: "JÁ EXISTE",
            text: "O fichário <?php echo $arm_gav_pas; ?> está arquivando o cadastro <?php echo $codfam; ?>.",
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/TechSUAS/fichario_test/form_fichario";
            }
        })
    </script>
    <?php
    exit();
}

    if ($verifica_cadastro->num_rows == 0) {
        ?>
        <script>
            Swal.fire({
            icon: "info",
            title: "SEM CADASTRO NA BASE",
            text: "O código <?php echo $ajustando_cod; ?> não está em sua base de dados atual, confira no V7.",
            confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/fichario_test/form_fichario";
                }
            })
        </script>
            <?php
        exit();
    }
    
            // Verifica se o nome de codigo já existe no banco de dados
        $verifica_fichario = $conn->prepare("SELECT codfam FROM fichario WHERE codfam = ?");
        $verifica_fichario->bind_param("s", $ajustando_cod);
        $verifica_fichario->execute();
        $verifica_fichario->store_result();
    
        if ($verifica_fichario->num_rows > 0) {
            // Se o código já está cadastrado, exibe uma mensagem
            ?>
            <script>
                Swal.fire({
                icon: "info",
                title: "JÁ EXISTE",
                text: "O código <?php echo $ajustando_cod; ?> está arquivado em <?php echo $arm_gav_pas; ?>."
                confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/TechSUAS/fichario_test/form_fichario";
                    }
                })
            </script>
                <?php
            exit();
        }

    $sql_insert = "INSERT INTO fichario (codfam, arm_gav_pas, operador, arm, gav, pas) VALUES ('$ajustando_cod', '$arm_gav_pas', '$operador', '$arm', '$gav', '$pasta')";

    if ($conn->query($sql_insert) === true) {
      ?>
      <script>
          Swal.fire({
          icon: "success",
          title: "SALVO",
          text: "Os dados foram salvos com sucesso!",
          confirmButtonText: 'OK',
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = "/TechSUAS/fichario_test/form_fichario";
              }
          })
      </script>
          <?php
          exit();
    } else {
      ?>
      <script>
          Swal.fire({
          icon: "error",
          title: "ERRO",
          text: 'Erro ao salvar registro: <?php echo $conn->error; ?>',
          confirmButtonText: 'OK',
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = "/TechSUAS/fichario_test/form_fichario";
              }
          })
      </script>
          <?php
          exit();
    }
}
?>
<a href="/TechSUAS/config/back"><i class="fas fa-arrow-left"></i>Voltar ao menu</a>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelector('input[name="codfam"]').focus()
    })
  </script>
</body>
</html>