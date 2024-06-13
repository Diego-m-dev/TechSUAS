<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/style-painel_entrevistador.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="/TechSUAS/js/cadastro_unico.js"></script>

    <title>Painel entrevistador</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/h1-painel_entrevistador.svg" alt="Título com imagem">
        </h1>
    </div>
    <div class="tudo">
        <div class="container">
            <form method="post" action="/TechSUAS/controller/cadunico/salvar_dados_painel" enctype="multipart/form-data">
                <div class="ocult2">
                    <div id="codfamiliar_print" class="ocult"></div>
                    <div id="data_entrevista" class="ocult"></div>
                    <div id="familia_show" class="ocult"></div>
                </div>
                <!--FORMULARIO PARA IDENTIFICAÇÃO DA ENTREVISTA-->
                <div class="bloc1">
                    <div>
                        <label>Código familiar:</label>
                        <input type="text" name="cod_fam" id="codfamiliar" onblur="buscarDadosFamily()" required />
                    </div>

                    <div id="cont_data">
                        <label for="data_entrevista">Data da Entrevista:</label>
                        <input type="date" id="data_entrevista" name="data_entrevista" required>
                        <button type="button" onclick="dataHoje()">Hoje</button>
                    </div>

                    <div id="data_entre" class="ocult"></div>

                </div>

                <div class="bloc2">
                    <div class="situacao">
                        <label>Selecione a situação do benefício:</label>
                        <div>
                            <label class="urg">
                                <input type="checkbox" name="fimRestricao" />
                                <span class="checkmark"></span>
                                <span>Fim de restrinção especifica</span>
                        </div>

                        <div>
                            <label class="urg">
                                <input type="checkbox" name="fimRestricao" />
                                <span class="checkmark"></span>
                                <input type="checkbox" name="bloc" />
                                <span>Bloqueado</span>
                        </div>

                        <div>
                            <label class="urg">
                                <input type="checkbox" name="fimRestricao" />
                                <span class="checkmark"></span>
                                <input type="checkbox" name="Canc" />
                                <span>Cancelado</span>
                        </div>

                        <div>
                            <label class="urg">
                                <input type="checkbox" name="fimRestricao" />
                                <span class="checkmark"></span>
                                <input type="checkbox" name="s_benef" />
                                <span>Não tem benefício</span>
                        </div>
                    </div>
                    <div class="observ">
                        <div><label>Observação:</label></div>
                        <div><textarea name="resumo" id="resumo" placeholder="Se houve alguma observação durante a entrevista registre-a."></textarea></div>
                    </div>
                    </label><br><input type="hidden" id="tipo_documento" value=".pdf">
                </div>
                <!--FORMULÁRIO PARA UPLOAD DOS ARQUIVOS-->
                <div class="upload">
                    <div>

                        <label>Tipo de Documento:</label>
                        <br>
                        <select name="tipo_documento[]" id="tipo_documento" multiple required>
                            <option value="" disabled hidden>Selecione o(s) tipo(s)</option>
                            <option value="Cadastro">Cadastro</option>
                            <option value="Atualização">Atualização</option>
                            <option value="Assinatura">Assinatura</option>
                            <option value="Fichas exclusão">Fichas exclusão</option>
                            <option value="Relatórios">Relatórios</option>
                            <option value="Parecer visitas">Parecer visitas</option>
                            <option value="Documento externo">Documento externo</option>
                        </select>
                        <br>

                    </div>
                    <div class="upl">
                        <label>Arquivo:</label>
                        <input type="file" id="arquivo" name="arquivo" accept=".pdf" required>
                    </div>
                </div>
                <div class="btn">
                    <button type="submit">Cadastrar</button>
                    <button onclick="voltaMenu()"><i class="fas fa-arrow-left"></i>Voltar ao menu</button>
                </div>

            </form>

            <!--BOTÕES PARA FÁCIL ACESSO AOS FORMULÁRIO E DECLARAÇÕES-->
        </div>
        <div class="btns">
            <div><label for="">Botões de facíl acesso:</label></div>
            <nav>
                <a type="button" id="btn_residencia">
                    <i class="fas fa-home icon"></i> Termo de Declaração de Residência
                </a>

                <a type="button" id="btn_dec_renda">
                    <i class="fas fa-file-invoice-dollar icon"></i> Termo de Declaração de Renda
                </a>

                <a type="button" id="btn_fc_familia">
                    <i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Familia
                </a>

                <a type="button" id="btn_fc_pessoa">
                    <i class="fas fa-user-minus icon"></i> Ficha de Exclusão de Pessoa
                </a>
                <!--DECLARAÇÃO PARA INFORMAR SE A PESSOA É INSCRITA NO CADASTRO ÚNICO E/OU TEM BENEFÍCIO-->
                <a type="button" id="btn_dec_cad">
                    <i class="material-symbols-outlined">assignment_add</i> Declaração Cadastro Único
                </a>

                <!--ENCAMINHAMENTO ELABORAÇÃO DE INFORMATIVO PARA ENCAMINHAR O USUÁRIO PARA OUTROS SERVIÇOS-->
                <a type="button" id="btn_encamnhamento">
                    <i class="material-symbols-outlined">export_notes</i> Encaminhamentos
                </a>

                <!--DOCUMENTO PARA FIRMAR O DESLIGAMENTO VOLUNTÁRIO-->
                <a type="button" id="btn_des_vol">
                    <i class="material-symbols-outlined">contract_delete</i> Desligamento Voluntário
                </a>

                <!--DOCUMENTO PARA CAIXA REALIZAR UM PAGAMENTO CASO A TROCA DE RF NÃO TENHA SIDO REFLETIDO NO SIBEC OU NOS SISTEMAS CAIXA-->
                <a type="button" id="btn_troca">
                    <i class="material-symbols-outlined">quick_reference</i> Troca de RF - C.E.F.
                </a>
            </nav>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const targets = [
                document.getElementById('codfamiliar_print'),
                document.getElementById('data_entrevista'),
                document.getElementById('familia_show'),
                document.getElementById('data_entre')
            ];

            // Função para alternar visibilidade
            function toggleVisibility(target) {
                if (target.innerHTML.trim() !== '') {
                    target.classList.remove('ocult');
                    target.classList.add('visible');
                } else {
                    target.classList.remove('visible');
                    target.classList.add('ocult');
                }
            }

            // Configura o observer para cada target
            targets.forEach(targetNode => {
                const observer = new MutationObserver(function(mutationsList, observer) {
                    for (const mutation of mutationsList) {
                        if (mutation.type === 'childList') {
                            toggleVisibility(targetNode);
                        }
                    }
                });

                // Configurações do observer: observar mudanças nos filhos da div
                const config = {
                    childList: true,
                    subtree: true
                };

                // Inicia o observer
                observer.observe(targetNode, config);

                // Verificação inicial para o caso de a div já ter conteúdo no carregamento
                toggleVisibility(targetNode);
            });
        });
    </script>
</body>

</html>