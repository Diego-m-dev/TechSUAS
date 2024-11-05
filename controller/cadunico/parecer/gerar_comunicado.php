<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

// Captura os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);
$nisSelecionados = $data['nisSelecionados'];

if (!empty($nisSelecionados)) {
    // Transforma os NIS selecionados em uma lista para a consulta SQL
    $nisLista = implode(',', array_map('intval', $nisSelecionados));

    // Exemplo de consulta SQL
    $sql = "SELECT nom_pessoa, CONCAT(nom_tip_logradouro_fam, ' ', nom_titulo_logradouro_fam, ' ', nom_logradouro_fam, ', ', num_logradouro_fam, ' - ', nom_localidade_fam, ' ', txt_referencia_local_fam) AS endereco FROM tbl_tudo WHERE num_nis_pessoa_atual IN ($nisLista)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Aqui você gera o comunicado com base nos dados do banco
        while ($row = $result->fetch_assoc()) {
            // Exemplo: Exibir os dados ou gerar PDF/arquivo
            echo "<div class='comunicado'><h2>COMUNICADO CADASTRO ÚNICO</h2> <h4>" . $cidade . $data_formatada_extenso . " </h4> <p>Prezado(a) <strong>" . $row['nom_pessoa'] . "</strong>, residente em <strong>" . $row['endereco'] . "</strong></p> <p>Conforme nossos registros, identificamos que o seu Cadastro Único está desatualizado. Manter o seu cadastro atualizado é fundamental para garantir a continuidade e acesso aos benefícios sociais oferecidos pelo Governo Federal.</p> <p>Solicitamos que compareça a <strong>Secretaria de Assistência Social</strong>, localizado na <strong>Av Oswaldo Celso Maciel, 122 - Centro</strong>, os atendimentos começam a partir das <strong>8h de segunda a sexta</strong>. Durante o atendimento, será necessário apresentar documentos pessoais de todos os moradores e comprovante de residência.</p> <p>A atualização do Cadastro Único é fundamental e deve ser feita o quanto antes.</p> <p>Em caso de dúvidas, entre em contato pelo telefone <strong>(81) 9.8552-3380 (Whatsapp)</strong>.</p> <p>Contamos com sua presença!</p> <p> Atenciosamente,<br><strong>Coordenação do Cadastro Único/Bolsa Família<br>Secretaria Municipal de Assistência Social</strong></p> <p>(Se você não é a pessoa citada, por favor desconsiderar esta mensagem)</p></div>";
        }
    } else {
        echo "Nenhum dado encontrado para os NIS selecionados.";
    }
} else {
    echo "Nenhum NIS selecionado.";
}

$conn->close();
?>
