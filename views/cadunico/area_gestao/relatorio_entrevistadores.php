<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';


if ($_GET['escolha'] === 'mensal') {

$mesNumber = Date('m') - 1;

$mesMap = [
		1 => 'Janeiro',
		2 => 'Fevereiro',
		3 => 'Março',
		4 => 'Abril',
		5 => 'Maio',
		6 => 'Junho',
		7 => 'Julho',
		8 => 'Agosto',
		9 => 'Setembro',
		10 => 'Outubro',
		11 =>	'Novembro',
		12 =>	'Dezembro'];

$nomemes = $mesMap[$mesNumber];

// Buscar nome dos Entrevistadores ------------------------------------------------------------
$sqlEntrevistadores = "
	SELECT COUNT(*) AS totais, nom_entrevistador_fam
	FROM tbl_tudo
	WHERE cod_parentesco_rf_pessoa = 1
		AND MONTH(dta_entrevista_fam) = MONTH(CURRENT_DATE - INTERVAL 2 MONTH)
		AND YEAR(dta_entrevista_fam) = YEAR(CURRENT_DATE - INTERVAL 2 MONTH)
	GROUP BY nom_entrevistador_fam ASC
";

	include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/controller/cadunico/declaracao/dados_entrevistadores_mensal.php';
} else {

$mesNumber = Date('m') - 1;

$mesMap = [
		1 => 'Janeiro',
		2 => 'Fevereiro',
		3 => 'Março',
		4 => 'Abril',
		5 => 'Maio',
		6 => 'Junho',
		7 => 'Julho',
		8 => 'Agosto',
		9 => 'Setembro',
		10 => 'Outubro',
		11 =>	'Novembro',
		12 =>	'Dezembro'
	];

$nomemes = $mesMap[$mesNumber];

// Buscar nome dos Entrevistadores ------------------------------------------------------------
$sqlEntrevistadores = "
	SELECT COUNT(*) AS totais, nom_entrevistador_fam
	FROM tbl_tudo
	WHERE cod_parentesco_rf_pessoa = 1
	GROUP BY nom_entrevistador_fam ASC
";

	include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/controller/cadunico/declaracao/dados_entrevistadores_anual.php';
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    

    <title>Relatório Entrevistadores - TechSUAS</title>
</head>
<body>
	<h1>RELATÓRIO MENSAL - ENTREVISTADORES</h1>

	<h2>Entrevistadores do Cadastro Único Ativos em <?php echo $nomemes; ?></h2>

<?php

$stmtEntrevistadores = $pdo->prepare($sqlEntrevistadores);
$stmtEntrevistadores->execute();

$arm_dados_entrevistas = [];
	while ($dadinho = $stmtEntrevistadores->fetch(PDO::FETCH_ASSOC)) {
		$arm_dados_entrevistas[] = [
			'nome' => $dadinho['nom_entrevistador_fam'],
			'totais' => $dadinho['totais']
		];
	}

	if (!empty($arm_dados_entrevistas)) {
		?>
		<table width="40%">
			
		<ul>
		<?php
			foreach ($arm_dados_entrevistas as $linhas_ent) {
				$total = $linhas_ent['totais'] === 1 ? ' cadastro;' : ' cadastros;';
				?><tr>
				<td><li><?php echo $linhas_ent['nome'];?></li></td>
				<td><?php echo $linhas_ent['totais'] . $total; ?></td>
				</tr>
				<?php
			}
		?>
		</ul>
		
		</table>
		<?php

	}
?>

<h2>Tabela de detalhamento</h2>

<table border="1" width="95%">
	<tr>
		<th>Matricula</th>
		<th>Nome Entrevistador</th>
		<th>Entrevistas</th>
		<th colspan="2">Atualizações/Inclusões</th>
		<th colspan="2">Visitas/Visitas CadÚnico</th>
		<th>Fichário</th>
	</tr>

<?php
			if (!empty($dados_entrevistadores)) {
				foreach ($dados_entrevistadores as $linha) {
					echo '<tr>';
					echo '<td>---</td>';
					echo '<td>' . strtoupper(htmlspecialchars($linha['nome'])) . '</td>';
					echo '<td>' . intval($linha['entrevistas']) . '</td>';
					echo '<td>' . intval($linha['atualiza']) . '</td>';
					echo '<td>' . intval($linha['inclusao']) . '</td>';
					echo '<td>' . intval($linha['visitas']) . '</td>';
					echo '<td>' . intval($linha['visitas_cad']) . '</td>';
					echo '<td>' . intval($linha['fichario']) . '</td>';
					echo '</tr>';
				}
			} else {
				echo '<tr><td colspan="7">Nenhum dado localizado</td></tr>';
			}
?>
</table>

<h2>Atividades Externas</h2>
	<h4>CADASTRO ÚNICO MAIS PERTO DE VOCÊ</h4>

<?php
	if ($stmt_cadu->rowCount() > 0) {
		$cadu = $stmt_cadu->fetch(PDO::FETCH_ASSOC);
		?>
		<p>Foi realizado neste mês <strong><?php echo $cadu['totais_cadu']; ?></strong> cadastros <strong><span class="editable-field" contenteditable="true" ></span></strong></p>
		<?php
	} 
?>

<h2>Tabela - Hora Extra</h2>

<?php

if ($_GET['escolha'] === 'mensal') {
	?>
	<h2></h2>
	<table width="50%">
		<tr>
			<th>Nome</th>
			<th>Horas</th>
		</tr>
		<?php
			if (!empty($arm_dados_entrevistas)) {
				foreach ($arm_dados_entrevistas as $linhas_ent1) {
					?>
					<tr>
						<td><?php echo $linhas_ent1['nome']; ?></td>
						<td><input type="number" name="a" id="a"></td>
					</tr>
					<?php
				}
			}
		?>
	</table>
	<?php
} else {

}

?>
</body>
</html>