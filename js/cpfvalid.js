document.addEventListener("DOMContentLoaded", function () {
    var cpfInput = $("#cpf");
    var telefoneInput = $("#telefone");

    // Aplicar máscara para CPF
    cpfInput.mask('000.000.000-00');

    // Aplicar máscara para telefone (se necessário)
    telefoneInput.mask('(00) 0 0000-0000');
});

function formatarCPF(cpf) {
    // Remove caracteres especiais (pontos e traços)
    var cpfFormatado = cpf.replace(/[^\d]+/g, '');

    // Remove o zero à frente, se existir
    cpfFormatado = cpfFormatado.replace(/^0+/, '');

    // Adiciona a máscara
    cpfFormatado = cpfFormatado.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');

    return cpfFormatado;
}

function _cpf(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (!cpf) { // Se o CPF estiver vazio, retorna como válido
        return true;
    }
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    add = 0;
    for (i = 0; i < 9; i++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    add = 0;
    for (i = 0; i < 10; i++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

function validarCPF(el) {
    if (!_cpf(el.value)) {
        Swal.fire({
            icon: 'error',
            title: 'CPF Inválido',
            text: 'Por favor, insira um CPF válido!',
            confirmButtonText: 'OK'
        });

        // Apaga o valor
        el.value = "";
    }
}
