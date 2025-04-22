$(document).ready(function () {
    const cpfInput = $('#cpf_acao_cadu')
    //cpfInput.focus()

    // Captura todos os botões do teclado numérico
    $('.btn_teclas').on('click', function (r) {
        r.preventDefault() // Evita o comportamento padrão do botão
        const valor = $(this).text() // Pega o número do botão clicado

        if ($(this).attr('id') === 'backspace') {
            let atual = cpfInput.val().replace(/\D/g, '').slice(0, -1) // Remove último dígito e tudo não numérico
            cpfInput.val(formatarCPF(atual))
        } else {
            let atual = cpfInput.val().replace(/\D/g, '') + valor // Remove máscara antes de adicionar
            if (atual.length > 11) return // Limita a 11 dígitos
            cpfInput.val(formatarCPF(atual))
        }
        
          cpfInput.trigger('keyup') // Para validar
    })

})

function formatarCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    cpf = cpf.slice(0, 11); // Limita a 11 números
    return cpf
      .replace(/(\d{3})(\d)/, '$1.$2')
      .replace(/(\d{3})(\d)/, '$1.$2')
      .replace(/(\d{3})(\d{1,2})$/, '$1-$2')
}

// Validação de CPF
function validarCPF(input) {
    var cpf = input.val().replace(/\D/g, '');

    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
        animarErro(input);
        Swal.fire('CPF inválido!');
        return false;
    }

    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }

    let resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(9))) {
        animarErro(input);
        Swal.fire('CPF inválido!');
        return false;
    }

    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }

    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(10))) {
        animarErro(input);
        Swal.fire('CPF inválido!');
        return false;
    }

    return true;
}

function animarErro(input) {
    input.addClass('input-invalido');
    setTimeout(() => {
        input.removeClass('input-invalido');
    }, 500);
}


// Quando termina de digitar, valida
function consultar_cpf() {
    const cpfInput = $('#cpf_acao_cadu');
    let programaSelecionado = '';

    if (cpfInput.val().length === 14) {
        const cpfValido = validarCPF(cpfInput);

        if (!cpfValido) return;

        const secao1 = document.getElementById('secao1');
        const secao2 = document.getElementById('secao2');
        const secao3 = document.getElementById('secao3');

        // Transição seção 1 → 2
        secao1.style.transition = 'opacity 0.5s ease';
        secao1.style.opacity = '0';

        setTimeout(() => {
            secao1.style.display = 'none';
            secao2.style.display = 'block';
            secao2.style.opacity = '0';

            setTimeout(() => {
                secao2.style.transition = 'opacity 0.5s ease';
                secao2.style.opacity = '1';
            }, 100);
        }, 500);

        // ✅ Definir programa e avançar corretamente para seção 3
        document.getElementById('cadunico').onclick = () => {
            programaSelecionado = 'CADUNICO';
            avancarParaSecao3();
        };

        document.getElementById('bolsafamilia').onclick = () => {
            programaSelecionado = 'BOLSA FAMÍLIA';
            avancarParaSecao3();
        };

        // ✅ Botões de tipo de atendimento
        document.getElementById('prioridade').onclick = () => {
            avancarParaSecao4(programaSelecionado, 'PRIORIDADE');
        };

        document.getElementById('comum').onclick = () => {
            avancarParaSecao4(programaSelecionado, 'COMUM');
        };
    }

    function avancarParaSecao3() {
        const secao2 = document.getElementById('secao2');
        const secao3 = document.getElementById('secao3');

        secao2.style.transition = 'opacity 0.5s ease';
        secao2.style.opacity = '0';

        setTimeout(() => {
            secao2.style.display = 'none';
            secao3.style.display = 'block';
            secao3.style.opacity = '0';

            setTimeout(() => {
                secao3.style.transition = 'opacity 0.5s ease';
                secao3.style.opacity = '1';
            }, 100);
        }, 500);
    }

    function avancarParaSecao4(tipoPrograma, tipoAtendimento) {
        const secao3 = document.getElementById('secao3')
        const secao4 = document.getElementById('secao4')

        secao3.style.transition = 'opacity 0.5s ease'
        secao3.style.opacity = '0'

        setTimeout(() => {
            secao3.style.display = 'none'
            secao4.style.display = 'block'
            secao4.style.opacity = '0'

            setTimeout(() => {
                secao4.style.transition = 'opacity 0.5s ease'
                secao4.style.opacity = '1'
            }, 100)
        }, 500)

        // Envio para o backend
        cpf_limpo = $('#cpf_acao_cadu').val()
        cpf_limpo = cpf_limpo.replace(/\D/g, '')
        cpfLimpo = cpf_limpo.replace(/^0+/, '')

        const dadosAtendimento = {
            cpf: cpfLimpo,
            programa: tipoPrograma,
            tipo: tipoAtendimento
        }

        $.ajax({
            url: '/TechSUAS/acao_cadu/salvar_dados.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(dadosAtendimento),
            success: function (resposta) {
                if (resposta.status === 'sucesso') {
                    document.getElementById('senha_resultado').innerText = resposta.senha
                } else {
                    Swal.fire('Erro!', resposta.mensagem, 'error')
                }
            },
            error: function () {
                Swal.fire('Erro de conexão!', 'Tente novamente.', 'error')
                    .then((resultado) => {
                        if (resultado.isConfirmed) {
                            window.location.href = '/TechSUAS/acao_cadu/index.php'
                        }
                    });
            }
        });
    }

    document.getElementById('btnImprimir').onclick = () => {
        location.reload()
    };
}


