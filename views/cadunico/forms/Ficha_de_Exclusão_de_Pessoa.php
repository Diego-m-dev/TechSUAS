<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

$nis_from = $_POST['nis_exc_pessoa'];

$sql_declar = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = :nis_exc_pessoa");
$sql_declar->bindParam(':nis_exc_pessoa', $nis_from, PDO::PARAM_STR);
$sql_declar->execute();
?>


<!DOCTYPE html>
<html>
<head>
<title>Ficha de exclusão de pessoa</title>
<link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
<link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/ex_pesso.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único </span><?php echo $data_cabecalho; ?>
        </div>
    </div>
    <div id="form-container">
    <div id="title">ANEXO II - FICHA DE EXCLUSÃO DE PESSOA</div>
    <div id="subtitle">(Redação dada pela Portaria MDS nº 860, de 14 de fevereiro de 2023)</div>

    <?php
    if ($sql_declar->rowCount() > 0) {
      $dados_declar = $sql_declar->fetch(PDO::FETCH_ASSOC);

      $cod_familiar = $dados_declar['cod_familiar_fam'];
      $cod_familiar_formatado = substr_replace(str_pad($cod_familiar, 11, "0", STR_PAD_LEFT), '-', 9, 0);

      $sql_rf = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam = '$cod_familiar' AND cod_parentesco_rf_pessoa = '1'";
      $resultado_rf = $conn->query($sql_rf);

      if ($resultado_rf->num_rows > 0) {
        $row = $resultado_rf->fetch_assoc();
        $nis_rf = $row['num_nis_pessoa_atual'];
        $nis_responsavel_formatado = substr_replace(str_pad($nis_rf, 11, "0", STR_PAD_LEFT), '-', 10, 0);
    }
    ?>
      <label for="codigoFamiliar">CODIGO FAMILIAR:</label>
      <input type="text" id="codigoFamiliar" name="codigoFamiliar" value="<?php echo $cod_familiar_formatado; ?>" readonly>

      <label for="nisResponsavel">NIS DO RESPONSÁVEL FAMILIAR:</label>
      <input type="text" id="nisResponsavel" value="<?php echo $nis_responsavel_formatado; ?>" name="nisResponsavel">
      
      <label for="nomePessoa">NOME DA PESSOA:</label>
      <input type="text" id="nomePessoa" name="nomePessoa" value="<?php echo $dados_declar['nom_pessoa']; ?>" readonly>

      <label for="nisPessoa">NIS DA PESSOA:</label>
      <input type="text" id="nisPessoa" value="<?php echo $dados_declar['num_nis_pessoa_atual']; ?>" name="nisPessoa">
      
      <label for="dataExclusao">DATA DA EXCLUSÃO:</label>
      <input type="text" id="dataExclusao" name="dataExclusao" readonly>

      <label for="motivo">MOTIVO:</label>
      <select id="motivo" name="motivo">
        <option value="" disabled selected hidden>Selecione</option>
        <option value="1">Falecimento da pessoa.</option>
        <option value="2">Desvinculação da pessoa da família em que está cadastrada.</option>
        <option value="3">Decisão judicial.</option>
        <option value="4">Cadastros incluídos ou alterados em decorrência de fraude cibernética ou digital no Sistema de Cadastro Único.</option>
        <option value="5">Cadastros incluídos ou alterados indevidamente por agente público, por má fé.</option>
      </select>

      <label for="parecer">PARECER TECNICO:</label>
      <textarea id="parecer" name="parecer"></textarea>
      <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
      <button class="impr" onclick="voltarAoMenu()"><i class="fas fa-arrow-left"></i>Voltar</button>

      <div id="right-align">São Bento do Una - PE, <?php echo $data_formatada; ?>.</div>

      <div class="signature-line">_______________________________________________________<br>Assinatura do Responsável pela Unidade Familiar (RUF) (exceto no caso 3)</div>
      <div class="signature-line">_______________________________________________________<br>Assinatura do entrevistador</div>
      <div class="signature-line">_______________________________________________________<br>Assinatura do responsável pelo cadastramento</div>
      <div class="signature-line">_______________________________________________________<br>Assinatura do Gestor do CadÚnico (nos casos 4 e 5)</div>
    
    <div id="justified-text">
      <p>Caso o RF não saiba assinar, o entrevistador registra a expressão "A ROGO" e, a seguir, o nome do RF. (A ROGO é a expressão jurídica utilizada para indicar que a identificação, substituindo a assinatura, foi delegada a outra pessoa).</p>
    </div>
  </div>
  <?php
  } else {
    ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "NIS NÃO ENCONTRADO",
            html: `
            <p>Esse NIS <b>'<?php echo $nis_from; ?>' </b>não foi encontrado!</p>
            <h5>ATENÇÃO</h5>
            <p>Certifique se que os numeros estão corretos ou consulte no CadÚnico se o Cadastro está ativo.</p>
            `,
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/TechSUAS/views/cadunico/forms/menuformulario"
            }
        })
    </script>
    <?php

  }
  ?>
<script>
  function formatarNumero(numero) {
    return numero < 10 ? '0' + numero : numero
}

// Função para obter a data e hora atual e exibir na página
function mostrarDataHoraAtual() {
    let dataAtual = new Date()

    let dia = formatarNumero(dataAtual.getDate())
    let mes = formatarNumero(dataAtual.getMonth() + 1)
    let ano = dataAtual.getFullYear()

    let horas = formatarNumero(dataAtual.getHours())
    let minutos = formatarNumero(dataAtual.getMinutes())
    let segundos = formatarNumero(dataAtual.getSeconds())

    let dataHoraFormatada = `${dia}/${mes}/${ano} ${horas}:${minutos}:${segundos}`

    document.getElementById('dataHora').textContent = " - " + dataHoraFormatada
}

// Chamando a função para exibir a data e hora atual quando a página carrega
window.onload = function() {
    mostrarDataHoraAtual()
    // Atualizar a cada segundo
    setInterval(mostrarDataHoraAtual, 1000)
}

    const currentDate = new Date()
    const options = { day: '2-digit', month: 'long', year: 'numeric' }
    document.getElementById('dataExclusao').value = currentDate.toLocaleDateString('pt-BR', options)
    document.getElementById('dataExclusao2').textContent = currentDate.toLocaleDateString('pt-BR', options)
  </script>
  <script src="/TechSUAS/js/cadastro_unico.js"></script>
</body>
</html>