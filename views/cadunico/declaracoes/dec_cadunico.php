<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

//REQUISIÇÃO PARA DADOS DOS USUÁRIOS CREDENCIADOS COM ACESSO ADMINISTRATIVO
    $sql_user = "SELECT * FROM usuarios WHERE cargo = 'COORDENAÇÃO' AND setor = 'CADASTRO UNICO - SECRETARIA DE ASSISTENCIA SOCIAL'";
    $sql_user_query = $conn->query($sql_user) or die("ERRO ao consultar! " . $conn - error);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css" href=/TechSUAS/css/cadunico/declaracoes/style-dec-pref.css>
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Declaração CadÚnico</title>

</head>
<body>
    <div class="tudo">
        <h1>DECLARAÇÃO DO CADASTRO ÚNICO PARA PROGRAMAS DO GOVERNO FEDERAL</h1>
        <div class="conteudo">
    <?php
        if (isset($_POST['cpf_dec_cad'])) {
            
            $cpf_limpo = preg_replace('/\D/', '', $_POST['cpf_dec_cad']);
            $cpf_already = ltrim($cpf_limpo, '0');
            // SOLICITAÇÃO DA TABELA TBL_TUDO PARA PEGAR OS DADOS DO INDIVIDUO
            $sql_dec = "SELECT * FROM tbl_tudo WHERE num_cpf_pessoa LIKE '%$cpf_already'" ;
            $sql_query_dec = $conn->query($sql_dec) or die("ERRO ao consultar! " . $conn - error);

            $sql_dec_fl = "SELECT * FROM folha_pag WHERE rf_cpf LIKE '%$cpf_already'" ;
            $sql_query_dec_fl = $conn->query($sql_dec_fl) or die("ERRO ao consultar! " . $conn - error);

                if ($sql_query_dec->num_rows > 0) {
                    $dados_tbl = $sql_query_dec->fetch_assoc();
                    $sexo_pessoa_ = $dados_tbl["cod_sexo_pessoa"];
                    $dt_atualizacao_str = $dados_tbl['dat_atual_fam'];
                    $data_atual_str = date('Y-m-d');

                    $dt_atualizacao = DateTime::createFromFormat('Y-m-d', $dt_atualizacao_str);
                    $data_atual_ = DateTime::createFromFormat('Y-m-d', $data_atual_str);
    ?>
                    <p style="text-indent: 1.25cm;">Para os devidos fins, confirmo que  
    <?php
                echo $sexo_pessoa_ == "1" ? " o Sr. " : " a Sra. ";
                echo '<strong>'. $dados_tbl['nom_pessoa']. '</strong>';?>, CPF: <strong><?php echo $_POST['cpf_dec_cad'];
    ?>
    </strong>, 
    <?php
                echo $sexo_pessoa_ == "1" ? " filho de " : " filha de ";
                echo '<strong>'. $dados_tbl['nom_completo_mae_pessoa'];
    ?>
    </strong>, 
    <?php
                echo $sexo_pessoa_ == "1" ? " inscrito " : " inscrita ";
    ?> no Cadastro Único para Programas do Governo Federal. 
    <?php
        if ($dt_atualizacao instanceof DateTime && $data_atual_ instanceof DateTime) {
            // Calcula a diferença em dias entre a data de atualização e a data atual
            $diferenca = $data_atual_->diff($dt_atualizacao)->days;

                echo $diferenca < 730.5 ? " É importante ressaltar que o cadastro está <strong>ATUALIZADO</strong>," : " É importante ressaltar que o cadastro está <strong>DESATUALIZADO</strong>,";

            } else {
            // Lida com o erro de formato de data
            echo "Formato de data incorreto!";
        }
    ?> 
    com uma renda per capita de <strong>R$ 
    <?php
                echo $dados_tbl['vlr_renda_media_fam'];
    ?>,00</strong>. 
    <?php
                echo $dados_tbl['vlr_renda_media_fam'] > 218 ? " Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família não se enquadra no perfil para o Programa Bolsa Família." : " Conforme o artigo 5° da lei 14.601 de 19 de junho de 2023, a família se enquadra no perfil para o Programa Bolsa Família.";
    ?>
    </p>
    <p>
    <?php

                if ($sql_query_dec_fl->num_rows == 0) {

                } else {
                    $dados_fl = $sql_query_dec_fl->fetch_assoc();
                    if ($dados_tbl['vlr_renda_media_fam'] >= 218 && $dados_tbl['vlr_renda_media_fam'] <= 706) {
                        echo "Apesar da renda familiar não ter perfil por ter uma renda acima de R$ 218,00 como determina o Art. 5º da Lei 14.601, de 19 de junho de 2023, a família recebe o Bolsa Família em regra de Proteção estabelecido na mesma lei, Art. 6º.";
                    } else {
                        $referencia = $dados_fl['ref_folha'];
                        $ref_folha = substr($referencia, -2);
                        echo "A família está com o Benefício " . $dados_fl['sitbeneficiario'] . ' no mês de ';
                        $ref_folha_map = [
                            '01' => 'janeiro',
                            '02' => 'fevereiro',
                            '03' => 'março',
                            '04' => 'abril',
                            '05' => 'maio',
                            '06' => 'junho',
                            '07' => 'julho',
                            '08' => 'agosto',
                            '09' => 'setembro',
                            '10' => 'outubro',
                            '11' => 'novembro',
                            '12' => 'dezembro',
                        ];
                        echo $ref_folha_map[$ref_folha];
                    }
                }
    ?>
    </p>
    <?php

    if ($sql_user_query->num_rows == 0) {
        die();
    } else {
        $dados_user = $sql_user_query->fetch_assoc();
    ?>
    </div>
    <div class="cidade_data">
        <?php echo $cidade; ?><?php echo $data_formatada; ?>.
    </div>
    <div class="assinatura">
        <p class="signature-line"></p>
        <p><?php echo $dados_user['nome']; ?><br>
        <?php echo $dados_user['id_cargo']; ?></p>
    </div>
    <div class="conteudo">
    <?php
    }

        } else {
            ?>
            <script>
                Swal.fire({
                    icon: "info",
                    title: "CPF NÃO ENCONTRADO",
                    text: "Esse CPF: <?php echo $_POST['cpf_dec_cad']; ?> não foi localizado na base de dados.",
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
        html:`
        <h4>FORMULÁRIO</h4>
        <h6>É importante conferir as informações no CadÚnico e SIBEC para certificar-se da situação recente da família.</h6>
        <label>CPF:
            <input type="text" id="cpf" name="cpf" value="<?php echo $_POST['cpf_dec_cad']; ?>" required/>
        </label>
        <br>
        <label>NOME:
            <input type="text" id="nome_pessoa" name="nome_pessoa" required/>
        </label>
        <br>
        <label>DATA DE NASCIMENTO:
            <input type="date" id="dta_nascimento" name="dta_nascimento" required/>
        </label>
        <br>
        <label><input type="radio" id="gender_male" name="gender" value="male" required>
        <span class="circle" style="background-color: dodgerblue;"></span> Homem</label>
        <br>
        <label><input type="radio" id="gender_female" name="gender" value="female">
        <span class="circle" style="background-color: hotpink;"></span> Mulher</label>
        `,
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        preConfirm: () => {
            // Obter valores dos campos
            const nomePessoa = document.getElementById('nome_pessoa').value
            const cpf = document.getElementById('cpf').value
            const dataNascimento = document.getElementById('dta_nascimento').value
            const genderMale = document.getElementById('gender_male').checked
            const genderFemale = document.getElementById('gender_female').checked

            // Verificar se todos os campos são válidos
            if (!nomePessoa || !cpf || !dataNascimento || (!genderMale && !genderFemale)) {
                Swal.showValidationMessage('Todos os campos são obrigatórios.')
                return false; // Evita que o modal seja fechado
            }

            return {
                nomePessoa: nomePessoa,
                cpf: cpf,
                dataNascimento: dataNascimento,
                gender: genderMale ? 'male' : 'female'
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { nomePessoa, cpf, dataNascimento, gender } = result.value

            $('#nome_1').text(nomePessoa)
            $('#cpf_1').text(cpf)
            $('#dataNascimento').text(dataNascimento)

            // Determinar os textos com base no gênero
            let sDDr, sDnC, sDEv;
            if (gender === "male") {
                sDDr = " o Sr. ";
                sDnC = " nascido ";
                sDEv = " inscrito ";
            } else {
                sDDr = " a Sra. ";
                sDnC = " nascida ";
                sDEv = " inscrita ";
            }
            
            $('#sDDr').text(sDDr);
            $('#sDnC').text(sDnC);
            $('#sDEv').text(sDEv);
            var formattedDate = formatDate(dataNascimento);
            $('#dataNascimento').text(formattedDate);
        }
        function formatDate(dateStr) {
            var [year, month, day] = dateStr.split('-');
            return `${day}/${month}/${year}`;
        }

        

        // Apresentar a data formatada no HTML usando jQuery

    })
    }
                })

    <?php
    $dados_user = $sql_user_query->fetch_assoc();
    ?>
            </script>
            <p class="cont">Para os devidos fins, confirmo que <span id="sDDr"><!--O SR OU A SRA--></span> <strong><span class="maiusculo" id="nome_1"><!--NOME DO INDIVIDUO--></span></strong>, CPF: <strong><span id="cpf_1"><!--CPF DO INDIVIDUO--></span></strong>, <span id="sDnC" ><!--NASCIDO OU NASCIDA--></span>no dia <strong><span id="dataNascimento"><!--DATA DE NASCIMENTO DO INDIVIDUO--></span></strong>, não é <span id="sDEv"><!--INSCRITO OU INSCRITA--></span> no Cadastro Único para Programas do Governo Federal.</p>
    </div>
    <div class="cidade_data">
        <?php echo $cidade; ?><?php echo $data_formatada; ?>.
    </div>
            <div class="assinatura">
                <p class="signature-line"></p>
                <p><?php echo $dados_user['nome']; ?><br>
                <?php echo $dados_user['id_cargo']; ?></p>
            </div>
    <?php
        }

    } else {

    }
    ?>

        <div class="no-print">
            <button onclick="printWithSignature()">Imprimir com Assinatura Eletrônica</button>
            <button onclick="printWithFields()">Imprimir com Campos de Assinatura</button>
            
            <button onclick="voltar()"><i class="fas fa-arrow-left"></i>Voltar</button>
        </div>
    </div>

</div>
</body>
</html>