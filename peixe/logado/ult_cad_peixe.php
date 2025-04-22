<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';

$operador = $_SESSION['nome_usuario'];

header('Content-Type: application/json'); // Define o tipo de resposta como JSON

$response = ['encontrado' => false]; // Inicializa a resposta como não encontrada
$operador = $_SESSION['nome_usuario'];

try {
        //FAÇA UMA REQUISIÇÃO PARA CRIAR UM GRAFICO COM OS 
        $stmt = $pdo->prepare("SELECT p.codigo_talao, t.cod_parentesco_rf_pessoa, p.nome, t.nom_pessoa, t.cod_familiar_fam
                                FROM peixe p
                                LEFT JOIN tbl_tudo t ON p.cpf = t.num_cpf_pessoa
                                WHERE p.operador = :op
                                AND DATE(p.createdAt) = CURDATE()
                                ORDER BY p.createdAt DESC;
                            ");
        $stmt->execute(array($operador));

        $resultado_dos = array();


        if ($stmt->rowCount() > 0) {
            $response['encontrado'] = true;
            $more = 0;
                while ($cremosinho = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $more ++;
                    $parentesco_map = [
                        1 => "RESPONSAVEL FAMILIAR",
                        2 => "CONJUGE OU COMPANHEIRO",
                        3 => "FILHO(A)",
                        4 => "ENTEADO(A)",
                        5 => "NETO(A) OU BISNETO(A)",
                        6 => "PAI OU MÃE",
                        7 => "SOGRO(A)",
                        8 => "IRMÃO OU IRMÃ",
                        9 => "GENRO OU NORA",
                        10 => "OUTROS PARENTES",
                        11 => "NÃO PARENTE",
                        "" => "Não informado"
                    ];
                    $parentesco = $parentesco_map[$cremosinho['cod_parentesco_rf_pessoa']];
                    $nome_pessoa = $cremosinho['nom_pessoa'] === NULL ? "BPC" : $cremosinho['nom_pessoa'];
                    $codigoDOtalaoFomra = str_pad($cremosinho['codigo_talao'], 4, '0', STR_PAD_LEFT);
                    $dados_ultimos[] = array(
                        'cod_talao' => $codigoDOtalaoFomra,
                        'cod_parentesco' => $parentesco,
                        'nome' => $cremosinho['nome'],
                        'nom_pessoa' => $nome_pessoa,
                        'cod_familiar_fam' => $cremosinho['cod_familiar_fam'],

                    );
                }
                $response['seq'] = $more;
                $response['operador'] = $_SESSION['nome_usuario'];
                $response['lc_cad'] = $_SESSION['lc_cad'];
                $response['dados_ultimos'] = !empty($dados_ultimos) ? $dados_ultimos : "Nenhum arquivo encontrado.";
        } else {
            $response['encontrado'] = false;
            $response['mensagem'] = "Nenhum resultado encontrado.";
        }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['erro' => "Erro: " . $e->getMessage()]);
}

