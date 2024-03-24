document.addEventListener("DOMContentLoaded", function () {
    var cpfInput = $("#cpf")
    var telefoneInput = $("#telefone")
    // Aplicar máscara para CPF
    cpfInput.mask('000.000.000-00')
    //Aplica máscara para o telefone
    telefoneInput.mask('(00) 0.0000-0000')
});


$(document).ready(function() {
    $('#btn_imprimir').click(function() {
        var idHist = $(this).attr('name');

        $.ajax({
            type: 'POST',
            url: '/Suas-Tech/concessao/controller/print_conc.php',
            data: { id_hist: idHist },
            dataType: 'json', // Espera uma resposta JSON do servidor
            success: function (response) {
                if (response.encontrado) {
                    $('#conteiner_hide').hide()
                    $('#conteiner_show').show()
                    $('#num_form').text('Formulário: ' + response.num_form + '/' + response.ano_form)
                    $('#nome_resp').text(response.nome_resp)
                    $('#naturalidade_resp').text(response.naturalidade_resp)
                    $('#nome_m').text(response.nome_m)
                    $('#contato').text(response.contato)
                    $('#cpf_pessoa').text('CPF: ' + response.cpf_resp)
                    $('#tet_ili').text('T.E.: ' + response.tit_eleitor_pessoa)
                    $('#rg_pessoa').text('RG: ' + response.rg_pessoa)
                    $('#nis_pessoa').text('NIS: ' + response.nis_pessoa)
                    $('#nome_benef').text(response.nome_benef)
                    $('#munic_nasc').text(response.munic_nasc)
                    $('#nom_mae_pessoa').text(response.nom_mae_pessoa)
                    $('#renda_media').text(response.renda_media)
                    $('#endereco_conc').text(response.endereco)
                    $('#cpf_pessoa_b').text('CPF: ' + response.cpf_pessoa_b)
                    $('#tet_ili_b').text('T.E.: ' + response.tet_ili_b)
                    $('#rg_pessoa_b').text('RG: ' + response.rg_pessoa_b)
                    $('#nis_pessoa_b').text('NIS: ' + response.nis_pessoa_b)
                    $('#parentes').text('QUAL PARENTESCO O RESPONSÁVEL TEM COM O BENEFICIÁRIO?: ' + response.parentes)
                    $('#nome_item').text(response.nome_item)
                    $('#descricao').text(response.nome_item)
                    $('#qtd_item').text(response.qtd_item)
                    $('#valor_uni').text(response.valor_uni)
                    $('#valor_total').text(response.valor_total)
                    $('#local_data').text('São Bento do Una - PE ____ de _____________ de ' + response.local_data)
                    window.print()

                    setTimeout(function() {
                        window.location.href = '/Suas-Tech/concessao/index'
                    }, 300)
                } else {
                    console.error(response.error)
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Lida com erros, se houver
                console.error("AJAX Request Failed: " + textStatus, errorThrown)
            }
        });
        $('#css_link').attr('href', '../css/style_impr_form.css')
    });
});

/*

$(document).ready(function () {
    //função calcula total
    function calcularTotal() {
        // loop para cada llinha
        $("#tabelaItens tbody tr").each(function () {
            // recebe a quantidade unitária
            var quantidade = parseFloat($(this).find(".quantidade").val()) || 0;
            var valorUnitario = parseFloat($(this).find(".valor-unitario").val().replace(",", ".")) || 0;

            // calcula total e formata moeda
            var total = quantidade * valorUnitario;
            $(this).find(".valor-total").val(total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
        });
    }

    // Attach the function to input change events
    $(".quantidade, .valor-unitario").on("input", calcularTotal);
});
*/

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
