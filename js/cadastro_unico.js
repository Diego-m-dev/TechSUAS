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
