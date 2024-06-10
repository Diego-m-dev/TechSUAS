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

    <link rel="stylesheet" type="text/css" href=/TechSUAS/css/cadunico/declaracoes/style_enc.css>
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Encaminhamento</title>

</head>

<body>
    <div class="tudo">
        <div class="conteudo">
            <?php
            if (isset($_POST['cpf_dec_cad'])) {

                $cpf_limpo = preg_replace('/\D/', '', $_POST['cpf_dec_cad']);
                $cpf_already = ltrim($cpf_limpo, '0');
                // SOLICITAÇÃO DA TABELA TBL_TUDO PARA PEGAR OS DADOS DO INDIVIDUO
                $sql_enc = "SELECT * FROM tbl_tudo WHERE num_cpf_pessoa LIKE '%$cpf_already'";
                $sql_query_enc = $conn->query($sql_enc) or die("ERRO ao consultar! " . $conn - error);

                // CONSULTA PARA O SELECTE DOS SETORES PRÓXIMOS
                $consultaSetores = $conn->query("SELECT instituicao, nome_instit FROM setores");

                if ($sql_query_enc->num_rows == 0) {
            ?>
                    <script>
                        Swal.fire({
                            html: `
                <h4>O CPF <?php echo $_POST['cpf_dec_cad']; ?> NÃO FOI LOCALIZADO</h4>
                <label>Preencha o formulário abaixo:</label>
                <input type="text" name="cpf_enc" id="cpf_dec_cad" value="<?php echo $_POST['cpf_dec_cad']; ?>" placeholder="Digite o CPF" />
                <div>
                    <input type="text" name="nome_enc" id="nome_enc" placeholder="Digite o nome completo" />
                </div>
                <div>
                    <input type="text" name="endereco" id="endereco" placeholder="Exemplo: RUA NOME, 00 - BAIRRO" />
                </div>
                `,

                            didOpen: () => {
                                $('#cpf_dec_cad').mask('000.000.000-00')
                                $('input[type="text"]').on('input', function() {
                                    $(this).val($(this).val().toUpperCase())
                                })
                            }

                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#setor').text(`<?php echo $_SESSION['setor']; ?>`)
                                $('#carimbo').text(`<?php echo $cidade . $data_formatada; ?>.`)
                                $('#assunto').text('Assunto:')
                                $('#encaminho').text('Encaminho o(a) Sr(a). ')
                                $('#cpf').text(', CPF: ')
                                $('#reside').text(', reside em ')
                                $('#finais').text('Permaneço à disposição para quaisquer esclarecimentos adicionais que se façam necessários.')
                                $('#atte').text('Atenciosamente,')

                                $('#vs').show()

                                $('#cpf_wen').text($("#cpf_dec_cad").val())
                                $('#nome_wen').text($("#nome_enc").val())
                                $('#end_wen').text($("#endereco").val())
                            }
                        })
                    </script>

                    <h1>ENCAMINHAMENTO</h1>
                    <h4><span id="setor"></span></h4>
                    <div class="cidade_data" id="carimbo"></div>
                    <p><span id="assunto"></span></p>


                    <p class="cont"><span id="encaminho"></span><strong><span id="nome_wen"></span></strong><span id="cpf"></span><strong><span id="cpf_wen"></span></strong><span id="reside"></span><strong><span id="end_wen"></span></strong>.

                        <div class="esconder">
                            <label>Para
                                <select name="setor" id="setor" onchange="mostrarCampoTexto()" required>
                                    <option value="" disabled selected hidden>Selecione</option>
                                    <?php
                                    // Verifica se há resultados na consulta
                                    if ($consultaSetores->num_rows > 0) {
                                        // Loop para criar as opções do select
                                        while ($setor = $consultaSetores->fetch_assoc()) {
                                            echo '<option value="' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '">' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '</option>';
                                        }
                                    ?>
                                        <option value="3">OUTROS</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <input type="text" name="funcao_outros" id="inputOutro" style="display: none;" placeholder="Digite a para quem você quer encaminhas">
                            </label>
                        </div>
                        <p><span id="mostrarDest"></span></p>

                        <div class="esconder">
                            <label for="">Descreva a situação:<br>
                                <textarea id="inputText" rows="4" cols="50" placeholder="Digite seu texto aqui..."></textarea><br>
                            </label>
                        </div>
                        <!-- O TEXTO DA caixa de texto SERÁ REDIRECIONADO PARA ESSE SPAN COMO PARAGRAFO -->
                        <p><span id="mostrarText"></span></p>
                        <p><span id="finais"></span></p>
                        <p><span id="atte"></span></p>
                    
                        <div class="assinatura">
                            <div>
                                <div class="signature-line"></div><br>
                                <div>
                                    <?php echo $_SESSION['nome_usuario']; ?><br>
                                    <?php echo $_SESSION['cargo_usuario'] . ' ' . $_SESSION['setor']; ?><br>
                                    <?php echo $_SESSION['id_cargo']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="no-print">
                            <button class="buttons" onclick="printWithSignature()">Imprimir com Assinatura Eletrônica</button>
                            <button class="buttons" onclick="printWithFields_preper()">Imprimir com Campos de Assinatura</button>
                            <button class="buttons" onclick="voltar()">Voltar</button>
                        </div>

                    <?php
                } else {
                    $dados_enc = $sql_query_enc->fetch_assoc();
                    ?>

                        <h1>ENCAMINHAMENTO</h1>
                        <h4><?php echo $_SESSION['setor']; ?></h4>

                        <!--CARIMBO DO DOCUMENTO-->
                        <div class="cidade_data">
                            <?php echo $cidade; ?><?php echo $data_formatada; ?>.
                        </div>
                        <?php

                        ?>
                        <!--CORPO-->
                        <p>Assunto:</p>
                        <div class="conteudo">
                            <p class="cont ">Encaminho <?php echo  $dados_enc['cod_sexo_pessoa'] == "1" ? " o Sr. " : " a Sra. "; ?> <strong><?php echo $dados_enc['nom_pessoa']; ?></strong>, CPF: <strong><?php echo $_POST['cpf_dec_cad']; ?>, </strong> <?php echo  $dados_enc['cod_sexo_pessoa'] == "1" ? " filho " : " filha "; ?> de <strong><?php echo $dados_enc['nom_completo_mae_pessoa']; ?></strong>, reside em
                                <span class="editable-field" contenteditable="true"><i>
                                        <?php
                                        //RUA, AVENIDA, LARGO, PRAÇA..
                                        echo $dados_enc["nom_tip_logradouro_fam"] . ' ';
                                        //TITULO - SÃO, SANTO, SARGENTO, GERENTE, GENERAL...
                                        echo $dados_enc["nom_titulo_logradouro_fam"] == "" ? " " : $dados_enc["nom_titulo_logradouro_fam"] . ' ';
                                        //LOGRADOURO NOME DA RUA, AV., PRAÇA...
                                        echo $dados_enc["nom_logradouro_fam"] . ', ';
                                        //NUMERO
                                        echo $dados_enc["num_logradouro_fam"] == "" ? "S/N" : $dados_enc["num_logradouro_fam"];
                                        //BAIRRO
                                        echo ' - ' . $dados_enc["nom_localidade_fam"] . ', ';
                                        //REFERENCIA DO ENDEREÇO (SEMPRE FACILITA A ENCONTRAR)
                                        echo $dados_enc["txt_referencia_local_fam"] == "" ? "SEM REFERÊNCIA" : $dados_enc["txt_referencia_local_fam"];
                                        ?>
                                    </i></span>.
                            </p>

                            <div class="esconder">
                                <label>Para
                                    <select name="setor" id="setor" onchange="mostrarCampoTexto()" required>
                                        <option value="" disabled selected hidden>Selecione</option>
                                        <?php
                                        // Verifica se há resultados na consulta
                                        if ($consultaSetores->num_rows > 0) {
                                            // Loop para criar as opções do select
                                            while ($setor = $consultaSetores->fetch_assoc()) {
                                                echo '<option value="' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '">' . $setor['instituicao'] . ' - ' . $setor['nome_instit'] . '</option>';
                                            }
                                        ?>
                                            <option value="3">OUTROS</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="text" name="funcao_outros" id="inputOutro" style="display: none;" placeholder="Digite a para quem você quer encaminhas">
                                </label>
                            </div>
                            <p><span id="mostrarDest"></span></p>

                            <div class="esconder">
                                <label for="">Descreva a situação:<br>
                                    <textarea id="inputText" rows="4" cols="50" placeholder="Digite seu texto aqui..."></textarea><br>
                                </label>
                            </div>
                            <!-- O TEXTO DA caixa de texto SERÁ REDIRECIONADO PARA ESSE SPAN COMO PARAGRAFO -->
                            <p><span id="mostrarText"></span></p>

                            <p>Permaneço à disposição para quaisquer esclarecimentos adicionais que se façam necessários.</p>
                            <p>Atenciosamente,</p>
                        </div>
                        <?php
                        if ($sql_user_query->num_rows == 0) {
                            die();
                        } else {
                            $dados_user = $sql_user_query->fetch_assoc();

                        ?>
                    </div>
                    <div class="assinatura">
                        <div>
                            <div class="signature-line"></div><br>
                            <div>
                                <?php echo $_SESSION['nome_usuario']; ?><br>
                                <?php echo $_SESSION['cargo_usuario'] . ' ' . $_SESSION['setor']; ?><br>
                            <?php echo $_SESSION['id_cargo'];
                        }
                        echo '</div>';
                        echo '</div>';
                            ?>

                            </div>
                            <div class="no-print">
                                <button class="buttons" onclick="printWithSignature()">Imprimir com Assinatura Eletrônica</button>
                                <button class="buttons" onclick="printWithFields_preper()">Imprimir com Campos de Assinatura</button>
                                <button class="buttons" onclick="voltar()">Voltar</button>
                            </div>

                    <?php
                }
            }
                    ?>
                        </div>
                        <script>
                            function mostrarCampoTexto() {
                                var select = document.getElementById("setor");
                                var campoTexto = document.getElementById("inputOutro");

                                if (select.value == "3") {
                                    // Se a opção 'Outros' for selecionada, mostra o campo de texto
                                    campoTexto.style.display = "block";
                                } else {
                                    // Caso contrário, oculta o campo de texto
                                    campoTexto.style.display = "none";
                                }
                            }
                        </script>
</body>

</html>