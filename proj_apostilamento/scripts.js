document.getElementById('valor_total').addEventListener('blur', function() {
    let valor = this.value;
    valor = valor.replace(/[^\d,.-]/g, '');
    valor = parseFloat(valor.replace(',', '.')).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
    this.value = valor;
});

document.getElementById('valor_anular').addEventListener('blur', function() {
    let valor = this.value;
    valor = valor.replace(/[^\d,.-]/g, '');
    valor = parseFloat(valor.replace(',', '.')).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
    this.value = valor;
});

document.getElementById('valor_suplementar').addEventListener('blur', function() {
    let valor = this.value;
    valor = valor.replace(/[^\d,.-]/g, '');
    valor = parseFloat(valor.replace(',', '.')).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
    this.value = valor;
});

document.getElementById('numero_contrato').addEventListener('keypress', function(e) {
    if (e.key !== '/' && (e.key < '0' || e.key > '9')) {
        e.preventDefault();
    }

    if (e.key === '/') {
        let inputValue = e.target.value;
        let slashIndex = inputValue.indexOf('/');
        if (slashIndex !== -1 && inputValue.length - slashIndex > 4) {
            e.preventDefault();
        }
    }
});


document.getElementById('add-divs-btn').addEventListener('click', function() {
    // Cria novas divs Anular e Suplementar
    const container = document.getElementById('anular-suplementar-container');

    const divAnular = document.createElement('div');
    divAnular.classList.add('anular');

    const divSuplementar = document.createElement('div');
    divSuplementar.classList.add('suplementar');

    // Copia os elementos existentes para as novas divs
    const anularDiv = container.querySelector('.anular');
    const suplementarDiv = container.querySelector('.suplementar');

    const newAnularInput = anularDiv.querySelector('.valor_anular').cloneNode(true);
    const newSuplementarInput = suplementarDiv.querySelector('.valor_suplementar').cloneNode(true);
    const newAnularSelect = anularDiv.querySelector('.select-anular').cloneNode(true);
    const newSuplementarSelect = suplementarDiv.querySelector('.select-suplementar').cloneNode(true);

    divAnular.appendChild(newAnularInput);
    divAnular.appendChild(newAnularSelect);

    divSuplementar.appendChild(newSuplementarInput);
    divSuplementar.appendChild(newSuplementarSelect);

    container.appendChild(divAnular);
    container.appendChild(divSuplementar);
}); 