<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

$nis_from = $_POST['nis_exc_pessoa'];

$sql_declar = $pdo->prepare("SELECT * FROM tbl_tudo WHERE num_nis_pessoa_atual = :nis_exc_pessoa");
$sql_declar->bindParam(':nis_exc_pessoa', $nis_from, PDO::PARAM_STR);
$sql_declar->execute();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ficha de exclusão de pessoa - TechSUAS</title>

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/forms/ex_pesso.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="<?php echo 'background-' . $_SESSION['estilo']; ?>">
    <div class="titulo">
        <div class="tech">
            <span>TechSUAS-Cadastro Único </span><?php echo $data_cabecalho; ?>
        </div>
    </div>
    <div class="container">
        <h1 class="center1">ANEXO II - FICHA DE EXCLUSÃO DE PESSOA</h1>
        <div class="assinatura">(Redação dada pela Portaria MDS nº 860, de 14 de fevereiro de 2023)</div>
        <?php
        if ($sql_declar->rowCount() > 0) {
            $dados_declar = $sql_declar->fetch(PDO::FETCH_ASSOC);

            $cod_familiar = $dados_declar['cod_familiar_fam'];
            $cod_familiar_formatado = substr_replace(str_pad($cod_familiar, 11, "0", STR_PAD_LEFT), '-', 9, 0);

            $sql_rf = "SELECT * FROM tbl_tudo WHERE cod_familiar_fam = '$cod_familiar' AND cod_parentesco_rf_pessoa = '1'";
            $resultado_rf = $conn->query($sql_rf);

            if ($resultado_rf->num_rows > 0) {
                $row = $resultado_rf->fetch_assoc();
                $nis_rf = $row['num_nis_pessoa_atual'];
                $nis_responsavel_formatado = substr_replace(str_pad($nis_rf, 11, "0", STR_PAD_LEFT), '-', 10, 0);
            } else {
                $nis_responsavel_formatado = "Cadastro sem Responsável Familiar";
            }
        ?>
            <label for="codigoFamiliar">CODIGO FAMILIAR:</label>
            <input type="text" id="codigoFamiliar" name="codigoFamiliar" value="<?php echo $cod_familiar_formatado; ?>" readonly>
            <br>
            <label for="nisResponsavel">NIS DO RESPONSÁVEL FAMILIAR:</label>
            <input type="text" id="nisResponsavel" value="<?php echo $nis_responsavel_formatado; ?>" name="nisResponsavel">
            <br>
            <label for="nomePessoa">NOME DA PESSOA:</label>
            <input type="text" id="nomePessoa" name="nomePessoa" value="<?php echo $dados_declar['nom_pessoa']; ?>" readonly>
            <br>
            <label for="nisPessoa">NIS DA PESSOA:</label>
            <input type="text" id="nisPessoa" value="<?php echo $dados_declar['num_nis_pessoa_atual']; ?>" name="nisPessoa">
            <br>
            <label for="dataExclusao">DATA DA EXCLUSÃO:</label>
            <input type="text" id="dataExclusao" name="dataExclusao" readonly>
            <br><br>
            <label for="motivo">Motivo:</label>
            <div class="impr">
                <select id="motivo" class="parecer" name="motivo" onchange="buscarTextoMotivo()">
                    <option value="" disabled selected hidden>Selecione o motivo</option>
                    <option value="1">1 - Falecimento...</option>
                    <option value="2">2 - Desvinculação da pessoa...</option>
                    <option value="3">3 - Decisão judicial...</option>
                    <option value="4">4 - Fraude cibernética...</option>
                    <option value="5">5 - Alterações indevidas...</option>
                </select>
            </div>
            <div>
                <span id="numeroMotivoSelecionado"></span>
                <span id="textoMotivo" name="justified-text">Texto do motivo selecionado será exibido aqui.</span>
            </div>
            <br>
            <label for="parecer">PARECER TECNICO:</label>
            <textarea id="parecer" name="parecer" onblur="showParecer()"></textarea>
            <p><span id="show_parecer"></span></p>
            <button class="impr" onclick="imprimirPagina()">Imprimir Página</button>
            <button class="impr" onclick="voltarAoMenu()"><i class="fas fa-arrow-left"></i>Voltar</button>
            <div class="cidade_data">
                <?php echo $cidade; ?><?php echo $data_formatada_extenso; ?>.
            </div>
            <div class="assinatura">_________________________________________________________________<br>Assinatura do Responsável pela Unidade Familiar (RUF) (exceto no caso 3)</div>
            <div class="assinatura">_________________________________________________________________<br>Assinatura do entrevistador</div>
            <div class="assinatura">_________________________________________________________________<br>Assinatura do responsável pelo cadastramento</div>
            <div class="assinatura">_________________________________________________________________<br>Assinatura do Gestor do CadÚnico (nos casos 4 e 5)</div>
            <div id="justified-text">
                <p>Caso o RF não saiba assinar, o entrevistador registra a expressão "A ROGO" e, a seguir, o nome do RF. (A ROGO é a expressão jurídica utilizada para indicar que a identificação, substituindo a assinatura, foi delegada a outra pessoa).</p>
            </div>
    </div>
<?php
        } else {
?>
    <script>
        Swal.fire({
            icon: "error",
            title: "NIS NÃO ENCONTRADO",
            html: `
            <p>Esse NIS <b>'<?php echo $nis_from; ?>' </b>não foi encontrado!</p>
            <h5>ATENÇÃO</h5>
            <p>Certifique se que os numeros estão corretos ou consulte no CadÚnico se o Cadastro está ativo.</p>
            `,
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/TechSUAS/views/cadunico/forms/menuformulario"
            }
        })
    </script>
<?php
        }
?>

<script>
    const motivoList = {
        "1": "- Falecimento da pessoa.",
        "2": "- Desvinculação da pessoa da família em que está cadastrada.",
        "3": "- Decisão judicial.",
        "4": "- Cadastros incluídos ou alterados em decorrência de fraude cibernética ou digital no Sistema de Cadastro Único.",
        "5": "- Cadastros incluídos ou alterados indevidamente por agente público, por má fé."
    }

    function formatarNumero(numero) {
        return numero < 10 ? '0' + numero : numero
    }

    // Função para obter a data e hora atual e exibir na página
    function mostrarDataHoraAtual() {
        let dataAtual = new Date();

        let dia = formatarNumero(dataAtual.getDate());
        let mes = formatarNumero(dataAtual.getMonth() + 1);
        let ano = dataAtual.getFullYear();

        let horas = formatarNumero(dataAtual.getHours());
        let minutos = formatarNumero(dataAtual.getMinutes());
        let segundos = formatarNumero(dataAtual.getSeconds());

        let dataHoraFormatada = `${dia}/${mes}/${ano} ${horas}:${minutos}:${segundos}`;

        // Verifica se o elemento existe antes de tentar atualizar
        const dataHoraElement = document.getElementById('dataHora');
        if (dataHoraElement) {
            dataHoraElement.textContent = " - " + dataHoraFormatada;
        }
    }

    // Chamando a função para exibir a data e hora atual quando a página carrega
    window.onload = function() {
        mostrarDataHoraAtual();
        // Atualizar a cada segundo
        setInterval(mostrarDataHoraAtual, 1000);

        const currentDate = new Date();
        const options = {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        };
        document.getElementById('dataExclusao').value = currentDate.toLocaleDateString('pt-BR', options);
        const dataExclusao2Element = document.getElementById('dataExclusao2');
        if (dataExclusao2Element) {
            dataExclusao2Element.textContent = currentDate.toLocaleDateString('pt-BR', options);
        }
    }

    function buscarTextoMotivo() {
        var motivoInput = document.getElementById("motivo")
        var numeroMotivoSelecionado = document.getElementById("numeroMotivoSelecionado")
        var textoMotivo = document.getElementById("textoMotivo")

        var selectedValue = motivoInput.value
        var selectedText = motivoList[selectedValue]

        if (selectedText) {
            numeroMotivoSelecionado.textContent = selectedValue
            textoMotivo.textContent = selectedText
            $('#motivo').hide()
        } else {
            numeroMotivoSelecionado.textContent = ""
            textoMotivo.textContent = "Texto do motivo selecionado será exibido aqui."
        }
    }

    function showParecer() {
        var parecer = document.getElementById('parecer').value; // Obtém o valor do elemento parecer
        $('#parecer').hide(); // Esconde o elemento parecer
        $('#show_parecer').text(parecer); // Define o texto do elemento show_parecer como o valor de parecer
        console.log(parecer); // Exibe o valor de parecer no console
    }
</script>
<script src="/TechSUAS/js/cadastro_unico.js"></script>
</body>

</html>