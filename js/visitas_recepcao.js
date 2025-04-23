
function visitas_recepcao() {
    Swal.fire({
        title: 'CADASTRO VISITAS',
        html: `
                <input id="codfam" type="text" name="codfam" placeholder="Digite o CPF aqui" onblur="validarCPF(this)"/> <br><br>
        `,
        showCancelButton: true,
        confirmButtonText: 'Buscar',
        cancelButtonText: 'Cancelar',
        didOpen : () => {
            $('#codfam').mask('000.000.000-00');
        }
    })
    .then((result) => {
        if (result.isConfirmed) {
            const cpf_pessoa = document.getElementById('codfam').value;
            var codfam = document.getElementById("codfam").value
            var codfam = codfam.replace(/\D/g, '') // Remove tudo que não for número
            var codfam = codfam.replace(/^0+/, '') // Remove zeros à esquerda
        
        $.ajax({
            url: "/TechSUAS/controller/recepcao/buscar_familia_visita.php",
            type: "POST",
            data: {codfam: codfam},
            dataType: "json",
            success: function(response) {
                if (response.encontrado) {
                    var table = ''
                    if (response.visitas.length === 0) {
                        table += `<p>Sem dados de visitas realizadas.</p>`
                    } else {
                        table += `
                    <table border="1" style="font-size: 12px;">
                    <tr>
                    <th>DATA DA VISITA</th>
                    <th>STATUS</th>
                    <th>PARECER</th>
                    </tr>
                    `
                    response.visitas.forEach(visita => {
                        table += `
                            <tr>
                                <td>${visita.edata}</td>
                                <td>${visita.status}</td>
                                <td>${visita.parecer_tec}</td>
                            </tr>
                        `
                    })
                }
                    Swal.fire({
                        html: `
                        <p style="font-size: 12px;"><strong>Essa pessoa tem cadastro com o código ${response.codfam}.</strong></p>
                        <ul>
                        <li>Nome: ${response.nome}</li>
                        <li style="text-align: justify;">Endereço: <span class="editable-field" contenteditable="true">${response.endereco}</span></li>
                        </ul>
                        <input type="hidden" id="codfam" value="${codfam}">
                        <textarea name="obs" id="obs" placeholder="Descreva a situação" style="width: 90%;"></textarea>

                        ${table}

                        `,
                        customClass: {
                            popup: 'animated',
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Salvar',
                        cancelButtonText: 'Cancelar',                
                    })
                    .then((result1) => {
                        if (result1.isConfirmed) {
                            var cod_familiar = document.getElementById('codfam').value
                            var endereco = document.querySelector('.editable-field').textContent
                            var obs = document.getElementById('obs').value
                            $.ajax({
                                url: "/TechSUAS/controller/recepcao/salva_visita.php",
                                type: "POST",
                                data: {
                                    codfam: cod_familiar,
                                    endereco: endereco,
                                    nome_: response.nome,
                                    obs: obs
                                    
                                },
                                dataType: "json",
                                success: function(response) {
                                    if (response.salvo) {
                                        Swal.fire("Salvo com sucesso!", "", "success")
                                    } else {
                                        Swal.fire("Erro ao salvar!", response.erro, "error")
                                    }
                                }
                            })
                        } else {
                            Swal.fire("Operação cancelada", "", "info")
                        }
                    })
                } else {
                    Swal.fire({
                        title: `Não foi possível encontrar o CPF: ${cpf_pessoa}`,
                        html:`
                            <input class="menu-sem" type="text" id="nome_rf" placeholder="Nome completo:"/>
                            <input class="menu-sem" type="hidden" id="codfam" value="${codfam}"/>
                            <input class="menu-sem" type="text" id="endereco" placeholder="Endereço: detalhe ao máximo, proximidades e apelidos"/>
                            <textarea name="obs" id="obs" placeholder="Descreva a situação" style="width: 90%;"></textarea>
                        `,
                        customClass: {
                            popup: 'animated',
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Salvar',
                        cancelButtonText: 'Cancelar', 
                        })
                        .then((result1) => {
                            if (result1.isConfirmed) {
                                var cod_familiar = document.getElementById('codfam').value
                                var nomeRF = document.getElementById('nome_rf').value
                                var endereco = document.getElementById('endereco').value
                                var obs = document.getElementById('obs').value
                                //console.log(`${cod_familiar} - ${nomeRF} - ${endereco} - ${obs} - `)
                                $.ajax({
                                    url: "/TechSUAS/controller/recepcao/salva_visita.php",
                                    type: "POST",
                                    data: {
                                        codfam: cod_familiar,
                                        endereco: endereco,
                                        nome_: nomeRF,
                                        obs: obs
                                        
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        if (response.salvo) {
                                            Swal.fire("Salvo com sucesso!", "", "success")
                                        } else {
                                            Swal.fire("Erro ao salvar!", response.erro, "error")
                                        }
                                    }
                                })
                            } else {
                                Swal.fire("Operação cancelada", "", "info")
                            }
                        })

                }
            }
        })
        } else {
            Swal.fire({
                title: 'Solicitação cancelada.',
                icon: 'warning',
            })
        }
    })
}