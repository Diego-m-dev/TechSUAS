$(document).ready(function () {
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    var modalTriggers = document.querySelectorAll(".modal-trigger");

    // Abre o modal ao clicar nos gatilhos
    modalTriggers.forEach(function (trigger) {
        trigger.addEventListener("click", function (event) {
            event.preventDefault();
            var buttonText = this.innerText.trim().split("\n").pop().trim();
            document.getElementById("modalText").innerText = buttonText;
            modal.style.display = "block";
        });
    });

    // Fecha o modal ao clicar no botão de fechar
    span.onclick = function () {
        modal.style.display = "none";
    };

    // Fecha o modal ao clicar fora dele
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // Aplica máscara para CPF
    $('#cpf').mask('000.000.000-00', { reverse: false });

    // Aplica máscara para Código Familiar (cod)
    $('#cod').mask('000000000-00', { reverse: false });

    // Aplica máscara para NIS
    $('#nis').mask('0000000000-0', { reverse: false });

    // Valida o CPF ao sair do campo
    $("#cpf").on("blur", function () {
        validarCPF(this);
    });

    // Requisição AJAX para buscar dados do CPF
    $('#cpf').on('blur', function () {
        const cpf = this.value.replace(/[^\d]/g, ''); // Remove caracteres não numéricos

        if (cpf) {
            $.ajax({
                type: 'POST',
                url: '/TechSUAS/controller/recepcao/buscar.php',
                data: { cpf: cpf },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#loading').hide();
                    if (response.success) {
                        $('#nome').val(response.nome);
                        $('#cod').val(response.cod_fam_familia);
                        $('#nis').val(response.nis);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'CPF não encontrado!',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function () {
                    $('#loading').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Erro na requisição. Por favor, tente novamente mais tarde!',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });

    // Impede o envio do formulário se o CPF for inválido
    $("#submitBtn").on("click", function (event) {
        var cpfInput = document.getElementById("cpf");
        if (!validarCPF(cpfInput)) {
            event.preventDefault();
        } else {
            $('#loading').css('display', 'block');
            var formData = $('#myForm').serialize();

            $.ajax({
                type: 'POST',
                url: '/TechSUAS/controller/recepcao/inserir.php',
                data: formData,
                success: function (response) {
                    $('#loading').css('display', 'none');
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Registro inserido com sucesso.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            atualizarTabela(); // Atualiza a tabela após o sucesso
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Erro ao inserir o registro. Tente novamente mais tarde.',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function () {
                    $('#loading').css('display', 'none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Erro na requisição. Por favor, tente novamente mais tarde!',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });

    // Atualiza a tabela sem recarregar a página
    function atualizarTabela() {
        $.ajax({
            url: '/TechSUAS/controller/recepcao/buscar_ultimas_solicitacoes.php',
            type: 'GET',
            success: function (response) {
                var dados = JSON.parse(response);
                var tabelaBody = $('#dataTable tbody');
                tabelaBody.empty(); // Limpa o corpo da tabela

                if (Array.isArray(dados) && dados.length > 0) {
                    dados.forEach(function (item) {
                        var linha = `<tr>
                        <td>${item.cpf}</td>
                        <td>${item.nome}</td>
                        <td>${item.cod_fam}</td>
                        <td>${item.nis}</td>
                        <td>${item.tipo}</td>
                        <td>${item.status}</td>
                        <td><i class='fas fa-check-circle check-icon' data-id='${item.id}'></i></td>
                    </tr>`;
                        tabelaBody.append(linha);
                    });

                    // Adiciona o manipulador de eventos para o clique no ícone
                    $('.check-icon').on('click', function () {
                        var id = $(this).data('id');
                        atualizarStatus(id);
                    });
                } else {
                    tabelaBody.append("<tr><td colspan='7'>Nenhum registro encontrado.</td></tr>");
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao atualizar a tabela. Tente novamente mais tarde.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    // Função para atualizar o status
    function atualizarStatus(id, novoStatus) {
        $.ajax({
            url: '/TechSUAS/controller/recepcao/atualizar_status.php',
            type: 'POST',
            data: {
                id: id,
                novo_status: novoStatus
            },
            success: function (response) {
                if (response.trim() === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Atualizado',
                        text: 'Status atualizado com sucesso.',
                        confirmButtonText: 'OK'
                    });
                    atualizarTabela(); // Atualiza a tabela após a atualização do status
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Erro ao conectar com o servidor.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    // Atualiza a tabela quando o status é atualizado
    $(document).on('click', '.check-icon', function () {
        var id = $(this).data('id');
        var novoStatus = 'ENTREGUE'; // Define o status desejado aqui

        atualizarStatus(id, novoStatus);
    });


    // Carrega os dados iniciais da tabela quando a página é carregada
    atualizarTabela();
});

// Função para validar CPF
function validarCPF(el) {
    if (!_cpf(el.value)) {
        Swal.fire({
            icon: 'error',
            title: 'CPF Inválido',
            text: 'Por favor, insira um CPF válido!',
            confirmButtonText: 'OK'
        });
        el.value = "";
        return false;
    }
    return true;
}
