<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ação Cadú</title>

    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="function.js"></script>
    

</head>
<body>
    <!-- Seção 1 coletar o CPF -->
    <div class="bl1">
        <section id="secao1">
            <input type="text" name="cpf_acao_cadu" id="cpf_acao_cadu" placeholder="CPF" onkeyup="consultar_cpf()" required/>
                <div id="teclado_numerico">
                    <button id="n1" class="btn_teclas">1</button>
                    <button id="n2" class="btn_teclas">2</button>
                    <button id="n3" class="btn_teclas">3</button>
                    <button id="n4" class="btn_teclas">4</button>
                    <button id="n5" class="btn_teclas">5</button>
                    <button id="n6" class="btn_teclas">6</button>
                    <button id="n7" class="btn_teclas">7</button>
                    <button id="n8" class="btn_teclas">8</button>
                    <button id="n9" class="btn_teclas">9</button>
                    <button id="n0" class="btn_teclas">0</button>
                    <button id="backspace" class="btn_teclas">⌫</button>
                </div>

            </section>
        </div>
    </div>
    <!-- Seção 2 identificar o tipo de atendimento -->
    <div class="bl1">
        <section id="secao2" style="display: none;">
            <h2>Escolha o tipo de atendimento</h2>
                <div class="tipo-atendimento">
                    <button class="btn_atendimento" id="cadunico">
                        <img src="/TechSUAS/acao_cadu/img/logo_cadunico.png" alt="Cadastro Único" />
                    </button>
                    <button class="btn_atendimento" id="bolsafamilia">
                        <img src="/TechSUAS/acao_cadu/img/logo_bolsafamilia.png" alt="Bolsa Família" />
                    </button>
                </div>
        </section>
    </div>
    <!-- Seção 3 identificar o tipo de ação -->
    <section id="secao3" style="display: none;">
        <h2>Tipo de Ação</h2>
            <div class="tipo-acao">
                <button class="btn_acao" id="prioridade">PRIORIDADE</button>
                <button class="btn_acao" id="comum">COMUM</button>
            </div>
    </section>

    <!-- Seção 4 identificar o tipo de cadastro -->
    <section id="secao4" style="display: none;">
        <h2>Sua Senha:</h2>
            <div class="senha-exibida" id="senha_resultado"></div>

            <button id="btnImprimir">IMPRIMIR</button>
    </section>
</body>
</html>