<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
      <form id="cadastroForm" action="/TechSUAS/controller/recepcao/salva_visita.php" method="POST">
      <!-- <input type="hidden" name="lc_cadastro" value="1"/> -->
      <input class="menu-sem" type="text" name="nome_rf" value="TESTE DA SILVA"/>
      <input class="menu-sem" type="hidden" name="codfam" value="123-TESTE"/>
      <input class="menu-sem" type="text" name="endereco" value= "RUA TESTE"/>
      <textarea name="obs" id="obs" placeholder="Descreva a situação" style="width: 90%;">TESTE 1, 2, 3... TESTANDO</textarea>



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