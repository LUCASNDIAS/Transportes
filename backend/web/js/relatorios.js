/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    var urlFatura = '/Transportes/backend/web/ajax/count-faturas';
    var urlCte = '/Transportes/backend/web/ajax/count-cte';
    var urlMinuta = '/Transportes/backend/web/ajax/count-minutas';
    var urlFrota = '/Transportes/backend/web/ajax/count-frota';
    var urlReceber = '/Transportes/backend/web/ajax/sum-financeiro/?tipo=R';
    var urlPagar = '/Transportes/backend/web/ajax/sum-financeiro/?tipo=D';
    var urlBalanco = '/Transportes/backend/web/ajax/get-balanco';

    $.ajax({
        url: urlFatura,
        type: 'GET',
        success: function (data) {
            $("#countFaturas").html(data);
        }
    });

    $.ajax({
        url: urlCte,
        type: 'GET',
        success: function (data) {
            $("#countCte").html(data);
        }
    });

    $.ajax({
        url: urlMinuta,
        type: 'GET',
        success: function (data) {
            $("#countMinutas").html(data);
        }
    });

    $.ajax({
        url: urlFrota,
        type: 'GET',
        success: function (data) {
            $("#countFrota").html(data);
        }
    });

    $.ajax({
        url: urlReceber,
        type: 'GET',
        success: function (data) {
            $("#countReceber").html(data);
        }
    });

    $.ajax({
        url: urlPagar,
        type: 'GET',
        success: function (data) {
            $("#countPagar").html(data);
        }
    });

    $.ajax({
        url: urlBalanco,
        type: 'GET',
        success: function (data) {
            $("#countBalanco").html(data);
        }
    });

});