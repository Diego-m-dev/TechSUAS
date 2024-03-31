$(document).ready(function () {
    $('#tabelaItens').on('input', '.quantidade, .valor-unitario', function () {
        calcularValorTotal($(this).closest('tr'));
    });

    $('#contatoInput').on('input', function (event) {
        formatarContato(event.target);
    });

    $('#cnpjInput').on('input', function (event) {
        formatarCNPJ(event.target);
    });
});

$(document).ready(function () {
    $('#btn_salva_contrato').click(function () {
        $('#form_itens').show()
        $('#btn_salva_contrato').hide()
        $('#form_contrato').hide()
        $('#voltar1').hide()
    })
})

function calcularValorTotal(linha) {
    const quantidade = parseFloat(linha.find('.quantidade').val()) || 0;
    const valorUnitario = parseFloat(linha.find('.valor-unitario').val()) || 0;
    const valorTotal = quantidade * valorUnitario;

    linha.find('.valor-total').val(valorTotal.toFixed(2));
}

function formatarContato(input) {
    let contato = input.value.replace(/\D/g, '');

    if (contato.length > 0) {
        contato = contato.substring(0, 0) + '(' + contato.substring(0);
    }
    if (contato.length > 3) {
        contato = contato.substring(0, 3) + ') ' + contato.substring(3);
    }
    if (contato.length > 6) {
        contato = contato.substring(0, 6) + ' ' + contato.substring(6);
    }
    if (contato.length > 11) {
        contato = contato.substring(0, 11) + '-' + contato.substring(11);
    }

    input.value = contato;
}

function formatarCNPJ(input) {
    let cnpj = input.value.replace(/\D/g, '');

    if (cnpj.length > 2) {
        cnpj = cnpj.substring(0, 2) + '.' + cnpj.substring(2);
    }
    if (cnpj.length > 6) {
        cnpj = cnpj.substring(0, 6) + '.' + cnpj.substring(6);
    }
    if (cnpj.length > 10) {
        cnpj = cnpj.substring(0, 10) + '/' + cnpj.substring(10);
    }
    if (cnpj.length > 15) {
        cnpj = cnpj.substring(0, 15) + '-' + cnpj.substring(15);
    }

    input.value = cnpj;
}

function adicionarLinha() {
    const tabelaItens = $('#tabelaItens');

    const novaLinha = $('<tr>' +
        '<td><input type="text" name="num_item[]"></td>' +
        '<td><input type="text" name="nome_produto[]"></td>' +
        '<td><input type="text" name="quantidade[]" class="quantidade"></td>' +
        '<td><input type="text" name="valor_unitario[]" class="valor-unitario"></td>' +
        '<td><input type="text" name="valor_total[]" class="valor-total" readonly></td>' +
        '</tr>');

    // Limpar os valores dos campos na nova linha
    novaLinha.find('input').val('');

    // Adicionar a nova linha à tabela
    tabelaItens.append(novaLinha);
}


document.addEventListener('DOMContentLoaded', function () {
    // Obtém todos os campos de entrada de texto
    var camposTexto = document.querySelectorAll('input[type="text"]');

    // Adiciona um ouvinte de eventos de entrada a cada campo de texto
    camposTexto.forEach(function (campo) {
        campo.addEventListener('input', function () {
            // Converte o valor do campo para maiúsculas
            this.value = this.value.toUpperCase();
        });
    });
});

$(document).ready(function () {
    $('#btn_pedido_itens').click(function () {
        Swal.fire({
            icon: 'library',
            html: 
            `
            <h2>FAZENDO PEDIDO</h2>
            <label>Código:</label>
            <input type='text' id='cod_iten'/><br>
            <label>Quantidade:</label>
            <input type='text' id='quantidade'/><br>
            <label>Valor Unitário:</label>
            <input type='text' id='valor_uni'/><br>

            `
        }).then((result) => {
            if(result.isConfirmed){
                var cod_iten = $('#cod_iten').val()
                var quantidade = $('#quantidade').val()
                var valor_uni = $('#valor_uni').val()

                $.ajax({
                    type: 'POST',
                    url: '/Suas-Tech/suas/controller/pedidos.php',
                    data: {
                        cod_iten: cod_iten,
                        quantidade: quantidade,
                        valor_uni: valor_uni
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.encontrado) {
                            
                        }
                    }
                })
            }
        })
    })
})