$(document).ready(function () {
    $('#simples').hide()
    $('#beneficio').hide()
    $('#entrevistadores').hide()

    $('#btn_familia').click(function () {
        $('#simples').show()
        $('#beneficio').hide()
        $('#entrevistadores').hide()
    })
    $('#btn_benef').click(function () {
        $('#beneficio').show()
        $('#simples').hide()
        $('#entrevistadores').hide()
    })
    $('#btn_entrevistadores').click(function () {
        $('#beneficio').hide()
        $('#simples').hide()
        $('#entrevistadores').show()
    })

})

$(document).ready(function () {
    $('#btn_residencia').click(function () {
        Swal.fire({
            title: "Selecione a Opção",
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Unipessoal',
            denyButtonText: 'Família',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Se Unipessoal for selecionado
                Swal.fire({
                    title: "TERMO DE RESPONSABILIDADE",
                    html: `
                    <h6>para unipessoal</h6>
                    <h4>INFORME O CPF</h4>
                    <form method="POST" action="termo_responsabilidade_uni.php" id="form_residencia_uni">
                        <label> CPF:
                            <input type="text" name="cpf_residencia"/>
                        </label>
                    </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Enviar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById("form_residencia_uni")
                        form.submit()
                    }
                })
            } else if (result.isDenied) {
                // Se Família for selecionado
                Swal.fire({
                    title: "TERMO DE RESPONSABILIDADE",
                    html: `
                    <h6>para famílias com duas pessoas ou mais</h6>
                    <h4>INFORME O CPF</h4>
                    <form method="POST" action="termo_responsabilidade.php" id="form_residencia_familia">
                        <label> CPF:
                            <input type="text" name="cpf_residencia"/>
                        </label>
                    </form>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Enviar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById("form_residencia_familia")
                        form.submit()
                    }
                })
            }
        })
    })
        /* FORMULARIO RERNDA */
    $('#btn_dec_renda').click(function () {
        Swal.fire({
            title: "TERMO DE DECLARAÇÃO",
            html: `
            <h4>INFORME O CPF</h4>
            <form method="POST" action="Termo_declaracao" id="form_dec_renda">
                <label> CPF:
                    <input type="text" name="cpf_declar"/>
                </label>
            </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("form_dec_renda")
                form.submit()
            }
        })
    })

    $('#btn_fc_familia').click(function () {
        Swal.fire({
            title: "FICHA DE EXCLUSÃO DE FAMILIA",
            html: `
            <h4>INFORME O NIS</h4>
            <form method="POST" action="Ficha_de_Exclusão_de_familia" id="form_fc_pessoa">
                <label> NIS:
                    <input type="text" name="nis_exc_pessoa"/>
                </label>
            </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("form_fc_pessoa")
                form.submit()
            }
        })
    })

    $('#btn_fc_pessoa').click(function () {
        Swal.fire({
            title: "FICHA DE EXCLUSÃO DE PESSOA",
            html: `
            <h4>INFORME O NIS</h4>
            <form method="POST" action="Ficha_de_Exclusão_de_Pessoa" id="form_fc_pessoa">
                <label> NIS:
                    <input type="text" name="nis_exc_pessoa"/>
                </label>
            </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("form_fc_pessoa")
                form.submit()
            }
        })
    })
})

function voltarAoMenu() {
    window.history.back()
}

function imprimirPagina() {
    window.print()
}

function adicionarLinha() {
    var tabela = document.getElementById("tabela_membros");
    var novaLinha = tabela.insertRow(); // Adiciona uma nova linha ao final

    // Cria células para a nova linha
    var celula1 = novaLinha.insertCell(0);
    var celula2 = novaLinha.insertCell(1);
    var celula3 = novaLinha.insertCell(2);
    var celula4 = novaLinha.insertCell(3);
    var celula5 = novaLinha.insertCell(4);

    // Adiciona conteúdo às células
    celula1.innerHTML = '<span class="editable-field" contenteditable="true"></span>';
    celula2.innerHTML = '<span class="editable-field" contenteditable="true"></span>';
    celula3.innerHTML = '<span class="editable-field" contenteditable="true"></span>';
    celula4.innerHTML = 'R$ <span class="editable-field" contenteditable="true">,00</span>';
    celula5.innerHTML = '<button onclick="removerLinha(this)">X</button>';
}

function removerLinha(botao) {
    var linha = botao.parentNode.parentNode; // Encontra a linha do botão
    var tabela = linha.parentNode; // Encontra a tabela
    tabela.removeChild(linha); // Remove a linha
}

//função para apresentar dados da família na tela de registrar família
$('#codfamiliar').on('change', function () {
    consultarFamilia()
})

function consultarFamilia() {
    var codfam = $('#codfamiliar').val();

    $.ajax({
        type: 'POST',
        url: '/TechSUAS/controller/cadunico/parecer/busca_visita.php',
        data: {
            codfam: codfam
        },
        dataType: 'json',
        success: function (response) {
            if (response.encontrado){
                if (response.nome) {
                    $('#nome').text('NOME: ' + response.nome)
                    $('#titulo_tela').text('VISITA(S) REALIZADA(S):')
                } else {
                    $('#nome').text('O código familiar digitado não existe no banco de dados atual')
                }
                if (response.visitas) {
                var visitas = response.visitas
                var visitasHtml = ''
                
                visitas.forEach(function(visita) {
                    if (visita.acao == 1) {
                        var acao = "ATUALIZAÇÃO REALIZADA";
                    } else if (visita.acao == 2) {
                        var acao = "NÃO LOCALIZADO";
                    } else if (visita.acao == 3) {
                        var acao = "FALECIMENTO DO RESPONSÁVEL FAMILIAR";
                    } else if (visita.acao == 4) {
                        var acao = "A FAMÍLIA RECUSOU ATUALIZAR";
                    } else if (visita.acao == 5) {
                        var acao = "ATUALIZAÇÃO NÃO REALIZADA";
                    } else {
                        var acao = ""
                    }
                    visitasHtml += '<div class="visita">';
                    visitasHtml += '<span>Data da Visita: ' + visita.data + '</span><br>';
                    visitasHtml += '<span>Ação: ' + acao + '</span><br>';
                    visitasHtml += '<span>Entrevistador: ' + visita.entrevistador + '</span><br>';
                    visitasHtml += '</div><br>';
                })
                $('#data_visita').html(visitasHtml);
            } else if (response.data_visita) {
                $('#data_visita').text(response.data_visita);
            }

                /* $('#data_visita').text(response.data_visita)
                if (response.acao == 1) {
                    var acao = "ATUALIZAÇÃO REALIZADA";
                } else if (response.acao == 2) {
                    var acao = "NÃO LOCALIZADO";
                } else if (response.acao == 3) {
                    var acao = "FALECIMENTO DO RESPONSÁVEL FAMILIAR";
                } else if (response.acao == 4) {
                    var acao = "A FAMÍLIA RECUSOU ATUALIZAR";
                } else if (response.acao == 5) {
                    var acao = "ATUALIZAÇÃO NÃO REALIZADA";
                } else {
                    var acao = "!"
                }
                $('#acao').text(acao)
                $('#parecer_tec').text('Parecer do Entrevistador: ' + response.parecer_tec)
                $('#entrevistador').text('Entrevistador: ' + response.entrevistador)*/
            }
        }
    })
}

//função para salvar dados da visita a família
$(document).ready(function () {
    $('#imprimir_parecer').click(function () {
        //imprimirParecer()
    })
})

function imprimirParecer() {
    var dados = {
        id_visita: document.getElementById("id_visita").innerText,
        numero_parecer: document.getElementById("numero_parecer").innerText,
        ano_parecer: document.getElementById("ano_parecer").innerText,
        codigo_familiar: document.getElementById("codigo_familiar").innerText,
        data_entrevista: document.getElementById("data_entrevista").innerText,
        renda_per_capita: document.getElementById("renda_per_capita").innerText,
        localidade: document.getElementById("localidade").innerText,
        tipo: document.getElementById("tipo").innerText,
        titulo: document.getElementById("titulo").innerText,
        nome_logradouro: document.getElementById("nome_logradouro").innerText,
        numero_logradouro: document.getElementById("numero_logradouro").innerText,
        complemento_numero: document.getElementById("complemento_numero").innerText,
        complemento_adicional: document.getElementById("complemento_adicional").innerText,
        cep: document.getElementById("cep").innerText,
        referencia_localizacao: document.getElementById("referencia_localizacao").innerText,
        situacao: document.getElementById("situacao").innerText,
        resumo_visita: document.getElementById("resumo_visita").innerText
    }

    var membrosFamilia = []
    var membros = document.querySelectorAll('.parentesco')
    membros.forEach(function(membro, index) {
        var membroData = {
            parentesco: membro.innerText,
            nome_completo: document.querySelectorAll('.nome_completo')[index].innerText,
            nis: document.querySelectorAll('.nis')[index].innerText,
            data_nascimento: document.querySelectorAll('.data_nascimento')[index].innerText
        };
        membrosFamilia.push(membroData)
    });
    dados.membros_familia = membrosFamilia

    $.ajax({
        url: '/TechSUAS/controller/cadunico/parecer/salvar_dados_visita.php',
        type: 'POST',
        data: JSON.stringify(dados),
        contentType: 'application/json',
        success: function(response) {
            Swal.fire({
                icon: "success",
                title: "SALVO",
                text: "Dados salvos com sucesso!",
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/TechSUAS/views/cadunico/visitas/buscarvisita"
                }
            })
        },
        error: function(xhr, status, error) {
            console.error('Erro ao salvar os dados:', error)
            console.log('Resposta do servidor:', xhr.responseText)
        }
    });
}

function imprimirParecerPARTE() {
    window.print()

    setTimeout(function() {
    var dados = {
        id_visita: document.getElementById("id_visita").innerText,
        numero_parecer: document.getElementById("numero_parecer").innerText,
        ano_parecer: document.getElementById("ano_parecer").innerText,
        codigo_familiar: document.getElementById("codigo_familiar").innerText,
        data_entrevista: document.getElementById("data_entrevista").innerText,
        renda_per_capita: document.getElementById("renda_per_capita").innerText,
        localidade: document.getElementById("localidade").innerText,
        tipo: document.getElementById("tipo").innerText,
        titulo: document.getElementById("titulo").innerText,
        nome_logradouro: document.getElementById("nome_logradouro").innerText,
        numero_logradouro: document.getElementById("numero_logradouro").innerText,
        complemento_numero: document.getElementById("complemento_numero").innerText,
        complemento_adicional: document.getElementById("complemento_adicional").innerText,
        cep: document.getElementById("cep").innerText,
        referencia_localizacao: document.getElementById("referencia_localizacao").innerText,
        situacao: document.getElementById("situacao").innerText,
        resumo_visita: document.getElementById("resumo_visita").innerText
    }

    var membrosFamilia = []
    var membros = document.querySelectorAll('.parentesco')
    membros.forEach(function(membro, index) {
        var membroData = {
            parentesco: membro.innerText,
            nome_completo: document.querySelectorAll('.nome_completo')[index].innerText,
            nis: document.querySelectorAll('.nis')[index].innerText,
            data_nascimento: document.querySelectorAll('.data_nascimento')[index].innerText
        };
        membrosFamilia.push(membroData)
    });
    dados.membros_familia = membrosFamilia

    $.ajax({
        url: '/TechSUAS/controller/cadunico/parecer/salvar_dados_visita.php',
        type: 'POST',
        data: JSON.stringify(dados),
        contentType: 'application/json',
        success: function(response) {
            Swal.fire({
                icon: "success",
                title: "SALVO",
                text: "Dados salvos com sucesso!",
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                        window.location.href = "/TechSUAS/views/cadunico/visitas/buscarvisita";
                }
            })
        },
        error: function(xhr, status, error) {
            console.error('Erro ao salvar os dados:', error)
            console.log('Resposta do servidor:', xhr.responseText)
            }
        })
    }, 300)
}

/*
DECLARAÇÃO DE INSCRITO NO CADASTRO UNICO - FUNÇÕES PARA A TELA 

*/

$(document).ready(function () {
    $('#btn_dec_cad').click(function () {
        Swal.fire({
            title: "DECLARAÇÃO DO CADASTRO ÚNICO",
            html: `
            <p>É importante conferir as informações no CadÚnico e SIBEC para certificar-se da situação recente da família.</p>
            <h4>INFORME O CPF</h4>
            <form method="POST" action="dec_cadunico" id="form_familia">
                <label> CPF:
                    <input id="cpf_dec_cad" type="text" name="cpf_dec_cad"/>
                </label>
            </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                $('#cpf_dec_cad').mask('000.000.000-00')
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("form_familia")
                form.submit()
            }
        })
    })
})



function voltar() {
    window.location.href = "/TechSUAS/views/cadunico/declaracoes/index"
}

function printWithFields() {
    window.print()
}

/*
DESLIGAMENTO VOLUNTÁRIO - FUNÇÕES PARA A TELA
*/

$(document).ready(function () {
    $('#btn_des_vol').click(function () {
        Swal.fire({
            title: "DECLARAÇÃO DE DESLIGAMENTO VOLUNTÁRIO",
            html: `
            <h4>INFORME O CPF</h4>
            <form method="POST" action="desligamento_voluntario" id="form_familia">
                <label> CPF:
                    <input id="cpf_dec_cad" type="text" name="cpf_dec_cad"/>
                </label>
            </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                $('#cpf_dec_cad').mask('000.000.000-00')
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("form_familia")
                form.submit()
            }
        })
    })
})

/*
TROCA DE RF - FUNÇÕES PARA A TELA
*/

$(document).ready(function () {
    $('#btn_troca').click(function () {
        Swal.fire({
            title: "TROCA DE RF - C.E.F.",
            html: `
            <form method="POST" action="novo_rf_pbf" id="form_familia">
                    <h4>INFORME O NIS DO RF ANTERIOR</h4>                    
                <label>
                    <input id="nis_tc_old" type="text" name="nis_tc_old" maxlength="11" placeholder="NIS do antigo RF"/>
                </label><br><br><hr>
                    <h4>INFORME O NIS DO NOVO RF</h4>
                <label>
                    <input id="nis_tc_new" type="text" name="nis_tc_new" maxlength="11" placeholder="NIS do novo RF"/>
                </label>
            </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                $('#cpf_dec_cad').mask('000.000.000-00')
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("form_familia")
                form.submit()
            }
        })
    })
})

/*
ENCAMINHAMENTOS - FUNÇÕES PARA A TELA
*/

$(document).ready(function () {
    $('#btn_encamnhamento').click(function () {
        Swal.fire({
            title: "ENCAMINHAMENTOS",
            html: `
            <form method="POST" action="encaminhamento" id="form_familia">
            <h4>Por favor, preencha as informações abaixo</h4>
                <label>
                    CPF: <input id="cpf_dec_cad" type="text" name="cpf_dec_cad" placeholder="Digite o cpf aqui"/> 
                </label>
            </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar',
            didOpen: () => {
                $('#cpf_dec_cad').mask('000.000.000-00')
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("form_familia")
                form.submit()
            }
        })
    })
})