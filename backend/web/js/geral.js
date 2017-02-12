/* 
 * Script jQuery com funções genéricas
 * usado em quase todas as páginas
 */

$(document).ready(function () {

    // Carrega a qtde de mensagens novas
    $("#msgNovas").load("/Transportes/backend/web/ajax/msg-qtde");

    // Verifica o valor repassado de mensagens
    // e informa ao usuário
    $('.messages-menu').click(function () {

        $("#msgNovas").load("/Transportes/backend/web/ajax/msg-qtde");

        qtde = parseFloat($(this).find('span').html());

        // Define a mensagem para o usuário
        msg = 'Você não tem mensagens novas.';

        if (qtde > 0) {
            msg = 'Você tem novas mensagens.';
        }

        //Escreve ao clicar no botão de msg
        $("#msgNovastxt").html(msg);

        // limpa a lista de mensagens
        $("#menuTopo").html('');

        // Escreve as mensagens mais recentes para o usuário.
        $.get("/Transportes/backend/web/ajax/mensagens", function (data) {
            $.each(data, function (key, value) {

                var lista = '<li><a href="/Transportes/backend/web/site/mensagens?id=' + value.id + '"><div class="pull-left"><img src="/Transportes/backend/web/img/sistema/avatar.png" class="img-circle" alt="User Image" /></div><h4>LND Sistemas<small><i class="fa fa-clock-o"></i>' + value.data + '</small></h4><p>' + value.titulo + '</p></a></li>';

                $("#menuTopo").append(lista);

            });
        });

    });

    //alert('hauhuaha');

});