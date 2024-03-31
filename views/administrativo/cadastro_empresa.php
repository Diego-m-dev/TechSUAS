<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/dados_operador.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/TechSUAS/img/geral/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="/TechSUAS/css/administrativo/style_cad_consul_cont.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <title>Cadastrar Empresas</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/administrativo/cadas_empre.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">
        <div id='form_contrato'>
            <form action="/TechSUAS/controller/administrativo/salvamento_teste" method="POST">
                <!-- Campos do Contrato -->
                <div>
                    <label>Nome empresa:</label>
                    <input type="text" name="nome_empresa" class="inpu" required>
                </div>
                <div>
                    <label>Razão social:</label>
                    <input type="text" name="razao_social" class="inpu" required>
                </div>
                <div>
                    <label>Endereço:</label>
                    <input type="text" name="endereco" class="inpu">
                </div>
                <div>
                    <label>CNPJ:</label>
                    <input type="text" name="cnpj" id="cnpjInput" maxlength="18" required>
                </div>
                <div>
                    <label>Telefone:</label>
                    <input type="text" name="num_contato" class="contatoInput" maxlength="16">
                </div>
                <div>
                    <label>E-mail:</label>
                    <input type="email" name="email_emp" class="inpu">
                </div>
                <div>
                    <label>Representante Legal:</label>
                    <input type="text" name="nom_representante">
                </div>
                <div>
                    <label>Contato do Representante:</label>
                    <input type="text" name="contato_representante" class="contatoInput">
                </div>
                <div>
                    <label>Segmento:</label>
                    <input type="text" name="segmento" class="inpu">
                </div>
                <div class="btns">
                    <button type="submit" name="btn_contrato">Salvar Empresa</button>
                    <button type="button" onclick="window.location.href ='/TechSUAS/views/administrativo/cadastro_contrato';">Cadastrar Contratos</button>
                    <button type="button" class="back" onclick="window.location.href ='/TechSUAS/config/back';">
                        <i class="fas fa-arrow-left"></i>
                        Voltar ao menu
                    </button>
                </div>
            </form>
        </div>
        <div id='form_itens' style='display: none'>
            <form action="/Suas-Tech/suas/controller/salvar_contrato.php" method="POST">
                <!-- Tabela de Itens -->
                <label>Informe o número contrato:</label>
                <input type=text name="num_contrato" placeholder="Os itens pertence a qual contrato?">
                <table width="500px" border="1" id="tabelaItens">
                    <tr>
                        <th colspan="5">TABELA ITENS</th>
                    </tr>
                    <tr>
                        <th>Código do Item</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Valor Total</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="num_item[]"></td>
                        <td><input type="text" name="nome_produto[]"></td>
                        <td><input type="text" name="quantidade[]" class="quantidade"></td>
                        <td><input type="text" name="valor_unitario[]" class="valor-unitario"></td>
                        <td><input type="text" name="valor_total[]" class="valor-total" readonly></td>
                    </tr>
                </table>

                <!-- Botões -->
                <button type="button" onclick="adicionarLinha()">Adicionar Linha</button>
                <button type="submit" name="btn_itens">Salvar Itens</button>
            </form>
            <div id="voltar1" class="back">
                <button type="button" onclick="window.location.href ='/TechSUAS/views/administrativo/';">
                    <i class="fas fa-arrow-left"></i>
                    Voltar ao menu
                </button>
            </div>
        </div>

    </div>
    <script src="/TechSUAS/js/script_contrato.js"></script>
    <script>
        $(document).ready(function() {
            $('#valor_contrato').mask('000.000.000.000.000,00', {
                reverse: true
            });
            $('.contatoInput').mask('(00) 0.0000-0000')
        });
    </script>

</body>

</html>