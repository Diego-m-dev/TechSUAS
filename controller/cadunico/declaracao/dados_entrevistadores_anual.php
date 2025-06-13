<?php

$dados_entrevistadores = [];

// Consulta de entrevistas
$sql_entrevistas = "
	SELECT COUNT(*) AS totais, nom_entrevistador_fam
	FROM tbl_tudo
	WHERE cod_parentesco_rf_pessoa = 1
	GROUP BY nom_entrevistador_fam
	ORDER BY totais DESC
";

$stmt_entrevistas = $pdo->prepare($sql_entrevistas);
$stmt_entrevistas->execute();

// Consulta de visitas
$sql_visitas = "
	SELECT COUNT(*) AS totais_visitas, entrevistador
	FROM visitas_feitas
	GROUP BY entrevistador
";

$stmt_visitas = $pdo->prepare($sql_visitas);
$stmt_visitas->execute();

// Consulta das inclusões realizadas
$sql_inclusao = "
		SELECT COUNT(*) AS totais_inc, nom_entrevistador_fam
		FROM tbl_tudo
		WHERE cod_parentesco_rf_pessoa = 1
		GROUP BY nom_entrevistador_fam
";

$stmt_inclusao = $pdo->prepare($sql_inclusao);
$stmt_inclusao->execute();

// Consultar visitas realizadas no CADÚNICO
$sql_visitas_cad = "
	SELECT COUNT(*) AS totais_visit, nom_entrevistador_fam
	FROM tbl_tudo
	WHERE cod_parentesco_rf_pessoa = 1
		AND cod_forma_coleta_fam = 2
	GROUP BY nom_entrevistador_fam
";

$stmt_visitas_cad = $pdo->prepare($sql_visitas_cad);
$stmt_visitas_cad->execute();

// Consultar atendimentos externos AÇÃO CADASTRO ÚNICO MAIS PERTO DE VC
$sql_cadu = "
	SELECT COUNT(*) AS totais_cadu
	FROM atendimentos_acao_cadu
";

$stmt_cadu = $pdo->prepare($sql_cadu);
$stmt_cadu->execute();

// Consultar os upload
$sql_fichario = "
	SELECT COUNT(*) AS totais_fichario, operador
	FROM cadastro_forms
	WHERE MONTH(criacao) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
		AND YEAR(criacao) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
	GROUP BY operador
";

$stmt_fichario = $pdo->prepare($sql_fichario);
$stmt_fichario->execute();

// Mapeia fichario upados
$fichario_map = [];
while ($rowFichario = $stmt_fichario->fetch(PDO::FETCH_ASSOC)) {
	$fichario_map[$rowFichario['operador']] = $rowFichario['totais_fichario'];
}


// Mapeia visitas realizadas com cadastros efetivos
$visitas_cad_map = [];
while ($rowVisitCad = $stmt_visitas_cad->fetch(PDO::FETCH_ASSOC)) {
	$visitas_cad_map[$rowVisitCad['nom_entrevistador_fam']] = $rowVisitCad['totais_visit'];
}


// Mapeia visitas por entrevistador
$visitas_map = [];
while ($rowVisit = $stmt_visitas->fetch(PDO::FETCH_ASSOC)) {
	$visitas_map[$rowVisit['entrevistador']] = $rowVisit['totais_visitas'];
}

// Mapeia inclusões por entrevistador
$inclusao_map = [];
while ($rowInc = $stmt_inclusao->fetch(PDO::FETCH_ASSOC)) {
	$inclusao_map[$rowInc['nom_entrevistador_fam']] = $rowInc['totais_inc'];
}

// Junta os dados
while ($row = $stmt_entrevistas->fetch(PDO::FETCH_ASSOC)) {
	$entrevistador = $row['nom_entrevistador_fam'];
	$entrevistas = $row['totais'];
	$visitas = $visitas_map[$entrevistador] ?? 0; // 0 se não tiver visita registrada
	$inclusao = $inclusao_map[$entrevistador] ?? 0;
	$visitas_cad = $visitas_cad_map[$entrevistador] ?? 0;
	$fichario = $fichario_map[$entrevistador] ?? 0;

	$atualizacao = $entrevistas - $inclusao;

	$dados_entrevistadores[] = [
		'nome' => $entrevistador,
		'entrevistas' => $entrevistas,
		'visitas' => $visitas,
		'inclusao' => $inclusao,
		'atualiza' => $atualizacao,
		'visitas_cad' => $visitas_cad,
		'fichario' => $fichario
	];
}