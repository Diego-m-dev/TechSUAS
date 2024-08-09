<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
ini_set('memory_limit', '256M');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

try {
    if (isset($_POST['buscar_dados']) && !empty($_POST['buscar_dados'])) {
        $opcao = filter_input(INPUT_POST, 'buscar_dados', FILTER_SANITIZE_STRING);
        $valorEscolhido = filter_input(INPUT_POST, 'valorescolhido', FILTER_SANITIZE_STRING);

        if ($opcao == "cpf_dec") {
            $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_cpf_pessoa = :valorEscolhido");
            $sql->execute([':valorEscolhido' => $valorEscolhido]);

            $sqli = $pdo->prepare("SELECT * FROM folha_pag WHERE rf_cpf = :valorEscolhido");
            $sqli->execute([':valorEscolhido' => $valorEscolhido]);

            if ($sql->rowCount() > 0) {
                $dados = $sql->fetch(PDO::FETCH_ASSOC);
                $cod_familiar = $dados["cod_familiar_fam"];
                $nom_pessoa = $dados["nom_pessoa"];
                $data_atualizada = $dados['dat_atual_fam'];
                $renba_media = $dados["vlr_renda_media_fam"];

                $real_br_formatado = number_format($renba_media, 2, ',', '.');

                $dt_atualizacao = DateTime::createFromFormat('Y-m-d', $data_atualizada);
                $data_atual = new DateTime();

                if ($dt_atualizacao instanceof DateTime) {
                    $diferenca = $data_atual->diff($dt_atualizacao)->format('%a');
                    $status_cadastro = $diferenca < 730.5 ? " é importante ressaltar que o cadastro está ATUALIZADO" : " é importante ressaltar que o cadastro está DESATUALIZADO";
                } else {
                    echo "Formato de data incorreto!";
                }

                $cpf_formatado = formatarCpf($dados['num_cpf_pessoa']);
                $nis_responsavel_formatado = substr_replace(str_pad($dados["num_nis_pessoa_atual"], 11, "0", STR_PAD_LEFT), '-', 10, 0);
                $cod_familiar_formatado = substr_replace(str_pad($cod_familiar, 11, "0", STR_PAD_LEFT), '-', 9, 0);

                $perfil = $renba_media > 218 ? "Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família não se enquadra no perfil para o Programa Bolsa Família" : "Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família se enquadra no perfil para o Programa Bolsa Família";

                $sexo = $dados["cod_sexo_pessoa"] == "1" ? " o Sr. " : " a Sra. ";
                $recebendo = $renba_media > 218 && $sqli->rowCount() > 0 ? ", mas segundo o art 6° da mesma lei a família está em Regra de Proteção." : ($renba_media < 219 && $sqli->rowCount() > 0 ? " e, está com benefício " . $dadosf['sitbeneficiario'] : ".");

            } else {
                echo "Não há registros correspondentes.";
            }

        } elseif ($opcao == "nis_dec") {
            $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = :valorEscolhido");
            $sql->execute([':valorEscolhido' => $valorEscolhido]);

            $sqli = $pdo->prepare("SELECT * FROM folha_pag WHERE rf_nis = :valorEscolhido");
            $sqli->execute([':valorEscolhido' => $valorEscolhido]);

            if ($sql->rowCount() > 0) {
                $dados = $sql->fetch(PDO::FETCH_ASSOC);
                $data_atualizada = $dados['dat_atual_fam'];
                $renba_media = $dados["vlr_renda_media_fam"];

                $real_br_formatado = number_format($renba_media, 2, ',', '.');

                $dt_atualizacao = DateTime::createFromFormat('d/m/Y', $data_atualizada);
                $data_atual = new DateTime();

                if ($dt_atualizacao instanceof DateTime) {
                    $diferenca = $data_atual->diff($dt_atualizacao)->format('%a');
                    $status_cadastro = $diferenca < 730.5 ? " é importante ressaltar que o cadastro está ATUALIZADO" : " é importante ressaltar que o cadastro está DESATUALIZADO";
                } else {
                    echo "Formato de data incorreto!";
                }

                $cpf_formatado = formatarCpf($dados['num_cpf_pessoa']);
                $nis_responsavel_formatado = substr_replace(str_pad($dados["num_nis_pessoa_atual"], 11, "0", STR_PAD_LEFT), '-', 10, 0);
                $cod_familiar_formatado = substr_replace(str_pad($dados["cod_familiar_fam"], 11, "0", STR_PAD_LEFT), '-', 9, 0);

                $perfil = $renba_media > 218 ? "Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família não se enquadra no perfil para o Programa Bolsa Família" : "Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família se enquadra no perfil para o Programa Bolsa Família";

                $sexo = $dados["cod_sexo_pessoa"] == "1" ? " o Sr. " : " a Sra. ";
                $recebendo = $renba_media > 218 && $sqli->rowCount() > 0 ? ", mas segundo o art 6° da mesma lei a família está em Regra de Proteção" : ($renba_media < 219 && $sqli->rowCount() > 0 ? " e, está com benefício " . $dadosf['sitbeneficiario'] : ".");

            } else {
                echo "<script>alert('NIS não encontrado.'); window.history.back();</script>";
                die();
            }
        }
    }
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
} finally {
    $pdo = null; // Fecha a conexão
}
?>