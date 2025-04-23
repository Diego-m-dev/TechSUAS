<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/style_peixe.css">
    <script src="../js/peixe.js"></script>
    <script src="/TechSUAS/js/cpfvalid.js"></script>
    <title>TechSUAS - Cadastro Peixe</title>

    <style>
        .animated {
            animation: example 2s infinite;
            width: 70%;
        }
    </style>

</head>

<body>

<?php
        if ($_SESSION['lc_cad'] === "X" && $_SESSION['funcao'] === '3') {
            ?>
            <script>
                Swal.fire({
                    icon: 'warning',
                    html: `
                    <p>Prezad@, <?php echo $_SESSION['nome_usuario']; ?>!</p>
                    <p> Estamos felizes por se juntar a nós nessa jornada!</p>
                    <p> O <strong>Programa de Distribuição de Peixe na Semana Santa</strong> é uma iniciativa voltada para garantir a segurança alimentar das famílias em situação de vulnerabilidade social, proporcionando um alimento tradicional nesse período especial. </p>
                    <p>Através do nosso sistema de cadastro, identificamos e organizamos a distribuição de forma eficiente, transparente e justa, garantindo que o benefício chegue a quem realmente precisa.</p>
                    <p> Com essa iniciativa, buscamos fortalecer o compromisso social do município e proporcionar uma Semana Santa mais digna e acolhedora para todos! </p>
                    `,
                    customClass: {
                        popup: 'animated',
                    }
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            html: `
                            <p>Para prosseguirmos, preciso que me informe onde os cadastros estão sendo realizados hoje.</p>
                            <p> <strong>LEMBRE-SE!</strong> <I>É importante que ao término, você encerre a sessão clicando no botão localizado à esquerda <strong>'Finalizar Cadastros'</strong>. Dessa forma, saberei que não haverá mais cadastros a serem realizados hoje nesta localidade. </I><strong>Combinado?</strong></p>
                                <select id="lc_cadastro" class="form-select" name="lc_cadastro" autocomplete="off" required>
                                    <option value="" data-default disabled selected>Selecione</option>
                                    <option value="ACUDE NOVO">AÇUDE NOVO</option>
                                    <option value="ARMAZEM">ARMAZEM</option>
                                    <option value="BASILIO">BASILIO</option>
                                    <option value="BATALHA">BATALHA</option>
                                    <option value="BAIXA">BAIXA</option>
                                    <option value="BARRO BRANCO">BARRO BRANCO</option>
                                    <option value="CAIBRAS">CAIBRAS</option>
                                    <option value="CAIANA">CAIANA</option>
                                    <option value="CALDEIRAOZINHO">CALDEIRAOZINHO</option>
                                    <option value="CALUMBI">CALUMBI</option>
                                    <option value="CRAS ANTONIO MATIAS">CRAS - ANTONIO MATIAS</option>
                                    <option value="CRAS SANTO AFONSO">CRAS - SANTO AFONSO</option>
                                    <option value="CREAS GILDO SOARES">CREAS GILDO SOARES</option>
                                    <option value="ESPIRITO SANTO">ESPIRITO SANTO</option>
                                    <option value="FURNAS">FURNAS</option>
                                    <option value="GAMA">GAMA</option>
                                    <option value="IMPUEIRA">IMPUEIRA</option>
                                    <option value="JURUBEBA">JURUBEBA</option>
                                    <option value="MANICOBA SOARES">MANICOBA SOARES</option>
                                    <option value="MINADOR">MINADOR</option>
                                    <option value="MONICA BRAGA">MONICA BRAGA</option>
                                    <option value="PASSAGEM">PASSAGEM</option>
                                    <option value="PAULO CORDEIRO">PAULO CORDEIRO</option>
                                    <option value="PIMENTA">PIMENTA</option>
                                    <option value="POCO COMPRIDO">POÇO COMPRIDO</option>
                                    <option value="PRIMAVERA">PRIMAVERA</option>
                                    <option value="QUEIMADA GRANDE">QUEIMADA GRANDE</option>
                                    <option value="RIACHO DA PORTEIRAS">RIACHO DA PORTEIRAS</option>
                                    <option value="SEDE">SEDE</option>
                                    <option value="SERRA VERDE">SERRA VERDE</option>
                                    <option value="SERROTE">SERROTE</option>
                                    <option value="SODRE">SODRE</option>
                                    <option value="TAMANDUA">TAMANDUA</option>
                                    <option value="UNA DO SIMAO">UNA DO SIMAO</option>
                                    <option value="ZE BENTO">ZE BENTO</option>
                                </select>
                            `,
                            preConfirm: () =>{
                                var ab = document.getElementById('lc_cadastro') ? document.getElementById('lc_cadastro').value : null

                                if (ab === null) {
                                        return true
                                    }
        
                                    if (!ab) {
                                        Swal.showValidationMessage('É obrigatório selecionar o local onde você está realizando o cadastro.')
                                        return false
                                    }

                                    return {
                                        ab
                                    }
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Sim, estou de acordo',
                            cancelButtonText: 'Não'
                        }).then((result1) => {
                            if (result1.isConfirmed) {

                                var lc_cadastro = document.getElementById("lc_cadastro").value;

                                $.ajax ({
                                    type: "POST",
                                    url: "/TechSUAS/peixe/logado/local_cadastro.php",
                                    data: {lc_cadastro: lc_cadastro},
                                    dataType: "json",
                                    success: function(response) {
                                        if (response.salvo) {
                                            Swal.fire({
                                                title: 'OBRIGADO!',
                                                html:`
                                                <p>Que bom poder contar com você!</p>
                                                <p>Podemos fazer a diferença na vida dessas pessoas!</p>
                                                `,
                                                confirmButtonText: "Seguir"
                                            }).then((reload) => {
                                                if (reload.isConfirmed) {
                                                    window.location.href = "/TechSUAS/peixe/logado/index.php";
                                                    }
                                            })
                                        } else {
                                            Swal.fire({
                                                title: 'Erro',
                                                html:`
                                                <p>Infelizmente, não foi possível realizar o cadastro. Tente novamente!</p>
                                                `,
                                                confirmButtonText: 'Ok'
                                            }).then((foraL) => {
                                                if (foraL.isConfirmed) {
                                                    window.location.href = "/TechSUAS/peixe/logado/index.php";
                                                }
                                            })
                                        }
                                    }
                                })
                            } else {
                                Swal.fire({
                                    title: 'Que pena!',
                                    html:`
                                    <p>Infelizmente, não posso seguir em frente sem a sua permissão!</p>
                                    <p>Conheça um pouco sobre a semana santa.</p>
                                    `,
                                    confirmButtonText: 'Ok'
                                }).then((foraL) => {
                                    if (foraL.isConfirmed) {
                                        window.location.href = "https://enciclopedia.paginasdabiblia.com/pages/a-historia-e-significado-da-semana-santa-origem-e-tradicoes";
                                    }
                                })
                            }
                        })
                    } else {
                        Swal.fire("Operação cancelada", "", "info")
                        .then((result1) => {
                            if (result1.isConfirmed) {
                                window.location.href = "/TechSUAS/peixe/logado/index";
                            }
                        })
                    }
                })
            </script>
            <?php
            exit;
        }
?>
<div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="../img/h1-peixe.svg" alt="Titulocomimagem">
        </h1>
    </div>

    <div class="bloco">
        <div class="bloco-1">
            <button class="menu-button" type="button" onclick="Cadastrar()">Cadastrar</button>

                <?php
                    if ($_SESSION['funcao'] == '1') {
                        ?>
                    <button class="menu-button" type="button" onclick="consultar()">Cosultar</button>
                    <button class="menu-button" type="button" onclick="Editar()">Editar</button>
                        <?php
                    }
                    if ($_SESSION['funcao'] != '1') {
                        ?>
                        <button class="menu-button" type="button" onclick="mensagem_encaminhamento()">Encaminhar P/ Secretaria</button>
                        <?php
                    }
                ?>

            <button class="menu-button" type="button" onclick="finishCad()">Finalizar Cadastros</button>
        </div>
        <div class="bloco-2">
            <div id="dadosUltCadastro"></div>
        </div>
    </div>
<!--
    <div class="corpo">
        <div id="cardF">

            <form method="POST" id="formCont" action='conferir.php'>

                <div class="cont-form">
                    <label for="estado">Local de Cadastramento:</label>
                    <select id="lc_cadastro" class="form-select" name="lc_cadastro" autocomplete="off" required>
    <option value="" data-default disabled selected></option>
    <option value="ACUDE NOVO">AÇUDE NOVO</option>
    <option value="ARMAZEM">ARMAZEM</option>
    <option value="BASILIO">BASILIO</option>
    <option value="BATALHA">BATALHA</option>
    <option value="BAIXA">BAIXA</option>
    <option value="BARRO BRANCO">BARRO BRANCO</option>
    <option value="CAIBRAS">CAIBRAS</option>
    <option value="CAIANA">CAIANA</option>
    <option value="CALDEIRAOZINHO">CALDEIRAOZINHO</option>
    <option value="CALUMBI">CALUMBI</option>
    <option value="CRAS ANTONIO MATIAS">CRAS - ANTONIO MATIAS</option>
    <option value="CRAS SANTO AFONSO">CRAS - SANTO AFONSO</option>
    <option value="CREAS GILDO SOARES">CREAS GILDO SOARES</option>
    <option value="ESPIRITO SANTO">ESPIRITO SANTO</option>
    <option value="FURNAS">FURNAS</option>
    <option value="GAMA">GAMA</option>
    <option value="IMPUEIRA">IMPUEIRA</option>
    <option value="JURUBEBA">JURUBEBA</option>
    <option value="MANICOBA SOARES">MANICOBA SOARES</option>
    <option value="MINADOR">MINADOR</option>
    <option value="MONICA BRAGA">MONICA BRAGA</option>
    <option value="PASSAGEM">PASSAGEM</option>
    <option value="PAULO CORDEIRO">PAULO CORDEIRO</option>
    <option value="PIMENTA">PIMENTA</option>
    <option value="POCO COMPRIDO">POÇO COMPRIDO</option>
    <option value="PRIMAVERA">PRIMAVERA</option>
    <option value="QUEIMADA GRANDE">QUEIMADA GRANDE</option>
    <option value="RIACHO DA PORTEIRAS">RIACHO DA PORTEIRAS</option>
    <option value="SEDE">SEDE</option>
    <option value="SERRA VERDE">SERRA VERDE</option>
    <option value="SERROTE">SERROTE</option>
    <option value="SODRE">SODRE</option>
    <option value="TAMANDUA">TAMANDUA</option>
    <option value="UNA DO SIMAO">UNA DO SIMAO</option>
    <option value="ZE BENTO">ZE BENTO</option>
</select>
                </div>

--><!-- ========= INICIO DO FORMULARIO ============== --><!--
                <div class="form-group">
--><!-- ========= DIVISORIA DO FORMULARIO ============== --><!--
                    <div class="cont-input1">
                        <div class="cont-formSus">
                            <label>Codigo do Talão:</label>
                            <input type="text" class="form-control" name="comprova" maxLength="04" autocomplete="off" required>
                        </div>

                        <select name="buscar_dados" required>
                            <option value="cpf_dec">CPF:</option>
                            <option value="nis_dec">NIS:</option>
                        </select>
                        <input type="text" name="valorescolhido" placeholder="Digite aqui:" maxlength="14" required>

                        <div class="cont-form">
                            <label for="estado">Local de Entrega:</label>
                            <select id="" class="form-select" name="entrega" autocomplete="off" required>
                                <option value="" data-default disabled selected></option>
                                <option value="ACUDE NOVO">AÇUDE NOVO</option>
                                <option value="ARMAZEM">ARMAZEM</option>
                                <option value="ARRANCACAO">ARRANCAÇÃO</option>
                                <option value="BASILIO">BASILIO</option>
                                <option value="BATALHA">BATALHA</option>
                                <option value="BAIXA">BAIXA</option>
                                <option value="BARRO BRANCO">BARRO BRANCO</option>
                                <option value="CAIBRAS">CAIBRAS</option>
                                <option value="CAIANA">CAIANA</option>
                                <option value="CALDEIRAOZINHO">CALDEIRAOZINHO</option>
                                <option value="CALUMBI">CALUMBI</option>
                                <option value="CRAS ANTONIO MATIAS">CRAS - ANTONIO MATIAS</option>
                                <option value="CRAS SANTO AFONSO">CRAS - SANTO AFONSO</option>
                                <option value="ESPIRITO SANTO">ESPIRITO SANTO</option>
                                <option value="ESTER SIQUEIRA">ESTER SIQUEIRA</option>
                                <option value="FURNAS">FURNAS</option>
                                <option value="GAMA">GAMA</option>
                                <option value="IMPUEIRA">IMPUEIRA</option>
                                <option value="JURUBEBA">JURUBEBA</option>
                                <option value="MANICOBA SOARES">MANICOBA SOARES</option>
                                <option value="MINADOR">MINADOR</option>
                                <option value="MONICA BRAGA">MONICA BRAGA</option>
                                <option value="ODETE COSTA">ODETE COSTA</option>
                                <option value="PASSAGEM">PASSAGEM</option>
                                <option value="PAULO CORDEIRO">PAULO CORDEIRO</option>
                                <option value="PIMENTA">PIMENTA</option>
                                <option value="POCO COMPRIDO">POÇO COMPRIDO</option>
                                <option value="POCO DOCE">POÇO DOCE</option>
                                <option value="PRIMAVERA">PRIMAVERA</option>
                                <option value="QUEIMADA GRANDE">
                            </select>
                        </div>
                    </div>
                    <div class="btn">
                        <button class="menu-button" type="submit">CADASTRAR</button>
                    </div>
                </div>
            </form>
        </div>    
            <div class="consul">
                <div class="cansult">
                    <form method="POST" action="">
                        <div class="consul1">
                            <div>
                                <label>Consultar Cadastros:</label>
                                <input class="camp1"  type="text" placeholder="Familias Cadastradas (CPF)." name="valorescolhido">
                            </div>
                        </div>
                        <div class="consul2">
                            <div class="camp">
                                <button class="menu-button" onclick="consultar_familia()">CONSULTAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div> -->
    <div>
    <footer><img src="../img/footer-peixe.svg" alt=""></footer>
    </div>

</body>
</html>