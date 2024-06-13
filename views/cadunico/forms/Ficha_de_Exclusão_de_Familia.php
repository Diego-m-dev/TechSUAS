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
<title>Ficha de exclusão de família</title>
<link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
<link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/ex_fami.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único </span><?php echo $data_cabecalho; ?>
        </div>
    </div>
    <div class="container" id="form-container">
    <div id="title">ANEXO III - FICHA DE EXCLUSÃO DE FAMÍLIA</div>

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

      <label for="codigoFamiliar">Código domiciliar ou código familiar:</label>
      <input type="text" id="codigoFamiliar" name="codigoFamiliar" value="<?php echo $cod_familiar_formatado; ?>" readonly>

      <label for="nisResponsavel">NIS do Responsável pela Unidade Familiar (RUF):</label>
      <input type="text" id="nisResponsavel" name="nisResponsavel" value="<?php echo $nis_responsavel_formatado; ?>">
      
      <label for="dataExclusao">DATA DA EXCLUSÃO:</label>
      <input type="text" id="dataExclusao" name="dataExclusao" readonly>

      <label for="motivo">Motivo:</label>
      <div class="impr">
      <input class="impr" type="text" id="motivo" class="parecer" name="motivo" oninput="buscarTextoMotivo()">
      </div>
  <div>
    <span id="numeroMotivoSelecionado"></span>
    <span id="textoMotivo" name="justified-text">Texto do motivo selecionado será exibido aqui.</span>
  </div>

      <label for="parecer">PARECER TECNICO:</label>
      <textarea id="parecer" name="parecer"></textarea>
      <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
      <button class="impr" onclick="voltarAoMenu()"><i class="fas fa-arrow-left"></i>Voltar</button>

      <div id="right-align">São Bento do Una - PE, <span id="dataExclusao2"></span>.</div>

      <div class="signature-line">______________________________________________________________<br>Assinatura do Responsável pela Unidade Familiar (RUF) (exceto no caso 3)</div>
      <div class="signature-line">______________________________________________________________<br>Assinatura do entrevistador</div>
      <div class="signature-line">______________________________________________________________<br>Assinatura do responsável pelo cadastramento</div>
      <div class="signature-line">______________________________________________________________<br>Assinatura do Gestor do CadÚnico (nos casos 4 e 5)</div>
    
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
              Esse NIS <b>'<?php echo $nis_from; ?>' </b>não foi encontrado!
              <h5>ATENÇÃO</h5>
              Certifique se que os numeros estão corretos ou consulte no CadÚnico se o Cadastro está ativo.
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

// Função para obter a data e hora atual e exibir na página
function mostrarDataHoraAtual() {
    let dataAtual = new Date();

    let dia = formatarNumero(dataAtual.getDate());
    let mes = formatarNumero(dataAtual.getMonth() + 1);
    let ano = dataAtual.getFullYear();

    let horas = formatarNumero(dataAtual.getHours());
    let minutos = formatarNumero(dataAtual.getMinutes());
    let segundos = formatarNumero(dataAtual.getSeconds());

    let dataHoraFormatada = `${dia}/${mes}/${ano} ${horas}:${minutos}:${segundos}`;

    document.getElementById('dataHora').textContent = " - " + dataHoraFormatada;
}

// Chamando a função para exibir a data e hora atual quando a página carrega
window.onload = function() {
    mostrarDataHoraAtual();
    // Atualizar a cada segundo
    setInterval(mostrarDataHoraAtual, 1000);
}
    const currentDate = new Date();
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    document.getElementById('dataExclusao').value = currentDate.toLocaleDateString('pt-BR', options);
    document.getElementById('dataExclusao2').textContent = currentDate.toLocaleDateString('pt-BR', options);

    const motivoList = {
        "1": {oneMt: "- Falecimento de toda a família, mediante apresentação das certidões de óbito."},
        "2": {twoMt: "- Recusa da família em prestar informações, mediante elaboração de parecer assinado por servidor municipal vinculado à gestão do CadÚnico."},
        "3": {threeMt: "- Omissão ou prestação de informações inverídicas pela família, por comprovada má fé."},
        "4": {fourMt: "- Solicitação do RUF."},
        "5": {fiveMt: "- Decisão judicial."},
        "6": {sixMt: "- Cadastros desatualizados cuja inclusão ou última atualização ocorreu há 48 (quarenta e oito) meses ou mais."},
        "7": {sevenMt: "- Cadastros incluídos ou alterados em decorrência de fraude cibernética ou digital no(s) sistema(s) de entrada e manutenção de dados do CadÚnico, operado(s) pelas gestões municipais e do Distrito Federal, mediante elaboração de parecer assinado pelo Gestor do CadÚnico que ateste que a inclusão ou a alteração não foi realizada pelo Município ou pelo Distrito Federal."},
        "8": {eightMt: "- Cadastros incluídos ou alterados indevidamente por agente público, por má fé, mediante elaboração de parecer assinado pelo Gestor do CadÚnico."},
        "9": {nineMt: "- Cadastros de famílias cuja renda mensal per capita é superior à meio salário mínimo, ressalvados os casos cobertos pelo parágrafo único do art. 5º do Decreto nº 11.016, de 29 de março de 2022."}
    }

    function buscarTextoMotivo() {
    var motivoInput = document.getElementById("motivo");
    var numeroMotivoSelecionado = document.getElementById("numeroMotivoSelecionado");
    var textoMotivo = document.getElementById("textoMotivo");

    var selectedValue = motivoInput.value;
    var selectedText = motivoList[selectedValue];

    if (selectedText) {
        numeroMotivoSelecionado.textContent = selectedValue;
        textoMotivo.textContent = selectedText[Object.keys(selectedText)[0]];
    } else {
        numeroMotivoSelecionado.textContent = "";
        textoMotivo.textContent = "Texto do motivo selecionado será exibido aqui.";
    }
}
</script>
<script src="/TechSUAS/js/cadastro_unico.js"></script>
</body>
</html>