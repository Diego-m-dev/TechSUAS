$(document).ready(function () {
    $('#gerar_relatorio').click(function () {
        var confirmarAcao = confirm("Essa ação vai encerrar a entrega. NÃO sendo possível retoma-la hoje, deseja continuar?");
        var gerar_relatorio = true;

        if (confirmarAcao) {

            window.location.href = "/TechSUAS/controller/cozinha_comunitaria/gerar_relatorio_diario";
            $('#buscar').hide();
            $('#gerar_relatorio').hide();

            // Armazenar a hora em que os botões foram escondidos no localStorage
            localStorage.setItem('horaEsconderBotoes', new Date().getTime());

        } else {
            alert('Ação cancelada!')
        }
    });

    // Verificar se os botões devem ser mostrados ao carregar a página
    var horaEsconderBotoes = localStorage.getItem('horaEsconderBotoes');
    if (horaEsconderBotoes) {
        var tempoPassado = new Date().getTime() - parseInt(horaEsconderBotoes);
        var horasParaEsconder = 8;

        // Se o tempo passado for menor que o tempo para esconder os botões, mantenha-os escondidos
        if (tempoPassado < horasParaEsconder) {
            $('#buscar').hide();
            $('#gerar_relatorio').hide();
            $('#mensagem_bloqueio').text('Após encerrar as entregas do dia e gerar o Relatório o sistema é bloqueado retornando apenas no dia seguinte.');
        }
    }
});