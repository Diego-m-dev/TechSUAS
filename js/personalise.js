    function sempre_maiusculo(elemento) {
    // Converte o texto do campo para maiúsculas
    elemento.value = elemento.value.toUpperCase();
    }

    function iniciarEdicao(campo) {
        // Oculta a visualização e exibe o campo de edição
        document.getElementById(campo + 'Visual').style.display = 'none';
        document.getElementById(campo + 'Edicao').style.display = 'block';
    }