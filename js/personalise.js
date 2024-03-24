function sempre_maiusculo(elemento) {
    // Converte o texto do campo para maiúsculas
    elemento.value = elemento.value.toUpperCase();
    }

    function iniciarEdicao(campo) {
        // Oculta a visualização e exibe o campo de edição
        document.getElementById(campo + 'Visual').style.display = 'none';
        document.getElementById(campo + 'Edicao').style.display = 'block';
    }
    


    document.getElementById('selecionarTodos').addEventListener('click', function (){
        // Obter todos os checkboxes na tabela
        var checkBoxes = document.querySelectorAll('input[name="excluir[]"]')

        checkBoxes.forEach(function(checkbox){
            checkbox.checked = document.getElementById('selecionarTodos').checked
        })
    })

function printerVisitas(){
        var nis_para_print = []

        $('input[name="excluir[]"]:checked').each(function (){
            nis_para_print.push($(this).val())
        })
        if (nis_para_print.length > 0) {
            $.ajax({
                url:'/Suas-Tech/cadunico/controller/parecer/print_visit.php',
                method: 'POST',
                data: {nis_para_print: nis_para_print},
                dataType: 'json',
                success: function(response){
                    if(response.printer){
                        $('#paraPrint').text(response.corpo);
                    } else {
                        console.error('Erro no servidor: ' + response.mensagem);
                    }
                },
                error: function (error) {
                    console.error('Erro ao enviar dados: ' + error);
                }
            })
        } else {
        alert('Nenhum NIS selecionado para impressão.');
        }
}