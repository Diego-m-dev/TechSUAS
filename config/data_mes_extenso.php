<?php
//formatando data para um formato 'd de mes de ano'
$data_atual = date('d/m/Y');
$date_formatando = DateTime::createFromFormat('d/m/Y', $data_atual);
$formatter = new IntlDateFormatter(
    'pt_BR', // Localidade
    IntlDateFormatter::FULL, // Estilo da data
    IntlDateFormatter::NONE, // Estilo do tempo
    'America/Sao_Paulo', // Fuso horário
    IntlDateFormatter::GREGORIAN // Calendário
);
$formatter->setPattern('d \'de\' MMMM \'de\' y');
$data_formatada_extenso = $formatter->format($date_formatando);

$data_cabecalho = date('d/m/Y H:i');
$ibge_cod = $_SESSION['municipio'];
$stmt_city = "SELECT municipio, estado FROM municipios WHERE cod_ibge = '$ibge_cod'";
$stmt_city_query = $conn_1->query($stmt_city) or die("Erro " .$conn_1 - error);

  if ($stmt_city_query->num_rows > 0) {
    $sfinge = $stmt_city_query->fetch_assoc();
    $cidade = $sfinge['municipio']. " - " .$sfinge['estado'].", ";
  }
