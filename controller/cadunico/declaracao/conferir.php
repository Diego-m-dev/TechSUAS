<?php
//inicia a sessão

// Inclui o arquivo "conexao.php" que deve conter a configuração da conexão com o banco de dados
require_once '../../../config/conexao.php';
ini_set('memory_limit', '256M');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

//buscando dados do formulário
if (isset($_POST['buscar_dados']) && !empty($_POST['buscar_dados'])) {
    $opcao = $_POST['buscar_dados'];
    if ($opcao == "cpf_dec") {
        $cpf_dec = $_POST['valorescolhido'];
        //dados da tabela com todos os cadastros
        // Consulta preparada para evitar injeção de SQL
        $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_cpf_pessoa = :cpf_dec");
        $sql->execute(array(':cpf_dec' => $cpf_dec));
        // Consulta preparada para evitar injeção de SQL
        $sqli = $pdo->prepare("SELECT * FROM folha_pag WHERE rf_cpf = :cpf_dec");
        $sqli->execute(array(':cpf_dec' => $cpf_dec));

        if ($sql->rowCount() > 0) {

            $dados = $sql->fetch(PDO::FETCH_ASSOC);
            //$dt_atualizacao = $dados['dat_atual_fam'];
            $cod_familiar = $dados["cod_familiar_fam"];
            $nom_pessoa = $dados["nom_pessoa"];
            $nom_mae_rf = $dados["nom_completo_mae_pessoa"];
            $sexo_pessoa_ = $dados["cod_sexo_pessoa"];
            $data_atualizada = $dados['dat_atual_fam'];
            $renba_media = $dados["vlr_renda_media_fam"];

            // Formata o número como moeda brasileira
            $real_br_formatado = number_format($renba_media, 2, ',', '.');

            // Supondo que $dt_atualizacao é uma data válida
            $dt_atualizacao = DateTime::createFromFormat('Y-m-d', $data_atualizada);
            $data_atual = new DateTime(); // Obtém a data atual

            // Verificar se $dt_atualizacao é uma instância de DateTime
            if ($dt_atualizacao instanceof DateTime) {

                // Calcula a diferença em dias entre a data de atualização e a data atual
                $diferenca = $data_atual->diff($dt_atualizacao)->format('%a');

                if ($diferenca < 730.5) {
                    $status_cadastro = " é importante ressaltar que o cadastro está ATUALIZADO";
                } else {
                    $status_cadastro = " é importante ressaltar que o cadastro está DESATUALIZADO";
                }

            } else {
                // Lida com o erro de formato de data
                echo "Formato de data incorreto!";
            }
            //Formatando o CPF
            $cpf_table = $dados['num_cpf_pessoa'];
            $cpf_formatando = sprintf('%011s', $cpf_table);
            $cpf_formatado = substr($cpf_formatando, 0, 3) . '.' . substr($cpf_formatando, 3, 3) . '.' . substr($cpf_formatando, 6, 3) . '-' . substr($cpf_formatando, 9, 2);
            //Formatando o nis
            $nis_responsavel = $dados["num_nis_pessoa_atual"];
            $nis_responsavel_formatado = substr_replace(str_pad($nis_responsavel, 11, "0", STR_PAD_LEFT), '-', 10, 0);
            //Formatando o código familiar
            $cod_familiar_formatado = substr_replace(str_pad($cod_familiar, 11, "0", STR_PAD_LEFT), '-', 9, 0);

            if ($renba_media > 218) {
                $perfil = " Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família não se enquadra no perfil para o Programa Bolsa Família";
            } else {
                $perfil = " Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família se enquadra no perfil para o Programa Bolsa Família";
            }
            if ($sexo_pessoa_ == "1") {
                $sexo = " o Sr. ";
            } else {
                $sexo = " a Sra. ";
            }
            if ($sexo_pessoa_ == "1") {
                $sexoo = " filho de ";
            } else {
                $sexoo = " filha de ";
            }
            if ($sexo_pessoa_ == "1") {
                $sexooo = " inscrito ";
            } else {
                $sexooo = " inscrita ";
            }
            if ($renba_media > 218 && $sqli->rowCount() > 0) {
                $recebendo = ", mas segundo o art 6° da mesma lei a família está em Regra de Proteção.";
            } elseif ($renba_media < 219 && $sqli->rowCount() > 0) {
                $dadosf = $sqli->fetch(PDO::FETCH_ASSOC);
                $situacao = $dadosf['sitbeneficiario'];
                $recebendo = " e, está com benefício " . $situacao;
            } else {
                $recebendo = ".";
            }
        } elseif ($sql->rowCount() == 0) {
            $semcadastro = "Não há registros correspondentes em nosso Banco de Dados. Verifique no Cadastro Único para garantir que a pessoa em questão não tenha cadastrado. Caso confirmado, forneça manualmente as informações abaixo.";
        }
        if ($sqli->rowCount() > 0) {

            $dadosf = $sqli->fetch(PDO::FETCH_ASSOC);

            $benef1 = $dadosf['pacto'];
        }
    } elseif ($opcao == "nis_dec") {
        $nis_dec = $_POST['valorescolhido'];

        //dados da tabela com todos os cadastros
        $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = :nis_dec");
        $sql->execute(array(':nis_dec' => $nis_dec));
        //dados da tabela folha de pagamento
        $sqli = $pdo->prepare("SELECT * FROM folha_pag WHERE rf_nis = :nis_dec");
        $sqli->execute(array(':nis_dec' => $nis_dec));

        if ($sql->rowCount() > 0) {

            $dados = $sql->fetch(PDO::FETCH_ASSOC);
            $dt_atualizacao = $dados['dat_atual_fam'];
            $cod_familiar = $dados["cod_familiar_fam"];
            $nom_pessoa = $dados["nom_pessoa"];
            $nom_mae_rf = $dados["nom_completo_mae_pessoa"];
            $sexo_pessoa_ = $dados["cod_sexo_pessoa"];
            $data_atualizada = $dados['dat_atual_fam'];
            $renba_media = $dados["vlr_renda_media_fam"];

            // Formata o número como moeda brasileira
            $real_br_formatado = number_format($renba_media, 2, ',', '.');

            // Supondo que $dt_atualizacao é uma data válida
            $dt_atualizacao = DateTime::createFromFormat('d/m/Y', $dt_atualizacao);
            $data_atual = new DateTime(); // Obtém a data atual

            // Verificar se $dt_atualizacao é uma instância de DateTime
            if ($dt_atualizacao instanceof DateTime) {
                // Calcula a diferença em dias entre a data de atualização e a data atual
                $diferenca = $data_atual->diff($dt_atualizacao)->format('%a');

                if ($diferenca < 730.5) {
                    $status_cadastro = " é importante ressaltar que o cadastro está ATUALIZADO";
                } else {
                    $status_cadastro = " é importante ressaltar que o cadastro está DESATUALIZADO";
                }

            } else {
                // Lida com o erro de formato de data
                echo "Formato de data incorreto!";
            }
            //Formatando o CPF
            $cpf_table = $dados['num_cpf_pessoa'];
            $cpf_formatando = sprintf('%011s', $cpf_table);
            $cpf_formatado = substr($cpf_formatando, 0, 3) . '.' . substr($cpf_formatando, 3, 3) . '.' . substr($cpf_formatando, 6, 3) . '-' . substr($cpf_formatando, 9, 2);
            //Formatando o nis
            $nis_responsavel = $dados["num_nis_pessoa_atual"];
            $nis_responsavel_formatado = substr_replace(str_pad($nis_responsavel, 11, "0", STR_PAD_LEFT), '-', 10, 0);
            //Formatando o código familiar
            $cod_familiar_formatado = substr_replace(str_pad($cod_familiar, 11, "0", STR_PAD_LEFT), '-', 9, 0);

            if ($renba_media > 218) {
                $perfil = " Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família não se enquadra no perfil para o Programa Bolsa Família";
            } else {
                $perfil = " Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família se enquadra no perfil para o Programa Bolsa Família";
            }
            if ($sexo_pessoa_ == "1") {
                $sexo = " o Sr. ";
            } else {
                $sexo = " a Sra. ";
            }
            if ($sexo_pessoa_ == "1") {
                $sexoo = " filho de ";
            } else {
                $sexoo = " filha de ";
            }
            if ($sexo_pessoa_ == "1") {
                $sexooo = " inscrito ";
            } else {
                $sexooo = " inscrita ";
            }
            if ($renba_media > 218 && $sqli->rowCount() > 0) {
                $recebendo = ", mas segundo o art 6° da mesma lei a família está em Regra de Proteção";
            } elseif ($renba_media < 219 && $sqli->rowCount() > 0) {
                $dadosf = $sqli->fetch(PDO::FETCH_ASSOC);
                $situacao = $dadosf['sitbeneficiario'];
                $recebendo = " e, está com benefício " . $situacao;
            } else {
                $recebendo = ".";
            }

        } else {
            echo "<script>
            alert('NIS não encontrado.');
            setTimeout(function() {
                window.history.back(); // Volta para a página anterior
            }, 500);
            </script>";
            die();
        }

        if ($sqli->rowCount() > 0) {

            $dadosf = $sqli->fetch(PDO::FETCH_ASSOC);

            $benef1 = $dadosf['pacto'];
        }
    }
}
