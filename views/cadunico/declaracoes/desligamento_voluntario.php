<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

//REQUISIÇÃO PARA DADOS DOS USUÁRIOS CREDENCIADOS COM ACESSO ADMINISTRATIVO
$setorizado = $_SESSION['setor'];
$sql_user = "SELECT * FROM operadores WHERE funcao = '1' AND setor = '$setorizado'";
$sql_user_query = $conn_1->query($sql_user) or die("ERRO ao consultar! " . $conn_1 - error);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href=/TechSUAS/css/cadunico/declaracoes/style-desligamento.css>
	<link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://accounts.google.com/gsi/client" async defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
	<script src="/TechSUAS/js/cadastro_unico.js"></script>

	<title>Declaração CadÚnico - TechSUAS</title>

</head>

<body class="<?php echo 'background-' . $_SESSION['estilo']; ?>">
<div class="titulo">
		<div class="tech">
			<span>TechSUAS-Cadastro Único - </span><?php echo $data_cabecalho; ?>
		</div>
	</div>
	<?php
	if (isset($_POST['cpf_dec_cad'])) {

		$cpf_limpo = preg_replace('/\D/', '', $_POST['cpf_dec_cad']);
		$cpf_already = ltrim($cpf_limpo, '0');
		// SOLICITAÇÃO DA TABELA TBL_TUDO PARA PEGAR OS DADOS DO INDIVIDUO
		$sql_dec = "SELECT * FROM tbl_tudo WHERE num_cpf_pessoa LIKE '%$cpf_already'";
		$sql_query_dec = $conn->query($sql_dec) or die("ERRO ao consultar! " . $conn - error);

		if ($sql_query_dec->num_rows == 0) {
	?>
			<script>
				Swal.fire({
					icon: "error",
					title: "CPF NÃO ENCONTRADO",
					text: "O CPF: <?php echo $_POST['cpf_dec_cad']; ?> não foi localizado no banco de dados atual, consulte o CadÚnico.",
					confirmButtonText: 'OK',
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = "/TechSUAS/views/cadunico/declaracoes/index"
					}
				})
			</script>
		<?php
		} else {
			$dados_tbl = $sql_query_dec->fetch_assoc();
		?>
			<div class="tudo">
      <h1>DECLARAÇÃO DE DESLIGAMENTO VOLUNTÁRIO DO PROGRAMA BOLSA FAMÍLIA</h1>

				<h4 style='text-align: center;'>(Base legal: inc. XVII do caput do art. 24 e §§ 6º a 8º do art. 27 da Portaria MDS nº 897/2023)</h4>

				<p>Prezado(a) coordenador(a) municipal do Programa Bolsa Família de <?php echo $cidade; ?></p>
				<p class="cont">Eu, <b><?php echo $dados_tbl['nom_pessoa']; ?></b> beneficiária(o) do Programa Bolsa Família (PBF), solicito meu desligamento voluntário do referido Programa, com a atualização cadastral no Cadastro Único para Programas Socias do Governo Federal (CadÚnico) e o registro da minha renda atual e/ou outras informações relevantes para o meu cadastro.</p>
				<p class="declar">Declaro, ainda, que:</p>
				<p class="cont">Estou ciente de que poderei, a qualquer momento dentro do prazo de 36 meses, solicitar meu retorno ao Programa Bolsa Família, mediante nova atualização cadastral que comprove minha necessidade socioeconômica para participar novamente do Programa.</p>
				<p class="cont">Estou ciente de que esse retorno ao Programa não gera o pagamento das parcelas anteriormente canceladas, e que apenas poderei receber as parcelas geradas a partir do processamento de minha nova inclusão no PBF</p>
				<div class="rf">
					<p>Dados do(a) Responsável Familiar:</p>
					<ul>
						<li>Nome complero: <strong><?php echo $dados_tbl['nom_pessoa']; ?></strong></li>
						<li>CPF: <strong><?php echo $_POST['cpf_dec_cad']; ?></strong></li>
						<li>NIS: <strong><?php echo $dados_tbl['num_nis_pessoa_atual']; ?></strong></li>
					</ul>
				</div>
				<div class="cidade_data">
					<?php echo $cidade; ?><?php echo $data_formatada_extenso; ?>.
				</div>
				<div class="signature-line"></div>
				<p style='text-align:center;'>Assinatura do(a) Responsável Familiar</p>

				<div id="justified-text" class="conteudo" style="page-break-before: always;">

					<p class="cont" style='margin-top: 100px;'>Eu, coordenador(a) municipal do Programa Bolsa Família de <?php echo $cidade; ?> ou por ele designado, afirmo que foi realizada, nesta data, a atualização cadastral do(a) beneficiário(a) acima identificado(a) no Cadastro Único para Programas Socias do Governo Federal (CadÚnico), e o cancelamento do benefício do Programa Bolsa Família, no Sistema de Benefícios ao Cidadão (Sibec), pelo motivo “Desligamento voluntário”.</p>
					<p class="cont">Declaro, ainda, que procedi ao cancelamento apenas do benefício da família, e não a exclusão de seu cadastro.</p>
					<p class="cont">O(a) responsável familiar acima identificado(a) poderá ter o cancelamento do seu benefício revertido dentro do prazo de 36 meses (três anos), retornando imediatamente à condição de beneficiário(a), caso sua renda volte a ser compatível com as regras do Programa Bolsa Família. Basta, para isso, que seus dados sejam atualizados no CadÚnico, e que o pedido de retorno garantido seja feito ao coordenador municipal do Programa.</p>
					<p class="cont">A presente declaração foi assinada em duas vias, uma arquivada no município e a outra entregue para o(a) beneficiário(a).</p>
					<p>Dados do(a) coordenador(a) municipal do Programa Bolsa Família:</p>

					<?php
  $sistema_id = $_SESSION['sistema_id'];
					$mysql = "SELECT * FROM operadores WHERE funcao LIKE 1 AND sistema_id LIKE '$sistema_id'";
					$mysqlq = $conn_1->query($mysql) or die("ERRO ao consultar!" . $conn_1 - error);

					if ($mysqlq->num_rows == 0) {
						echo "COORDENAÇÃO NÃO IDENTIFICADA.";
					} else {
						$dados = $mysqlq->fetch_assoc();
					?>
						<div class="cord">
							<li>Nome completo: <strong><?php echo $dados['nome']; ?></strong></li>
							<li>CPF: <strong><?php echo $dados['cpf']; ?></strong></li>
						</div>
						<div class="cidade_data2">
							<?php echo $cidade; ?><?php echo $data_formatada_extenso; ?>.
						</div>
						<div class="signature-line"></div>
						<p style='text-align:center;'>Assinatura do(a) coordenador(a) municipal do Programa Bolsa Família</p>
			<?php
					}
				}
			}
			?>
			<div class="no-print">
				<button onclick="printWithSignature()">Imprimir com Assinatura Eletrônica</button>
				<button onclick="printWithFields()">Imprimir com Campos de Assinatura</button>
				<button onclick="voltar()"><i class="fas fa-arrow-left"></i>Voltar</button>
			</div>
				</div>
</body>

</html>