<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
      <form id="cadastroForm" action="/TechSUAS/controller/cadunico/dashboard/atendimento_acao_cadu.php" method="POST">
      <input type="hidden" name="lc_cadastro" value="1"/>
      <?php
      print_r($_SESSION['acao_cadu']);
      ?>
      <!-- <input type="hidden" name="programa" value="CADUNICO"/>
      <input type="hidden" name="tipo" value="COMUM"/> -->
      

      <!-- <input type="hidden" name="tipo_documento" value="Atualização"/>
      <input type="date" name="dataEntre" /> -->
      
      <!-- <input type="hidden" name="cod_talao" value="1234"/>
      <input type="hidden" name="cpf_valido" value="1234"/>
      <input type="hidden" name="nome_pessoa" value="TESTE"/>
      <input type="hidden" name="entrega" value="TESTE"/>
      <input type="hidden" name="cod_talao" value="1234"/> -->

            <button type="submit">Cadastrar</button>
      </form>
      <!-- visualizar o pdf -->
</body>
</html>