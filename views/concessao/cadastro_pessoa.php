<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_concessao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Responsável - TechSUAS</title>
    <link rel="stylesheet" href="/TechSUAS/css/concessao/style_cadpess.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>
    <script src="/TechSUAS/js/concessao.js"></script>
    <script src="/TechSUAS/js/salve_dados_conc.js"></script>
    
</head>

<body>
  <?php
  if (isset($_POST['cpf'])) {

  $cpf_resp = $conn->real_escape_string($_POST['cpf']);
  $cpf_resp_limp = preg_replace('/\D/', '', $_POST['cpf']);
  $ajustando_cod = str_pad($cpf_resp_limp, 11, '0', STR_PAD_LEFT);

        // Consulta única para obter dados do responsável da concessão
        $stmt = $pdo->prepare("SELECT nom_pessoa, dta_nasc_pessoa, nom_completo_mae_pessoa, nom_ibge_munic_nasc_pessoa, num_titulo_eleitor_pessoa, num_identidade_pessoa, num_nis_pessoa_atual, CONCAT(nom_tip_logradouro_fam, '', nom_titulo_logradouro_fam, ' ', nom_logradouro_fam, ', ', num_logradouro_fam, ' - ', nom_localidade_fam, ' ', txt_referencia_local_fam) AS endereco, vlr_renda_total_fam
                              FROM tbl_tudo
                              WHERE num_cpf_pessoa = :cpf_resp");
        $stmt->execute(array(':cpf_resp' => $ajustando_cod));

        if ($stmt->rowCount() > 0) {
          $dados_resp = $stmt->fetch(PDO::FETCH_ASSOC);

          $nome_pessoa = $dados_resp['nom_pessoa'] ;
          $data_nasc = $dados_resp['dta_nasc_pessoa'];
          $naturalidade = $dados_resp['nom_ibge_munic_nasc_pessoa'];
          $nome_mae = $dados_resp['nom_completo_mae_pessoa'];
          $tit_ele = $dados_resp['num_titulo_eleitor_pessoa'];
          $rg = $dados_resp['num_identidade_pessoa'];
          $nis_pessoa = $dados_resp['num_nis_pessoa_atual'];
          $endereco = $dados_resp['endereco'];
          $renda = "R$ " . number_format(floatval(str_replace(',', '',$dados_resp['vlr_renda_total_fam'])), 2, ',', '.');

          ?>
          <div class="img">
              <h1 class="titulo-com-imagem">
                  <img src="/TechSUAS/img/concessao/h1-cad_user.svg" alt="Titulocomimagem">
              </h1>
          </div>
          <div class="container">
              <div class="cpf_form">
                  <form id="form" >
      
          <input  type="text" class="salve_resp" name="cpf" id="cpf" onblur="validarCPF(this)" placeholder="Digite o CPF do RESPONSÁVEL:" maxlength="14" value="<?php echo $cpf_resp; ?>"required />
            <input type="text" class="salve_resp" name="nome_pessoa" id="nome_pessoa" required placeholder="Nome do responsável" oninput="this.value = this.value.toUpperCase()" value="<?php echo $nome_pessoa; ?>"/>
              <input type="date" class="salve_resp" name="dt_nasc" id="dt_nasc" required value="<?php echo $data_nasc; ?>"/>
                <input type="text" class="salve_resp" name="naturalidade_pessoa" id="naturalidade_pessoa" required placeholder="O responsável nasceu onde?" oninput="this.value = this.value.toUpperCase()" value="<?php echo $naturalidade; ?>"/>
                  <input type="text" class="salve_resp" name="nome_mae_pessoa" id="nome_mae_pessoa" required placeholder="Nome da mão responsável" oninput="this.value = this.value.toUpperCase()" value="<?php echo $nome_mae; ?>"/>
                    <input  type="text"class="salve_resp" name="endereco" required placeholder="Endereço" oninput="this.value = this.value.toUpperCase()" value="<?php echo $endereco; ?>"/>
                      <input type="text" class="salve_resp" name="contato" id="telefone" maxlenght="16" required placeholder="Contato" />
                        <input type="text" class="salve_resp" name="te_pessoa" id="tit_ele" maxlenght="14" placeholder="Título Eleitor" value="<?php echo $tit_ele; ?>" />
                          <input type="text" class="salve_resp" name="rg_pessoa" id="rg_pessoa" maxlenght="15" placeholder="RG" value="<?php echo $rg; ?>" />
                            <input type="text" class="salve_resp" name="nis_pessoa" id="nis_pessoa" maxlenght="12" placeholder="NIS" value="<?php echo $nis_pessoa; ?>" />
                              <input type="text" class="salve_resp" name="renda" id="renda" required placeholder="Renda mensal, sem os centavos" value="<?php echo $renda; ?>" />
                                <input type="number" class="salve_resp" name="quant_mes" id="quant_mes" placeholder="Quantos meses de concessão?" />
                                  <input type="checkbox" name="i" id="i" /><label for="">Não expecificado</label>
      
                          <button type="submit" id="btn_salvar" >SALVAR</button>
            <a href="/TechSUAS/config/back">
              <i class="fas fa-arrow-left"></i> Voltar ao menu
            </a>
      
                  </form>
      
              </div>
          </div>
      
          <?php

        } else {
          ?>
          <div class="img">
              <h1 class="titulo-com-imagem">
                  <img src="/TechSUAS/img/concessao/h1-cad_user.svg" alt="Titulocomimagem">
              </h1>
          </div>
          <div class="container">
              <div class="cpf_form">
                  <form id="form" >
      
          <input  type="text" class="salve_resp" name="cpf" id="cpf" onblur="validarCPF(this)" placeholder="Digite o CPF:" maxlength="14" value="<?php echo $cpf_resp; ?>"required />
            <input type="text" class="salve_resp" name="nome_pessoa" id="nome_pessoa" required placeholder="Nome completo" oninput="this.value = this.value.toUpperCase()"/>
              <input type="date" class="salve_resp" name="dt_nasc" id="dt_nasc" required />
                <input type="text" class="salve_resp" name="naturalidade_pessoa" id="naturalidade_pessoa" required placeholder="Nasceu onde?" oninput="this.value = this.value.toUpperCase()" />
                  <input type="text" class="salve_resp" name="nome_mae_pessoa" id="nome_mae_pessoa" required placeholder="Nome da mão" oninput="this.value = this.value.toUpperCase()" />
                    <input  type="text"class="salve_resp" name="endereco" required placeholder="Endereço" oninput="this.value = this.value.toUpperCase()" />
                      <input type="text" class="salve_resp" name="contato" id="telefone" maxlenght="16" required placeholder="Contato" />
                        <input type="text" class="salve_resp" name="te_pessoa" id="tit_ele" maxlenght="14" placeholder="Título Eleitor" />
                          <input type="text" class="salve_resp" name="rg_pessoa" id="rg_pessoa" maxlenght="15" placeholder="RG" />
                            <input type="text" class="salve_resp" name="nis_pessoa" id="nis_pessoa" maxlenght="12" placeholder="NIS" />
                              <input type="text" class="salve_resp" name="renda" id="renda" required placeholder="Renda mensal, sem os centavos" value="R$ " />
                                <input type="number" class="salve_resp" name="quant_mes" id="quant_mes" placeholder="Quantos meses de concessão?" />
                                  <input type="checkbox" name="i" id="i" /><label for="">Não expecificado</label>
      
                          <button type="submit" id="btn_salvar" >SALVAR</button>
            <a href="/TechSUAS/config/back">
              <i class="fas fa-arrow-left"></i> Voltar ao menu
            </a>
      
                  </form>
      
              </div>
          </div>
      
          <?php
        }

    
  }
    ?>
</body>

</html>