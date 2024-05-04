$(document).ready(function () {
    $('#simples').hide()
    $('#beneficio').hide()
    $('#btn_familia').click(function () {
        $('#simples').show()
        $('#beneficio').hide()
    })
    $('#btn_benef').click(function () {
        $('#beneficio').show()
        $('#simples').hide()
    })


})

$(document).ready(function () {
    $('#btn_residencia').click(function () {
        Swal.fire({
            title: "TERMO DE RESPONSABILIDADE",
            html: `
            <h4>INFORME O CPF</h4>
            <form method="POST" action="termo_responsabilidade" id="form_residencia">
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
                const form = document.getElementById("form_residencia")
                form.submit()
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

})


function voltarAoMenu() {
    window.location.href = '/TechSUAS/config/back'
}

function imprimirPagina() {
    window.print()
}