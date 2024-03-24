<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/cadunico/controller/acesso_user/dados_usuario.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSUAS - Concessão</title>
    <link rel="stylesheet" href="../css/style_cadpess.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="/Suas-Tech/img/cadunico/logo.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/Suas-Tech/concessao/js/script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');

            if (cpf === '' || cpf.length !== 11 || /^(.)\1+$/.test(cpf)) {
                return false;
            }

            let soma = 0;
            for (let i = 0; i < 9; i++) {
                soma += parseInt(cpf.charAt(i)) * (10 - i);
            }

            let resto = 11 - (soma % 11);
            resto = (resto === 10 || resto === 11) ? 0 : resto;

            if (resto !== parseInt(cpf.charAt(9))) {
                return false;
            }

            soma = 0;
            for (let i = 0; i < 10; i++) {
                soma += parseInt(cpf.charAt(i)) * (11 - i);
            }

            resto = 11 - (soma % 11);
            resto = (resto === 10 || resto === 11) ? 0 : resto;

            return resto === parseInt(cpf.charAt(10));
        }

        function validarFormulario() {
            const cpfInput = document.getElementById('cpf');
            const cpf = cpfInput.value;

            if (!validarCPF(cpf)) {
                Swal.fire({
                    icon: 'error',
                    title: 'CPF INVÁLIDO',
                    text: 'Informe um CPF válido!',
                });
                cpfInput.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="../img/h1-cad_user.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <div class="cpf_form">
            <form id="form" method="POST" action="" onsubmit="return validarFormulario()">
                <div id="form">
                    <label>CPF: </label>
                    <input class="inpu" type="text" name="cpf" id="cpf" placeholder="Digite o CPF do RESPONSÁVEL:" maxlength="14" required>
                    <button type="submit" id="btn_salvar">SALVAR</button>
                    <a href="/Suas-Tech/controller/back.php">
                        <i class="fas fa-arrow-left"></i> Voltar ao menu
                    </a>
                </div>
            </form>
            <?php
            if (!isset($_POST['cpf'])) {
            } else {
                $cpf_dec = $_POST['cpf'];

                $data_atual = date('d/m/Y H:i');

                $cpf_limpo = preg_replace('/[^0-9]/', '', $cpf_dec);
                $cpf = ltrim($cpf_limpo, '0');

                //buscar dados do responsável na base de dados CADUNICO
                $sql_tudo_resp = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_cpf_pessoa = :cpf");
                $sql_tudo_resp->execute(array(':cpf' => $cpf));

                if ($sql_tudo_resp->rowCount() > 0) {
                    $dados_resp = $sql_tudo_resp->fetch(PDO::FETCH_ASSOC);

                    $nome_pessoa = $dados_resp['nom_pessoa'];
                    $naturalidade_pessoa = $dados_resp['nom_ibge_munic_nasc_pessoa'];
                    $nome_mae_pessoa = $dados_resp['nom_completo_mae_pessoa'];
                    $nis_pessoa = $dados_resp['num_nis_pessoa_atual'];

                    // Verifica se o nome de usuário já existe no banco de dados
                    $verifica_usuario = $conn->prepare("SELECT nis_pessoa FROM concessao_tbl WHERE nis_pessoa = ?");
                    $verifica_usuario->bind_param("s", $nis_pessoa);
                    $verifica_usuario->execute();
                    $verifica_usuario->store_result();

                    if ($verifica_usuario->num_rows > 0) {
            ?>
                        <script>
                            Swal.fire({
                                icon: 'info',
                                title: 'JÁ EXISTE',
                                text: 'Já existe um cadastro com esse CPF.',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "/Suas-Tech/concessao/index.php"
                                }
                            })
                        </script>
                    <?php
                        exit();
                    }

                    //formatando contato
                    $ddd1 = $dados_resp['num_ddd_contato_1_fam'];
                    $tel1 = $dados_resp['num_tel_contato_1_fam'];
                    $ddd2 = $dados_resp['num_ddd_contato_2_fam'];
                    $tel2 = $dados_resp['num_tel_contato_2_fam'];

                    // Obter os últimos 8 caracteres
                    $tel1 = substr($tel1, -8);

                    // Adicionar hífens na formatação
                    $tel1_formatado = implode('-', str_split($tel1, 4));

                    if ($ddd1 == 0 && $tel1 == 0 && $ddd2 == 0 && $tel2 == 0) {
                        $contato = "SEM CONTATO";
                    } elseif ($ddd1 == 0 && $ddd2 > 0 && $tel1 == 0 && $tel2 > 0) {
                        $tel2 = ltrim($tel2, '0');
                        $contato = "(" . $ddd2 . ") " . "9." . $tel2;
                    } else {
                        $tel1 = ltrim($tel1, '0');
                        $contato = "(" . $ddd1 . ") " . "9." . $tel1_formatado;
                    }

                    $tit_resp = $dados_resp['num_titulo_eleitor_pessoa'];
                    // Adicionar hífens na formatação
                    $tit_resp = substr($tit_resp, -12);
                    $tit_resp_formatado = implode('-', str_split($tit_resp, 4));

                    $rg_resp = $dados_resp['num_identidade_pessoa'];

                    //Define as variáveis com o endereço
                    $tipo_logradouro = $dados_resp["nom_tip_logradouro_fam"];
                    $nom_logradouro_fam = $dados_resp["nom_logradouro_fam"];
                    $num_logradouro_fam = $dados_resp["num_logradouro_fam"];
                    if ($num_logradouro_fam == "") {
                        $num_logradouro = "S/N";
                    } else {
                        $num_logradouro = $dados_resp["num_logradouro_fam"];
                    }
                    $nom_localidade_fam = $dados_resp["nom_localidade_fam"];
                    $nom_titulo_logradouro_fam = $dados_resp["nom_titulo_logradouro_fam"];
                    if ($nom_titulo_logradouro_fam == "") {
                        $nom_tit = "";
                    } else {
                        $nom_tit = $dados_resp["nom_titulo_logradouro_fam"];
                    }
                    $txt_referencia_local_fam = $dados_resp["txt_referencia_local_fam"];
                    if ($txt_referencia_local_fam == "") {
                        $referencia = "SEM REFERÊNCIA";
                    } else {
                        $referencia = $dados_resp["txt_referencia_local_fam"];
                    }
                    $endereco_completo = $tipo_logradouro . " " . $nom_tit . " " . $nom_logradouro_fam . ", " . $num_logradouro . " - " . $nom_localidade_fam . ", " . $referencia;

                    $renda = $dados_resp['vlr_renda_media_fam'];
                    // Formatando o número como moeda brasileira
                    $renda_formatado = number_format($renda, 2, ',', '.');

                    $smtp_conc = $conn->prepare("INSERT INTO concessao_tbl (nome, naturalidade, nome_mae, contato, cpf_pessoa, rg_pessoa, tit_eleitor_pessoa, nis_pessoa, renda_media, endereco, operador, data_cadastro) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                    $smtp_conc->bind_param("ssssssssssss", $nome_pessoa, $naturalidade_pessoa, $nome_mae_pessoa, $contato, $cpf_dec, $rg_resp_formatado, $tit_resp_formatado, $nis_pessoa, $renda_formatado, $endereco_completo, $nome, $data_atual);

                    if ($smtp_conc->execute()) { ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'SALVO',
                                text: 'Dados salvos com sucesso!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "/Suas-Tech/concessao/index.php"
                                }
                            })
                        </script>
                    <?php
                    } else {
                        echo "ERRO no envio dos DADOS: " . $smtp->error;
                    }
                    $smtp_conc->close();
                    $conn->close();
                } else {
                    ?>
        </div>
        <div class="cadastro">
            <h3>CADASTRO MANUAL</h3>
            <form method="POST" action="/Suas-Tech/concessao/controller/processo_concessao.php">
                <table border='1'>
                    <tr class="resultado">
                        <td class="resultado" colspan="2">NOME COMPLETO:</td>
                        <td class="resultado" colspan="9"><b><input class="inpu1" type="text" name="nome_pessoa" required oninput="this.value = this.value.toUpperCase()" /></b></td>
                        <td class="resultado" colspan="2">NATURALIDADE:</td>
                        <td class="resultado" colspan="3"><b><input type="text" name="naturalidade_pessoa" required oninput="this.value = this.value.toUpperCase()" /></b></td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="2">NOME DA MÃE:</td>
                        <td class="resultado" colspan="9"><b><input class="inpu1" type="text" name="nome_mae_pessoa" required oninput="this.value = this.value.toUpperCase()" /></b></td>
                        <td class="resultado" colspan="2">CONTATO:</td>
                        <td class="resultado" colspan="3"><b><input type="text" name="contato" id="telefone" maxlenght="16" required></b></td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="2">CPF: <b><?php echo $_POST['cpf']; ?></b></td>
                        <td class="resultado" colspan="9">T.E: <b><input type="text" name="te_pessoa" id="tit_ele" maxlenght="14"></b></td>
                        <td class="resultado" colspan="2">RG: <b><input type="text" name="rg_pessoa" id="rg_pessoa" maxlenght="15"></b></td>
                        <td class="resultado" colspan="3">NIS: <b><input type="text" name="nis_pessoa" id="nis_pessoa" maxlenght="12"></b></td>
                    </tr>
                    <tr class="resultado">
                        <td class="resultado" colspan="2">ENDEREÇO:</td>
                        <td class="resultado" colspan="14"><b><input type="text" name="endereco" required oninput="this.value = this.value.toUpperCase()" /></b></td>
                    </tr>
                </table>
                <div class="btn">
                    <label>Renda Media: R$</label>
                    <input type="text" name="renda_per" id="renda" required />
                    <button type="submit">SALVAR</button>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var telefoneInput = $("#telefone")
                var tituloInput = $("#tit_ele")
                var rgInput = $("#rg_pessoa")
                var nisInput = $("#nis_pessoa")
                var rendaInput = $("#renda")
                //Aplica as máscara
                telefoneInput.mask('(00) 0.0000-0000')
                tituloInput.mask('0000-0000-0000')
                nisInput.mask('0000000000-0')
                rendaInput.mask('000.000,00', {
                    reverse: true
                })
                rgInput.mask('000.000.000.000', {
                    reverse: true
                })
                $("#form").hide()
            })
        </script>


<?php
                    $_SESSION['cpf'] = $_POST['cpf'];
                }
            }
?>
    </div>
</body>

</html>