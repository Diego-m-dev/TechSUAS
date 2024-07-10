<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Tabela Itens Concessão - TechSUAS</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
		<link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
		<link rel="stylesheet" href="/TechSUAS/css/concessao/style_item.css">
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
		<div class="img">
				<h1 class="titulo-com-imagem">
						<img src="/TechSUAS/img/concessao/h1-tabela.svg" alt="Titulocomimagem">
				</h1>
		</div>
		<div class="container">
				<form method="POST" action="/TechSuas/controller/concessao/excluir_item">
						<?php
						$sql_dados = $conn->query("SELECT * FROM concessao_itens ORDER BY nome_item");

						if ($sql_dados->num_rows > 0) {
						?>
								<table width="650px" border="1">
										<tr class="titulo">
												<th class="cabecalho">Código Item</th>
												<th class="cabecalho">Característica</th>
												<th class="cabecalho">Nome do Item</th>
										</tr>

										<?php

										while ($dados = $sql_dados->fetch_assoc()) {
										?>
												<tr class="resultado" style="text-align: center;">
														<td class="resultado"><?php echo $dados['cod_item']; ?></td>
														<td class="resultado"><?php echo $dados['caracteristica']; ?></td>
														<td class="resultado"><?php echo $dados['nome_item']; ?></td>
														<td class="check">
																<label class="urg">
																		<input type="checkbox" name="excluir[]" value="<?php echo $dados['id_itens_conc']; ?>">
																		<span class="checkmark"></span>
																</label>
														</td>
												</tr>
										<?php
										}
								} else {
										?>
										<tr>
												<td colspan="3"><p>Resultados da pesquisa.</p></td>
										</tr>
								<?php
								}
								?>
								</table>

								<div class="btn" id="modal">
										<button type="button" onclick="excluirSelecionados()">Excluir</button>
										<a href="/TechSUAS/config/back">
								<i class="fas fa-arrow-left"></i> Voltar ao menu
								</a>
								</div>
				</form>

				<script>
						function excluirSelecionados() {
								document.forms[0].submit(); // Envia o formulário
						}
				</script>
		</div>
</body>

</html>