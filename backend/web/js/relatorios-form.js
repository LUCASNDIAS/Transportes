/**
 * Script em jQuery com funções para formulários de cadastro
 * e edição de clientes.
 */

$(document).ready(function () {

    // Datas
    $('.data').mask('00/00/0000');

    // RELATÓRIO DE FINANCEIRO
    var urlRelatorio = '/Transportes/backend/web/relatorios/default/get-relatorio/?';

    function getRelatorio() {
        var resultado = '';
        var di = $('#di').val();
        var df = $('#df').val();
        var tipo = $('#tipo').val();
        var status = $('input[name=status]:checked').val();
        var p = 'di=' + di + '&df=' + df + '&tipo=' + tipo + '&status=' + status;

        $.ajax({
            url: urlRelatorio + p,
            type: 'GET',
            success: function (data) {
                $.each(data.lista, function (index, value) {
                    var nl = novalinha(value);
                    $("#resultados").append(nl);
                });

                $.each(data.totais, function (abc, value) {

                    $.each(data.totais[abc], function (i, v) {
                        v['status'] = i;
                        var nl = novalinhatotal(v);
                        $("#resultados-totais").append(nl);
                    });

                });


            }
        });

        return resultado;
    }

    function novalinha(data) {

        var label = '';

        if (data.status == 'PAGO') {
            label = '<span class="label label-success">' + data.status + '</span>';
        } else if (data.status == 'VENCIDO') {
            label = '<span class="label label-danger">' + data.status + '</span>';
        } else {
            label = '<span class="label label-warning">' + data.status + '</span>';
        }

        var corlinha = '<tr style="color: #F00">';

        if (data.tipo == 'R') {
            corlinha = '<tr style="color: #00F">';
        }

        var nl = '';
        nl = corlinha;
        nl += '<td>' + data.nome + '</td>';
        nl += '<td>' + data.descricao + '</td>';
        nl += '<td>' + data.vencimento + '</td>';
        nl += '<td>' + data.valor + '</td>';
        nl += '<td>' + label + '</td>';
        nl += '</tr>';

        return nl;
    }

    function novalinhatotal(data) {

        var label = '';

        if (data.status == 'PAGO') {
            label = '<span class="label label-success">' + data.status + '</span>';
        } else if (data.status == 'VENCIDO') {
            label = '<span class="label label-danger">' + data.status + '</span>';
        } else {
            label = '<span class="label label-warning">' + data.status + '</span>';
        }

        var corlinha = '<tr style="color: #F00">';

        if (data.tipo == 'RECEITA') {
            corlinha = '<tr style="color: #00F">';
        }

        var nl = '';
        nl = corlinha;
        nl += '<td>' + data.tipo + '</td>';
        nl += '<td>' + label + '</td>';
        nl += '<td>' + data.qtde + '</td>';
        nl += '<td>' + data.total.toFixed(2) + '</td>';
        nl += '</tr>';

        return nl;
    }

    $('#gerar').on('click', function () {
        $("#resultados").html('');
        getRelatorio();
    });
    // FIM DO RELATÓRIO DE FINANCEIRO

    // RELATÓRIO DE CT-E
    var urlCte = '/Transportes/backend/web/relatorios/default/get-cte/?';

    function getCte() {
        var resultado = '';
        var di = $('#di').val();
        var df = $('#df').val();
        var status = $('input[name=status]:checked').val();
        var p = 'di=' + di + '&df=' + df + '&status=' + status;

        $.ajax({
            url: urlCte + p,
            type: 'GET',
            success: function (data) {
                $.each(data.lista, function (index, value) {
                    var nl = novalinhacte(value);
                    $("#resultados").append(nl);
                });

                $.each(data.totais, function (index, value) {
                    var nl = novalinhactetotal(index,value);
                    $("#resultados_totais").append(nl);
                });
            }
        });

        return resultado;
    }

    function novalinhactetotal(status,data) {

        var label = '';

        if (status == 'CANCELADO') {
            label = '<span class="label label-danger">' + status + '</span>';
        } else {
            label = '<span class="label label-success">' + status + '</span>';
        }

        var corlinha = '<tr style="color: #F00">';

        if (status == 'AUTORIZADO' || status == 'ENTREGUE') {
            corlinha = '<tr style="color: #00F">';
        }

        var media = '';
        media = data.total / data.qtde;

        var nl = '';
        nl = corlinha;
        nl += '<td>' + label + '</td>';
        nl += '<td>' + data.qtde + '</td>';
        nl += '<td>' + data.total.toFixed(2) + '</td>';
        nl += '<td>' + media.toFixed(2) + '</td>';

        nl += '</tr>';

        return nl;
    }

    function novalinhacte(data) {

        var label = '';

        if (data.status == 'CANCELADO') {
            label = '<span class="label label-danger">' + data.status + '</span>';
        } else {
            label = '<span class="label label-success">' + data.status + '</span>';
        }

        var corlinha = '<tr style="color: #F00">';

        if (data.status == 'AUTORIZADO' || data.status == 'ENTREGUE') {
            corlinha = '<tr style="color: #00F">';
        }

        var nl = '';
        nl = corlinha;
        nl += '<td>' + data.numero + '</td>';
        nl += '<td>' + data.emissao + '</td>';
        nl += '<td>' + data.tomanome + '</td>';
        nl += '<td>' + data.valor + '</td>';
        nl += '<td>' + label + '</td>';
        nl += '</tr>';

        return nl;
    }

    $("#gerar-cte").on('click', function () {
        $("#resultados, #resultados_totais").html('');
        getCte();
    });


    $('#imprimir').on('click', function () {
        $(".area-print").printThis({
            importStyle: true,
            copyTagClasses: true,
        });
    });

});