function Cadastrar() {
    Swal.fire({
        title: 'Cadastrar',
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
            var codfam = document.getElementById("codfam").value
            const palmiro = codfam
            codfam = codfam.replace(/\D/g, '') // Remove tudo que não for número
            codfam = parseInt(codfam, 10).toString() // Remove zeros à esquerda


                $.ajax({
                    //url: 'https://api.mocki.io/v1/5c5a7e0f',
                    url: '/TechSUAS/peixe/logado/busca_dados_fam.php',
                    type: 'POST',
                    data: {codfam: codfam},
                    dataType: 'json',
                    success: function(response) {
                            let cpfInformado = codfam
                        if (response.encontrado === true) {
                            let tabela = `
                <style>
                    .familia-table {
                        width: 90%;
                        border-collapse: collapse;
                        margin-top: 10px;
                        border-radius: 5px;
                    }

                    .familia-table tr:hover {
                        background:rgb(220, 220, 250);
                    }
                    .familia-table th, .familia-table td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                
                    td {
                        font-size: 16px;
                    }
                    .familia-table th {
                        background-color: #13294b;
                        color: white;
                    }
                    
                    .cpf-destacado {
                        font-weight: bold;
                    }
                    .responsavel {
                        color:rgb(13, 38, 228);
                        
                        font-weight: bold;
                    }
                </style>

                <table class="familia-table" border="1">
                    <tr>
                        <th>Nome</th>
                        <th>Parentesco</th>
                        <th>NIS</th>
                    </tr>`

                    response.dados_familia.forEach(pessoas => {
                        let cpfDestaque = pessoas.cpf_pessoa === cpfInformado ? 'cpf-destacado' : ''
                        let responsavel = pessoas.parentesco === 'RESPONSAVEL FAMILIAR' ? 'responsavel' : ''
                                                 

                        tabela += `
                        <tr class="${responsavel}">
                        <td style="background-color: #ffffff">${pessoas.nome}</td>
                        <td style="background-color: #ffffff">${pessoas.parentesco}</td>
                        <td style="background-color: #ffffff" class="${cpfDestaque}">${pessoas.nis_atual}</td>
                        <tr>
                        `
                    })
                    let talao = response.codigo_talao == 'X' ? `
                    <p class="paragr">Nenhum talão encontrado para está família.</p>

                        <input type="hidden" id="cpf_valido" value="${cpfInformado}"/>
                        <input type="hidden" id="nome_pessoa" value="${response.nome_pessoa}"/>
                        <input type="hidden" id="cod_famil" value="${response.codigo_fam}"/>
                        <input type="hidden" id="bpc" value="${response.bpc}"/>

                            <input type="text" id="cod_talao" placeholder="Código do Talão" />
                            
                                <select id="entrega" class="form-select" name="entrega" autocomplete="off" required>
                                    <option value="" data-default disabled selected> Selecione o local que vai receber o Peixe</option>
                                    <option value="ACUDE NOVO">AÇUDE NOVO</option>
                                    <option value="ARMAZEM">ARMAZEM</option>
                                    <option value="ARRANCACAO">ARRANCAÇÃO</option>
                                    <option value="BASILIO">BASILIO</option>
                                    <option value="BATALHA">BATALHA</option>
                                    <option value="BAIXA">BAIXA</option>
                                    <option value="BARRO BRANCO">BARRO BRANCO</option>
                                    <option value="CAIBRAS">CAIBRAS</option>
                                    <option value="CAIANA">CAIANA</option>
                                    <option value="CALDEIRAOZINHO">CALDEIRAOZINHO</option>
                                    <option value="CALUMBI">CALUMBI</option>
                                    <option value="CRAS ANTONIO MATIAS">CRAS - ANTONIO MATIAS</option>
                                    <option value="CRAS SANTO AFONSO">CRAS - SANTO AFONSO</option>
                                    <option value="ESPIRITO SANTO">ESPIRITO SANTO</option>
                                    <option value="FURNAS">FURNAS</option>
                                    <option value="GAMA">GAMA</option>
                                    <option value="GRAVATA">GRAVATÁ</option>
                                    <option value="IMPUEIRA">IMPUEIRA</option>
                                    <option value="JURUBEBA">JURUBEBA</option>
                                    <option value="MANICOBA SOARES">MANICOBA SOARES</option>
                                    <option value="MILHO BRANCO">MILHO BRANCO</option
                                    <option value="MINADOR">MINADOR</option>
                                    <option value="MONICA BRAGA">MONICA BRAGA</option>
                                    <option value="ODETE COSTA">ODETE COSTA</option>
                                    <option value="PASSAGEM">PASSAGEM</option>
                                    <option value="PAULO CORDEIRO">PAULO CORDEIRO</option>
                                    <option value="PIMENTA">PIMENTA</option>
                                    <option value="POCO COMPRIDO">POÇO COMPRIDO</option>
                                    <option value="POCO DOCE">POÇO DOCE</option>
                                    <option value="PRIMAVERA">PRIMAVERA</option>
                                    <option value="QUEIMADA GRANDE">QUEIMADA GRANDE</option>
                                    <option value="RIACHO DA PORTEIRAS">RIACHO DAS PORTEIRAS</option>
                                    <option value="SEDE">SECRETARIA DE ASSISTÊNCIA SOCIAL</option>
                                    <option value="SERRA VERDE">SERRA VERDE</option>
                                    <option value="SERROTE">SERROTE</option>
                                    <option value="SODRE">SODRE</option>
                                    <option value="TAMANDUA">TAMANDUA</option>
                                    <option value="UNA DO SIMAO">UNA DO SIMAO</option>
                                    <option value="ZE BENTO">ZE BENTO</option>
                                </select>

                    ` : `A família já foi cadastrado no talão <strong> ${response.codigo_talao}</strong>.`
                    tabela += `</table>`

                    Swal.fire({
                        title: 'Dados da Família',
                        html: `
                            <p>Data Atualização: <strong>${response.data_entrevista}</strong></p>
                        `
                        + tabela + talao,
                        customClass: {
                            popup: 'swal2-wide' // Aplica a classe personalizada
                        },
                        didOpen: () => {
                            $('#cod_talao').mask('0000')

                        },
                        preConfirm: () => {
                            var ab = document.getElementById('cod_talao') ? document.getElementById('cod_talao').value : null
                            var ba = document.getElementById('entrega') ? document.getElementById('entrega').value : null

                            if (ab === null && ba === null) {
                                return true
                            }

                            if (!ab) {
                                Swal.showValidationMessage('O código do talão é obrigatório')
                                return false
                            }
                            if (!ba) {
                                Swal.showValidationMessage('É obrigatório selecionar o local de entrega')
                                return false
                            }

                            return {
                                ab, ba
                            }
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Confirmar',
                        cancelButtonText: 'Cancelar'
                    }).then((result1) => {
                        if (result1.isConfirmed) {
                            let {ab, ba} = result1.value;
                            const codTalao = ab
                            const cpf_valido = document.getElementById('cpf_valido').value
                            const nome_pessoa = document.getElementById('nome_pessoa').value
                            const cod_famil = document.getElementById('cod_famil').value
                            const bpc = document.getElementById('bpc').value
                            const entrega = ba

                            $.ajax ({
                                type: 'POST',
                                url: '/TechSUAS/peixe/logado/save_new.php',
                                data: {
                                    cod_talao: codTalao,
                                    cpf_valido: cpf_valido,
                                    nome_pessoa: nome_pessoa,
                                    codfam: cod_famil,
                                    entrega: entrega,
                                    bpc: bpc
                                },
                                dataType: 'json',
                                success: function(salvo) {
                                    if (salvo.salvo) {
                                        Swal.fire(salvo.msg, "", "success")
                                        .then((ok) => {
                                            if (ok.isConfirmed) {
                                                window.location.reload()                                                
                                            } else {
                                                window.location.reload()
                                            }
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            html: `<p>${salvo.msg}, certifique de preencher o talão após digitar no sistema</p><p>Caso tenha entregue equivocadamente, entre em contato com o suporte do sistema</p>`,
                                        })
                                        .then((dor) => {
                                            if (dor.isConfirmed) {
                                                    window.location.reload()
                                                } else {
                                                    window.location.reload()
                                                }
                                        })
                                    }
                                }
                            })
                        } else {
                            Swal.fire('Ação cancelada', '', 'info')
                        }
                    })
                        } else if (response.encontrado === false && response.bpc === 'S') {
                            let talao_bpc = response.bpc_talao === 'X' ?
                                `
                                    <p>Famílias que recebem o BPC tem direito ao programa de Distribuição de Peixe na Semana Santa</p>
                                    <p>Para garantir que essa família receba o peixe, é necessário que você preencha às informações abaixo.</p>

                                    <p>NOME DO BENEFICIÁRIO: ${response.bpc_nome}</p>

                            <input type="text" id="cod_talao" placeholder="Código do Talão" />

                                <select id="entrega" class="form-select" name="entrega" autocomplete="off" required>
                                    <option value="" data-default disabled selected> Selecione o local que vai receber o Peixe</option>
                                    <option value="ACUDE NOVO">AÇUDE NOVO</option>
                                    <option value="ARMAZEM">ARMAZEM</option>
                                    <option value="ARRANCACAO">ARRANCAÇÃO</option>
                                    <option value="BASILIO">BASILIO</option>
                                    <option value="BATALHA">BATALHA</option>
                                    <option value="BAIXA">BAIXA</option>
                                    <option value="BARRO BRANCO">BARRO BRANCO</option>
                                    <option value="CAIBRAS">CAIBRAS</option>
                                    <option value="CAIANA">CAIANA</option>
                                    <option value="CALDEIRAOZINHO">CALDEIRAOZINHO</option>
                                    <option value="CALUMBI">CALUMBI</option>
                                    <option value="CRAS ANTONIO MATIAS">CRAS - ANTONIO MATIAS</option>
                                    <option value="CRAS SANTO AFONSO">CRAS - SANTO AFONSO</option>
                                    <option value="ESPIRITO SANTO">ESPIRITO SANTO</option>
                                    <option value="FURNAS">FURNAS</option>
                                    <option value="GAMA">GAMA</option>
                                    <option value="GRAVATA">GRAVATÁ</option>
                                    <option value="IMPUEIRA">IMPUEIRA</option>
                                    <option value="JURUBEBA">JURUBEBA</option>
                                    <option value="MANICOBA SOARES">MANICOBA SOARES</option>
                                    <option value="MILHO BRANCO">MILHO BRANCO</option
                                    <option value="MINADOR">MINADOR</option>
                                    <option value="MONICA BRAGA">MONICA BRAGA</option>
                                    <option value="ODETE COSTA">ODETE COSTA</option>
                                    <option value="PASSAGEM">PASSAGEM</option>
                                    <option value="PAULO CORDEIRO">PAULO CORDEIRO</option>
                                    <option value="PIMENTA">PIMENTA</option>
                                    <option value="POCO COMPRIDO">POÇO COMPRIDO</option>
                                    <option value="POCO DOCE">POÇO DOCE</option>
                                    <option value="PRIMAVERA">PRIMAVERA</option>
                                    <option value="QUEIMADA GRANDE">QUEIMADA GRANDE</option>
                                    <option value="RIACHO DA PORTEIRAS">RIACHO DAS PORTEIRAS</option>
                                    <option value="SEDE">SECRETARIA DE ASSISTÊNCIA SOCIAL</option>
                                    <option value="SERRA VERDE">SERRA VERDE</option>
                                    <option value="SERROTE">SERROTE</option>
                                    <option value="SODRE">SODRE</option>
                                    <option value="TAMANDUA">TAMANDUA</option>
                                    <option value="UNA DO SIMAO">UNA DO SIMAO</option>
                                    <option value="ZE BENTO">ZE BENTO</option>
                                </select>

                        <input type="hidden" id="cpf_valido" value="${palmiro}"/><br>
                        <input type="hidden" id="nome_pessoa" value="${response.bpc_nome}"/><br>
                        <input type="hidden" id="cod_famil" value="${response.bpc_numero}"/><br>
                        <input type="hidden" id="bpc" value="${response.bpc}"/>

                            `: `A família já foi cadastrado no talão <strong> ${response.bpc_talao}</strong>.`
                            Swal.fire({
                                title: 'FAMÍLIA SEM CADÚNICO, MAS COM BPC',
                                html: talao_bpc,
                                customClass: {
                                    popup: 'animated',
                                },
                                preConfirm: () => {
                                    var ab = document.getElementById('cod_talao') ? document.getElementById('cod_talao').value : null
                                    var ba = document.getElementById('entrega') ? document.getElementById('entrega').value : null
        
                                    if (ab === null && ba === null) {
                                        return true
                                    }
        
                                    if (!ab) {
                                        Swal.showValidationMessage('O código do talão é obrigatório')
                                        return false
                                    }
                                    if (!ba) {
                                        Swal.showValidationMessage('É obrigatório selecionar o local de entrega')
                                        return false
                                    }
        
                                    return {
                                        ab, ba
                                    }
                                },
                                showCancelButton: true,
                                confirmButtonText: 'Confirmar',
                                cancelButtonText: 'Cancelar'
                            }).then((result1) => {
                                if (result1.isConfirmed) {
                                    let {ab, ba} = result1.value;
                                    const codTalao = ab
                                    var cpf_valido = document.getElementById('cpf_valido').value
                                        cpf_valido = cpf_valido.replace(/\D/g, '') // Remove tudo que não for número
                                        cpf_valido = parseInt(cpf_valido, 10).toString() // Remove zeros à esquerda
                        
                                    const nome_pessoa = document.getElementById('nome_pessoa').value
                                    const cod_famil = document.getElementById('cod_famil').value
                                    const bpc = document.getElementById('bpc').value
                                    const entrega = ba
        
                                    $.ajax ({
                                        type: 'POST',
                                        url: '/TechSUAS/peixe/logado/save_new.php',
                                        data: {
                                            cod_talao: codTalao,
                                            cpf_valido: cpf_valido,
                                            nome_pessoa: nome_pessoa,
                                            codfam: cod_famil,
                                            entrega: entrega,
                                            bpc: bpc
                                        },
                                        dataType: 'json',
                                        success: function(salvo) {
                                            if (salvo.salvo) {
                                                Swal.fire(salvo.msg, "", "success")
                                                .then((ok) => {
                                                    if (ok.isConfirmed) {
                                                        window.location.reload()                                                
                                                    } else {
                                                        window.location.reload()
                                                    }
                                                })
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    html: `<p>${salvo.msg}, certifique de preencher o talão após digitar no sistema</p><p>Caso tenha entregue equivocadamente, entre em contato com o suporte do sistema</p>`,
                                                })
                                                .then((dor) => {
                                                    if (dor.isConfirmed) {
                                                            window.location.reload()
                                                        } else {
                                                            window.location.reload()
                                                        }
                                                })
                                            }
                                        }
                                    })
                                } else {
                                    Swal.fire("Operação cancelada", "", "info")
                                }
                            })                                    
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'OPSS!!',
                                html: `${response.dados_familia}`,
                            })
                        }
                    } 
                })
        } else {
            Swal.fire("Operação cancelada", "", "info")
        }
    })
}

function finishCad() {
    Swal.fire({
        title: 'Deseja finalizar o cadastro?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: '/TechSUAS/peixe/logado/local_cadastro.php',
                data: {
                    lc_cadastro: 'X'
                    },
                dataType: 'json',
                success: function(salvo) {
                    if (salvo.salvo) {
                        Swal.fire("Cadastro finalizado com sucesso!", "", "success")
                        .then((result1) => {
                            if (result1.isConfirmed) {
                                window.location.href = "/TechSUAS/config/logout.php";
                            }
                        })
                    }
                }
            })
        } else {
            Swal.fire("Operação cancelada", "", "info")
        }
    })
}

$(document).ready(function () {
    fetch('/TechSUAS/peixe/logado/ult_cad_peixe.php')
    .then(response => response.json())
    .then(response => {
        if (response.encontrado) {
            let tabelaHtml = `
            <table>
            <tr>
                <th colspan="2"> Contador: ${response.seq}</th>
                <td colspan="2" style="text-align: center; font-size: 12px;"><p>OPERADOR ATIVO: <strong>${response.operador}</strong></p>
                <p>${response.lc_cad}</p></td>
            </tr>
                <tr>
                    <th>Cód. Talão</th>
                    <th>Fez o Cadastro</th>
                    <th>Parantesco c/RF</th>
                    <th>Responsável Familiar</th>
                </tr>`
                response.dados_ultimos.forEach(medida => {
                    tabelaHtml += `
                    <tr>
                        <td style="text-align: center;"><strong>${medida.cod_talao}</strong></td>
                        <td style="text-align: center;">${medida.nom_pessoa}</td>
                        <td style="text-align: center;">${medida.cod_parentesco}</td>
                        <td style="text-align: center;">${medida.nome}</td>
                    </tr>
                    `
                })

                tabelaHtml += `</table>`

                $('#dadosUltCadastro').html(tabelaHtml)
        } else {
            $('#dadosUltCadastro').html('<p>Você ainda não realizou nenhum cadastro.</p>');
        }
    })
})

function mensagem_encaminhamento() {
    Swal.fire({
        title: 'ENCAMINHAMENTO',
        html: `
        <input type="text" id="encaminhamento" placeholder="Digite o CPF"><br>
        <textarea id="obs" placeholder="Observações" style="width: 100%; height: 100px; margin-top: 5px;"></textarea><br>
        `,
        showCancelButton: true,
        confirmButtonText: 'Encaminhar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
    })
    .then((result) => {
        if (result.value) {
            let cpf = document.getElementById('encaminhamento').value
            let obs = document.getElementById('obs').value
                cpf = cpf.replace(/\D/g, '') // Remove tudo que não for número
                cpf = parseInt(cpf, 10).toString() // Remove zeros à esquerda
            $.ajax({
                type: 'POST',
                url: '/TechSUAS/peixe/logado/encaminhamento.php',
                data: {
                    cpf: cpf,
                    obs: obs
                },
                dataType: 'json',
                success: function(data) {
                    if (data.salvo) {
                        Swal.fire({
                            title: 'Encaminhamento realizado com sucesso',
                            text: 'O encaminhamento foi realizado com sucesso',
                            icon: 'success',

                        }).then((scver) =>{
                            if (scver.value) {
                                window.location.href = '/TechSUAS/peixe/logado/index'
                            }
                        })
                    } else {
                        Swal.fire({
                            title: 'Erro ao encaminhar',
                            text: 'O encaminhamento não foi realizado com sucesso' + data.erro,
                            icon: 'error',
                        })
                    }
                }
            })
        } else {
            Swal.fire({
                title: 'Cancelado',
                text: 'O encaminhamento foi cancelado',
                icon: 'warning',
            })
        }
    })
}

function consultar() {
    fetch("/TechSUAS/peixe/logado/locais_cadastrados.php")
    .then(response => response.json())
    .then(response => {
        if (response.encontrado) {
            let htmlSelect = `
            <form id="form_consultar" action="/TechSUAS/peixe/logado/cadastrados.php" method="post">
            <select id="locais" name="locais">
            <option value="1">TODOS</option>
            `
                        
            response.dados_local_entrega.forEach((local_entrega) => {
                htmlSelect += `<option value="${local_entrega.local}">${local_entrega.local}</option>`
            })

            htmlSelect += `</select>
                </form>
            `

            Swal.fire({
                title: 'FILTRO DOS LOCAIS',
                html: htmlSelect,
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.getElementById("form_consultar")
                    form.submit()
                    // Aqui você pode executar alguma ação com o local selecionado
                }
            })
        }
    })
    .catch(error => {
        Swal.fire('Erro', error.message, 'error')
    })
}