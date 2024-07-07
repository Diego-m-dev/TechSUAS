<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/declaracoes/style-dec-pref.css">
    <title>Documento oficial do Cadastro Único - São Bento do Una</title>
</head>

<body>
    <div class="tudo">
        <div class="container">
            <div id="title">DECLARAÇÃO DO CADASTRO UNICO PARA PROGRAMAS DO GOVERNO FEDERAL</div>

            <?php

            ini_set('memory_limit', '256M');

            setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

            include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/controller/cadunico/declaracao/create_moth.php';
            //data criada com formato 'DD de mmmm de YYYY'
            $data_formatada_at = $dia_atual . " de " . $mes_formatado . " de ". $ano_atual;
            //receber os dados do formulário
            $dados_post = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if (isset($_POST['btn-ip1'])) {

                if (isset($_SESSION['dados_conferidos'])) {

                    $dados_conferidos = $_SESSION['dados_conferidos'];
                    $cpf_formatado = $dados_conferidos['cpf_formatado'];
                    $nis_responsavel_formatado = $dados_conferidos['nis_responsavel_formatado'];
                    $cod_familiar_formatado = $dados_conferidos['cod_familiar_formatado'];
                    $nom_pessoa = $dados_conferidos['nom_pessoa'];
                    $sexo = $dados_conferidos['sexo'];
                    $nom_pessoa = $dados_conferidos['nom_pessoa'];
                    $sexoo = $dados_conferidos['sexoo'];
                    $nom_mae_rf = $dados_conferidos['nom_mae_rf'];
                    $status_cadastro = $dados_conferidos['status_cadastro'];
                    $real_br_formatado = $dados_conferidos['real_br_formatado'];
                    $sexooo = $dados_conferidos['sexooo'];
                    $perfil = $dados_conferidos['perfil'];
                    $recebendo = $dados_conferidos['recebendo'];

            ?>
                    <div id="form">

                        <div id="justified-text" class="conteudo">
                            <p>Para os devidos fins, confirmo que <?php echo $sexo; ?> <?php echo $nom_pessoa; ?>, CPF:
                                <?php echo $cpf_formatado; ?>, <?php echo $sexoo; ?> <?php echo $nom_mae_rf; ?>, está
                                <?php echo $sexooo; ?> no Cadastro Único para Programas do Governo Federal.
                                <?php echo $status_cadastro; ?>, com uma renda per capita de R$
                                <?php echo $real_br_formatado; ?>. <?php echo $perfil; ?> <?php echo $recebendo; ?>.</p>
                        </div>
                        <div id="right-align">São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</div>

                        <div class="signature-line">___________________________________________________________<br>DIEGO EMMANUEL
                            CADETE<br><span id="cord">Coord. Cadastro Único e Prog. Bolsa Família</span><br><span id="mat">Mat.: 108026</span></div><br>

                    </div>
                <?php
                } else {
                    echo "ERRO no armazenamento dos dados.";
                }

                ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "/TechSUAS/views/cadunico/declaracoes/declaracao";
                    }, 500);
                </script>
                <script>
                    window.onload = function() {
                        window.print();
                    };
                </script>
                <?php
            } elseif (isset($_POST['btn-ip2'])) {

                if (isset($_SESSION['dados_conferidos'])) {

                    $dados_conferidos = $_SESSION['dados_conferidos'];
                    $cpf_formatado = $dados_conferidos['cpf_formatado'];
                    $nis_responsavel_formatado = $dados_conferidos['nis_responsavel_formatado'];
                    $cod_familiar_formatado = $dados_conferidos['cod_familiar_formatado'];
                    $nom_pessoa = $dados_conferidos['nom_pessoa'];
                    $sexo = $dados_conferidos['sexo'];
                    $nom_pessoa = $dados_conferidos['nom_pessoa'];
                    $sexoo = $dados_conferidos['sexoo'];
                    $nom_mae_rf = $dados_conferidos['nom_mae_rf'];
                    $status_cadastro = $dados_conferidos['status_cadastro'];
                    $real_br_formatado = $dados_conferidos['real_br_formatado'];
                    $sexooo = $dados_conferidos['sexooo'];
                    $perfil = $dados_conferidos['perfil'];

                ?>
                    <div id="form">

                        <div id="justified-text">
                            <p>Para os devidos fins, confirmo que <?php echo $sexo; ?> <?php echo $nom_pessoa; ?>, CPF:
                                <?php echo $cpf_formatado; ?>, <?php echo $sexoo; ?> <?php echo $nom_mae_rf; ?>, está
                                <?php echo $sexooo; ?> no Cadastro Único para Programas do Governo Federal.
                                <?php echo $status_cadastro; ?>, com uma renda per capita de R$
                                <?php echo $real_br_formatado; ?>. <?php echo $perfil; ?>.</p>
                        </div>
                        <div id="right-align">São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</div>

                        <div class="signature-line">___________________________________________________________<br>DIEGO EMMANUEL
                              CADETE<br><span id="cord">Coord. Cadastro Único e Prog. Bolsa Família</span><br><span id="mat">Mat.: 108026</span></div><br>
                    </div>
                <?php
                } else {
                    echo "ERRO no armazenamento dos dados.";
                }

                ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "/TechSUAS/views/cadunico/declaracoes/declaracao";
                    }, 500);
                </script>
                <script>
                    window.onload = function() {
                        window.print();
                    };
                </script>
                <?php
            } elseif (isset($_POST['btn-ip3'])) {
                session_start();

                if (isset($_SESSION['dados_conferidos'])) {

                    $dados_conferidos = $_SESSION['dados_conferidos'];
                    $cpf_formatado = $dados_conferidos['cpf_formatado'];
                    $nis_responsavel_formatado = $dados_conferidos['nis_responsavel_formatado'];
                    $cod_familiar_formatado = $dados_conferidos['cod_familiar_formatado'];
                    $nom_pessoa = $dados_conferidos['nom_pessoa'];
                    $sexo = $dados_conferidos['sexo'];
                    $nom_pessoa = $dados_conferidos['nom_pessoa'];
                    $sexoo = $dados_conferidos['sexoo'];
                    $nom_mae_rf = $dados_conferidos['nom_mae_rf'];
                    $status_cadastro = $dados_conferidos['status_cadastro'];
                    $real_br_formatado = $dados_conferidos['real_br_formatado'];
                    $sexooo = $dados_conferidos['sexooo'];
                    $perfil = $dados_conferidos['perfil'];

                ?>
                    <div id="form">

                        <div id="justified-text">
                            <p>Para os devidos fins, confirmo que <?php echo $sexo; ?> <?php echo $nom_pessoa; ?>, CPF:
                                <?php echo $cpf_formatado; ?>, <?php echo $sexoo; ?> <?php echo $nom_mae_rf; ?>, está
                                <?php echo $sexooo; ?> no Cadastro Único para Programas do Governo Federal.
                                <?php echo $status_cadastro; ?>, com uma renda per capita de R$
                                <?php echo $real_br_formatado; ?>. <?php echo $perfil; ?>.</p>
                        </div>
                        <div id="right-align">São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</div>

                        <div class="signature-line">___________________________________________________________<br>DIEGO EMMANUEL
                            CADETE<br><span id="cord">Coord. Cadastro Único e Prog. Bolsa Família</span><br><span id="mat">Mat.: 108026</span></div><br>

                    </div>
                <?php
                } else {
                    echo "ERRO no armazenamento dos dados.";
                }

                ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "/TechSUAS/views/cadunico/declaracoes/declaracao";
                    }, 5000);
                </script>
                <script>
                    window.onload = function() {
                        window.print();
                    };
                </script>
                <?php
            } elseif (isset($_POST['btn-ip4'])) {
                session_start();

                if (isset($_SESSION['dados_conferidos'])) {

                    $dados_conferidos = $_SESSION['dados_conferidos'];
                    $cpf_formatado = $dados_conferidos['cpf_formatado'];
                    $nis_responsavel_formatado = $dados_conferidos['nis_responsavel_formatado'];
                    $cod_familiar_formatado = $dados_conferidos['cod_familiar_formatado'];
                    $nom_pessoa = $dados_conferidos['nom_pessoa'];
                    $sexo = $dados_conferidos['sexo'];
                    $nom_pessoa = $dados_conferidos['nom_pessoa'];
                    $sexoo = $dados_conferidos['sexoo'];
                    $nom_mae_rf = $dados_conferidos['nom_mae_rf'];
                    $status_cadastro = $dados_conferidos['status_cadastro'];
                    $real_br_formatado = $dados_conferidos['real_br_formatado'];
                    $sexooo = $dados_conferidos['sexooo'];
                    $perfil = $dados_conferidos['perfil'];

                ?>
                    <div id="form">

                        <div id="justified-text">
                            <p>Para os devidos fins, confirmo que <?php echo $sexo; ?> <?php echo $nom_pessoa; ?>, CPF:
                                <?php echo $cpf_formatado; ?>, <?php echo $sexoo; ?> <?php echo $nom_mae_rf; ?>, está
                                <?php echo $sexooo; ?> no Cadastro Único para Programas do Governo Federal.
                                <?php echo $status_cadastro; ?>, com uma renda per capita de R$
                                <?php echo $real_br_formatado; ?>. <?php echo $perfil; ?>.</p>
                        </div>
                        <div id="right-align">São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</div>

                        <div class="signature-line">___________________________________________________________DIEGO EMMANUEL
                            CADETE<br><span id="cord">Coord. Cadastro Único e Prog. Bolsa Família</span><br><span id="mat">Mat.: 108026</span></div><br>
                        </div>

                    </div>
                <?php

                } else {
                    echo "ERRO no armazenamento dos dados.";
                }

                ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "/TechSUAS/views/cadunico/declaracoes/declaracao";
                    }, 5000);
                </script>
                <script>
                    window.onload = function() {
                        window.print();
                    };
                </script>
            <?php
            } elseif (isset($_POST['btn-ip5'])) {
            ?>
                <div id="form">
                    <?php
                    $nome_dec = $_POST['nome_dec'];
                    $gender = $_POST['gender'];
                    $nome_mae_dec = $_POST['nome_mae_dec'];

                    if (isset($_SESSION['dados_conferidos_s'])) {

                        $dados_conferidos = $_SESSION['dados_conferidos_s'];
                        $cpf_dec = $dados_conferidos['cpf_dec'];
                        if ($gender == "male") {
                            $sexo = "o Sr.";
                        } else {
                            $sexo = "a Sra.";
                        }
                        if ($gender == "male") {
                            $sexoo = "filho";
                        } else {
                            $sexoo = "filha";
                        }
                        if ($gender == "male") {
                            $sexooo = "inscrito";
                        } else {
                            $sexooo = "inscrita";
                        }
                        $cpf_formatando = sprintf('%011s', $cpf_dec);
                        $cpf_formatado = substr($cpf_formatando, 0, 3) . '.' . substr($cpf_formatando, 3, 3) . '.' . substr($cpf_formatando, 6, 3) . '-' . substr($cpf_formatando, 9, 2);

                    ?>


                        <div id="justified-text">
                            <p>Para os devidos fins, confirmo que <?php echo $sexo; ?> <?php echo $nome_dec; ?>, CPF:
                                <?php echo $cpf_formatado; ?>, <?php echo $sexoo; ?> de <?php echo $nome_mae_dec; ?>, não está
                                <?php echo $sexooo; ?> no Cadastro Único para Programas do Governo Federal.</p>
                        </div>
                        <div id="right-align">São Bento do Una - PE, <?php echo $data_formatada_at; ?>.</div>

                        <div class="signature-line">___________________________________________________________<br>DIEGO EMMANUEL
                            CADETE<br><span id="cord">Coord. Cadastro Único e Prog. Bolsa Família</span><br><span id="mat">Mat.: 108026</span></div><br>

                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = "/TechSUAS/views/cadunico/declaracoes/declaracao";
                    }, 500);
                </script>
                <script>
                    window.onload = function() {
                        window.print();
                    };
                </script>
                <script>
                    window.onload = function() {
                        window.print();
                    };
                </script>
        <?php
                    } else {
                        echo "ERRO no armazenamento dos dados.";
                    }
                }
        ?>

        </div>
    </div>
    </div>
</body>

</html>