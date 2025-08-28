<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

header('Content-Type: application/json');


try {
    // Busca os registros das visitas
    $stmt = $pdo->prepare("
        SELECT var.id, var.nome, var.cpf, var.endereco, vf.id, vf.acao, vf.data_visita, vf.texto, vf.entrevistador, t.dat_atual_fam, t.vlr_renda_media_fam, t.qtde_meses_desat_cat
        FROM visitas_a_realizar var
        LEFT JOIN visitas_feitas vf ON vf.id_visita = var.id
        LEFT JOIN tbl_tudo t ON t.num_cpf_pessoa = var.cpf
        WHERE var.status = 'feito'
    ");

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    function gerarNumeroDocumentoPreview(PDO $pdo, int $increment = 0): string {
        $anoAtual = date('Y');
        $st = $pdo->prepare("SELECT COUNT(*) as total FROM historico_relatorio_visita WHERE YEAR(created_at) = :ano");
        $st->execute([':ano' => $anoAtual]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        $base = isset($row['total']) ? (int)$row['total'] : 0;
        $seq = $base + 1 + $increment;
        return str_pad((string)$seq, 4, '0', STR_PAD_LEFT) . '/' . $anoAtual;
    }

    $salarioMinimo = 1518; // valor atual (2025), ajuste conforme necessário
    $meioSalario = $salarioMinimo / 2;

    foreach ($result as $index => &$item) {

      //Entrevistador que realizou a visita
        $item['entrevistador'] = $item['entrevistador'] ?? 'Não informado';

        // CPF: apenas dígitos e pad com zeros à esquerda até 11
        $cpfDigits = preg_replace('/\D/', '', (string)($item['cpf'] ?? ''));
        $item['cpf'] = str_pad($cpfDigits, 11, '0', STR_PAD_LEFT);

        // Garantir que data_visita esteja como YYYY-MM-DD (vindo do DB)
        // Se por acaso for nulo, manter null/empty para o front tratar
        $item['data_visita'] = $item['data_visita'] ?? null;

        // Número de documento para preview (não escreve nada no BD aqui)
        $item['numero_documento'] = gerarNumeroDocumentoPreview($pdo, $index);

        $secretKey = 'h1N7b9lT4cQ5gA9s!2mQvXkPzEoF*H7jL3dW8uZrYx#GkV0nR6';
        $dataToSign = $item['numero_documento'] . '|' . $item['cpf'] . '|' . ($item['data_visita'] ?? '');
        $hash = hash_hmac('sha256', $dataToSign, $secretKey);

        // Código de autenticação: primeiros 8 caracteres do hash em maiúsculas, formatado
        $item['auth_code'] = strtoupper(substr($hash, 0, 4) . '-' . substr($hash, 4, 4));

        // Valores numéricos seguros
        $mesesDesatualizado = isset($item['qtde_meses_desat_cat']) ? (int)$item['qtde_meses_desat_cat'] : 0;
        // vlr_renda_media_fam pode vir com vírgula; normaliza
        $rendaRaw = $item['vlr_renda_media_fam'] ?? '0';
        $rendaRaw = str_replace(['.', ','], ['', '.'], (string)$rendaRaw);
        $rendaMedia = (float)$rendaRaw;

        $acao = isset($item['acao']) ? (int)$item['acao'] : null;
        // Condições para parecer

        if ($acao == 2) {
            $item['acao'] = "Entretanto, a família não foi localizada.";
        } elseif ($acao == 1) {
            $item['acao'] = "A família foi localizada com cadastro realizado em domicílio.";
        } elseif ($acao == 3) {
            $item['acao'] = "Segundo informações de vizinhos, o responsável familiar faleceu.";
        } elseif ($acao == 5) {
            $item['acao'] = "A família foi localizada, mas se recusaram a prestar informações para atualizar o cadastro.";
        } elseif ($acao == 4) {
            $item['acao'] = "O responsável se recusou a atualizar o cadastro.";
        } else {
            $item['acao'] = "AÇÃO NÃO INFORMADA";
        }

        if ($acao ===1) {
            $item['parecer'] = "";
        } else if ($mesesDesatualizado >= 4 && $rendaMedia > $meioSalario) {
            $item['parecer'] = "Com base nas informações coletadas, o cadastro foi excluído com fundamento no Art. 25, inciso VI, da Portaria MC nº 810/2022, por apresentar desatualização superior a 48 meses e renda per capita superior a ½ salário mínimo, não atendendo aos critérios estabelecidos para permanência no Cadastro Único.";
        } elseif ($mesesDesatualizado >= 4) {
            $item['parecer'] = "Com base nas informações coletadas, o cadastro foi excluído com fundamento no Art. 25, inciso VI, da Portaria MC nº 810/2022, por apresentar desatualização superior a 48 meses, não atendendo aos critérios estabelecidos para permanência no Cadastro Único.";
        } elseif ($rendaMedia > $meioSalario) {
            $item['parecer'] = "Com base nas informações coletadas, o cadastro foi excluído com fundamento no Art. 25, inciso V, da Portaria MC nº 810/2022, por apresentar renda per capita superior a ½ salário mínimo, não atendendo aos critérios estabelecidos para permanência no Cadastro Único.";
        } elseif ($acao === 2) {
            $item['parecer'] = "Com base nas informações coletadas, o cadastro foi excluído com fundamento no Art. 25, inciso VI, da Portaria MC nº 810/2022, devido à impossibilidade de atualização cadastral por não localização da família, inviabilizando a manutenção das informações exigidas pelo programa.";
        } elseif ($acao === 3 && $rendaRaw) {
            $item['parecer'] = "Com base nas informações coletadas, o cadastro foi excluído com fundamento no Art. 25, inciso IV, da Portaria MC nº 810/2022, em razão do falecimento dos integrantes da família, conforme informações obtidas durante a visita domiciliar.";
        } else {
            $item['parecer'] = "Com base nas informações coletadas, no ato da busca ativa, não foi localizada a família para inclusão no Cadastro Único, a família não tem dados na base do governo federal.";
        }
    }

    unset($item); // limpa referência

    echo json_encode(['status' => 'success', 'dados' => $result]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
$pdo = null;
exit;
?>