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
$data_formatada = $formatter->format($date_formatando);

$data_cabecalho = date('d/m/Y H:i');

$cidade = 'São Bento do Una - PE, ';