<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');

$response = ['encontrado' => false];

try {
	 // Consulta do MÊS ANTERIOR entrevistas
    $stmtMes = $pdo->prepare("
			SELECT COUNT(*) AS totais
			FROM tbl_tudo
			WHERE nom_entrevistador_fam = :operador
				AND cod_parentesco_rf_pessoa = 1
				AND MONTH(dta_entrevista_fam) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
				AND YEAR(dta_entrevista_fam) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
    ");

		$stmtMes->execute([':operador' => $_SESSION['nome_usuario']]);
    	$dadosMes = $stmtMes->fetch(PDO::FETCH_ASSOC);

		//Consulta do total geral
		$stmtGeral = $pdo->prepare("
			SELECT COUNT(*) AS totais_geral
			FROM tbl_tudo
			WHERE nom_entrevistador_fam = :operador
				AND cod_parentesco_rf_pessoa = 1
    ");

		$stmtGeral->execute([':operador' => $_SESSION['nome_usuario']]);
		$dadosGeral = $stmtGeral->fetch(PDO::FETCH_ASSOC);

		//Consulta de visitas
		$stmtScaneament = $pdo->prepare("
			SELECT COUNT(*) AS totais_up, MONTH(criacao) AS mes
			FROM cadastro_forms
			WHERE operador = :operador
			AND MONTH(criacao) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
			AND YEAR(criacao) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
		");

		$stmtScaneament->execute([':operador' => $_SESSION['nome_usuario']]);
		$dadosScan = $stmtScaneament->fetch(PDO::FETCH_ASSOC);

		$stmtInclusao = $pdo->prepare("
			SELECT COUNT(*) AS totais_inc
			FROM tbl_tudo
			WHERE nom_entrevistador_fam = :operador
			AND cod_parentesco_rf_pessoa = 1
			AND MONTH(dat_cadastramento_fam) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
			AND YEAR(dat_cadastramento_fam) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
		");

		$stmtInclusao->execute([':operador' => $_SESSION['nome_usuario']]);
		$dadosInclusao = $stmtInclusao->fetch(PDO::FETCH_ASSOC);

		$stmtVisitas = $pdo->prepare("
			SELECT COUNT(*) AS totalVisit
			FROM visitas_feitas
			WHERE entrevistador = :entrevistador
			AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
			AND YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
		");

		$stmtVisitas->execute([':entrevistador' => $_SESSION['nome_usuario']]);
		$dadosVisit = $stmtVisitas->fetch(PDO::FETCH_ASSOC);

	if (($dadosMes && $dadosMes['totais'] > 0) || ($dadosGeral && $dadosGeral['totais_geral'] > 0) || ($dadosScan && $dadosScan['totais_up']) || ($dadosInclusao && $dadosInclusao['totais_inc']) || ($dadosVisit && $dadosVisit['totalVisit'])) {
		$response['encontrado'] = true;
		$response['totais'] = $dadosMes['totais'] ?? 0;
		$response['operador'] = $_SESSION['nome_usuario'] ?? 0;
		$response['totais_geral'] = $dadosGeral['totais_geral'] ?? 0;
		$response['totais_up'] = $dadosScan['totais_up'] ?? 0;
		$response['mes'] = $dadosScan['mes'] ?? 0;
		$response['totais_inc'] = $dadosInclusao['totais_inc'] ?? 0;
		$response['totalVisit'] = $dadosVisit['totalVisit'] ?? 0;
	}
} catch (\Throwable $th) {
	echo json_encode(['status' => 'erro', 'mensagem' => "Erro: " . $th->getMessage()]);
	exit;
}

echo json_encode($response);

$pdo = null;