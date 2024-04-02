<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style-timbre.css">
    <title>Encaminhamento</title>
</head>
<body>
<div class="conteudo">    
        <?php

        // Inclui o arquivo "conexao.php" que deve conter a configuração da conexão com o banco de dados
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/config/conexao.php';
        include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/cadunico/controller/acesso_user/dados_usuario.php';

        $usuario = $dados['nome'];
        $cargo = $dados['cargo'];
        $idcargo = $dados['id_cargo'];

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

        //buscando dados do formulário
        if (isset($_POST['buscar_dados']) && !empty($_POST['buscar_dados'])) {

        $opcao = $_POST['buscar_dados'];
        if ($opcao == "cpf_dec") {
            //Dados do formulário
            $cpf_dec = $_POST['valorescolhido'];
            $texto = $_POST['texto'];
            $direcao = $_POST['direcao'];

            //dados da tabela com todos os cadastros

            // Consulta preparada para evitar injeção de SQL
            $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_cpf_pessoa = :cpf_dec");
            $sql->execute(array(':cpf_dec' => $cpf_dec));

            // Consulta preparada para evitar injeção de SQL
            $timestampptbr = time();
            $data_formatada_at = strftime('%d de %B de %Y', $timestampptbr);

            if ($sql->rowCount() > 0) {
                $dados = $sql->fetch(PDO::FETCH_ASSOC);
                $cod_familiar = $dados["cod_familiar_fam"];
                $nom_pessoa = $dados["nom_pessoa"];
                $nom_mae_rf = $dados["nom_completo_mae_pessoa"];
                $sexo_pessoa_ = $dados["cod_sexo_pessoa"];

                //Define as variáveis com o Female e Male
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
                //Formatando o CPF
                $cpf_table = $dados['num_cpf_pessoa'];
                $cpf_formatando = sprintf('%011s', $cpf_table);
                $cpf_formatado = substr($cpf_formatando, 0, 3) . '.' . substr($cpf_formatando, 3, 3) . '.' . substr($cpf_formatando, 6, 3) . '-' . substr($cpf_formatando, 9, 2);

                //Define as variáveis com o endereço
                $tipo_logradouro = $dados["nom_tip_logradouro_fam"];
                $nom_logradouro_fam = $dados["nom_logradouro_fam"];
                $num_logradouro_fam = $dados["num_logradouro_fam"];
                if ($num_logradouro_fam == "") {
                    $num_logradouro = "S/N";
                } else {
                    $num_logradouro = $dados["num_logradouro_fam"];
                }
                $nom_localidade_fam = $dados["nom_localidade_fam"];
                $nom_titulo_logradouro_fam = $dados["nom_titulo_logradouro_fam"];
                if ($nom_titulo_logradouro_fam == "") {
                    $nom_tit = "";
                } else {
                    $nom_tit = $dados["nom_titulo_logradouro_fam"];
                }
                $txt_referencia_local_fam = $dados["txt_referencia_local_fam"];
                if ($txt_referencia_local_fam == "") {
                    $referencia = "SEM REFERÊNCIA";
                } else {
                    $referencia = $dados["txt_referencia_local_fam"];
                }
                $endereco_conpleto = $tipo_logradouro . " " . $nom_tit . " " . $nom_logradouro_fam . ", " . $num_logradouro . " - " . $nom_localidade_fam . ", " . $referencia;

                $conteudo = "<div id='title'style='margin-top: 100px;'>" . $setor . " - SÃO BENTO DO UNA</div>";
                $conteudo .= "<br><br><p class='right-align'>São Bento do Una, " . $data_formatada_at . "</p>";
                $conteudo .= "<br><br><p>Assunto: Encaminho" . $sexo . $nom_pessoa . ", CPF: " . $cpf_formatado . $sexoo . $nom_mae_rf . ", reside em " . $endereco_conpleto . ".</p>";
                $conteudo .= "<p>Ao(a) Coordenador(a) do " . $direcao . ",</p>";
                $conteudo .= "<p>" . $texto . "</p>";
                $conteudo .= "<p>Permaneço à disposição para quaisquer esclarecimentos adicionais que se façam necessários.</p>";
                $conteudo .= "<p>Atenciosamente,</p>";
                $conteudo .= "<div class='signature-line'>";
                $conteudo .= $usuario . "<br>";
                $conteudo .= $cargo . "<br>";
                $conteudo .= $idcargo . "<br><br><br>";
                $conteudo .= "<p>_________________________________________________________________________________________________________</p>";
                $conteudo .= "<p>ASSINATURA</p>";
                $conteudo .= "</div>";
                header("Location: print_enc.php?conteudo=" . urlencode($conteudo));
            }
        } elseif ($opcao == "nis_dec") {
            $nis_dec = $_POST['valorescolhido'];
            $texto = $_POST['texto'];
            $direcao = $_POST['direcao'];

            //dados da tabela com todos os cadastros

            // Consulta preparada para evitar injeção de SQL
            $sql = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = :nis_dec");
            $sql->execute(array(':nis_dec' => $nis_dec));

            // Consulta preparada para evitar injeção de SQL
            $timestampptbr = time();
            $data_formatada_at = strftime('%d de %B de %Y', $timestampptbr);

            if ($sql->rowCount() > 0) {
                $dados = $sql->fetch(PDO::FETCH_ASSOC);
                $cod_familiar = $dados["cod_familiar_fam"];
                $nom_pessoa = $dados["nom_pessoa"];
                $nom_mae_rf = $dados["nom_completo_mae_pessoa"];
                $sexo_pessoa_ = $dados["cod_sexo_pessoa"];

                //Define as variáveis com o Female e Male
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

                //Define as variáveis com o endereço
                $tipo_logradouro = $dados["nom_tip_logradouro_fam"];
                $nom_logradouro_fam = $dados["nom_logradouro_fam"];
                $num_logradouro_fam = $dados["num_logradouro_fam"];
                if ($num_logradouro_fam == "") {
                    $num_logradouro = "S/N";
                } else {
                    $num_logradouro = $dados["num_logradouro_fam"];
                }
                $nom_localidade_fam = $dados["nom_localidade_fam"];
                $nom_titulo_logradouro_fam = $dados["nom_titulo_logradouro_fam"];
                if ($nom_titulo_logradouro_fam == "") {
                    $nom_tit = "";
                } else {
                    $nom_tit = $dados["nom_titulo_logradouro_fam"];
                }
                $txt_referencia_local_fam = $dados["txt_referencia_local_fam"];
                if ($txt_referencia_local_fam == "") {
                    $referencia = "SEM REFERÊNCIA";
                } else {
                    $referencia = $dados["txt_referencia_local_fam"];
                }
                $endereco_conpleto = $tipo_logradouro . " " . $nom_tit . " " . $nom_logradouro_fam . ", " . $num_logradouro . " - " . $nom_localidade_fam . ", " . $referencia;

                $conteudo = "<h1>CADASTRO ÚNICO - SÃO BENTO DO UNA</h1>";
                $conteudo .= "<br><br><p class='right-align'>São Bento do Una, " . $data_formatada_at . "</p>";
                $conteudo .= "<br><br><p>Assunto: Encaminho" . $sexo . $nom_pessoa . ", CPF: " . $cpf_formatado . $sexoo . $nom_mae_rf . ", reside em " . $endereco_conpleto . ".</p>";
                $conteudo .= "<p>Ao(a) Coordenador(a) do " . $direcao . ",</p>";
                $conteudo .= "<p>" . $texto . "</p>";
                $conteudo .= "<p>Permaneço à disposição para quaisquer esclarecimentos adicionais que se façam necessários.</p>";
                $conteudo .= "<p>Atenciosamente,</p>";
                $conteudo .= "<div class='signature-line'>";
                $conteudo .= $usuario . "<br>";
                $conteudo .= $cargo . "<br>";
                $conteudo .= $idcargo . "<br><br><br>";
                $conteudo .= "<p>_________________________________________________________________________________________________________</p>";
                $conteudo .= "<p>ASSINATURA</p>";
                $conteudo .= "</div>";
                header("Location: print_enc.php?conteudo=" . urlencode($conteudo));
            }
        } else {
            echo "Nâo encontrado.";
        }
        }
        ?>
</div>
</body>
</html>